<?php
/*
Plugin Name: Aviso de Cookies
Description: Muestra un aviso de cookies en la parte inferior con botón de aceptar.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= MOSTRAR AVISO DE COOKIES ======================= //
function ac_mostrar_aviso()
{
    $ac_activo = get_option('ac_activo', false);
    $ac_mensaje = get_option('ac_mensaje', 'Este sitio usa cookies para mejorar tu experiencia.');
    $ac_color_fondo = get_option('ac_color_fondo', '#333333');
    $ac_color_texto = get_option('ac_color_texto', '#ffffff');

    if (!$ac_activo) {
        return;
    }

    ?>
    <div id="ac-aviso" style="
        display: none;
        position: fixed;
        bottom: 0;
        left: 0;
        width: 100%;
        background-color: <?php echo esc_attr($ac_color_fondo); ?>;
        color: <?php echo esc_attr($ac_color_texto); ?>;
        padding: 20px;
        text-align: center;
        z-index: 99999;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.3);
    ">
        <span><?php echo esc_html($ac_mensaje); ?></span>
        <button onclick="aceptarCookies()" style="
            margin-left: 20px;
            background-color: white;
            color: <?php echo esc_attr($ac_color_fondo); ?>;
            border: none;
            padding: 10px 30px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        ">Aceptar</button>
    </div>

    <script>
        function aceptarCookies() {
            localStorage.setItem('cookies_aceptadas', 'si');
            document.getElementById('ac-aviso').style.display = 'none';
        }

        // Mostrar aviso si no se han aceptado aún
        if (!localStorage.getItem('cookies_aceptadas')) {
            document.getElementById('ac-aviso').style.display = 'block';
        }
    </script>
    <?php
}
add_action('wp_footer', 'ac_mostrar_aviso');

// ======================= CREAR MENÚ ======================= //
function ac_crear_menu()
{
    add_menu_page(
        'Aviso de Cookies',
        'Cookies',
        'manage_options',
        'aviso-cookies',
        'ac_pagina_configuracion',
        'dashicons-info'
    );
}
add_action('admin_menu', 'ac_crear_menu');

// ======================= CONFIGURACIÓN ======================= //
function ac_pagina_configuracion()
{
    if (isset($_POST['ac_mensaje']) && check_admin_referer('ac_guardar')) {
        update_option('ac_mensaje', sanitize_text_field($_POST['ac_mensaje']));
        update_option('ac_color_fondo', sanitize_hex_color($_POST['ac_color_fondo']));
        update_option('ac_color_texto', sanitize_hex_color($_POST['ac_color_texto']));
        update_option('ac_activo', isset($_POST['ac_activo']));
        echo '<div class="updated"><p>✅ Guardado.</p></div>';
    }

    $ac_mensaje = get_option('ac_mensaje', 'Este sitio usa cookies para mejorar tu experiencia.');
    $ac_color_fondo = get_option('ac_color_fondo', '#333333');
    $ac_color_texto = get_option('ac_color_texto', '#ffffff');
    $ac_activo = get_option('ac_activo', false);
    ?>

    <div class="wrap">
        <h1>Aviso de Cookies</h1>
        <form method="post">
            <?php wp_nonce_field('ac_guardar'); ?>

            <p>
                <label>
                    <input type="checkbox" name="ac_activo" <?php echo $ac_activo ? 'checked' : ''; ?>>
                    Activar aviso de cookies
                </label>
            </p>

            <p>
                <label><strong>Mensaje:</strong></label><br>
                <input type="text" name="ac_mensaje" value="<?php echo esc_attr($ac_mensaje); ?>" style="width: 100%; max-width: 600px;">
            </p>

            <p>
                <label><strong>Color de fondo:</strong></label><br>
                <input type="color" name="ac_color_fondo" value="<?php echo esc_attr($ac_color_fondo); ?>">
            </p>

            <p>
                <label><strong>Color del texto:</strong></label><br>
                <input type="color" name="ac_color_texto" value="<?php echo esc_attr($ac_color_texto); ?>">
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar">
            </p>
        </form>

        <h2>ℹ️ Información</h2>
        <div class="notice notice-info">
            <p>El aviso aparece una sola vez. Cuando el usuario hace clic en "Aceptar", se guarda en localStorage y no vuelve a aparecer.</p>
        </div>
    </div>
    <?php
}
