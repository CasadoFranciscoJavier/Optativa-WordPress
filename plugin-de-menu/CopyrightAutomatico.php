<?php
/*
Plugin Name: Copyright Automático
Description: Cambia de forma automática el año del Copyright en el pie de página además de añadir el nombre del autor o marca, con opción de alineación.
Version: 1.1
Author: Javica
*/

if (!defined('ABSPATH')) exit;

// ======================= FUNCIÓN DEL FOOTER ======================= //
function ca_mensaje_pie()
{
    // Recuperamos las opciones guardadas
    $ca_nombre_marca = get_option('ca_nombre_marca', '');
    $ca_alineacion = get_option('ca_alineacion', 'center'); // valor por defecto centrado
    $ca_color = get_option('ca_color', '#000000'); // valor por defecto negro
    $ca_anio = date("Y");

    // Determinar el estilo de alineación
    if ($ca_alineacion === 'left') {
        $estilo = 'text-align:left;';
    } elseif ($ca_alineacion === 'right') {
        $estilo = 'text-align:right;';
    } else {
        $estilo = 'text-align:center;';
    }

    // Añadir el color al estilo
    $estilo .= "color: $ca_color;";

    // Mostrar el mensaje con estilo
    if (!empty($ca_nombre_marca)) {
        echo "<p style='$estilo'>© $ca_anio $ca_nombre_marca</p>";
    } else {
        echo "<p style='$estilo'>© $ca_anio</p>";
    }
}
add_action('wp_footer', 'ca_mensaje_pie');

// ======================= MENÚ DEL PLUGIN ======================= //
function ca_crear_menu()
{
    add_menu_page(
        'Copyright Automático',
        'Copyright Automático',
        'manage_options',
        'mensaje-del-dia',
        'ca_pagina_configuracion'
    );
}
add_action('admin_menu', 'ca_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function ca_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['ca_nombre_marca']) && check_admin_referer('ca_guardar_nombre')) {
        $nombre = sanitize_text_field($_POST['ca_nombre_marca']);
        update_option('ca_nombre_marca', $nombre);

        $alineacion = sanitize_text_field($_POST['ca_alineacion']);
        update_option('ca_alineacion', $alineacion);

        $color = sanitize_hex_color($_POST['ca_color']);
        update_option('ca_color', $color);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $nombre_actual = get_option('ca_nombre_marca', '');
    $alineacion_actual = get_option('ca_alineacion', 'center');
    $color_actual = get_option('ca_color', '#000000');
    ?>
    <div class="wrap">
        <h1>Configuración del Copyright Automático</h1>
        <p>Escribe el nombre de tu empresa o tu nombre personal y elige cómo se alineará el texto en el pie de página.</p>

        <form method="post">
            <?php wp_nonce_field('ca_guardar_nombre'); ?>

            <p><strong>Nombre o marca:</strong></p>
            <input type="text" name="ca_nombre_marca" value="<?php echo esc_attr($nombre_actual); ?>" style="width: 300px;">
            <br><br>

            <p><strong>Alineación del texto:</strong></p>
            <label><input type="radio" name="ca_alineacion" value="left" <?php checked($alineacion_actual, 'left'); ?>> Izquierda</label><br>
            <label><input type="radio" name="ca_alineacion" value="center" <?php checked($alineacion_actual, 'center'); ?>> Centrada</label><br>
            <label><input type="radio" name="ca_alineacion" value="right" <?php checked($alineacion_actual, 'right'); ?>> Derecha</label>
            <br><br>

            <p><strong>Color del texto:</strong></p>
            <input type="color" name="ca_color" value="<?php echo esc_attr($color_actual); ?>">
            <br><br>

            <input type="submit" class="button-primary" value="Guardar configuración">
        </form>
    </div>
    <?php
}
