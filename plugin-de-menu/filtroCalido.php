<?php


// Plugin 2 – Filtro cálido nocturno configurable
// Crea un plugin que aplique un filtro amarillo o tono cálido a toda la web cuando sea de noche (por ejemplo, entre las 20:00 y las 07:00).

// 👉 Añade un menú de configuración para que el usuario pueda personalizar:

// La hora de inicio y hora de fin del modo nocturno.
// La intensidad del filtro cálido (por ejemplo: suave, medio o fuerte).
// El color exacto del filtro, usando un selector de color.

/*
Plugin Name: Filtro Cálido Nocturno
Description: Aplifc un tono cálido a toda la web 
Version: 1.1
Author: Javica
*/

if ( !defined('ABSPATH') ) exit;

// require_once "fla_admin_menu.php";  por si queremos hacer esta primera parte en otro archivo diferente

function fla_aplicar_filtro_luz() {

    $FLA_HORA_INICIO = get_option("fla_hora_inicio");
    $FLA_HORA_FIN = get_option("fla_hora_fin");
    $fla_color = get_option("fla_color");
    $fla_intensidad = get_option("fla_intensidad");

    $fla_hora_actual = date("H");
    if ($fla_hora_actual >= $FLA_HORA_INICIO || $fla_hora_actual <= $FLA_HORA_FIN){
        echo "<div style='
                position: fixed; 
                top: 0; 
                left: 0; 
                width: 100dvw; 
                height: 100dvh; 
                background-color: $fla_color; 
                opacity: $fla_intensidad; 
                pointer-events: none'>
             </div>";
    }
}

// Enganchar la función al evento del pie
add_action('wp_footer', 'fla_aplicar_filtro_luz');

// ======================= MENÚ DEL PLUGIN ======================= //
function fla_crear_menu() {
    add_menu_page(
        'Filtro de Luz Azul',
        'Filtro de Luz Azul',
        'manage_options',
        'filtro-luz-azul',
        'fla_pagina_configuracion'
    );
}

function fla_pagina_configuracion() {

    // Si el formulario fue enviadoy el código generado con wp_nonce_field es correcto ...
    if ( isset($_POST['fla_hora_inicio']) && check_admin_referer('fla_configuracion') ) {

        $fla_hora_inicio = $_POST["fla_hora_inicio"];
        $fla_hora_fin = $_POST["fla_hora_fin"];
        $fla_color = $_POST["fla_color"];
        $fla_intensidad = $_POST["fla_intensidad"];

        update_option('fla_hora_inicio', $fla_hora_inicio);
        update_option('fla_hora_fin', $fla_hora_fin);
        update_option('fla_color', $fla_color);
        update_option('fla_intensidad', $fla_intensidad);

        echo '<div class="updated"><p>✅ Frases guardadas correctamente.</p></div>';
    }

    $fla_hora_inicio = get_option("fla_hora_inicio");
    $fla_hora_fin = get_option("fla_hora_fin");
    $fla_color = get_option("fla_color");
    $fla_intensidad = get_option("fla_intensidad");

    ?>

    <div class="wrap">
        <h1>Configuración: Filtro</h1>
        <p>Elige un color e intensidad para el filtro de tu página.</p>

        <form method="post">
            <?php wp_nonce_field('fla_configuracion');?>
            
            <label>Hora de inicio: <input name="fla_hora_inicio" type="number" min="00" max="23" value="<?php echo $fla_hora_inicio ?>"></label><br>
            
            <label>Hora de Fin: <input name="fla_hora_fin" type="number" min="00" max="23" value="<?php echo $fla_hora_fin ?>"></label><br>

            <label>Color: <input name="fla_color" type="color" value="<?php echo $fla_color ?>"></label><br>

            <label>Intensidad: <input name="fla_intensidad" type="range" min="0" max="1" step="0.01" value="<?php echo $fla_intensidad ?>"></label><br>

            <input type="submit" class="button-primary" value="Guardar configuracion">
        </form>
    </div>

    <?php
}

add_action('admin_menu', 'fla_crear_menu');


