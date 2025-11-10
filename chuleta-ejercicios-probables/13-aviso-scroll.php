<?php
/*
Plugin Name: Aviso al Final del Scroll
Description: Muestra un mensaje cuando el usuario llega al final de la página.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= MOSTRAR MENSAJE AL LLEGAR AL FINAL ======================= //
function as_agregar_script()
{
    $as_activo = get_option('as_activo', false);
    $as_mensaje = get_option('as_mensaje', '¡Has llegado al final! Gracias por leer.');
    $as_color_fondo = get_option('as_color_fondo', '#0073aa');
    $as_color_texto = get_option('as_color_texto', '#ffffff');

    if (!$as_activo) {
        return;
    }

    ?>
    <div id="as-aviso" style="
        display: none;
        position: fixed;
        bottom: 20px;
        right: 20px;
        background-color: <?php echo esc_attr($as_color_fondo); ?>;
        color: <?php echo esc_attr($as_color_texto); ?>;
        padding: 20px 30px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        z-index: 9999;
        max-width: 300px;
        font-size: 16px;
    ">
        <button onclick="document.getElementById('as-aviso').style.display=\'none\'" style="
            position: absolute;
            top: 5px;
            right: 10px;
            background: none;
            border: none;
            color: <?php echo esc_attr($as_color_texto); ?>;
            font-size: 20px;
            cursor: pointer;
            opacity: 0.7;
        ">&times;</button>
        <p style="margin: 0;"><?php echo esc_html($as_mensaje); ?></p>
    </div>

    <script>
        (function() {
            var avisoMostrado = false;

            function verificarScroll() {
                // Calcular si estamos cerca del final
                var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
                var scrollHeight = document.documentElement.scrollHeight;
                var clientHeight = document.documentElement.clientHeight;

                // Si estamos a 100px o menos del final
                var cercaDelFinal = (scrollTop + clientHeight) >= (scrollHeight - 100);

                if (cercaDelFinal && !avisoMostrado) {
                    document.getElementById('as-aviso').style.display = 'block';
                    avisoMostrado = true;
                }
            }

            // Verificar scroll cada vez que el usuario hace scroll
            window.addEventListener('scroll', verificarScroll);
        })();
    </script>
    <?php
}
add_action('wp_footer', 'as_agregar_script');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function as_crear_menu()
{
    add_menu_page(
        'Aviso de Scroll',
        'Aviso Scroll',
        'manage_options',
        'aviso-scroll',
        'as_pagina_configuracion',
        'dashicons-arrow-down-alt'
    );
}
add_action('admin_menu', 'as_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function as_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['as_mensaje']) && check_admin_referer('as_guardar_config')) {

        $mensaje = sanitize_text_field($_POST['as_mensaje']);
        update_option('as_mensaje', $mensaje);

        $color_fondo = sanitize_hex_color($_POST['as_color_fondo']);
        update_option('as_color_fondo', $color_fondo);

        $color_texto = sanitize_hex_color($_POST['as_color_texto']);
        update_option('as_color_texto', $color_texto);

        $activo = isset($_POST['as_activo']);
        update_option('as_activo', $activo);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $as_mensaje = get_option('as_mensaje', '¡Has llegado al final! Gracias por leer.');
    $as_color_fondo = get_option('as_color_fondo', '#0073aa');
    $as_color_texto = get_option('as_color_texto', '#ffffff');
    $as_activo = get_option('as_activo', false);
    ?>

    <div class="wrap">
        <h1>Configuración de Aviso de Scroll</h1>
        <p>Muestra un mensaje emergente cuando el usuario llega al final de la página.</p>

        <form method="post">
            <?php wp_nonce_field('as_guardar_config'); ?>

            <h2>⚙️ Configuración</h2>

            <p>
                <label>
                    <input type="checkbox" name="as_activo" <?php echo $as_activo ? 'checked' : ''; ?>>
                    <strong>Activar aviso al final del scroll</strong>
                </label>
            </p>

            <p>
                <label for="as_mensaje"><strong>Mensaje a mostrar:</strong></label><br>
                <input type="text"
                       id="as_mensaje"
                       name="as_mensaje"
                       value="<?php echo esc_attr($as_mensaje); ?>"
                       style="width: 100%; max-width: 500px;"
                       placeholder="¡Has llegado al final! Gracias por leer.">
            </p>

            <h2>🎨 Personalización</h2>

            <p>
                <label for="as_color_fondo"><strong>Color de fondo del aviso:</strong></label><br>
                <input type="color"
                       id="as_color_fondo"
                       name="as_color_fondo"
                       value="<?php echo esc_attr($as_color_fondo); ?>">
            </p>

            <p>
                <label for="as_color_texto"><strong>Color del texto:</strong></label><br>
                <input type="color"
                       id="as_color_texto"
                       name="as_color_texto"
                       value="<?php echo esc_attr($as_color_texto); ?>">
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📖 Cómo funciona</h2>
        <div class="notice notice-info">
            <p><strong>Detección automática:</strong> El plugin usa JavaScript para detectar cuando el usuario está a 100 píxeles o menos del final de la página.</p>
            <p><strong>Solo una vez:</strong> El mensaje aparece solo la primera vez que el usuario llega al final. Si cierra el mensaje y vuelve a subir, no aparecerá de nuevo.</p>
            <p><strong>Posición:</strong> El aviso aparece en la esquina inferior derecha de la pantalla.</p>
        </div>

        <h2>💡 Casos de uso</h2>
        <div class="notice notice-success">
            <p>✅ Agradecer a los lectores que terminaron el artículo</p>
            <p>✅ Invitar a suscribirse al newsletter</p>
            <p>✅ Sugerir artículos relacionados</p>
            <p>✅ Mostrar llamadas a la acción (CTA)</p>
            <p>✅ Avisar sobre contenido premium</p>
        </div>

        <h2>🔧 Concepto técnico</h2>
        <div style="background: #f0f0f1; padding: 15px;">
            <p><strong>JavaScript usado:</strong></p>
            <ul>
                <li><code>window.pageYOffset</code> - Posición actual del scroll</li>
                <li><code>scrollHeight</code> - Altura total del documento</li>
                <li><code>clientHeight</code> - Altura visible de la ventana</li>
            </ul>
            <p><strong>Cálculo:</strong> Si (scroll + altura visible) ≥ (altura total - 100px) → Estamos cerca del final</p>
        </div>
    </div>

    <?php
}
