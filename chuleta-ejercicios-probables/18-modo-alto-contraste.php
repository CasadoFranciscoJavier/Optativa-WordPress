<?php
/*
Plugin Name: Modo Alto Contraste
Description: Permite activar un modo de alto contraste para mejorar la accesibilidad.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= APLICAR MODO ALTO CONTRASTE ======================= //
function mac_aplicar_modo()
{
    $mac_activo = get_option('mac_activo', false);

    if (!$mac_activo) {
        return;
    }

    echo '<style>
        body {
            background-color: #000000 !important;
            color: #FFFFFF !important;
        }

        a {
            color: #FFFF00 !important;
        }

        h1, h2, h3, h4, h5, h6 {
            color: #FFFFFF !important;
        }

        .entry-content,
        .entry-title,
        article {
            color: #FFFFFF !important;
            background-color: #000000 !important;
        }
    </style>';
}
add_action('wp_head', 'mac_aplicar_modo');

// ======================= CREAR MENÚ ======================= //
function mac_crear_menu()
{
    add_menu_page(
        'Alto Contraste',
        'Alto Contraste',
        'manage_options',
        'modo-alto-contraste',
        'mac_pagina_configuracion',
        'dashicons-visibility'
    );
}
add_action('admin_menu', 'mac_crear_menu');

// ======================= CONFIGURACIÓN ======================= //
function mac_pagina_configuracion()
{
    if (isset($_POST['mac_activo']) && check_admin_referer('mac_guardar')) {
        update_option('mac_activo', isset($_POST['mac_activo']));
        echo '<div class="updated"><p>✅ Configuración guardada.</p></div>';
    }

    $mac_activo = get_option('mac_activo', false);
    ?>

    <div class="wrap">
        <h1>Modo de Alto Contraste</h1>
        <p>Mejora la legibilidad para personas con discapacidad visual o sensibilidad a la luz.</p>

        <form method="post">
            <?php wp_nonce_field('mac_guardar'); ?>

            <p>
                <label>
                    <input type="checkbox" name="mac_activo" <?php echo $mac_activo ? 'checked' : ''; ?>>
                    <strong>Activar modo de alto contraste</strong>
                </label>
            </p>

            <p class="description">
                Cuando está activo: Fondo negro, texto blanco, enlaces amarillos
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>💡 Sobre la accesibilidad</h2>
        <div class="notice notice-info">
            <p>El alto contraste ayuda a personas con:</p>
            <p>✅ Baja visión</p>
            <p>✅ Daltonismo</p>
            <p>✅ Sensibilidad a la luz</p>
            <p>✅ Problemas de lectura</p>
        </div>
    </div>
    <?php
}
