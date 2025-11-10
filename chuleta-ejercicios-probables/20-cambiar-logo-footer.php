<?php
/*
Plugin Name: Logo Personalizado en Footer
Description: Añade un logo personalizado en el pie de página con enlace configurable.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= MOSTRAR LOGO EN FOOTER ======================= //
function clf_mostrar_logo()
{
    $clf_activo = get_option('clf_activo', false);
    $clf_logo_url = get_option('clf_logo_url', '');
    $clf_enlace_url = get_option('clf_enlace_url', '');
    $clf_ancho = get_option('clf_ancho', 150);

    if (!$clf_activo || empty($clf_logo_url)) {
        return;
    }

    $enlace_inicio = '';
    $enlace_fin = '';

    if (!empty($clf_enlace_url)) {
        $enlace_inicio = '<a href="' . esc_url($clf_enlace_url) . '" target="_blank" rel="noopener">';
        $enlace_fin = '</a>';
    }

    echo '<div style="text-align: center; padding: 30px 0; margin-top: 40px; border-top: 1px solid #ddd;">';
    echo $enlace_inicio;
    echo '<img src="' . esc_url($clf_logo_url) . '" alt="Logo" style="width: ' . esc_attr($clf_ancho) . 'px; height: auto;">';
    echo $enlace_fin;
    echo '</div>';
}
add_action('wp_footer', 'clf_mostrar_logo');

// ======================= CREAR MENÚ ======================= //
function clf_crear_menu()
{
    add_menu_page(
        'Logo Footer',
        'Logo Footer',
        'manage_options',
        'logo-footer',
        'clf_pagina_configuracion',
        'dashicons-format-gallery'
    );
}
add_action('admin_menu', 'clf_crear_menu');

// ======================= CONFIGURACIÓN ======================= //
function clf_pagina_configuracion()
{
    if (isset($_POST['clf_logo_url']) && check_admin_referer('clf_guardar')) {
        update_option('clf_logo_url', esc_url_raw($_POST['clf_logo_url']));
        update_option('clf_enlace_url', esc_url_raw($_POST['clf_enlace_url']));
        update_option('clf_ancho', (int)sanitize_text_field($_POST['clf_ancho']));
        update_option('clf_activo', isset($_POST['clf_activo']));
        echo '<div class="updated"><p>✅ Guardado.</p></div>';
    }

    $clf_logo_url = get_option('clf_logo_url', '');
    $clf_enlace_url = get_option('clf_enlace_url', '');
    $clf_ancho = get_option('clf_ancho', 150);
    $clf_activo = get_option('clf_activo', false);
    ?>

    <div class="wrap">
        <h1>Logo en el Footer</h1>
        <form method="post">
            <?php wp_nonce_field('clf_guardar'); ?>

            <p>
                <label>
                    <input type="checkbox" name="clf_activo" <?php echo $clf_activo ? 'checked' : ''; ?>>
                    Mostrar logo en el footer
                </label>
            </p>

            <p>
                <label><strong>URL del logo:</strong></label><br>
                <input type="url" name="clf_logo_url" value="<?php echo esc_attr($clf_logo_url); ?>" style="width: 100%; max-width: 500px;" placeholder="https://tusitio.com/logo.png">
            </p>

            <p>
                <label><strong>Enlace del logo (opcional):</strong></label><br>
                <input type="url" name="clf_enlace_url" value="<?php echo esc_attr($clf_enlace_url); ?>" style="width: 100%; max-width: 500px;" placeholder="https://tusitio.com">
                <br><small>Deja vacío si no quieres que sea clic able</small>
            </p>

            <p>
                <label><strong>Ancho del logo (px):</strong></label><br>
                <input type="number" name="clf_ancho" min="50" max="500" value="<?php echo esc_attr($clf_ancho); ?>" style="width: 100px;">
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar">
            </p>
        </form>
    </div>
    <?php
}
