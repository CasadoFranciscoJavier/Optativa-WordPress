<?php
/*
Plugin Name: Tamaño de Texto Accesible
Description: Permite cambiar el tamaño de fuente global del sitio para mejorar la accesibilidad.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= APLICAR TAMAÑO DE FUENTE GLOBAL ======================= //
function tta_aplicar_tamano()
{
    $tta_tamano = get_option('tta_tamano', 'normal');

    // Determinar tamaño según configuración
    $font_size = '16px';
    if ($tta_tamano === 'pequeno') {
        $font_size = '14px';
    } elseif ($tta_tamano === 'grande') {
        $font_size = '18px';
    }

    // Inyectar CSS para cambiar el tamaño de fuente global
    echo '<style>
        body {
            font-size: ' . esc_attr($font_size) . ' !important;
        }

        /* Ajustar también párrafos y elementos de texto */
        p, li, span, div {
            font-size: inherit;
        }
    </style>';
}
add_action('wp_head', 'tta_aplicar_tamano');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function tta_crear_menu()
{
    add_menu_page(
        'Accesibilidad',
        'Accesibilidad',
        'manage_options',
        'tamano-texto',
        'tta_pagina_configuracion',
        'dashicons-universal-access'
    );
}
add_action('admin_menu', 'tta_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function tta_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['tta_tamano']) && check_admin_referer('tta_guardar_config')) {
        $tamano = sanitize_text_field($_POST['tta_tamano']);
        update_option('tta_tamano', $tamano);

        echo '<div class="updated"><p>✅ Tamaño de texto guardado correctamente.</p></div>';
    }

    // Leer valor actual
    $tta_tamano = get_option('tta_tamano', 'normal');
    ?>

    <div class="wrap">
        <h1>Configuración de Accesibilidad</h1>
        <p>Ajusta el tamaño de fuente global del sitio para mejorar la legibilidad.</p>

        <form method="post">
            <?php wp_nonce_field('tta_guardar_config'); ?>

            <h2>Tamaño de Fuente Global</h2>

            <p><strong>Selecciona el tamaño de texto:</strong></p>

            <p>
                <label>
                    <input type="radio" name="tta_tamano" value="pequeno" <?php checked($tta_tamano, 'pequeno'); ?>>
                    Pequeño (14px) - Para pantallas grandes o buena visión
                </label>
            </p>

            <p>
                <label>
                    <input type="radio" name="tta_tamano" value="normal" <?php checked($tta_tamano, 'normal'); ?>>
                    Normal (16px) - Tamaño estándar recomendado
                </label>
            </p>

            <p>
                <label>
                    <input type="radio" name="tta_tamano" value="grande" <?php checked($tta_tamano, 'grande'); ?>>
                    Grande (18px) - Para mejor legibilidad
                </label>
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📖 Sobre la accesibilidad web</h2>
        <div class="notice notice-info">
            <p><strong>¿Por qué es importante?</strong></p>
            <p>Permitir a los usuarios ajustar el tamaño del texto mejora la experiencia para personas con discapacidad visual o que simplemente prefieren texto más grande.</p>
            <p><strong>Ejemplo de uso:</strong> Un sitio web para personas mayores podría tener configurado por defecto "Grande".</p>
        </div>
    </div>

    <?php
}
