<?php
/*
Plugin Name: Frases Motivacionales Rotativas
Description: Muestra frases que cambian automáticamente cada X segundos con JavaScript.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= MOSTRAR FRASES ROTATIVAS ======================= //
function fr_mostrar_frases()
{
    // Recuperar configuración
    $fr_frases = get_option('fr_frases', []);
    $fr_intervalo = get_option('fr_intervalo', 5);
    $fr_auto_cambio = get_option('fr_auto_cambio', true);
    $fr_color = get_option('fr_color', '#0073aa');

    // Si no hay frases, no mostrar nada
    if (empty($fr_frases)) {
        return;
    }

    // Convertir frases a formato JSON para JavaScript
    $frases_json = json_encode($fr_frases);
    $intervalo_ms = $fr_intervalo * 1000; // Convertir segundos a milisegundos

    ?>
    <div id="fr-contenedor" style="
        text-align: center;
        padding: 20px;
        font-size: 24px;
        font-weight: bold;
        color: <?php echo esc_attr($fr_color); ?>;
        min-height: 60px;
    ">
        <p id="fr-frase"></p>
    </div>

    <script>
        (function() {
            var frases = <?php echo $frases_json; ?>;
            var autoCambio = <?php echo $fr_auto_cambio ? 'true' : 'false'; ?>;
            var intervalo = <?php echo esc_js($intervalo_ms); ?>;
            var indiceActual = 0;

            function mostrarFrase() {
                var elementoFrase = document.getElementById('fr-frase');
                if (elementoFrase && frases.length > 0) {
                    elementoFrase.textContent = frases[indiceActual];
                }
            }

            function cambiarFrase() {
                indiceActual = indiceActual + 1;
                if (indiceActual >= frases.length) {
                    indiceActual = 0;
                }
                mostrarFrase();
            }

            // Mostrar primera frase
            mostrarFrase();

            // Si auto-cambio está activado, cambiar cada X segundos
            if (autoCambio && frases.length > 1) {
                setInterval(cambiarFrase, intervalo);
            }
        })();
    </script>
    <?php
}
add_action('wp_footer', 'fr_mostrar_frases');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function fr_crear_menu()
{
    add_menu_page(
        'Frases Rotativas',
        'Frases Rotativas',
        'manage_options',
        'frases-rotativas',
        'fr_pagina_configuracion',
        'dashicons-slides'
    );
}
add_action('admin_menu', 'fr_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function fr_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['fr_frases_texto']) && check_admin_referer('fr_guardar_config')) {

        $texto = sanitize_textarea_field($_POST['fr_frases_texto']);
        $frases = explode("\n", $texto);

        // Limpiar frases vacías
        $frases_limpias = [];
        $i = 0;
        while ($i < count($frases)) {
            $frase_limpia = trim($frases[$i]);
            if (!empty($frase_limpia)) {
                $frases_limpias[] = $frase_limpia;
            }
            $i = $i + 1;
        }

        update_option('fr_frases', $frases_limpias);

        $intervalo = (int)sanitize_text_field($_POST['fr_intervalo']);
        update_option('fr_intervalo', $intervalo);

        $auto_cambio = isset($_POST['fr_auto_cambio']);
        update_option('fr_auto_cambio', $auto_cambio);

        $color = sanitize_hex_color($_POST['fr_color']);
        update_option('fr_color', $color);

        echo '<div class="updated"><p>✅ Frases guardadas correctamente.</p></div>';
    }

    // Leer valores actuales
    $fr_frases = get_option('fr_frases', []);
    $fr_intervalo = get_option('fr_intervalo', 5);
    $fr_auto_cambio = get_option('fr_auto_cambio', true);
    $fr_color = get_option('fr_color', '#0073aa');

    // Convertir array a texto
    $texto_frases = implode("\n", $fr_frases);
    ?>

    <div class="wrap">
        <h1>Configuración de Frases Rotativas</h1>
        <p>Las frases cambiarán automáticamente cada cierto tiempo en el footer de tu sitio.</p>

        <form method="post">
            <?php wp_nonce_field('fr_guardar_config'); ?>

            <h2>✍️ Tus Frases</h2>
            <p>
                <label for="fr_frases_texto"><strong>Escribe una frase por línea:</strong></label><br>
                <textarea id="fr_frases_texto"
                          name="fr_frases_texto"
                          rows="10"
                          style="width: 100%; max-width: 600px;"
                          placeholder="Cada día es una nueva oportunidad&#10;El éxito empieza con la actitud&#10;Sé el cambio que quieres ver"><?php echo esc_textarea($texto_frases); ?></textarea>
            </p>

            <h2>⚙️ Configuración del Cambio Automático</h2>

            <p>
                <label>
                    <input type="checkbox" name="fr_auto_cambio" <?php echo $fr_auto_cambio ? 'checked' : ''; ?>>
                    <strong>Activar cambio automático de frases</strong>
                </label>
            </p>

            <p>
                <label for="fr_intervalo"><strong>Cambiar cada:</strong></label><br>
                <input type="number"
                       id="fr_intervalo"
                       name="fr_intervalo"
                       min="1"
                       max="60"
                       value="<?php echo esc_attr($fr_intervalo); ?>"
                       style="width: 100px;">
                segundos
            </p>

            <h2>🎨 Personalización</h2>

            <p>
                <label for="fr_color"><strong>Color del texto:</strong></label><br>
                <input type="color"
                       id="fr_color"
                       name="fr_color"
                       value="<?php echo esc_attr($fr_color); ?>">
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📊 Estadísticas</h2>
        <div class="notice notice-info">
            <p><strong>Total de frases configuradas:</strong> <?php echo count($fr_frases); ?></p>
            <?php if ($fr_auto_cambio && count($fr_frases) > 1): ?>
                <p><strong>Estado:</strong> ✅ Las frases cambiarán cada <?php echo esc_html($fr_intervalo); ?> segundos</p>
            <?php elseif (count($fr_frases) === 1): ?>
                <p><strong>Estado:</strong> ℹ️ Solo hay 1 frase, no habrá rotación</p>
            <?php else: ?>
                <p><strong>Estado:</strong> ⏸️ Cambio automático desactivado</p>
            <?php endif; ?>
        </div>

        <h2>💡 Casos de uso</h2>
        <div class="notice notice-success">
            <p>✅ Frases motivacionales para un blog de desarrollo personal</p>
            <p>✅ Tips rotativos en un sitio educativo</p>
            <p>✅ Eslóganes de marca que cambian</p>
            <p>✅ Mensajes promocionales dinámicos</p>
        </div>
    </div>

    <?php
}
