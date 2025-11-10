<?php
/*
Plugin Name: Temporizador de Cuenta Regresiva
Description: Muestra una cuenta regresiva para un evento específico con fecha y hora configurables.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= MOSTRAR CUENTA REGRESIVA ======================= //
function cr_mostrar_temporizador()
{
    // Recuperar configuración
    $cr_fecha = get_option('cr_fecha', '');
    $cr_hora = get_option('cr_hora', '00:00');
    $cr_mensaje = get_option('cr_mensaje', 'Cuenta regresiva para el evento:');
    $cr_mensaje_fin = get_option('cr_mensaje_fin', '¡El evento ha comenzado!');
    $cr_color_texto = get_option('cr_color_texto', '#0073aa');
    $cr_posicion = get_option('cr_posicion', 'footer');

    // Si no hay fecha configurada, no mostrar nada
    if (empty($cr_fecha)) {
        return;
    }

    // Combinar fecha y hora para crear timestamp
    $fecha_completa = $cr_fecha . ' ' . $cr_hora;
    $timestamp_evento = strtotime($fecha_completa);
    $timestamp_actual = time();

    // Calcular diferencia en segundos
    $diferencia = $timestamp_evento - $timestamp_actual;

    // Variable para el HTML que vamos a mostrar
    $html = '';

    // Si el evento ya pasó, mostrar mensaje final
    if ($diferencia <= 0) {
        $html = "<div style='
            text-align: center;
            color: " . esc_attr($cr_color_texto) . ";
            font-size: 24px;
            font-weight: bold;
            padding: 20px;
            margin: 20px 0;
        '>" . esc_html($cr_mensaje_fin) . "</div>";
    } else {
        // Calcular días, horas, minutos y segundos
        $dias = floor($diferencia / (60 * 60 * 24));
        $horas = floor(($diferencia % (60 * 60 * 24)) / (60 * 60));
        $minutos = floor(($diferencia % (60 * 60)) / 60);
        $segundos = $diferencia % 60;

        // Construir el HTML de la cuenta regresiva
        $html = "<div style='
            text-align: center;
            color: " . esc_attr($cr_color_texto) . ";
            padding: 20px;
            margin: 20px 0;
        '>
            <p style='font-size: 18px; margin-bottom: 10px;'>" . esc_html($cr_mensaje) . "</p>
            <div style='font-size: 32px; font-weight: bold;'>
                <span style='display: inline-block; margin: 0 10px;'>
                    <strong>" . $dias . "</strong><br>
                    <small style='font-size: 14px;'>días</small>
                </span>
                <span style='display: inline-block; margin: 0 10px;'>
                    <strong>" . $horas . "</strong><br>
                    <small style='font-size: 14px;'>horas</small>
                </span>
                <span style='display: inline-block; margin: 0 10px;'>
                    <strong>" . $minutos . "</strong><br>
                    <small style='font-size: 14px;'>minutos</small>
                </span>
                <span style='display: inline-block; margin: 0 10px;'>
                    <strong>" . $segundos . "</strong><br>
                    <small style='font-size: 14px;'>segundos</small>
                </span>
            </div>
        </div>";
    }

    echo $html;
}

// Añadir a header o footer según configuración
function cr_agregar_temporizador()
{
    $cr_posicion = get_option('cr_posicion', 'footer');

    if ($cr_posicion === 'header') {
        add_action('wp_head', 'cr_mostrar_temporizador');
    } else {
        add_action('wp_footer', 'cr_mostrar_temporizador');
    }
}
add_action('init', 'cr_agregar_temporizador');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function cr_crear_menu()
{
    add_menu_page(
        'Cuenta Regresiva',
        'Cuenta Regresiva',
        'manage_options',
        'cuenta-regresiva',
        'cr_pagina_configuracion',
        'dashicons-clock'
    );
}
add_action('admin_menu', 'cr_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function cr_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['cr_fecha']) && check_admin_referer('cr_guardar_config')) {

        $fecha = sanitize_text_field($_POST['cr_fecha']);
        update_option('cr_fecha', $fecha);

        $hora = sanitize_text_field($_POST['cr_hora']);
        update_option('cr_hora', $hora);

        $mensaje = sanitize_text_field($_POST['cr_mensaje']);
        update_option('cr_mensaje', $mensaje);

        $mensaje_fin = sanitize_text_field($_POST['cr_mensaje_fin']);
        update_option('cr_mensaje_fin', $mensaje_fin);

        $color_texto = sanitize_hex_color($_POST['cr_color_texto']);
        update_option('cr_color_texto', $color_texto);

        $posicion = sanitize_text_field($_POST['cr_posicion']);
        update_option('cr_posicion', $posicion);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $cr_fecha = get_option('cr_fecha', '');
    $cr_hora = get_option('cr_hora', '00:00');
    $cr_mensaje = get_option('cr_mensaje', 'Cuenta regresiva para el evento:');
    $cr_mensaje_fin = get_option('cr_mensaje_fin', '¡El evento ha comenzado!');
    $cr_color_texto = get_option('cr_color_texto', '#0073aa');
    $cr_posicion = get_option('cr_posicion', 'footer');

    // Fecha y hora actual para referencia
    $fecha_actual = date('Y-m-d');
    $hora_actual = date('H:i');
    ?>

    <div class="wrap">
        <h1>Configuración de Cuenta Regresiva</h1>
        <p>Configura una cuenta regresiva para un evento específico.</p>
        <p><strong>Fecha y hora actual del servidor:</strong> <?php echo esc_html($fecha_actual . ' ' . $hora_actual); ?></p>

        <form method="post">
            <?php wp_nonce_field('cr_guardar_config'); ?>

            <table class="form-table">
                <tr>
                    <th><label for="cr_fecha">Fecha del evento:</label></th>
                    <td>
                        <input type="date"
                               id="cr_fecha"
                               name="cr_fecha"
                               value="<?php echo esc_attr($cr_fecha); ?>"
                               required>
                        <p class="description">Selecciona la fecha del evento</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="cr_hora">Hora del evento:</label></th>
                    <td>
                        <input type="time"
                               id="cr_hora"
                               name="cr_hora"
                               value="<?php echo esc_attr($cr_hora); ?>"
                               required>
                        <p class="description">Hora en formato 24h</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="cr_mensaje">Mensaje antes del evento:</label></th>
                    <td>
                        <input type="text"
                               id="cr_mensaje"
                               name="cr_mensaje"
                               value="<?php echo esc_attr($cr_mensaje); ?>"
                               style="width: 400px;"
                               placeholder="Ej: Falta poco para el gran evento">
                        <p class="description">Texto que aparece mientras la cuenta regresiva está activa</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="cr_mensaje_fin">Mensaje cuando termine:</label></th>
                    <td>
                        <input type="text"
                               id="cr_mensaje_fin"
                               name="cr_mensaje_fin"
                               value="<?php echo esc_attr($cr_mensaje_fin); ?>"
                               style="width: 400px;"
                               placeholder="Ej: ¡Ya estamos en vivo!">
                        <p class="description">Texto que aparece cuando la fecha del evento ya ha pasado</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="cr_color_texto">Color del texto:</label></th>
                    <td>
                        <input type="color"
                               id="cr_color_texto"
                               name="cr_color_texto"
                               value="<?php echo esc_attr($cr_color_texto); ?>">
                    </td>
                </tr>

                <tr>
                    <th>Posición:</th>
                    <td>
                        <label><input type="radio" name="cr_posicion" value="header" <?php checked($cr_posicion, 'header'); ?>> Parte superior (header)</label><br>
                        <label><input type="radio" name="cr_posicion" value="footer" <?php checked($cr_posicion, 'footer'); ?>> Parte inferior (footer)</label>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <div class="notice notice-warning">
            <p><strong>⚠️ Importante:</strong> La cuenta regresiva se calcula con la hora del servidor, no con la hora del navegador del visitante.</p>
        </div>
    </div>

    <?php
}
