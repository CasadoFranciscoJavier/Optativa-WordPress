<?php
/*
Plugin Name: Modificador de Títulos
Description: Añade prefijos, sufijos o modifica los títulos de entradas y páginas automáticamente.
Version: 1.0
Author: Chuleta de Estudio

CONCEPTO NUEVO: Uso del filtro 'the_title' para modificar títulos antes de mostrarlos
*/

if (!defined('ABSPATH')) exit;

// ======================= MODIFICAR TÍTULOS AUTOMÁTICAMENTE ======================= //
function mt_modificar_titulo($titulo, $id = null)
{
    // Recuperar configuración
    $mt_prefijo = get_option('mt_prefijo', '');
    $mt_sufijo = get_option('mt_sufijo', '');
    $mt_transformacion = get_option('mt_transformacion', 'ninguna');
    $mt_solo_posts = get_option('mt_solo_posts', false);
    $mt_solo_paginas = get_option('mt_solo_paginas', false);

    // Si no hay ID o no es una entrada válida, devolver el título sin modificar
    if (!$id) {
        return $titulo;
    }

    // Obtener el tipo de contenido (post, page, etc.)
    $tipo_contenido = get_post_type($id);

    // Aplicar filtros según el tipo de contenido
    $aplicar_modificacion = true;

    if ($mt_solo_posts && $tipo_contenido !== 'post') {
        $aplicar_modificacion = false;
    }

    if ($mt_solo_paginas && $tipo_contenido !== 'page') {
        $aplicar_modificacion = false;
    }

    // Si no debemos aplicar la modificación, devolver título original
    if (!$aplicar_modificacion) {
        return $titulo;
    }

    // Aplicar transformación de texto
    $titulo_modificado = $titulo;

    if ($mt_transformacion === 'mayusculas') {
        $titulo_modificado = strtoupper($titulo_modificado);
    } elseif ($mt_transformacion === 'minusculas') {
        $titulo_modificado = strtolower($titulo_modificado);
    } elseif ($mt_transformacion === 'capitalize') {
        $titulo_modificado = ucwords(strtolower($titulo_modificado));
    }

    // Añadir prefijo y sufijo
    $titulo_final = $mt_prefijo . $titulo_modificado . $mt_sufijo;

    return $titulo_final;
}
// HOOK NUEVO: the_title modifica los títulos antes de mostrarlos
// Acepta 2 parámetros: el título y el ID del post
add_filter('the_title', 'mt_modificar_titulo', 10, 2);

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function mt_crear_menu()
{
    add_menu_page(
        'Modificador de Títulos',
        'Mod. Títulos',
        'manage_options',
        'modificador-titulos',
        'mt_pagina_configuracion',
        'dashicons-edit'
    );
}
add_action('admin_menu', 'mt_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function mt_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['mt_prefijo']) && check_admin_referer('mt_guardar_config')) {

        $prefijo = sanitize_text_field($_POST['mt_prefijo']);
        update_option('mt_prefijo', $prefijo);

        $sufijo = sanitize_text_field($_POST['mt_sufijo']);
        update_option('mt_sufijo', $sufijo);

        $transformacion = sanitize_text_field($_POST['mt_transformacion']);
        update_option('mt_transformacion', $transformacion);

        $solo_posts = isset($_POST['mt_solo_posts']);
        update_option('mt_solo_posts', $solo_posts);

        $solo_paginas = isset($_POST['mt_solo_paginas']);
        update_option('mt_solo_paginas', $solo_paginas);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $mt_prefijo = get_option('mt_prefijo', '');
    $mt_sufijo = get_option('mt_sufijo', '');
    $mt_transformacion = get_option('mt_transformacion', 'ninguna');
    $mt_solo_posts = get_option('mt_solo_posts', false);
    $mt_solo_paginas = get_option('mt_solo_paginas', false);
    ?>

    <div class="wrap">
        <h1>Configuración del Modificador de Títulos</h1>
        <p>Modifica automáticamente los títulos de entradas y páginas en todo el sitio.</p>

        <form method="post">
            <?php wp_nonce_field('mt_guardar_config'); ?>

            <table class="form-table">
                <tr>
                    <th><label for="mt_prefijo">Prefijo (antes del título):</label></th>
                    <td>
                        <input type="text"
                               id="mt_prefijo"
                               name="mt_prefijo"
                               value="<?php echo esc_attr($mt_prefijo); ?>"
                               style="width: 300px;"
                               placeholder="Ej: ⭐ ">
                        <p class="description">Texto que aparecerá antes del título. Ejemplo: "🔥 "</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="mt_sufijo">Sufijo (después del título):</label></th>
                    <td>
                        <input type="text"
                               id="mt_sufijo"
                               name="mt_sufijo"
                               value="<?php echo esc_attr($mt_sufijo); ?>"
                               style="width: 300px;"
                               placeholder="Ej:  ✨">
                        <p class="description">Texto que aparecerá después del título. Ejemplo: " ✨"</p>
                    </td>
                </tr>

                <tr>
                    <th>Transformación de texto:</th>
                    <td>
                        <label><input type="radio" name="mt_transformacion" value="ninguna" <?php checked($mt_transformacion, 'ninguna'); ?>> Sin cambios</label><br>
                        <label><input type="radio" name="mt_transformacion" value="mayusculas" <?php checked($mt_transformacion, 'mayusculas'); ?>> TODO MAYÚSCULAS</label><br>
                        <label><input type="radio" name="mt_transformacion" value="minusculas" <?php checked($mt_transformacion, 'minusculas'); ?>> todo minúsculas</label><br>
                        <label><input type="radio" name="mt_transformacion" value="capitalize" <?php checked($mt_transformacion, 'capitalize'); ?>> Primera Letra De Cada Palabra</label>
                    </td>
                </tr>

                <tr>
                    <th>Aplicar solo a:</th>
                    <td>
                        <label>
                            <input type="checkbox"
                                   name="mt_solo_posts"
                                   <?php echo $mt_solo_posts ? 'checked' : ''; ?>>
                            Solo entradas (posts)
                        </label><br>
                        <label>
                            <input type="checkbox"
                                   name="mt_solo_paginas"
                                   <?php echo $mt_solo_paginas ? 'checked' : ''; ?>>
                            Solo páginas
                        </label>
                        <p class="description">Si no marcas ninguna, se aplicará a todo. Si marcas ambas, no se modificará nada.</p>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📝 Ejemplo de uso</h2>
        <div class="notice notice-info">
            <p><strong>Título original:</strong> "Mi primera entrada en el blog"</p>
            <p><strong>Con prefijo "🔥 " y sufijo " ⭐":</strong> 🔥 Mi primera entrada en el blog ⭐</p>
            <p><strong>Con transformación a mayúsculas:</strong> 🔥 MI PRIMERA ENTRADA EN EL BLOG ⭐</p>
        </div>

        <h2>🧠 Concepto técnico</h2>
        <div class="card" style="padding: 15px; background: #f0f0f1;">
            <p><strong>Hook utilizado:</strong> <code>the_title</code></p>
            <p><strong>Tipo:</strong> Filtro (modifica contenido antes de mostrarlo)</p>
            <p><strong>Qué hace:</strong> Se ejecuta cada vez que WordPress va a mostrar un título. El plugin intercepta ese momento y lo modifica.</p>
            <p><strong>Diferencia con actions:</strong> Los filtros MODIFICAN y DEVUELVEN datos. Los actions solo EJECUTAN código.</p>
        </div>
    </div>

    <?php
}
