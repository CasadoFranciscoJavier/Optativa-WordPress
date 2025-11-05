<?php
/*
Plugin Name: Copyright automático
Description: Cambia de forma automática el año del copyright en el pie de pagina.
Version: 1.0
Author: [Tu nombre]
*/

// Evitar acceso directo
if ( !defined('ABSPATH') ) exit;


// Plugin 1 – Copyright automático
// Crea un plugin que muestre en el pie de página el símbolo © seguido del año actual, para que se actualice automáticamente cada nuevo año.
// Le ponemos ca_ delante (copyright automatico) para diferenciarlo de otras funciones por si tienen el mismo nombre

function ca_mensaje_footer() {
    $ca_anio_actual = date('Y'); 
    echo '<p style="text-align:center; color: gray;">Copyright ' . $ca_anio_actual . '</p>';
}

add_action('wp_footer', 'ca_mensaje_footer');