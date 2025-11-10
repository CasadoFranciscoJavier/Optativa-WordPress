<?php
/*
Plugin Name: Contenido Protegido con Contraseña
Description: Oculta una sección del sitio y solo la muestra si el usuario ingresa la contraseña correcta.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= MOSTRAR CONTENIDO PROTEGIDO ======================= //
function ocp_mostrar_seccion()
{
    $ocp_activo = get_option('ocp_activo', false);
    $ocp_password = get_option('ocp_password', '');
    $ocp_contenido = get_option('ocp_contenido', '');

    if (!$ocp_activo || empty($ocp_password)) {
        return;
    }

    // Verificar si el usuario ya ingresó la contraseña correcta (sesión)
    session_start();
    $password_correcta = isset($_SESSION['ocp_acceso']) && $_SESSION['ocp_acceso'] === true;

    // Si enviaron el formulario, verificar contraseña
    if (isset($_POST['ocp_password_input'])) {
        $input_password = sanitize_text_field($_POST['ocp_password_input']);
        if ($input_password === $ocp_password) {
            $_SESSION['ocp_acceso'] = true;
            $password_correcta = true;
        }
    }

    ?>
    <div style="padding: 30px; margin: 20px 0; background: #f9f9f9; border: 1px solid #ddd;">
        <?php if (!$password_correcta): ?>
            <h3>🔒 Contenido Protegido</h3>
            <p>Ingresa la contraseña para ver el contenido exclusivo:</p>
            <form method="post">
                <input type="password"
                       name="ocp_password_input"
                       placeholder="Contraseña"
                       style="padding: 10px; width: 250px;">
                <input type="submit" value="Acceder" class="button-primary">
            </form>
        <?php else: ?>
            <h3>✅ Contenido Exclusivo</h3>
            <div><?php echo wp_kses_post($ocp_contenido); ?></div>
        <?php endif; ?>
    </div>
    <?php
}
add_action('wp_footer', 'ocp_mostrar_seccion');

// ======================= CREAR MENÚ ======================= //
function ocp_crear_menu()
{
    add_menu_page(
        'Contenido Protegido',
        'Cont. Protegido',
        'manage_options',
        'contenido-protegido',
        'ocp_pagina_configuracion',
        'dashicons-lock'
    );
}
add_action('admin_menu', 'ocp_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function ocp_pagina_configuracion()
{
    if (isset($_POST['ocp_password']) && check_admin_referer('ocp_guardar_config')) {
        update_option('ocp_password', sanitize_text_field($_POST['ocp_password']));
        update_option('ocp_contenido', wp_kses_post($_POST['ocp_contenido']));
        update_option('ocp_activo', isset($_POST['ocp_activo']));
        echo '<div class="updated"><p>✅ Configuración guardada.</p></div>';
    }

    $ocp_password = get_option('ocp_password', '');
    $ocp_contenido = get_option('ocp_contenido', '');
    $ocp_activo = get_option('ocp_activo', false);
    ?>

    <div class="wrap">
        <h1>Contenido Protegido con Contraseña</h1>
        <form method="post">
            <?php wp_nonce_field('ocp_guardar_config'); ?>

            <p>
                <label>
                    <input type="checkbox" name="ocp_activo" <?php echo $ocp_activo ? 'checked' : ''; ?>>
                    Activar contenido protegido
                </label>
            </p>

            <p>
                <label><strong>Contraseña:</strong></label><br>
                <input type="text" name="ocp_password" value="<?php echo esc_attr($ocp_password); ?>" style="width: 300px;">
            </p>

            <p>
                <label><strong>Contenido protegido:</strong></label><br>
                <textarea name="ocp_contenido" rows="8" style="width: 100%; max-width: 600px;"><?php echo esc_textarea($ocp_contenido); ?></textarea>
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar">
            </p>
        </form>
    </div>
    <?php
}
