<?php
/*
Plugin Name: Ocultar Menús del Admin
Description: Oculta opciones del menú de administración para usuarios no administradores.
Version: 1.0
Author: Chuleta de Estudio

CONCEPTO NUEVO: remove_menu_page() y current_user_can() para control de acceso al admin
*/

if (!defined('ABSPATH')) exit;

// ======================= OCULTAR MENÚS SEGÚN CONFIGURACIÓN ======================= //
function oma_ocultar_menus()
{
    // Solo aplicar si el usuario NO es administrador
    if (current_user_can('manage_options')) {
        return;
    }

    // Recuperar configuración
    $oma_ocultar_posts = get_option('oma_ocultar_posts', false);
    $oma_ocultar_paginas = get_option('oma_ocultar_paginas', false);
    $oma_ocultar_comentarios = get_option('oma_ocultar_comentarios', false);
    $oma_ocultar_herramientas = get_option('oma_ocultar_herramientas', false);
    $oma_ocultar_apariencia = get_option('oma_ocultar_apariencia', false);
    $oma_ocultar_plugins = get_option('oma_ocultar_plugins', false);

    // Ocultar menús según configuración
    if ($oma_ocultar_posts) {
        remove_menu_page('edit.php');
    }

    if ($oma_ocultar_paginas) {
        remove_menu_page('edit.php?post_type=page');
    }

    if ($oma_ocultar_comentarios) {
        remove_menu_page('edit-comments.php');
    }

    if ($oma_ocultar_herramientas) {
        remove_menu_page('tools.php');
    }

    if ($oma_ocultar_apariencia) {
        remove_menu_page('themes.php');
    }

    if ($oma_ocultar_plugins) {
        remove_menu_page('plugins.php');
    }
}
// HOOK: admin_menu permite modificar el menú del admin
add_action('admin_menu', 'oma_ocultar_menus', 999);

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function oma_crear_menu()
{
    add_menu_page(
        'Ocultar Menús',
        'Ocultar Menús',
        'manage_options',
        'ocultar-menus-admin',
        'oma_pagina_configuracion',
        'dashicons-hidden'
    );
}
add_action('admin_menu', 'oma_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function oma_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['oma_submit']) && check_admin_referer('oma_guardar_config')) {

        $ocultar_posts = isset($_POST['oma_ocultar_posts']);
        update_option('oma_ocultar_posts', $ocultar_posts);

        $ocultar_paginas = isset($_POST['oma_ocultar_paginas']);
        update_option('oma_ocultar_paginas', $ocultar_paginas);

        $ocultar_comentarios = isset($_POST['oma_ocultar_comentarios']);
        update_option('oma_ocultar_comentarios', $ocultar_comentarios);

        $ocultar_herramientas = isset($_POST['oma_ocultar_herramientas']);
        update_option('oma_ocultar_herramientas', $ocultar_herramientas);

        $ocultar_apariencia = isset($_POST['oma_ocultar_apariencia']);
        update_option('oma_ocultar_apariencia', $ocultar_apariencia);

        $ocultar_plugins = isset($_POST['oma_ocultar_plugins']);
        update_option('oma_ocultar_plugins', $ocultar_plugins);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $oma_ocultar_posts = get_option('oma_ocultar_posts', false);
    $oma_ocultar_paginas = get_option('oma_ocultar_paginas', false);
    $oma_ocultar_comentarios = get_option('oma_ocultar_comentarios', false);
    $oma_ocultar_herramientas = get_option('oma_ocultar_herramientas', false);
    $oma_ocultar_apariencia = get_option('oma_ocultar_apariencia', false);
    $oma_ocultar_plugins = get_option('oma_ocultar_plugins', false);
    ?>

    <div class="wrap">
        <h1>Configuración: Ocultar Menús del Admin</h1>
        <p>Selecciona qué menús quieres ocultar para usuarios NO administradores (editores, autores, colaboradores, etc.).</p>

        <div class="notice notice-info">
            <p><strong>ℹ️ Importante:</strong> Los administradores SIEMPRE verán todos los menús. Esta configuración solo afecta a otros roles.</p>
        </div>

        <form method="post">
            <?php wp_nonce_field('oma_guardar_config'); ?>

            <h2>Selecciona los menús a ocultar</h2>
            <table class="form-table">
                <tr>
                    <th>Menús del panel de administración:</th>
                    <td>
                        <fieldset>
                            <label>
                                <input type="checkbox"
                                       name="oma_ocultar_posts"
                                       <?php echo $oma_ocultar_posts ? 'checked' : ''; ?>>
                                📝 Ocultar "Entradas"
                            </label>
                            <br>

                            <label>
                                <input type="checkbox"
                                       name="oma_ocultar_paginas"
                                       <?php echo $oma_ocultar_paginas ? 'checked' : ''; ?>>
                                📄 Ocultar "Páginas"
                            </label>
                            <br>

                            <label>
                                <input type="checkbox"
                                       name="oma_ocultar_comentarios"
                                       <?php echo $oma_ocultar_comentarios ? 'checked' : ''; ?>>
                                💬 Ocultar "Comentarios"
                            </label>
                            <br>

                            <label>
                                <input type="checkbox"
                                       name="oma_ocultar_herramientas"
                                       <?php echo $oma_ocultar_herramientas ? 'checked' : ''; ?>>
                                🔧 Ocultar "Herramientas"
                            </label>
                            <br>

                            <label>
                                <input type="checkbox"
                                       name="oma_ocultar_apariencia"
                                       <?php echo $oma_ocultar_apariencia ? 'checked' : ''; ?>>
                                🎨 Ocultar "Apariencia"
                            </label>
                            <br>

                            <label>
                                <input type="checkbox"
                                       name="oma_ocultar_plugins"
                                       <?php echo $oma_ocultar_plugins ? 'checked' : ''; ?>>
                                🔌 Ocultar "Plugins"
                            </label>
                        </fieldset>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" name="oma_submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📚 Casos de uso</h2>
        <div class="card" style="padding: 15px;">
            <h3>¿Cuándo usar esto?</h3>
            <ul>
                <li><strong>Sitios con múltiples editores:</strong> Ocultar plugins y apariencia para que solo editen contenido</li>
                <li><strong>Sitios de clientes:</strong> Simplificar el panel eliminando opciones que no necesitan</li>
                <li><strong>Blogs con colaboradores:</strong> Limitar acceso solo a entradas</li>
            </ul>

            <h3>Ejemplo práctico:</h3>
            <p>Tienes un blog con 3 autores que solo escriben artículos. Puedes ocultar:</p>
            <ul>
                <li>✅ Páginas (no las necesitan)</li>
                <li>✅ Comentarios (tú los moderas)</li>
                <li>✅ Herramientas (no las usan)</li>
                <li>✅ Apariencia (solo tú la controlas)</li>
                <li>✅ Plugins (solo tú los instalas)</li>
            </ul>
            <p>Así, cuando inician sesión, solo ven: Escritorio, Entradas, Medios y Perfil.</p>
        </div>

        <h2>🧠 Concepto técnico</h2>
        <div class="card" style="padding: 15px; background: #f0f0f1;">
            <p><strong>Funciones importantes:</strong></p>
            <ul>
                <li>
                    <code>current_user_can('manage_options')</code> - Verifica si el usuario actual tiene un permiso<br>
                    <small>'manage_options' = capacidad que solo tienen los administradores</small>
                </li>
                <li>
                    <code>remove_menu_page('slug')</code> - Oculta un menú del panel de administración<br>
                    <small>No elimina funcionalidad, solo oculta visualmente</small>
                </li>
            </ul>

            <p><strong>Slugs de menús principales:</strong></p>
            <ul>
                <li><code>edit.php</code> - Entradas</li>
                <li><code>edit.php?post_type=page</code> - Páginas</li>
                <li><code>edit-comments.php</code> - Comentarios</li>
                <li><code>tools.php</code> - Herramientas</li>
                <li><code>themes.php</code> - Apariencia</li>
                <li><code>plugins.php</code> - Plugins</li>
            </ul>

            <p><strong>Prioridad 999:</strong> Se ejecuta tarde para asegurar que todos los menús ya estén registrados.</p>
        </div>

        <div class="notice notice-warning">
            <p><strong>⚠️ Nota:</strong> Ocultar un menú NO elimina los permisos. Si un usuario conoce la URL directa, podría acceder igualmente. Para restricciones de seguridad reales, usa plugins de roles y permisos más avanzados.</p>
        </div>
    </div>

    <?php
}
