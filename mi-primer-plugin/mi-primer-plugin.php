<?php
/*
Plugin Name: Mi Primer Plugin
Description: Nuestro primer plugin del taller.
Version: 1.0
Author: [Tu nombre]
*/

// Evitar acceso directo
if ( !defined('ABSPATH') ) exit;

// Acción: agregar texto al pie del sitio
function mensaje_pie() {
    echo '<p style="text-align:center; color: gray;">🌟 Hecho con mi primer plugin 🌟</p>';
}

function mensaje_header() {
    echo '<p style="text-align:center; color: gray;">🌟 Hecho con mi primer plugin para la cabecera 🌟</p>';
}

// Enganchar la función al evento del pie
add_action('wp_footer', 'mensaje_pie');
add_action('wp_head', 'mensaje_header');


function mensaje_en_contenido($contenido) {
    return $contenido . '<p style="color:gray;">- Hecho con mi primer plugin para el contenido</p>';
}
add_filter('the_content', 'mensaje_en_contenido');



// Añadir un emoji al final de cada título
function mi_plugin_modificar_titulo($titulo) {
    if (is_singular()) { // Solo en páginas o entradas individuales
        $titulo .= '🎪 ';
    }
    return $titulo;
}
add_filter('the_title', 'mi_plugin_modificar_titulo');

//Añadir enlace a la barra de administración
//Ejemplo de action hook con admin_bar_menu.
function enlace_barra_admin($admin_bar) {
    $admin_bar->add_menu(array(
        'id'    => 'mi-enlace',
        'title' => '💡 Ir al Frontend',
        'href'  => home_url(),
    ));
}
add_action('admin_bar_menu', 'enlace_barra_admin', 100);





// Activar funciones del tema al iniciar
function mi_configuracion_tema() {
    // Permitir imágenes destacadas (post-thumbnails)
    add_theme_support('post-thumbnails');

    // Registrar un menú personalizado
    register_nav_menu('menu-principal', 'Menú Principal');

    // Activar soporte para logotipo personalizado
    add_theme_support('custom-logo', array(
        'height'      => 120,
        'width'       => 120,
        'flex-width'  => true,
        'flex-height' => true,
    ));

    // Activar soporte para fondos personalizados
    add_theme_support('custom-background', array(
        'default-color' => 'f0f0f0',
        'default-image' => '',
    ));

    // Registrar tamaño personalizado de imagen
    add_image_size('miniatura-cuadrada', 200, 200, true);
}
add_action('after_setup_theme', 'mi_configuracion_tema');


// functions.php o tu plugin
add_action('admin_menu', 'menu_personalizado');

function menu_personalizado() {
    add_menu_page(
        'Mi Página',           // Título de la página
        'Mi Menú',             // Nombre del menú en el admin
        'manage_options',      // Capacidad requerida
        'mi-menu-slug',        // Slug único
        'mostrar_contenido'    // Función que muestra el contenido
    );
}

function mostrar_contenido() {
    echo '<h1>¡Bienvenido a mi menú personalizado!</h1>';
}


// Plugin 1 – Copyright automático
// Crea un plugin que muestre en el pie de página el símbolo © seguido del año actual, para que se actualice automáticamente cada nuevo año.


function mensaje_footer() {
    $anio_actual = date('Y'); 
    echo '<p style="text-align:center; color: gray;">Copyright ' . $anio_actual . '</p>';
}

add_action('wp_footer', 'mensaje_footer');





