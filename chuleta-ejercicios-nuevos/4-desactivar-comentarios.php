<?php
/*
Plugin Name: Desactivador de Comentarios Automático
Description: Desactiva automáticamente los comentarios en entradas antiguas después de X días.
Version: 1.0
Author: Chuleta de Estudio

CONCEPTO NUEVO: Hook 'comments_open' y trabajo con fechas de publicación
*/

if (!defined('ABSPATH')) exit;

// ======================= CERRAR COMENTARIOS EN POSTS ANTIGUOS ======================= //
function dc_cerrar_comentarios_antiguos($open, $post_id)
{
    // Verificar si la función está activada
    $dc_activo = get_option('dc_activo', false);
    if (!$dc_activo) {
        return $open;
    }

    // Obtener configuración
    $dc_dias_limite = (int)get_option('dc_dias_limite', 30);
    $dc_solo_posts = get_option('dc_solo_posts', true);
    $dc_solo_paginas = get_option('dc_solo_paginas', false);

    // Obtener información del post
    $post = get_post($post_id);

    // Si no existe el post, devolver el valor original
    if (!$post) {
        return $open;
    }

    // Verificar el tipo de contenido
    $tipo = $post->post_type;
    $aplicar = false;

    if ($dc_solo_posts && $tipo === 'post') {
        $aplicar = true;
    }

    if ($dc_solo_paginas && $tipo === 'page') {
        $aplicar = true;
    }

    // Si no debemos aplicar la regla, devolver el valor original
    if (!$aplicar) {
        return $open;
    }

    // Calcular días desde la publicación
    $fecha_publicacion = strtotime($post->post_date);
    $fecha_actual = time();
    $segundos_transcurridos = $fecha_actual - $fecha_publicacion;
    $dias_transcurridos = floor($segundos_transcurridos / (60 * 60 * 24));

    // Si han pasado más días que el límite, cerrar comentarios
    if ($dias_transcurridos > $dc_dias_limite) {
        return false;
    }

    return $open;
}
// HOOK NUEVO: comments_open decide si los comentarios están abiertos o no
// Recibe 2 parámetros: estado actual (true/false) y el ID del post
add_filter('comments_open', 'dc_cerrar_comentarios_antiguos', 10, 2);

// ======================= MENSAJE PERSONALIZADO CUANDO COMENTARIOS CERRADOS ======================= //
function dc_mensaje_comentarios_cerrados($defaults)
{
    $dc_mensaje = get_option('dc_mensaje', '');

    if (!empty($dc_mensaje)) {
        $defaults['comment_notes_after'] = '<p class="comentarios-cerrados-aviso">' . esc_html($dc_mensaje) . '</p>';
    }

    return $defaults;
}
add_filter('comment_form_defaults', 'dc_mensaje_comentarios_cerrados');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function dc_crear_menu()
{
    add_menu_page(
        'Desactivar Comentarios',
        'Desact. Coment.',
        'manage_options',
        'desactivar-comentarios',
        'dc_pagina_configuracion',
        'dashicons-admin-comments'
    );
}
add_action('admin_menu', 'dc_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function dc_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['dc_dias_limite']) && check_admin_referer('dc_guardar_config')) {

        $dias_limite = (int)sanitize_text_field($_POST['dc_dias_limite']);
        update_option('dc_dias_limite', $dias_limite);

        $mensaje = sanitize_text_field($_POST['dc_mensaje']);
        update_option('dc_mensaje', $mensaje);

        $solo_posts = isset($_POST['dc_solo_posts']);
        update_option('dc_solo_posts', $solo_posts);

        $solo_paginas = isset($_POST['dc_solo_paginas']);
        update_option('dc_solo_paginas', $solo_paginas);

        $activo = isset($_POST['dc_activo']);
        update_option('dc_activo', $activo);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $dc_dias_limite = get_option('dc_dias_limite', 30);
    $dc_mensaje = get_option('dc_mensaje', '');
    $dc_solo_posts = get_option('dc_solo_posts', true);
    $dc_solo_paginas = get_option('dc_solo_paginas', false);
    $dc_activo = get_option('dc_activo', false);
    ?>

    <div class="wrap">
        <h1>Configuración del Desactivador de Comentarios</h1>
        <p>Cierra automáticamente los comentarios en entradas después de un número específico de días.</p>

        <form method="post">
            <?php wp_nonce_field('dc_guardar_config'); ?>

            <table class="form-table">
                <tr>
                    <th>Activar cierre automático:</th>
                    <td>
                        <label>
                            <input type="checkbox"
                                   name="dc_activo"
                                   <?php echo $dc_activo ? 'checked' : ''; ?>>
                            Cerrar automáticamente comentarios en contenido antiguo
                        </label>
                    </td>
                </tr>

                <tr>
                    <th><label for="dc_dias_limite">Cerrar comentarios después de:</label></th>
                    <td>
                        <input type="number"
                               id="dc_dias_limite"
                               name="dc_dias_limite"
                               min="1"
                               max="365"
                               value="<?php echo esc_attr($dc_dias_limite); ?>"
                               style="width: 100px;">
                        días desde la publicación
                        <p class="description">Los comentarios se cerrarán automáticamente después de este número de días</p>
                    </td>
                </tr>

                <tr>
                    <th>Aplicar a:</th>
                    <td>
                        <label>
                            <input type="checkbox"
                                   name="dc_solo_posts"
                                   <?php echo $dc_solo_posts ? 'checked' : ''; ?>>
                            Entradas (posts)
                        </label><br>
                        <label>
                            <input type="checkbox"
                                   name="dc_solo_paginas"
                                   <?php echo $dc_solo_paginas ? 'checked' : ''; ?>>
                            Páginas
                        </label>
                        <p class="description">Selecciona dónde aplicar esta regla</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="dc_mensaje">Mensaje personalizado:</label></th>
                    <td>
                        <input type="text"
                               id="dc_mensaje"
                               name="dc_mensaje"
                               value="<?php echo esc_attr($dc_mensaje); ?>"
                               style="width: 500px;"
                               placeholder="Ej: Los comentarios están cerrados en esta entrada antigua">
                        <p class="description">Mensaje opcional que se mostrará cuando los comentarios estén cerrados (déjalo vacío para no mostrar mensaje)</p>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📊 Cálculo de días</h2>
        <div class="card" style="padding: 15px;">
            <p><strong>Ejemplo:</strong> Si configuras 30 días:</p>
            <ul>
                <li>Una entrada publicada <strong>hace 25 días</strong> → Comentarios ABIERTOS ✅</li>
                <li>Una entrada publicada <strong>hace 35 días</strong> → Comentarios CERRADOS ❌</li>
            </ul>
            <p>El cálculo se hace cada vez que alguien intenta ver los comentarios, por lo que es automático y preciso.</p>
        </div>

        <h2>🧠 Concepto técnico</h2>
        <div class="card" style="padding: 15px; background: #f0f0f1;">
            <p><strong>Hook utilizado:</strong> <code>comments_open</code></p>
            <p><strong>Tipo:</strong> Filtro</p>
            <p><strong>Parámetros:</strong></p>
            <ul>
                <li><code>$open</code> - Boolean, si los comentarios están abiertos (true) o cerrados (false)</li>
                <li><code>$post_id</code> - ID del post que estamos verificando</li>
            </ul>
            <p><strong>Funciones importantes usadas:</strong></p>
            <ul>
                <li><code>get_post($post_id)</code> - Obtiene información completa de un post</li>
                <li><code>strtotime($fecha)</code> - Convierte una fecha en timestamp (segundos desde 1970)</li>
                <li><code>time()</code> - Obtiene el timestamp actual</li>
                <li><code>floor()</code> - Redondea hacia abajo (para obtener días completos)</li>
            </ul>
            <p><strong>Cálculo de días:</strong></p>
            <code>días = (timestamp_actual - timestamp_publicación) / (60 * 60 * 24)</code>
        </div>

        <div class="notice notice-warning">
            <p><strong>⚠️ Importante:</strong> Esta configuración no afecta a los comentarios que ya estén cerrados manualmente. Solo controla el cierre automático por edad.</p>
        </div>
    </div>

    <?php
}
