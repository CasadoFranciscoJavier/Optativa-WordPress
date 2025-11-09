<?php
/*
Plugin Name: Redirección Automática tras Login
Description: Redirige a los usuarios a diferentes páginas según su rol después de iniciar sesión.
Version: 1.0
Author: Chuleta de Estudio

CONCEPTO NUEVO: Hook 'login_redirect' y trabajar con roles de usuario
*/

if (!defined('ABSPATH')) exit;

// ======================= REDIRIGIR SEGÚN ROL DE USUARIO ======================= //
function rl_redirigir_tras_login($redirect_to, $request, $user)
{
    // Verificar que el login fue exitoso y tenemos un usuario válido
    if (!isset($user->roles) || !is_array($user->roles)) {
        return $redirect_to;
    }

    // Verificar si la redirección está activada
    $rl_activo = get_option('rl_activo', false);
    if (!$rl_activo) {
        return $redirect_to;
    }

    // Recuperar URLs configuradas
    $rl_url_admin = get_option('rl_url_admin', '');
    $rl_url_editor = get_option('rl_url_editor', '');
    $rl_url_autor = get_option('rl_url_autor', '');
    $rl_url_colaborador = get_option('rl_url_colaborador', '');
    $rl_url_suscriptor = get_option('rl_url_suscriptor', '');

    // Variable para almacenar la URL de redirección final
    $url_final = $redirect_to;

    // Verificar el rol del usuario (el primero que coincida)
    // Orden de prioridad: administrador > editor > autor > colaborador > suscriptor
    if (in_array('administrator', $user->roles) && !empty($rl_url_admin)) {
        $url_final = $rl_url_admin;
    } elseif (in_array('editor', $user->roles) && !empty($rl_url_editor)) {
        $url_final = $rl_url_editor;
    } elseif (in_array('author', $user->roles) && !empty($rl_url_autor)) {
        $url_final = $rl_url_autor;
    } elseif (in_array('contributor', $user->roles) && !empty($rl_url_colaborador)) {
        $url_final = $rl_url_colaborador;
    } elseif (in_array('subscriber', $user->roles) && !empty($rl_url_suscriptor)) {
        $url_final = $rl_url_suscriptor;
    }

    return $url_final;
}
// HOOK NUEVO: login_redirect se ejecuta después de un login exitoso
// Parámetros: URL de redirección, URL solicitada, objeto usuario
add_filter('login_redirect', 'rl_redirigir_tras_login', 10, 3);

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function rl_crear_menu()
{
    add_menu_page(
        'Redirección Login',
        'Redir. Login',
        'manage_options',
        'redireccion-login',
        'rl_pagina_configuracion',
        'dashicons-admin-users'
    );
}
add_action('admin_menu', 'rl_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function rl_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['rl_url_admin']) && check_admin_referer('rl_guardar_config')) {

        $url_admin = esc_url_raw($_POST['rl_url_admin']);
        update_option('rl_url_admin', $url_admin);

        $url_editor = esc_url_raw($_POST['rl_url_editor']);
        update_option('rl_url_editor', $url_editor);

        $url_autor = esc_url_raw($_POST['rl_url_autor']);
        update_option('rl_url_autor', $url_autor);

        $url_colaborador = esc_url_raw($_POST['rl_url_colaborador']);
        update_option('rl_url_colaborador', $url_colaborador);

        $url_suscriptor = esc_url_raw($_POST['rl_url_suscriptor']);
        update_option('rl_url_suscriptor', $url_suscriptor);

        $activo = isset($_POST['rl_activo']);
        update_option('rl_activo', $activo);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $rl_url_admin = get_option('rl_url_admin', '');
    $rl_url_editor = get_option('rl_url_editor', '');
    $rl_url_autor = get_option('rl_url_autor', '');
    $rl_url_colaborador = get_option('rl_url_colaborador', '');
    $rl_url_suscriptor = get_option('rl_url_suscriptor', '');
    $rl_activo = get_option('rl_activo', false);

    // Obtener URL del sitio para ayuda
    $site_url = get_site_url();
    ?>

    <div class="wrap">
        <h1>Configuración de Redirección tras Login</h1>
        <p>Configura a dónde se redirigirá cada tipo de usuario después de iniciar sesión.</p>

        <form method="post">
            <?php wp_nonce_field('rl_guardar_config'); ?>

            <table class="form-table">
                <tr>
                    <th>Activar redirección:</th>
                    <td>
                        <label>
                            <input type="checkbox"
                                   name="rl_activo"
                                   <?php echo $rl_activo ? 'checked' : ''; ?>>
                            Activar redirección personalizada por rol
                        </label>
                        <p class="description">Si está desactivado, WordPress usará su comportamiento por defecto</p>
                    </td>
                </tr>
            </table>

            <h2>🔐 URLs de Redirección por Rol</h2>
            <p class="description">Deja en blanco los roles que no quieras redirigir. URL del sitio: <code><?php echo esc_html($site_url); ?></code></p>

            <table class="form-table">
                <tr>
                    <th><label for="rl_url_admin">👑 Administrador:</label></th>
                    <td>
                        <input type="url"
                               id="rl_url_admin"
                               name="rl_url_admin"
                               value="<?php echo esc_attr($rl_url_admin); ?>"
                               style="width: 500px;"
                               placeholder="<?php echo esc_attr($site_url); ?>/wp-admin">
                        <p class="description">URL para usuarios con rol de administrador</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="rl_url_editor">✏️ Editor:</label></th>
                    <td>
                        <input type="url"
                               id="rl_url_editor"
                               name="rl_url_editor"
                               value="<?php echo esc_attr($rl_url_editor); ?>"
                               style="width: 500px;"
                               placeholder="<?php echo esc_attr($site_url); ?>/wp-admin/edit.php">
                    </td>
                </tr>

                <tr>
                    <th><label for="rl_url_autor">📝 Autor:</label></th>
                    <td>
                        <input type="url"
                               id="rl_url_autor"
                               name="rl_url_autor"
                               value="<?php echo esc_attr($rl_url_autor); ?>"
                               style="width: 500px;"
                               placeholder="<?php echo esc_attr($site_url); ?>/wp-admin/profile.php">
                    </td>
                </tr>

                <tr>
                    <th><label for="rl_url_colaborador">🤝 Colaborador:</label></th>
                    <td>
                        <input type="url"
                               id="rl_url_colaborador"
                               name="rl_url_colaborador"
                               value="<?php echo esc_attr($rl_url_colaborador); ?>"
                               style="width: 500px;"
                               placeholder="<?php echo esc_attr($site_url); ?>">
                    </td>
                </tr>

                <tr>
                    <th><label for="rl_url_suscriptor">👤 Suscriptor:</label></th>
                    <td>
                        <input type="url"
                               id="rl_url_suscriptor"
                               name="rl_url_suscriptor"
                               value="<?php echo esc_attr($rl_url_suscriptor); ?>"
                               style="width: 500px;"
                               placeholder="<?php echo esc_attr($site_url); ?>/mi-cuenta">
                        <p class="description">Los suscriptores normalmente no tienen acceso al admin</p>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📚 Roles de WordPress</h2>
        <div class="card" style="padding: 15px;">
            <ul>
                <li><strong>Administrador:</strong> Control total del sitio</li>
                <li><strong>Editor:</strong> Puede publicar y administrar entradas de todos los usuarios</li>
                <li><strong>Autor:</strong> Puede publicar y administrar sus propias entradas</li>
                <li><strong>Colaborador:</strong> Puede escribir y administrar sus entradas pero no publicarlas</li>
                <li><strong>Suscriptor:</strong> Solo puede administrar su perfil</li>
            </ul>
        </div>

        <h2>🧠 Concepto técnico</h2>
        <div class="card" style="padding: 15px; background: #f0f0f1;">
            <p><strong>Hook utilizado:</strong> <code>login_redirect</code></p>
            <p><strong>Tipo:</strong> Filtro</p>
            <p><strong>Parámetros que recibe:</strong></p>
            <ul>
                <li><code>$redirect_to</code> - URL a donde WordPress iba a redirigir</li>
                <li><code>$request</code> - URL solicitada originalmente</li>
                <li><code>$user</code> - Objeto del usuario que acaba de hacer login</li>
            </ul>
            <p><strong>Función importante:</strong> <code>in_array()</code> verifica si un valor existe en un array. Aquí lo usamos para ver si el usuario tiene un rol específico.</p>
        </div>
    </div>

    <?php
}
