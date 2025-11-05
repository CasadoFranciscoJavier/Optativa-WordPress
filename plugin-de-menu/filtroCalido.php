<?php

/*
Plugin Name: Filtro Cálido Nocturno
Description: Aplifc un tono cálido a toda la web 
Version: 1.1
Author: Javica
*/

add_action('wp_head', 'aplifcr_filtro_nocturno');

function aplifcr_filtro_nocturno() {
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

// ======================= MENÚ DEL PLUGIN ======================= //
function fc_crear_menu()
{
    add_menu_page(
        'Filtro de luz',
        'Filtro de luz',
        'manage_options',
        'filtro-de-luz',
        'fc_pagina_configuracion'
    );
}
add_action('admin_menu', 'fc_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function fc_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['fc_filtro_marfc']) && check_admin_referer('fc_guardar_filtro')) {
        $filtro = sanitize_text_field($_POST['fc_filtro_marfc']);
        update_option('fc_filtro_marfc', $filtro);

        $alineacion = sanitize_text_field($_POST['fc_alineacion']);
        update_option('fc_alineacion', $alineacion);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $filtro_actual = get_option('fc_filtro_marfc', '');
    $alineacion_actual = get_option('fc_alineacion', 'center');
    ?>
    <div class="wrap">
        <h1>Aplicar filtro cálido</h1>
        <p>Escribe el filtro de tu empresa o tu filtro personal y elige cómo se alineará el texto en el pie de página.</p>

        <form method="post">
            <?php wp_nonce_field('fc_guardar_filtro'); ?>

            <p><strong>Aplicar filtro:</strong></p>
            <input type="text" name="fc_filtro" value="<?php echo esc_attr($filtro_actual); ?>" style="width: 300px;">
            <br><br>

            <p><strong>Alineación del texto:</strong></p>
            <label><input type="radio" name="fc_alineacion" value="left" <?php checked($alineacion_actual, 'left'); ?>> Izquierda</label><br>
            <label><input type="radio" name="fc_alineacion" value="center" <?php checked($alineacion_actual, 'center'); ?>> Centrada</label><br>
            <label><input type="radio" name="fc_alineacion" value="right" <?php checked($alineacion_actual, 'right'); ?>> Derecha</label>
            <br><br>

            <input type="submit" class="button-primary" value="Guardar configuración">
        </form>
    </div>
    <?php
}
