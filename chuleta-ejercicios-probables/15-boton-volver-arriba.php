<?php
/*
Plugin Name: Botón Volver Arriba
Description: Muestra un botón flotante para volver arriba de la página cuando el usuario hace scroll.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= MOSTRAR BOTÓN VOLVER ARRIBA ======================= //
function bva_agregar_boton()
{
    $bva_activo = get_option('bva_activo', false);
    $bva_color = get_option('bva_color', '#0073aa');
    $bva_posicion = get_option('bva_posicion', 'derecha');

    if (!$bva_activo) {
        return;
    }

    // Determinar posición del botón
    $posicion_css = 'right: 20px;';
    if ($bva_posicion === 'izquierda') {
        $posicion_css = 'left: 20px;';
    }

    ?>
    <button id="bva-boton" style="
        display: none;
        position: fixed;
        bottom: 20px;
        <?php echo $posicion_css; ?>
        background-color: <?php echo esc_attr($bva_color); ?>;
        color: white;
        border: none;
        border-radius: 50%;
        width: 50px;
        height: 50px;
        font-size: 24px;
        cursor: pointer;
        box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        z-index: 9999;
        transition: opacity 0.3s;
    " onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
        ↑
    </button>

    <script>
        (function() {
            var boton = document.getElementById('bva-boton');

            // Mostrar/ocultar botón según scroll
            window.addEventListener('scroll', function() {
                var scrollTop = window.pageYOffset || document.documentElement.scrollTop;

                if (scrollTop > 300) {
                    boton.style.display = 'block';
                } else {
                    boton.style.display = 'none';
                }
            });

            // Al hacer clic, volver arriba suavemente
            boton.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });
        })();
    </script>
    <?php
}
add_action('wp_footer', 'bva_agregar_boton');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function bva_crear_menu()
{
    add_menu_page(
        'Botón Volver Arriba',
        'Volver Arriba',
        'manage_options',
        'boton-volver-arriba',
        'bva_pagina_configuracion',
        'dashicons-arrow-up-alt'
    );
}
add_action('admin_menu', 'bva_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function bva_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['bva_color']) && check_admin_referer('bva_guardar_config')) {

        $color = sanitize_hex_color($_POST['bva_color']);
        update_option('bva_color', $color);

        $posicion = sanitize_text_field($_POST['bva_posicion']);
        update_option('bva_posicion', $posicion);

        $activo = isset($_POST['bva_activo']);
        update_option('bva_activo', $activo);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $bva_color = get_option('bva_color', '#0073aa');
    $bva_posicion = get_option('bva_posicion', 'derecha');
    $bva_activo = get_option('bva_activo', false);
    ?>

    <div class="wrap">
        <h1>Configuración del Botón Volver Arriba</h1>
        <p>Añade un botón flotante que aparece cuando el usuario hace scroll hacia abajo.</p>

        <form method="post">
            <?php wp_nonce_field('bva_guardar_config'); ?>

            <h2>⚙️ Configuración</h2>

            <p>
                <label>
                    <input type="checkbox" name="bva_activo" <?php echo $bva_activo ? 'checked' : ''; ?>>
                    <strong>Activar botón volver arriba</strong>
                </label>
            </p>

            <h2>🎨 Personalización</h2>

            <p>
                <label for="bva_color"><strong>Color del botón:</strong></label><br>
                <input type="color"
                       id="bva_color"
                       name="bva_color"
                       value="<?php echo esc_attr($bva_color); ?>">
            </p>

            <p>
                <strong>Posición del botón:</strong><br>
                <label>
                    <input type="radio" name="bva_posicion" value="derecha" <?php checked($bva_posicion, 'derecha'); ?>>
                    Esquina inferior derecha
                </label><br>
                <label>
                    <input type="radio" name="bva_posicion" value="izquierda" <?php checked($bva_posicion, 'izquierda'); ?>>
                    Esquina inferior izquierda
                </label>
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📖 Cómo funciona</h2>
        <div class="notice notice-info">
            <p><strong>Aparición:</strong> El botón aparece automáticamente cuando el usuario ha hecho scroll más de 300 píxeles hacia abajo.</p>
            <p><strong>Desaparición:</strong> Se oculta cuando el usuario está cerca del inicio de la página.</p>
            <p><strong>Comportamiento:</strong> Al hacer clic, la página sube suavemente hasta arriba del todo.</p>
        </div>

        <h2>💡 Beneficios</h2>
        <div class="notice notice-success">
            <p>✅ Mejora la experiencia de usuario en páginas largas</p>
            <p>✅ Facilita la navegación</p>
            <p>✅ Reduce el cansancio del usuario</p>
            <p>✅ Aspecto profesional y moderno</p>
        </div>
    </div>

    <?php
}
