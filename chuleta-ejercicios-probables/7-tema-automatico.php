<?php
/*
Plugin Name: Cambio de Tema Automático por Horario
Description: Cambia automáticamente el esquema de colores del sitio según la hora del día (modo claro/oscuro).
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= APLICAR TEMA SEGÚN HORARIO ======================= //
function ta_aplicar_tema()
{
    // Recuperar configuración
    $ta_hora_oscuro = get_option('ta_hora_oscuro', 20);
    $ta_hora_claro = get_option('ta_hora_claro', 7);
    $ta_fondo_oscuro = get_option('ta_fondo_oscuro', '#1a1a1a');
    $ta_texto_oscuro = get_option('ta_texto_oscuro', '#ffffff');
    $ta_fondo_claro = get_option('ta_fondo_claro', '#ffffff');
    $ta_texto_claro = get_option('ta_texto_claro', '#000000');

    // Obtener hora actual
    $hora_actual = (int)date('H');

    // Variables para el tema a aplicar
    $color_fondo = '';
    $color_texto = '';

    // Determinar qué tema aplicar según la hora
    // Similar a la lógica del modo mantenimiento
    $modo_oscuro = false;

    if ($ta_hora_oscuro < $ta_hora_claro) {
        // Rango normal: ej: 2 a 8 (modo oscuro de 2:00 a 8:00)
        if ($hora_actual >= $ta_hora_oscuro && $hora_actual < $ta_hora_claro) {
            $modo_oscuro = true;
        }
    } else {
        // Rango que cruza medianoche: ej: 20 a 7 (modo oscuro de 20:00 a 7:00)
        if ($hora_actual >= $ta_hora_oscuro || $hora_actual < $ta_hora_claro) {
            $modo_oscuro = true;
        }
    }

    // Asignar colores según el modo
    if ($modo_oscuro) {
        $color_fondo = $ta_fondo_oscuro;
        $color_texto = $ta_texto_oscuro;
    } else {
        $color_fondo = $ta_fondo_claro;
        $color_texto = $ta_texto_claro;
    }

    // Inyectar CSS personalizado en el head
    echo "<style>
        body {
            background-color: $color_fondo !important;
            color: $color_texto !important;
            transition: background-color 0.5s, color 0.5s;
        }

        /* Ajustar también los enlaces para que sean visibles */
        body a {
            color: $color_texto;
            opacity: 0.8;
        }

        body a:hover {
            opacity: 1;
        }

        /* Asegurar que los artículos y entradas también tengan el color correcto */
        .entry-content,
        .entry-title,
        .site-title,
        .site-description,
        article {
            color: $color_texto !important;
        }
    </style>";
}
add_action('wp_head', 'ta_aplicar_tema');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function ta_crear_menu()
{
    add_menu_page(
        'Tema Automático',
        'Tema Automático',
        'manage_options',
        'tema-automatico',
        'ta_pagina_configuracion',
        'dashicons-admin-appearance'
    );
}
add_action('admin_menu', 'ta_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function ta_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['ta_hora_oscuro']) && check_admin_referer('ta_guardar_config')) {

        $hora_oscuro = (int)sanitize_text_field($_POST['ta_hora_oscuro']);
        update_option('ta_hora_oscuro', $hora_oscuro);

        $hora_claro = (int)sanitize_text_field($_POST['ta_hora_claro']);
        update_option('ta_hora_claro', $hora_claro);

        $fondo_oscuro = sanitize_hex_color($_POST['ta_fondo_oscuro']);
        update_option('ta_fondo_oscuro', $fondo_oscuro);

        $texto_oscuro = sanitize_hex_color($_POST['ta_texto_oscuro']);
        update_option('ta_texto_oscuro', $texto_oscuro);

        $fondo_claro = sanitize_hex_color($_POST['ta_fondo_claro']);
        update_option('ta_fondo_claro', $fondo_claro);

        $texto_claro = sanitize_hex_color($_POST['ta_texto_claro']);
        update_option('ta_texto_claro', $texto_claro);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $ta_hora_oscuro = get_option('ta_hora_oscuro', 20);
    $ta_hora_claro = get_option('ta_hora_claro', 7);
    $ta_fondo_oscuro = get_option('ta_fondo_oscuro', '#1a1a1a');
    $ta_texto_oscuro = get_option('ta_texto_oscuro', '#ffffff');
    $ta_fondo_claro = get_option('ta_fondo_claro', '#ffffff');
    $ta_texto_claro = get_option('ta_texto_claro', '#000000');

    // Hora actual
    $hora_actual = date('H:i');
    ?>

    <div class="wrap">
        <h1>Configuración de Tema Automático</h1>
        <p>El sitio cambiará automáticamente entre modo claro y oscuro según la hora del día.</p>
        <p><strong>Hora actual del servidor:</strong> <?php echo esc_html($hora_actual); ?></p>

        <form method="post">
            <?php wp_nonce_field('ta_guardar_config'); ?>

            <h2>⏰ Horarios</h2>
            <table class="form-table">
                <tr>
                    <th><label for="ta_hora_oscuro">Inicio del modo oscuro (24h):</label></th>
                    <td>
                        <input type="number"
                               id="ta_hora_oscuro"
                               name="ta_hora_oscuro"
                               min="0"
                               max="23"
                               value="<?php echo esc_attr($ta_hora_oscuro); ?>">
                        <p class="description">Hora en formato 24h. Ej: 20 para las 8pm</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="ta_hora_claro">Inicio del modo claro (24h):</label></th>
                    <td>
                        <input type="number"
                               id="ta_hora_claro"
                               name="ta_hora_claro"
                               min="0"
                               max="23"
                               value="<?php echo esc_attr($ta_hora_claro); ?>">
                        <p class="description">Hora en formato 24h. Ej: 7 para las 7am</p>
                    </td>
                </tr>
            </table>

            <h2>🌙 Modo Oscuro (Nocturno)</h2>
            <table class="form-table">
                <tr>
                    <th><label for="ta_fondo_oscuro">Color de fondo:</label></th>
                    <td>
                        <input type="color"
                               id="ta_fondo_oscuro"
                               name="ta_fondo_oscuro"
                               value="<?php echo esc_attr($ta_fondo_oscuro); ?>">
                        <span style="margin-left: 10px;"><?php echo esc_html($ta_fondo_oscuro); ?></span>
                    </td>
                </tr>

                <tr>
                    <th><label for="ta_texto_oscuro">Color del texto:</label></th>
                    <td>
                        <input type="color"
                               id="ta_texto_oscuro"
                               name="ta_texto_oscuro"
                               value="<?php echo esc_attr($ta_texto_oscuro); ?>">
                        <span style="margin-left: 10px;"><?php echo esc_html($ta_texto_oscuro); ?></span>
                    </td>
                </tr>
            </table>

            <h2>☀️ Modo Claro (Diurno)</h2>
            <table class="form-table">
                <tr>
                    <th><label for="ta_fondo_claro">Color de fondo:</label></th>
                    <td>
                        <input type="color"
                               id="ta_fondo_claro"
                               name="ta_fondo_claro"
                               value="<?php echo esc_attr($ta_fondo_claro); ?>">
                        <span style="margin-left: 10px;"><?php echo esc_html($ta_fondo_claro); ?></span>
                    </td>
                </tr>

                <tr>
                    <th><label for="ta_texto_claro">Color del texto:</label></th>
                    <td>
                        <input type="color"
                               id="ta_texto_claro"
                               name="ta_texto_claro"
                               value="<?php echo esc_attr($ta_texto_claro); ?>">
                        <span style="margin-left: 10px;"><?php echo esc_html($ta_texto_claro); ?></span>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <div class="notice notice-info">
            <p><strong>💡 Ejemplo:</strong> Si configuras inicio oscuro: 20 e inicio claro: 7, el modo oscuro estará activo de 20:00 a 6:59.</p>
        </div>

        <div class="notice notice-warning">
            <p><strong>⚠️ Nota:</strong> Algunos temas pueden tener estilos CSS más específicos que sobrescriban estos colores. Si no ves cambios, puede que necesites ajustar el tema o usar un tema más simple.</p>
        </div>
    </div>

    <?php
}
