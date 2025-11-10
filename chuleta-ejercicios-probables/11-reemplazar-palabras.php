<?php
/*
Plugin Name: Reemplazador Automático de Palabras
Description: Reemplaza automáticamente palabras específicas en todo el contenido del sitio.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= REEMPLAZAR PALABRAS EN EL CONTENIDO ======================= //
function rp_reemplazar_palabras($contenido)
{
    // Verificar si la función está activa
    $rp_activo = get_option('rp_activo', false);
    if (!$rp_activo) {
        return $contenido;
    }

    // Obtener pares de reemplazo
    $rp_palabra_1 = get_option('rp_palabra_1', '');
    $rp_reemplazo_1 = get_option('rp_reemplazo_1', '');

    $rp_palabra_2 = get_option('rp_palabra_2', '');
    $rp_reemplazo_2 = get_option('rp_reemplazo_2', '');

    $rp_palabra_3 = get_option('rp_palabra_3', '');
    $rp_reemplazo_3 = get_option('rp_reemplazo_3', '');

    // Reemplazar palabra 1
    if (!empty($rp_palabra_1) && !empty($rp_reemplazo_1)) {
        $contenido = str_replace($rp_palabra_1, $rp_reemplazo_1, $contenido);
    }

    // Reemplazar palabra 2
    if (!empty($rp_palabra_2) && !empty($rp_reemplazo_2)) {
        $contenido = str_replace($rp_palabra_2, $rp_reemplazo_2, $contenido);
    }

    // Reemplazar palabra 3
    if (!empty($rp_palabra_3) && !empty($rp_reemplazo_3)) {
        $contenido = str_replace($rp_palabra_3, $rp_reemplazo_3, $contenido);
    }

    return $contenido;
}
// Filtro que modifica el contenido antes de mostrarlo
add_filter('the_content', 'rp_reemplazar_palabras');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function rp_crear_menu()
{
    add_menu_page(
        'Reemplazos Automáticos',
        'Reemplazos',
        'manage_options',
        'reemplazar-palabras',
        'rp_pagina_configuracion',
        'dashicons-image-rotate'
    );
}
add_action('admin_menu', 'rp_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function rp_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['rp_palabra_1']) && check_admin_referer('rp_guardar_config')) {

        $palabra_1 = sanitize_text_field($_POST['rp_palabra_1']);
        update_option('rp_palabra_1', $palabra_1);

        $reemplazo_1 = sanitize_text_field($_POST['rp_reemplazo_1']);
        update_option('rp_reemplazo_1', $reemplazo_1);

        $palabra_2 = sanitize_text_field($_POST['rp_palabra_2']);
        update_option('rp_palabra_2', $palabra_2);

        $reemplazo_2 = sanitize_text_field($_POST['rp_reemplazo_2']);
        update_option('rp_reemplazo_2', $reemplazo_2);

        $palabra_3 = sanitize_text_field($_POST['rp_palabra_3']);
        update_option('rp_palabra_3', $palabra_3);

        $reemplazo_3 = sanitize_text_field($_POST['rp_reemplazo_3']);
        update_option('rp_reemplazo_3', $reemplazo_3);

        $activo = isset($_POST['rp_activo']);
        update_option('rp_activo', $activo);

        echo '<div class="updated"><p>✅ Reemplazos guardados correctamente.</p></div>';
    }

    // Leer valores actuales
    $rp_palabra_1 = get_option('rp_palabra_1', '');
    $rp_reemplazo_1 = get_option('rp_reemplazo_1', '');
    $rp_palabra_2 = get_option('rp_palabra_2', '');
    $rp_reemplazo_2 = get_option('rp_reemplazo_2', '');
    $rp_palabra_3 = get_option('rp_palabra_3', '');
    $rp_reemplazo_3 = get_option('rp_reemplazo_3', '');
    $rp_activo = get_option('rp_activo', false);
    ?>

    <div class="wrap">
        <h1>Reemplazos Automáticos de Palabras</h1>
        <p>Define palabras que se reemplazarán automáticamente en todo el contenido de tus entradas y páginas.</p>

        <form method="post">
            <?php wp_nonce_field('rp_guardar_config'); ?>

            <h2>⚙️ Configuración</h2>

            <p>
                <label>
                    <input type="checkbox" name="rp_activo" <?php echo $rp_activo ? 'checked' : ''; ?>>
                    <strong>Activar reemplazos automáticos</strong>
                </label>
            </p>

            <h2>📝 Pares de Reemplazo</h2>
            <p><em>Deja en blanco los pares que no quieras usar</em></p>

            <div style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #0073aa;">
                <h3>Par 1</h3>
                <p>
                    <label><strong>Palabra a buscar:</strong></label><br>
                    <input type="text"
                           name="rp_palabra_1"
                           value="<?php echo esc_attr($rp_palabra_1); ?>"
                           style="width: 250px;"
                           placeholder="WordPress">
                </p>
                <p>
                    <label><strong>Reemplazar por:</strong></label><br>
                    <input type="text"
                           name="rp_reemplazo_1"
                           value="<?php echo esc_attr($rp_reemplazo_1); ?>"
                           style="width: 250px;"
                           placeholder="WordPress CMS">
                </p>
            </div>

            <div style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #00a32a;">
                <h3>Par 2</h3>
                <p>
                    <label><strong>Palabra a buscar:</strong></label><br>
                    <input type="text"
                           name="rp_palabra_2"
                           value="<?php echo esc_attr($rp_palabra_2); ?>"
                           style="width: 250px;"
                           placeholder="plugin">
                </p>
                <p>
                    <label><strong>Reemplazar por:</strong></label><br>
                    <input type="text"
                           name="rp_reemplazo_2"
                           value="<?php echo esc_attr($rp_reemplazo_2); ?>"
                           style="width: 250px;"
                           placeholder="extensión">
                </p>
            </div>

            <div style="background: #f9f9f9; padding: 15px; margin-bottom: 15px; border-left: 4px solid #d63638;">
                <h3>Par 3</h3>
                <p>
                    <label><strong>Palabra a buscar:</strong></label><br>
                    <input type="text"
                           name="rp_palabra_3"
                           value="<?php echo esc_attr($rp_palabra_3); ?>"
                           style="width: 250px;"
                           placeholder="web">
                </p>
                <p>
                    <label><strong>Reemplazar por:</strong></label><br>
                    <input type="text"
                           name="rp_reemplazo_3"
                           value="<?php echo esc_attr($rp_reemplazo_3); ?>"
                           style="width: 250px;"
                           placeholder="sitio web">
                </p>
            </div>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar reemplazos">
            </p>
        </form>

        <hr>

        <h2>📖 Cómo funciona</h2>
        <div class="notice notice-info">
            <p><strong>Ejemplo:</strong></p>
            <p>Si configuras: <code>WordPress</code> → <code>WordPress CMS</code></p>
            <p>Entonces cada vez que escribas "WordPress" en una entrada, se mostrará como "WordPress CMS"</p>
            <p><strong>⚠️ Nota:</strong> Los reemplazos distinguen entre mayúsculas y minúsculas. "wordpress" NO se reemplazará si buscas "WordPress".</p>
        </div>

        <h2>💡 Casos de uso</h2>
        <div class="notice notice-success">
            <p>✅ Cambiar términos técnicos por términos más simples</p>
            <p>✅ Actualizar nombres de marca en todo el sitio</p>
            <p>✅ Corregir errores tipográficos comunes</p>
            <p>✅ Añadir marcas registradas automáticamente (© ® ™)</p>
        </div>

        <h2>🔧 Concepto técnico</h2>
        <div style="background: #f0f0f1; padding: 15px;">
            <p><strong>Hook utilizado:</strong> <code>the_content</code></p>
            <p><strong>Función PHP:</strong> <code>str_replace()</code></p>
            <p>Este filtro modifica el contenido de entradas y páginas ANTES de mostrarlo al usuario, pero NO modifica la base de datos.</p>
        </div>
    </div>

    <?php
}
