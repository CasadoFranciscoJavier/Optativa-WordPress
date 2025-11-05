<?php
/*
Plugin Name: Mensaje del Día
Description: Muestra un mensaje aleatorio en el pie de página con opción de emoji decorativo.
Version: 1.1
Author: Isaac
*/

if (!defined('ABSPATH')) exit;

// ======================= FUNCIÓN PRINCIPAL ======================= //

function mdd_mostrar_mensaje()
{
    $mdd_frases = get_option("mdd_frases", []); // ponemos [] para que lea el array y no el string almacenado
    $mdd_emoji_activo = get_option("mdd_emoji_activo", false);


    $mdd_indice_aleatorio = array_rand($mdd_frases);
    $mdd_mensaje = esc_html($mdd_frases[$mdd_indice_aleatorio]);

    
    if ($mdd_emoji_activo) {
        $emoji = "🔥";
        echo "<p>$emoji $mdd_mensaje $emoji</p>";
    } else {
        echo "<p>$mdd_mensaje</p>";
    }
}

add_action('wp_footer', 'mdd_mostrar_mensaje');


// ======================= MENU DEL PLUGIN ======================= //

function mdd_crear_menu()
{
    add_menu_page(
        // 🅰️ 1️⃣ - TÍTULO DE LA PÁGINA (parte superior)
        // Este texto aparecerá en la barra de título del navegador
        // y también como encabezado dentro de la página de configuración.
        'Mensaje del Día',

        // 🅱️ 2️⃣ - TEXTO DEL MENÚ
        // Es el texto que se mostrará en el menú lateral de WordPress.
        // Ejemplo: En el panel verás un botón que dice "Mensaje del Día".
        'Mensaje del Día',

        // 🆎 3️⃣ - PERMISO NECESARIO
        // Define qué tipo de usuario puede ver este menú.
        // 'manage_options' significa que solo los administradores pueden verlo.
        // Si quisieras que los editores también lo vean, podrías usar 'edit_posts'.
        'manage_options',

        // 🔠 4️⃣ - SLUG (identificador interno)
        // Es una palabra única que identifica la página dentro de WordPress.
        // Aparecerá en la URL como ?page=mensaje-del-dia
        // y se usa también como "nombre interno" para este menú.
        'mensaje-del-dia',

        // 🧩 5️⃣ - FUNCIÓN QUE MOSTRARÁ EL CONTENIDO
        // Cuando el usuario haga clic en este menú,
        // WordPress llamará a esta función para generar el contenido HTML de la página.
        // Esa función la definiremos más abajo (por ejemplo, mdd_pagina_configuracion()).
        'mdd_pagina_configuracion'
    );
}
add_action('admin_menu', 'mdd_crear_menu');


// ======================= PÁGINA DE CONFIGURACIÓN ======================= //

function mdd_pagina_configuracion()
{

    // Guardar configuración cuando se envía el formulario
     // Si el formulario fue enviadoy el código generado con wp_nonce_field es correcto ...
    if (isset($_POST['mdd_frases']) && check_admin_referer('mdd_guardar_frases')) {

        // Guardar frases
          // Limpia el texto
        $texto = sanitize_textarea_field($_POST['mdd_frases']);
        $frases = explode("\n", $texto);

        // Guarda las frases en la base de datos
        update_option('mdd_frases', $frases);

        // Guardar estado del emoji (checkbox)
        $emoji_activo = isset($_POST['mdd_emoji_activo']) ? true : false;
        update_option('mdd_emoji_activo', $emoji_activo);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

     // Leer las frases actuales (si hay)
    $frases = get_option('mdd_frases', []);
    $contenido = implode("\n", $frases);
    $emoji_activo = get_option('mdd_emoji_activo', false);
?>

    <div class="wrap">
        <h1>Configuración: Mensaje del Día</h1>
        <p>Escribe una frase por línea. Se mostrará una diferente cada vez que se cargue la página.</p>

        <form method="post">
            <?php wp_nonce_field('mdd_guardar_frases'); //sistema de seguridad llamado nonce (número único temporal). que hay que validar luego para impedir envíos no autorizado del formulario ?>

            <textarea name="mdd_frases" rows="10" cols="60"><?php echo esc_textarea($contenido); ?></textarea>

            <p>
                <label>
                    <input type="checkbox" name="mdd_emoji_activo" value="1" <?php checked($emoji_activo, true); ?>>
                    Mostrar emoji decorativo junto al mensaje
                </label>
            </p>

            <input type="submit" class="button-primary" value="Guardar frases">
        </form>
    </div>

<?php
}
