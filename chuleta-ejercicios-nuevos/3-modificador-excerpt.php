<?php
/*
Plugin Name: Modificador de Excerpt (Resumen)
Description: Personaliza la longitud y el texto final de los resúmenes automáticos de WordPress.
Version: 1.0
Author: Chuleta de Estudio

CONCEPTO NUEVO: Filtros 'excerpt_length' y 'excerpt_more' para personalizar resúmenes
*/

if (!defined('ABSPATH')) exit;

// ======================= CAMBIAR LONGITUD DEL EXCERPT ======================= //
function me_cambiar_longitud($length)
{
    // Obtener la longitud configurada (por defecto WordPress usa 55 palabras)
    $nueva_longitud = (int)get_option('me_longitud', 55);

    return $nueva_longitud;
}
// HOOK NUEVO: excerpt_length controla cuántas palabras tendrá el resumen
add_filter('excerpt_length', 'me_cambiar_longitud');

// ======================= CAMBIAR TEXTO FINAL DEL EXCERPT ======================= //
function me_cambiar_more($more)
{
    // Obtener el texto configurado (por defecto WordPress usa "[...]")
    $texto_more = get_option('me_texto_more', '[...]');

    return ' ' . $texto_more;
}
// HOOK NUEVO: excerpt_more controla el texto que aparece al final del resumen
add_filter('excerpt_more', 'me_cambiar_more');

// ======================= AÑADIR ESTILOS AL TEXTO "LEER MÁS" ======================= //
function me_agregar_estilos()
{
    $me_color_more = get_option('me_color_more', '#0073aa');

    echo "<style>
        .entry-summary,
        .excerpt {
            color: inherit;
        }

        /* Estilizar el texto de leer más si contiene un enlace */
        .more-link,
        .entry-summary a,
        .excerpt a {
            color: $me_color_more !important;
            text-decoration: none;
        }

        .more-link:hover,
        .entry-summary a:hover,
        .excerpt a:hover {
            text-decoration: underline;
        }
    </style>";
}
add_action('wp_head', 'me_agregar_estilos');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function me_crear_menu()
{
    add_menu_page(
        'Modificador Excerpt',
        'Mod. Excerpt',
        'manage_options',
        'modificador-excerpt',
        'me_pagina_configuracion',
        'dashicons-text'
    );
}
add_action('admin_menu', 'me_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function me_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['me_longitud']) && check_admin_referer('me_guardar_config')) {

        $longitud = (int)sanitize_text_field($_POST['me_longitud']);
        update_option('me_longitud', $longitud);

        $texto_more = sanitize_text_field($_POST['me_texto_more']);
        update_option('me_texto_more', $texto_more);

        $color_more = sanitize_hex_color($_POST['me_color_more']);
        update_option('me_color_more', $color_more);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales
    $me_longitud = get_option('me_longitud', 55);
    $me_texto_more = get_option('me_texto_more', '[...]');
    $me_color_more = get_option('me_color_more', '#0073aa');
    ?>

    <div class="wrap">
        <h1>Configuración del Modificador de Excerpt</h1>
        <p>El excerpt (resumen) es el texto corto que WordPress genera automáticamente para las entradas en listados y archivos.</p>

        <form method="post">
            <?php wp_nonce_field('me_guardar_config'); ?>

            <table class="form-table">
                <tr>
                    <th><label for="me_longitud">Número de palabras:</label></th>
                    <td>
                        <input type="number"
                               id="me_longitud"
                               name="me_longitud"
                               min="10"
                               max="200"
                               value="<?php echo esc_attr($me_longitud); ?>"
                               style="width: 100px;">
                        palabras
                        <p class="description">WordPress por defecto usa 55 palabras. Rango recomendado: 20-100</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="me_texto_more">Texto al final del resumen:</label></th>
                    <td>
                        <input type="text"
                               id="me_texto_more"
                               name="me_texto_more"
                               value="<?php echo esc_attr($me_texto_more); ?>"
                               style="width: 300px;"
                               placeholder="[...]">
                        <p class="description">Texto que aparece cuando el resumen se corta. Ejemplos: "[...]", "...", "→ Leer más"</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="me_color_more">Color del enlace "Leer más":</label></th>
                    <td>
                        <input type="color"
                               id="me_color_more"
                               name="me_color_more"
                               value="<?php echo esc_attr($me_color_more); ?>">
                        <span style="margin-left: 10px;"><?php echo esc_html($me_color_more); ?></span>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📝 ¿Qué es el excerpt?</h2>
        <div class="card" style="padding: 15px;">
            <p>El <strong>excerpt</strong> (extracto o resumen) es una versión corta de tus entradas que WordPress muestra en:</p>
            <ul>
                <li>Páginas de archivo (categorías, etiquetas, búsqueda)</li>
                <li>La página principal del blog</li>
                <li>Feeds RSS</li>
                <li>Algunas vistas de temas</li>
            </ul>
            <p><strong>Ejemplo:</strong></p>
            <p style="background: #f5f5f5; padding: 10px; border-left: 3px solid #0073aa;">
                "Esta es una entrada muy larga sobre WordPress. Tiene mucho contenido interesante que los lectores van a disfrutar.
                WordPress tomará solo las primeras <?php echo esc_html($me_longitud); ?> palabras y añadirá <?php echo esc_html($me_texto_more); ?>"
            </p>
        </div>

        <h2>🧠 Concepto técnico</h2>
        <div class="card" style="padding: 15px; background: #f0f0f1;">
            <p><strong>Hooks utilizados:</strong></p>
            <ul>
                <li>
                    <code>excerpt_length</code> - Filtro que controla cuántas palabras se extraerán<br>
                    <small>Por defecto: 55 palabras</small>
                </li>
                <li>
                    <code>excerpt_more</code> - Filtro que controla el texto final del excerpt<br>
                    <small>Por defecto: "[...]"</small>
                </li>
            </ul>
            <p><strong>Diferencia importante:</strong></p>
            <ul>
                <li><strong>Excerpt automático:</strong> WordPress lo genera cortando el contenido</li>
                <li><strong>Excerpt manual:</strong> Si escribes un resumen personalizado al crear la entrada, WordPress usará ese en lugar del automático</li>
            </ul>
        </div>

        <div class="notice notice-info">
            <p><strong>💡 Consejo:</strong> Si tus excerpts no aparecen, puede que tu tema no los esté usando. La mayoría de temas modernos sí los usan en listados de entradas.</p>
        </div>
    </div>

    <?php
}
