<?php
/*
Plugin Name: Cambiador de Logo del Login
Description: Personaliza el logo y el enlace de la página de login de WordPress.
Version: 1.0
Author: Chuleta de Estudio

CONCEPTO NUEVO: Hooks de personalización de la página de login (login_enqueue_scripts, login_headerurl, login_headertext)
*/

if (!defined('ABSPATH')) exit;

// ======================= CAMBIAR EL LOGO DEL LOGIN ======================= //
function ll_custom_login_logo()
{
    $ll_logo_url = get_option('ll_logo_url', '');
    $ll_logo_width = get_option('ll_logo_width', '84');
    $ll_logo_height = get_option('ll_logo_height', '84');
    $ll_bg_color = get_option('ll_bg_color', '#f0f0f1');

    if (empty($ll_logo_url)) {
        return;
    }

    echo '<style type="text/css">
        /* Cambiar el fondo de la página de login */
        body.login {
            background-color: ' . esc_attr($ll_bg_color) . ';
        }

        /* Cambiar el logo */
        #login h1 a {
            background-image: url(' . esc_url($ll_logo_url) . ');
            background-size: contain;
            background-position: center;
            background-repeat: no-repeat;
            width: ' . esc_attr($ll_logo_width) . 'px;
            height: ' . esc_attr($ll_logo_height) . 'px;
            padding: 0;
        }

        /* Asegurar que el contenedor tenga el tamaño correcto */
        #login h1 {
            padding: 20px 0;
        }
    </style>';
}
// HOOK NUEVO: login_enqueue_scripts permite inyectar estilos en la página de login
add_action('login_enqueue_scripts', 'll_custom_login_logo');

// ======================= CAMBIAR URL DEL LOGO ======================= //
function ll_custom_login_url()
{
    $ll_url_destino = get_option('ll_url_destino', '');

    if (empty($ll_url_destino)) {
        return home_url();
    }

    return $ll_url_destino;
}
// HOOK NUEVO: login_headerurl cambia la URL a donde lleva el logo al hacer clic
add_filter('login_headerurl', 'll_custom_login_url');

// ======================= CAMBIAR TITLE DEL LOGO ======================= //
function ll_custom_login_title()
{
    $ll_texto_alt = get_option('ll_texto_alt', '');

    if (empty($ll_texto_alt)) {
        return get_bloginfo('name');
    }

    return $ll_texto_alt;
}
// HOOK NUEVO: login_headertext cambia el texto alternativo del logo
add_filter('login_headertext', 'll_custom_login_title');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function ll_crear_menu()
{
    add_menu_page(
        'Logo del Login',
        'Logo Login',
        'manage_options',
        'logo-login',
        'll_pagina_configuracion',
        'dashicons-admin-customizer'
    );
}
add_action('admin_menu', 'll_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function ll_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['ll_logo_url']) && check_admin_referer('ll_guardar_config')) {

        $logo_url = esc_url_raw($_POST['ll_logo_url']);
        update_option('ll_logo_url', $logo_url);

        $logo_width = (int)sanitize_text_field($_POST['ll_logo_width']);
        update_option('ll_logo_width', $logo_width);

        $logo_height = (int)sanitize_text_field($_POST['ll_logo_height']);
        update_option('ll_logo_height', $logo_height);

        $url_destino = esc_url_raw($_POST['ll_url_destino']);
        update_option('ll_url_destino', $url_destino);

        $texto_alt = sanitize_text_field($_POST['ll_texto_alt']);
        update_option('ll_texto_alt', $texto_alt);

        $bg_color = sanitize_hex_color($_POST['ll_bg_color']);
        update_option('ll_bg_color', $bg_color);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $ll_logo_url = get_option('ll_logo_url', '');
    $ll_logo_width = get_option('ll_logo_width', '84');
    $ll_logo_height = get_option('ll_logo_height', '84');
    $ll_url_destino = get_option('ll_url_destino', '');
    $ll_texto_alt = get_option('ll_texto_alt', '');
    $ll_bg_color = get_option('ll_bg_color', '#f0f0f1');

    $site_url = home_url();
    ?>

    <div class="wrap">
        <h1>Configuración del Logo de Login</h1>
        <p>Personaliza la apariencia de la página de login de WordPress.</p>

        <form method="post">
            <?php wp_nonce_field('ll_guardar_config'); ?>

            <h2>🖼️ Configuración del Logo</h2>
            <table class="form-table">
                <tr>
                    <th><label for="ll_logo_url">URL de la imagen del logo:</label></th>
                    <td>
                        <input type="url"
                               id="ll_logo_url"
                               name="ll_logo_url"
                               value="<?php echo esc_attr($ll_logo_url); ?>"
                               style="width: 500px;"
                               placeholder="https://tusitio.com/logo.png">
                        <p class="description">URL completa de tu logo. Recomendado: PNG con fondo transparente</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="ll_logo_width">Ancho del logo (px):</label></th>
                    <td>
                        <input type="number"
                               id="ll_logo_width"
                               name="ll_logo_width"
                               min="50"
                               max="500"
                               value="<?php echo esc_attr($ll_logo_width); ?>"
                               style="width: 100px;">
                        <span> píxeles (por defecto: 84)</span>
                    </td>
                </tr>

                <tr>
                    <th><label for="ll_logo_height">Alto del logo (px):</label></th>
                    <td>
                        <input type="number"
                               id="ll_logo_height"
                               name="ll_logo_height"
                               min="50"
                               max="500"
                               value="<?php echo esc_attr($ll_logo_height); ?>"
                               style="width: 100px;">
                        <span> píxeles (por defecto: 84)</span>
                    </td>
                </tr>
            </table>

            <h2>🔗 Configuración del Enlace</h2>
            <table class="form-table">
                <tr>
                    <th><label for="ll_url_destino">URL de destino al hacer clic:</label></th>
                    <td>
                        <input type="url"
                               id="ll_url_destino"
                               name="ll_url_destino"
                               value="<?php echo esc_attr($ll_url_destino); ?>"
                               style="width: 500px;"
                               placeholder="<?php echo esc_attr($site_url); ?>">
                        <p class="description">Por defecto lleva a tu página principal. Puedes cambiarlo a cualquier URL.</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="ll_texto_alt">Texto alternativo del logo:</label></th>
                    <td>
                        <input type="text"
                               id="ll_texto_alt"
                               name="ll_texto_alt"
                               value="<?php echo esc_attr($ll_texto_alt); ?>"
                               style="width: 300px;"
                               placeholder="Ir a <?php echo get_bloginfo('name'); ?>">
                        <p class="description">Texto que aparece al pasar el mouse sobre el logo</p>
                    </td>
                </tr>
            </table>

            <h2>🎨 Personalización Visual</h2>
            <table class="form-table">
                <tr>
                    <th><label for="ll_bg_color">Color de fondo de la página:</label></th>
                    <td>
                        <input type="color"
                               id="ll_bg_color"
                               name="ll_bg_color"
                               value="<?php echo esc_attr($ll_bg_color); ?>">
                        <span style="margin-left: 10px;"><?php echo esc_html($ll_bg_color); ?></span>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>👁️ Vista previa</h2>
        <div class="notice notice-info">
            <p>Para ver los cambios, cierra sesión y ve a la página de login: <code><?php echo wp_login_url(); ?></code></p>
        </div>

        <h2>🧠 Concepto técnico</h2>
        <div class="card" style="padding: 15px; background: #f0f0f1;">
            <p><strong>Hooks utilizados:</strong></p>
            <ul>
                <li><code>login_enqueue_scripts</code> - Permite inyectar CSS/JS en la página de login</li>
                <li><code>login_headerurl</code> - Cambia la URL del enlace del logo (por defecto es wordpress.org)</li>
                <li><code>login_headertext</code> - Cambia el texto alternativo del logo</li>
            </ul>
            <p><strong>¿Por qué personalizar el login?</strong></p>
            <p>Dar una apariencia profesional y con tu marca, especialmente si desarrollas sitios para clientes.</p>
        </div>
    </div>

    <?php
}
