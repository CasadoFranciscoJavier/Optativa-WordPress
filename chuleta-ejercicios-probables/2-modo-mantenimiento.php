<?php
/*
Plugin Name: Modo Mantenimiento Programable
Description: Activa automáticamente una página de mantenimiento en un horario específico con mensaje personalizable.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= FUNCIÓN QUE ACTIVA EL MODO MANTENIMIENTO ======================= //
function mm_verificar_mantenimiento()
{
    // Recuperar configuración
    $mm_hora_inicio = get_option('mm_hora_inicio', 0);
    $mm_hora_fin = get_option('mm_hora_fin', 6);
    $mm_mensaje = get_option('mm_mensaje', 'Sitio en mantenimiento. Volveremos pronto.');
    $mm_color_fondo = get_option('mm_color_fondo', '#2c3e50');
    $mm_permitir_admin = get_option('mm_permitir_admin', true);

    // Si el usuario es administrador y se permite acceso, no hacer nada
    if ($mm_permitir_admin && current_user_can('manage_options')) {
        return;
    }

    // Obtener hora actual (formato 24h)
    $hora_actual = (int)date('H');

    // Verificar si estamos en horario de mantenimiento
    // Considerar rangos que cruzan medianoche (ej: 22:00 a 06:00)
    $en_mantenimiento = false;

    if ($mm_hora_inicio < $mm_hora_fin) {
        // Rango normal: ej: 2 a 6 (de 2:00 a 6:00)
        if ($hora_actual >= $mm_hora_inicio && $hora_actual < $mm_hora_fin) {
            $en_mantenimiento = true;
        }
    } else {
        // Rango que cruza medianoche: ej: 22 a 6 (de 22:00 a 6:00)
        if ($hora_actual >= $mm_hora_inicio || $hora_actual < $mm_hora_fin) {
            $en_mantenimiento = true;
        }
    }

    // Si estamos en modo mantenimiento, mostrar página y detener WordPress
    if ($en_mantenimiento) {
        wp_die(
            '<div style="
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh;
                background-color: ' . esc_attr($mm_color_fondo) . ';
                color: white;
                font-family: Arial, sans-serif;
                text-align: center;
                margin: 0;
            ">
                <div>
                    <h1 style="font-size: 48px; margin-bottom: 20px;">🔧 Mantenimiento</h1>
                    <p style="font-size: 20px;">' . esc_html($mm_mensaje) . '</p>
                    <p style="font-size: 14px; margin-top: 40px; opacity: 0.7;">
                        Horario de mantenimiento: ' . sprintf('%02d:00', $mm_hora_inicio) . ' - ' . sprintf('%02d:00', $mm_hora_fin) . '
                    </p>
                </div>
            </div>',
            'Sitio en Mantenimiento',
            ['response' => 503]
        );
    }
}
// template_redirect se ejecuta antes de cargar cualquier template
add_action('template_redirect', 'mm_verificar_mantenimiento');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function mm_crear_menu()
{
    add_menu_page(
        'Modo Mantenimiento',
        'Mantenimiento',
        'manage_options',
        'modo-mantenimiento',
        'mm_pagina_configuracion',
        'dashicons-hammer'  // Icono de herramienta
    );
}
add_action('admin_menu', 'mm_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function mm_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['mm_hora_inicio']) && check_admin_referer('mm_guardar_config')) {

        $hora_inicio = (int)sanitize_text_field($_POST['mm_hora_inicio']);
        update_option('mm_hora_inicio', $hora_inicio);

        $hora_fin = (int)sanitize_text_field($_POST['mm_hora_fin']);
        update_option('mm_hora_fin', $hora_fin);

        $mensaje = sanitize_textarea_field($_POST['mm_mensaje']);
        update_option('mm_mensaje', $mensaje);

        $color_fondo = sanitize_hex_color($_POST['mm_color_fondo']);
        update_option('mm_color_fondo', $color_fondo);

        $permitir_admin = isset($_POST['mm_permitir_admin']);
        update_option('mm_permitir_admin', $permitir_admin);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $mm_hora_inicio = get_option('mm_hora_inicio', 0);
    $mm_hora_fin = get_option('mm_hora_fin', 6);
    $mm_mensaje = get_option('mm_mensaje', 'Sitio en mantenimiento. Volveremos pronto.');
    $mm_color_fondo = get_option('mm_color_fondo', '#2c3e50');
    $mm_permitir_admin = get_option('mm_permitir_admin', true);

    // Mostrar hora actual para referencia
    $hora_actual = date('H:i');
    ?>

    <div class="wrap">
        <h1>Configuración del Modo Mantenimiento</h1>
        <p>El sitio mostrará una página de mantenimiento durante el horario configurado.</p>
        <p><strong>Hora actual del servidor:</strong> <?php echo esc_html($hora_actual); ?></p>

        <form method="post">
            <?php wp_nonce_field('mm_guardar_config'); ?>

            <table class="form-table">
                <tr>
                    <th><label for="mm_hora_inicio">Hora de inicio (24h):</label></th>
                    <td>
                        <input type="number"
                               id="mm_hora_inicio"
                               name="mm_hora_inicio"
                               min="0"
                               max="23"
                               value="<?php echo esc_attr($mm_hora_inicio); ?>">
                        <p class="description">Hora en formato 24h (0-23). Ej: 22 para las 10pm</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="mm_hora_fin">Hora de fin (24h):</label></th>
                    <td>
                        <input type="number"
                               id="mm_hora_fin"
                               name="mm_hora_fin"
                               min="0"
                               max="23"
                               value="<?php echo esc_attr($mm_hora_fin); ?>">
                        <p class="description">Hora en formato 24h (0-23). Ej: 6 para las 6am</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="mm_mensaje">Mensaje personalizado:</label></th>
                    <td>
                        <textarea id="mm_mensaje"
                                  name="mm_mensaje"
                                  rows="4"
                                  cols="50"><?php echo esc_textarea($mm_mensaje); ?></textarea>
                        <p class="description">Este mensaje se mostrará durante el mantenimiento</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="mm_color_fondo">Color de fondo:</label></th>
                    <td>
                        <input type="color"
                               id="mm_color_fondo"
                               name="mm_color_fondo"
                               value="<?php echo esc_attr($mm_color_fondo); ?>">
                    </td>
                </tr>

                <tr>
                    <th>Permitir acceso a administradores:</th>
                    <td>
                        <label>
                            <input type="checkbox"
                                   name="mm_permitir_admin"
                                   <?php echo $mm_permitir_admin ? 'checked' : ''; ?>>
                            Los administradores pueden ver el sitio durante el mantenimiento
                        </label>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <div class="notice notice-info">
            <p><strong>💡 Nota:</strong> Puedes configurar rangos que crucen medianoche. Por ejemplo, inicio: 22 y fin: 6 activará el mantenimiento de 22:00 a 6:00.</p>
        </div>
    </div>

    <?php
}
