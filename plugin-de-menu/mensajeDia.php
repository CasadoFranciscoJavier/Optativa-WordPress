<?php
/*
Plugin Name: Mensaje del Día
Description: Muestra un mensaje aleatorio en el pie de página con opción de emoji decorativo.
Version: 1.1
Author: Javica
*/

//require_once "mdd_admin_menu.php"; por si nos llevamos esta primera parte a otro archivo diferente

if ( !defined('ABSPATH') ) exit;

function mdd_mostrar_mensaje() {

    $frases = get_option("mdd_frases", []); // ponemos [] para que lea el array y no el string almacenado
    $emojiActivo = get_option('mdd_emoji_activo');

    $indice_aleatorio = array_rand($frases);
    $mensaje = $frases[$indice_aleatorio];

    echo "<p>". ($emojiActivo ? "🚀 " : "") ."$mensaje</p>";
}

// Enganchar la función al evento del pie
add_action('wp_footer', 'mdd_mostrar_mensaje');


// ======================= MENU DEL PLUGIN ======================= //

function mdd_crear_menu() {
    add_menu_page(
        'Mensaje del Día',
        'Mensaje del Día',
        'manage_options',
        'mensaje-del-dia',
        'mdd_pagina_configuracion'
    );
}

function mdd_pagina_configuracion() {

    // Si el formulario fue enviadoy el código generado con wp_nonce_field es correcto ...
    if ( isset($_POST['mdd_frases']) && check_admin_referer('mdd_guardar_frases') ) {

        // Limpia el texto
        $texto = sanitize_textarea_field($_POST['mdd_frases']);

        $emojiActivo = isset($_POST['mdd_emoji_activo']);

        // Divide el texto en líneas (una frase por línea)
        $frases = explode("\n", $texto);

        // Guarda las frases en la base de datos
        update_option('mdd_frases', $frases);
        update_option('mdd_emoji_activo', $emojiActivo);

        echo '<div class="updated"><p>✅ Frases guardadas correctamente.</p></div>';
    }

    // Leer las frases actuales (si hay)
    $frases = get_option('mdd_frases', []);
    $emojiActivo = get_option('mdd_emoji_activo');

    $contenido = implode("\n", $frases);
    ?>

    <div class="wrap">
        <h1>Configuración: Mensaje del Día</h1>
        <p>Escribe una frase por línea. Se mostrará una diferente cada vez que se cargue la página.</p>

        <form method="post">
            <?php wp_nonce_field('mdd_guardar_frases'); //sistema de seguridad llamado nonce (número único temporal). que hay que validar luego para impedir envíos no autorizado del formulario ?>
            <textarea name="mdd_frases" rows="10" cols="60"><?php echo esc_textarea($contenido); ?></textarea>
            <br><br>
            <label>Activar emoji: <input type="checkbox" name="mdd_emoji_activo" <?php echo $emojiActivo ? "checked" : "" ?>></label>
            <input type="submit" class="button-primary" value="Guardar frases">
        </form>
    </div>

    <?php
}

add_action('admin_menu', 'mdd_crear_menu');
