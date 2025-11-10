<?php
/*
Plugin Name: Widget de Redes Sociales
Description: Muestra iconos de redes sociales en el footer con enlaces personalizables.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= MOSTRAR ICONOS DE REDES SOCIALES ======================= //
function rs_mostrar_iconos()
{
    // Recuperar configuración
    $rs_facebook = get_option('rs_facebook', '');
    $rs_instagram = get_option('rs_instagram', '');
    $rs_twitter = get_option('rs_twitter', '');
    $rs_linkedin = get_option('rs_linkedin', '');
    $rs_youtube = get_option('rs_youtube', '');
    $rs_tamano = get_option('rs_tamano', 'mediano');
    $rs_alineacion = get_option('rs_alineacion', 'center');

    // Determinar tamaño de los iconos
    $icon_size = '32px';
    if ($rs_tamano === 'pequeno') {
        $icon_size = '24px';
    } elseif ($rs_tamano === 'grande') {
        $icon_size = '48px';
    }

    // Determinar alineación
    $text_align = 'center';
    if ($rs_alineacion === 'left') {
        $text_align = 'left';
    } elseif ($rs_alineacion === 'right') {
        $text_align = 'right';
    }

    // Crear array con las redes que tienen URL configurada
    $redes = [];

    if (!empty($rs_facebook)) {
        $redes[] = [
            'nombre' => 'Facebook',
            'url' => $rs_facebook,
            'color' => '#1877f2',
            'icono' => 'f'
        ];
    }

    if (!empty($rs_instagram)) {
        $redes[] = [
            'nombre' => 'Instagram',
            'url' => $rs_instagram,
            'color' => '#e4405f',
            'icono' => 'I'
        ];
    }

    if (!empty($rs_twitter)) {
        $redes[] = [
            'nombre' => 'Twitter/X',
            'url' => $rs_twitter,
            'color' => '#000000',
            'icono' => 'X'
        ];
    }

    if (!empty($rs_linkedin)) {
        $redes[] = [
            'nombre' => 'LinkedIn',
            'url' => $rs_linkedin,
            'color' => '#0a66c2',
            'icono' => 'in'
        ];
    }

    if (!empty($rs_youtube)) {
        $redes[] = [
            'nombre' => 'YouTube',
            'url' => $rs_youtube,
            'color' => '#ff0000',
            'icono' => '▶'
        ];
    }

    // Si no hay ninguna red configurada, no mostrar nada
    if (empty($redes)) {
        return;
    }

    // Comenzar a construir el HTML
    echo '<div style="text-align: ' . esc_attr($text_align) . '; padding: 20px; margin: 20px 0;">';

    // Recorrer cada red social y crear su icono
    $index = 0;
    $total_redes = count($redes);

    while ($index < $total_redes) {
        $red = $redes[$index];

        echo '<a href="' . esc_url($red['url']) . '"
                 target="_blank"
                 rel="noopener noreferrer"
                 title="' . esc_attr($red['nombre']) . '"
                 style="
                     display: inline-block;
                     width: ' . $icon_size . ';
                     height: ' . $icon_size . ';
                     line-height: ' . $icon_size . ';
                     background-color: ' . esc_attr($red['color']) . ';
                     color: white;
                     text-align: center;
                     border-radius: 50%;
                     margin: 0 5px;
                     text-decoration: none;
                     font-weight: bold;
                     font-size: calc(' . $icon_size . ' / 2);
                     transition: transform 0.3s;
                 "
                 onmouseover="this.style.transform=\'scale(1.1)\'"
                 onmouseout="this.style.transform=\'scale(1)\'">' .
            esc_html($red['icono']) .
        '</a>';

        $index = $index + 1;
    }

    echo '</div>';
}
add_action('wp_footer', 'rs_mostrar_iconos');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function rs_crear_menu()
{
    add_menu_page(
        'Redes Sociales',
        'Redes Sociales',
        'manage_options',
        'redes-sociales',
        'rs_pagina_configuracion',
        'dashicons-share'
    );
}
add_action('admin_menu', 'rs_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function rs_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['rs_facebook']) && check_admin_referer('rs_guardar_config')) {

        $facebook = esc_url_raw($_POST['rs_facebook']);
        update_option('rs_facebook', $facebook);

        $instagram = esc_url_raw($_POST['rs_instagram']);
        update_option('rs_instagram', $instagram);

        $twitter = esc_url_raw($_POST['rs_twitter']);
        update_option('rs_twitter', $twitter);

        $linkedin = esc_url_raw($_POST['rs_linkedin']);
        update_option('rs_linkedin', $linkedin);

        $youtube = esc_url_raw($_POST['rs_youtube']);
        update_option('rs_youtube', $youtube);

        $tamano = sanitize_text_field($_POST['rs_tamano']);
        update_option('rs_tamano', $tamano);

        $alineacion = sanitize_text_field($_POST['rs_alineacion']);
        update_option('rs_alineacion', $alineacion);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $rs_facebook = get_option('rs_facebook', '');
    $rs_instagram = get_option('rs_instagram', '');
    $rs_twitter = get_option('rs_twitter', '');
    $rs_linkedin = get_option('rs_linkedin', '');
    $rs_youtube = get_option('rs_youtube', '');
    $rs_tamano = get_option('rs_tamano', 'mediano');
    $rs_alineacion = get_option('rs_alineacion', 'center');
    ?>

    <div class="wrap">
        <h1>Configuración de Redes Sociales</h1>
        <p>Configura los enlaces a tus redes sociales. Solo se mostrarán los iconos de las redes que tengan URL.</p>

        <form method="post">
            <?php wp_nonce_field('rs_guardar_config'); ?>

            <h2>URLs de Redes Sociales</h2>
            <table class="form-table">
                <tr>
                    <th><label for="rs_facebook">Facebook:</label></th>
                    <td>
                        <input type="url"
                               id="rs_facebook"
                               name="rs_facebook"
                               value="<?php echo esc_attr($rs_facebook); ?>"
                               style="width: 400px;"
                               placeholder="https://facebook.com/tu-pagina">
                    </td>
                </tr>

                <tr>
                    <th><label for="rs_instagram">Instagram:</label></th>
                    <td>
                        <input type="url"
                               id="rs_instagram"
                               name="rs_instagram"
                               value="<?php echo esc_attr($rs_instagram); ?>"
                               style="width: 400px;"
                               placeholder="https://instagram.com/tu-usuario">
                    </td>
                </tr>

                <tr>
                    <th><label for="rs_twitter">Twitter / X:</label></th>
                    <td>
                        <input type="url"
                               id="rs_twitter"
                               name="rs_twitter"
                               value="<?php echo esc_attr($rs_twitter); ?>"
                               style="width: 400px;"
                               placeholder="https://twitter.com/tu-usuario">
                    </td>
                </tr>

                <tr>
                    <th><label for="rs_linkedin">LinkedIn:</label></th>
                    <td>
                        <input type="url"
                               id="rs_linkedin"
                               name="rs_linkedin"
                               value="<?php echo esc_attr($rs_linkedin); ?>"
                               style="width: 400px;"
                               placeholder="https://linkedin.com/in/tu-perfil">
                    </td>
                </tr>

                <tr>
                    <th><label for="rs_youtube">YouTube:</label></th>
                    <td>
                        <input type="url"
                               id="rs_youtube"
                               name="rs_youtube"
                               value="<?php echo esc_attr($rs_youtube); ?>"
                               style="width: 400px;"
                               placeholder="https://youtube.com/@tu-canal">
                    </td>
                </tr>
            </table>

            <h2>Personalización</h2>
            <table class="form-table">
                <tr>
                    <th>Tamaño de los iconos:</th>
                    <td>
                        <label><input type="radio" name="rs_tamano" value="pequeno" <?php checked($rs_tamano, 'pequeno'); ?>> Pequeño (24px)</label><br>
                        <label><input type="radio" name="rs_tamano" value="mediano" <?php checked($rs_tamano, 'mediano'); ?>> Mediano (32px)</label><br>
                        <label><input type="radio" name="rs_tamano" value="grande" <?php checked($rs_tamano, 'grande'); ?>> Grande (48px)</label>
                    </td>
                </tr>

                <tr>
                    <th>Alineación:</th>
                    <td>
                        <label><input type="radio" name="rs_alineacion" value="left" <?php checked($rs_alineacion, 'left'); ?>> Izquierda</label><br>
                        <label><input type="radio" name="rs_alineacion" value="center" <?php checked($rs_alineacion, 'center'); ?>> Centro</label><br>
                        <label><input type="radio" name="rs_alineacion" value="right" <?php checked($rs_alineacion, 'right'); ?>> Derecha</label>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <div class="notice notice-info">
            <p><strong>💡 Consejo:</strong> Deja en blanco las redes sociales que no uses. Solo se mostrarán los iconos de las redes que tengan una URL configurada.</p>
        </div>
    </div>

    <?php
}
