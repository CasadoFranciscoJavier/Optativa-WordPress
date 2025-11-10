<?php
/*
Plugin Name: Fondo Dinámico por Estación
Description: Cambia el color de fondo del sitio según la estación del año seleccionada.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= APLICAR FONDO SEGÚN ESTACIÓN ======================= //
function fe_aplicar_fondo()
{
    $fe_estacion = get_option('fe_estacion', 'primavera');

    // Determinar color según la estación
    $color_fondo = '#ffffff';
    $color_texto = '#000000';

    if ($fe_estacion === 'primavera') {
        $color_fondo = '#e8f5e9'; // Verde claro
        $color_texto = '#1b5e20'; // Verde oscuro
    } elseif ($fe_estacion === 'verano') {
        $color_fondo = '#fff3e0'; // Naranja claro
        $color_texto = '#e65100'; // Naranja oscuro
    } elseif ($fe_estacion === 'otono') {
        $color_fondo = '#fff8e1'; // Amarillo claro
        $color_texto = '#f57c00'; // Naranja
    } elseif ($fe_estacion === 'invierno') {
        $color_fondo = '#e3f2fd'; // Azul claro
        $color_texto = '#0d47a1'; // Azul oscuro
    }

    // Aplicar estilos
    echo '<style>
        body {
            background-color: ' . esc_attr($color_fondo) . ' !important;
            color: ' . esc_attr($color_texto) . ' !important;
            transition: background-color 0.5s, color 0.5s;
        }

        article,
        .entry-content,
        .entry-title {
            color: ' . esc_attr($color_texto) . ' !important;
        }
    </style>';
}
add_action('wp_head', 'fe_aplicar_fondo');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function fe_crear_menu()
{
    add_menu_page(
        'Fondo por Estación',
        'Fondo Estación',
        'manage_options',
        'fondo-estacion',
        'fe_pagina_configuracion',
        'dashicons-palmtree'
    );
}
add_action('admin_menu', 'fe_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function fe_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['fe_estacion']) && check_admin_referer('fe_guardar_config')) {
        $estacion = sanitize_text_field($_POST['fe_estacion']);
        update_option('fe_estacion', $estacion);

        echo '<div class="updated"><p>✅ Estación guardada correctamente.</p></div>';
    }

    // Leer valor actual
    $fe_estacion = get_option('fe_estacion', 'primavera');
    ?>

    <div class="wrap">
        <h1>Configuración de Fondo por Estación</h1>
        <p>Elige la estación del año y el sitio cambiará automáticamente sus colores.</p>

        <form method="post">
            <?php wp_nonce_field('fe_guardar_config'); ?>

            <h2>🌍 Selecciona la Estación</h2>

            <p>
                <label style="display: block; padding: 15px; background: #e8f5e9; margin-bottom: 10px; border-radius: 5px; cursor: pointer;">
                    <input type="radio" name="fe_estacion" value="primavera" <?php checked($fe_estacion, 'primavera'); ?>>
                    <strong>🌸 Primavera</strong> - Tonos verdes claros y frescos
                </label>
            </p>

            <p>
                <label style="display: block; padding: 15px; background: #fff3e0; margin-bottom: 10px; border-radius: 5px; cursor: pointer;">
                    <input type="radio" name="fe_estacion" value="verano" <?php checked($fe_estacion, 'verano'); ?>>
                    <strong>☀️ Verano</strong> - Tonos naranjas cálidos y brillantes
                </label>
            </p>

            <p>
                <label style="display: block; padding: 15px; background: #fff8e1; margin-bottom: 10px; border-radius: 5px; cursor: pointer;">
                    <input type="radio" name="fe_estacion" value="otono" <?php checked($fe_estacion, 'otono'); ?>>
                    <strong>🍂 Otoño</strong> - Tonos amarillos y naranjas otoñales
                </label>
            </p>

            <p>
                <label style="display: block; padding: 15px; background: #e3f2fd; margin-bottom: 10px; border-radius: 5px; cursor: pointer;">
                    <input type="radio" name="fe_estacion" value="invierno" <?php checked($fe_estacion, 'invierno'); ?>>
                    <strong>❄️ Invierno</strong> - Tonos azules fríos y nevados
                </label>
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Aplicar estación">
            </p>
        </form>

        <hr>

        <h2>🎨 Paleta de Colores</h2>
        <div class="notice notice-info">
            <p><strong>Primavera:</strong> Fondo verde claro (#e8f5e9) con texto verde oscuro</p>
            <p><strong>Verano:</strong> Fondo naranja claro (#fff3e0) con texto naranja oscuro</p>
            <p><strong>Otoño:</strong> Fondo amarillo claro (#fff8e1) con texto naranja</p>
            <p><strong>Invierno:</strong> Fondo azul claro (#e3f2fd) con texto azul oscuro</p>
        </div>

        <h2>💡 Casos de uso</h2>
        <div class="notice notice-success">
            <p>✅ Blogs que quieren reflejar la época del año</p>
            <p>✅ Sitios de turismo que destacan temporadas</p>
            <p>✅ Tiendas online con promociones estacionales</p>
            <p>✅ Páginas educativas que enseñan sobre las estaciones</p>
        </div>

        <h2>🔧 Mejoras posibles</h2>
        <div style="background: #f0f0f1; padding: 15px;">
            <p><strong>Versión avanzada:</strong> En lugar de seleccionar manualmente, el plugin podría detectar automáticamente la estación según la fecha:</p>
            <ul>
                <li>Primavera: 21 marzo - 20 junio</li>
                <li>Verano: 21 junio - 20 septiembre</li>
                <li>Otoño: 21 septiembre - 20 diciembre</li>
                <li>Invierno: 21 diciembre - 20 marzo</li>
            </ul>
            <p>Esto se haría con <code>date()</code> y condicionales.</p>
        </div>
    </div>

    <?php
}
