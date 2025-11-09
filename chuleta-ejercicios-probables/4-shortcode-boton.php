<?php
/*
Plugin Name: Shortcode de Botón Personalizable
Description: Crea un shortcode [mi_boton] para insertar botones personalizables en páginas y entradas.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= FUNCIÓN QUE GENERA EL SHORTCODE ======================= //
function sb_crear_boton()
{
    // Recuperar configuración del botón
    $sb_texto = get_option('sb_texto', 'Haz clic aquí');
    $sb_url = get_option('sb_url', '#');
    $sb_color_boton = get_option('sb_color_boton', '#0073aa');
    $sb_color_texto = get_option('sb_color_texto', '#ffffff');
    $sb_tamano = get_option('sb_tamano', 'mediano');
    $sb_nueva_pestana = get_option('sb_nueva_pestana', false);

    // Determinar tamaño del botón
    $padding = '10px 20px';
    $font_size = '16px';

    if ($sb_tamano === 'pequeno') {
        $padding = '8px 16px';
        $font_size = '14px';
    } elseif ($sb_tamano === 'grande') {
        $padding = '14px 28px';
        $font_size = '18px';
    }

    // Determinar si se abre en nueva pestaña
    $target = '';
    if ($sb_nueva_pestana) {
        $target = ' target="_blank" rel="noopener noreferrer"';
    }

    // Generar HTML del botón
    $html = '<a href="' . esc_url($sb_url) . '"' . $target . ' style="
        display: inline-block;
        background-color: ' . esc_attr($sb_color_boton) . ';
        color: ' . esc_attr($sb_color_texto) . ';
        padding: ' . $padding . ';
        font-size: ' . $font_size . ';
        text-decoration: none;
        border-radius: 5px;
        border: none;
        cursor: pointer;
        transition: opacity 0.3s;
    " onmouseover="this.style.opacity=\'0.8\'" onmouseout="this.style.opacity=\'1\'">' .
        esc_html($sb_texto) .
    '</a>';

    return $html;
}
// Registrar el shortcode [mi_boton]
add_shortcode('mi_boton', 'sb_crear_boton');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function sb_crear_menu()
{
    add_menu_page(
        'Shortcode Botón',
        'Shortcode Botón',
        'manage_options',
        'shortcode-boton',
        'sb_pagina_configuracion',
        'dashicons-admin-links'
    );
}
add_action('admin_menu', 'sb_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function sb_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['sb_texto']) && check_admin_referer('sb_guardar_config')) {

        $texto = sanitize_text_field($_POST['sb_texto']);
        update_option('sb_texto', $texto);

        $url = esc_url_raw($_POST['sb_url']);
        update_option('sb_url', $url);

        $color_boton = sanitize_hex_color($_POST['sb_color_boton']);
        update_option('sb_color_boton', $color_boton);

        $color_texto = sanitize_hex_color($_POST['sb_color_texto']);
        update_option('sb_color_texto', $color_texto);

        $tamano = sanitize_text_field($_POST['sb_tamano']);
        update_option('sb_tamano', $tamano);

        $nueva_pestana = isset($_POST['sb_nueva_pestana']);
        update_option('sb_nueva_pestana', $nueva_pestana);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $sb_texto = get_option('sb_texto', 'Haz clic aquí');
    $sb_url = get_option('sb_url', '#');
    $sb_color_boton = get_option('sb_color_boton', '#0073aa');
    $sb_color_texto = get_option('sb_color_texto', '#ffffff');
    $sb_tamano = get_option('sb_tamano', 'mediano');
    $sb_nueva_pestana = get_option('sb_nueva_pestana', false);
    ?>

    <div class="wrap">
        <h1>Configuración del Shortcode de Botón</h1>
        <p>Personaliza el botón y luego inserta el shortcode <code>[mi_boton]</code> en cualquier página o entrada.</p>

        <form method="post">
            <?php wp_nonce_field('sb_guardar_config'); ?>

            <table class="form-table">
                <tr>
                    <th><label for="sb_texto">Texto del botón:</label></th>
                    <td>
                        <input type="text"
                               id="sb_texto"
                               name="sb_texto"
                               value="<?php echo esc_attr($sb_texto); ?>"
                               style="width: 300px;"
                               placeholder="Ej: Comprar ahora">
                    </td>
                </tr>

                <tr>
                    <th><label for="sb_url">URL de destino:</label></th>
                    <td>
                        <input type="url"
                               id="sb_url"
                               name="sb_url"
                               value="<?php echo esc_attr($sb_url); ?>"
                               style="width: 400px;"
                               placeholder="https://ejemplo.com">
                        <p class="description">URL completa a la que llevará el botón</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="sb_color_boton">Color del botón:</label></th>
                    <td>
                        <input type="color"
                               id="sb_color_boton"
                               name="sb_color_boton"
                               value="<?php echo esc_attr($sb_color_boton); ?>">
                    </td>
                </tr>

                <tr>
                    <th><label for="sb_color_texto">Color del texto:</label></th>
                    <td>
                        <input type="color"
                               id="sb_color_texto"
                               name="sb_color_texto"
                               value="<?php echo esc_attr($sb_color_texto); ?>">
                    </td>
                </tr>

                <tr>
                    <th>Tamaño del botón:</th>
                    <td>
                        <label><input type="radio" name="sb_tamano" value="pequeno" <?php checked($sb_tamano, 'pequeno'); ?>> Pequeño</label><br>
                        <label><input type="radio" name="sb_tamano" value="mediano" <?php checked($sb_tamano, 'mediano'); ?>> Mediano</label><br>
                        <label><input type="radio" name="sb_tamano" value="grande" <?php checked($sb_tamano, 'grande'); ?>> Grande</label>
                    </td>
                </tr>

                <tr>
                    <th>Abrir en nueva pestaña:</th>
                    <td>
                        <label>
                            <input type="checkbox"
                                   name="sb_nueva_pestana"
                                   <?php echo $sb_nueva_pestana ? 'checked' : ''; ?>>
                            Abrir el enlace en una nueva pestaña
                        </label>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <!-- VISTA PREVIA -->
        <h2>Vista Previa</h2>
        <div class="card" style="padding: 20px;">
            <?php echo sb_crear_boton(); ?>
        </div>

        <!-- INSTRUCCIONES DE USO -->
        <hr>
        <h2>Cómo usar el shortcode</h2>
        <div class="notice notice-info">
            <p><strong>Para insertar el botón en una página o entrada:</strong></p>
            <ol>
                <li>Edita cualquier página o entrada</li>
                <li>En el editor, escribe: <code>[mi_boton]</code></li>
                <li>Publica o actualiza</li>
                <li>¡El botón aparecerá con la configuración que definiste aquí!</li>
            </ol>
        </div>
    </div>

    <?php
}
