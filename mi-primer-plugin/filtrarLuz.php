<?php
/*
Plugin Name: Filtro Cálido Nocturno
Description: Aplica un tono cálido a toda la web (frontend) entre las 20:00 y las 07:00.
Version: 1.1
Author: Tu Nombre
*/

add_action('wp_head', 'aplicar_filtro_nocturno');

function aplicar_filtro_nocturno() {
    date_default_timezone_set('Europe/Madrid'); // Ajusta según tu zona
    $hora_actual = date('H');

    if ($hora_actual >= 8 || $hora_actual < 12) {
        echo '
        <style>
            body, html {
                filter: sepia(30%) hue-rotate(-15deg) brightness(110%) saturate(120%);
                background-color: #fff8e1 !important;
            }

            /* También forzamos el filtro en la barra admin si está visible */
            #wpadminbar {
                filter: sepia(35%) hue-rotate(-15deg) brightness(110%) saturate(120%);
            }
        </style>
        ';
    }
}