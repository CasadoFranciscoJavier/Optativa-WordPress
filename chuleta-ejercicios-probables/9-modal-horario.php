<?php
/*
Plugin Name: Modal Emergente por Horario
Description: Muestra un modal emergente solo en ciertos horarios configurables.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= MOSTRAR MODAL SEGÚN HORARIO ======================= //
function mh_mostrar_modal()
{
    // Recuperar configuración
    $mh_activo = get_option('mh_activo', false);
    $mh_mensaje = get_option('mh_mensaje', '¡Bienvenido a nuestro sitio!');
    $mh_hora_inicio = get_option('mh_hora_inicio', 9);
    $mh_hora_fin = get_option('mh_hora_fin', 18);

    // Si no está activo, no hacer nada
    if (!$mh_activo) {
        return;
    }

    // Obtener hora actual
    $hora_actual = (int)date('H');

    // Verificar si estamos en el horario configurado
    $mostrar_modal = false;

    if ($mh_hora_inicio < $mh_hora_fin) {
        // Horario normal: ej. 9 a 18
        if ($hora_actual >= $mh_hora_inicio && $hora_actual < $mh_hora_fin) {
            $mostrar_modal = true;
        }
    } else {
        // Horario que cruza medianoche: ej. 20 a 7
        if ($hora_actual >= $mh_hora_inicio || $hora_actual < $mh_hora_fin) {
            $mostrar_modal = true;
        }
    }

    // Si no toca mostrar el modal, salir
    if (!$mostrar_modal) {
        return;
    }

    // Mostrar el modal
    ?>
    <div id="mh-modal" style="
        display: block;
        position: fixed;
        z-index: 999999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.7);
    ">
        <div style="
            background-color: white;
            margin: 10% auto;
            padding: 30px;
            border-radius: 10px;
            width: 80%;
            max-width: 500px;
            position: relative;
            box-shadow: 0 4px 6px rgba(0,0,0,0.3);
        ">
            <button onclick="document.getElementById('mh-modal').style.display='none'" style="
                position: absolute;
                top: 10px;
                right: 15px;
                font-size: 28px;
                font-weight: bold;
                background: none;
                border: none;
                cursor: pointer;
                color: #999;
            ">&times;</button>

            <div style="
                font-size: 20px;
                color: #333;
                text-align: center;
                margin-top: 20px;
            ">
                <?php echo esc_html($mh_mensaje); ?>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <button onclick="document.getElementById('mh-modal').style.display='none'" style="
                    background-color: #0073aa;
                    color: white;
                    padding: 10px 30px;
                    border: none;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                ">Cerrar</button>
            </div>
        </div>
    </div>
    <?php
}
add_action('wp_footer', 'mh_mostrar_modal');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function mh_crear_menu()
{
    add_menu_page(
        'Modal Horario',
        'Modal Horario',
        'manage_options',
        'modal-horario',
        'mh_pagina_configuracion',
        'dashicons-format-chat'
    );
}
add_action('admin_menu', 'mh_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function mh_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['mh_mensaje']) && check_admin_referer('mh_guardar_config')) {

        $mensaje = sanitize_textarea_field($_POST['mh_mensaje']);
        update_option('mh_mensaje', $mensaje);

        $hora_inicio = (int)sanitize_text_field($_POST['mh_hora_inicio']);
        update_option('mh_hora_inicio', $hora_inicio);

        $hora_fin = (int)sanitize_text_field($_POST['mh_hora_fin']);
        update_option('mh_hora_fin', $hora_fin);

        $activo = isset($_POST['mh_activo']);
        update_option('mh_activo', $activo);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $mh_mensaje = get_option('mh_mensaje', '¡Bienvenido a nuestro sitio!');
    $mh_hora_inicio = get_option('mh_hora_inicio', 9);
    $mh_hora_fin = get_option('mh_hora_fin', 18);
    $mh_activo = get_option('mh_activo', false);

    $hora_actual = date('H:i');
    ?>

    <div class="wrap">
        <h1>Configuración del Modal por Horario</h1>
        <p>Muestra un mensaje emergente solo durante ciertos horarios del día.</p>
        <p><strong>Hora actual del servidor:</strong> <?php echo esc_html($hora_actual); ?></p>

        <form method="post">
            <?php wp_nonce_field('mh_guardar_config'); ?>

            <h2>⚙️ Configuración</h2>

            <p>
                <label>
                    <input type="checkbox" name="mh_activo" <?php echo $mh_activo ? 'checked' : ''; ?>>
                    <strong>Activar modal emergente</strong>
                </label>
            </p>

            <p>
                <label for="mh_mensaje"><strong>Mensaje del modal:</strong></label><br>
                <textarea id="mh_mensaje"
                          name="mh_mensaje"
                          rows="4"
                          style="width: 100%; max-width: 600px;"><?php echo esc_textarea($mh_mensaje); ?></textarea>
            </p>

            <p>
                <label for="mh_hora_inicio"><strong>Hora de inicio (24h):</strong></label><br>
                <input type="number"
                       id="mh_hora_inicio"
                       name="mh_hora_inicio"
                       min="0"
                       max="23"
                       value="<?php echo esc_attr($mh_hora_inicio); ?>"
                       style="width: 100px;">
                <small>Hora en formato 24h (0-23). Ej: 9 para las 9am</small>
            </p>

            <p>
                <label for="mh_hora_fin"><strong>Hora de fin (24h):</strong></label><br>
                <input type="number"
                       id="mh_hora_fin"
                       name="mh_hora_fin"
                       min="0"
                       max="23"
                       value="<?php echo esc_attr($mh_hora_fin); ?>"
                       style="width: 100px;">
                <small>Hora en formato 24h (0-23). Ej: 18 para las 6pm</small>
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📝 Ejemplos de uso</h2>
        <div class="notice notice-info">
            <p><strong>Horario comercial:</strong> Inicio: 9, Fin: 18 → Modal aparece de 9am a 6pm</p>
            <p><strong>Promoción nocturna:</strong> Inicio: 20, Fin: 2 → Modal aparece de 8pm a 2am</p>
            <p><strong>Todo el día:</strong> Inicio: 0, Fin: 23 → Modal aparece siempre</p>
        </div>

        <h2>💡 Casos de uso</h2>
        <div class="notice notice-success">
            <p>✅ Avisar sobre horarios de atención al cliente</p>
            <p>✅ Promociones especiales en ciertos horarios</p>
            <p>✅ Mensajes de bienvenida durante horario laboral</p>
            <p>✅ Avisos urgentes temporales</p>
        </div>
    </div>

    <?php
}
