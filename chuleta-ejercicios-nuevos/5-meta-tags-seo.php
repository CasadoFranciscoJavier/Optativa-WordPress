<?php
/*
Plugin Name: Agregador de Meta Tags SEO
Description: Añade meta tags personalizados en el <head> del sitio para mejorar SEO.
Version: 1.0
Author: Chuleta de Estudio

CONCEPTO NUEVO: Inyección de meta tags en el head para SEO y redes sociales
*/

if (!defined('ABSPATH')) exit;

// ======================= AGREGAR META TAGS AL HEAD ======================= //
function mt_agregar_meta_tags()
{
    // Recuperar configuración
    $mt_description = get_option('mt_description', '');
    $mt_keywords = get_option('mt_keywords', '');
    $mt_author = get_option('mt_author', '');
    $mt_og_title = get_option('mt_og_title', '');
    $mt_og_image = get_option('mt_og_image', '');

    // Meta Description (importante para SEO)
    if (!empty($mt_description)) {
        echo '<meta name="description" content="' . esc_attr($mt_description) . '">' . "\n";
    }

    // Meta Keywords (menos importante ahora pero algunos lo usan)
    if (!empty($mt_keywords)) {
        echo '<meta name="keywords" content="' . esc_attr($mt_keywords) . '">' . "\n";
    }

    // Meta Author
    if (!empty($mt_author)) {
        echo '<meta name="author" content="' . esc_attr($mt_author) . '">' . "\n";
    }

    // Open Graph Title (para redes sociales como Facebook)
    if (!empty($mt_og_title)) {
        echo '<meta property="og:title" content="' . esc_attr($mt_og_title) . '">' . "\n";
    }

    // Open Graph Image (imagen que aparece al compartir en redes)
    if (!empty($mt_og_image)) {
        echo '<meta property="og:image" content="' . esc_url($mt_og_image) . '">' . "\n";
    }

    // Open Graph Type (siempre website)
    echo '<meta property="og:type" content="website">' . "\n";
}
// wp_head es donde se inyectan elementos en el <head> del HTML
add_action('wp_head', 'mt_agregar_meta_tags');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function mt_crear_menu()
{
    add_menu_page(
        'Meta Tags SEO',
        'Meta Tags SEO',
        'manage_options',
        'meta-tags-seo',
        'mt_pagina_configuracion',
        'dashicons-search'
    );
}
add_action('admin_menu', 'mt_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function mt_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['mt_description']) && check_admin_referer('mt_guardar_config')) {

        $description = sanitize_textarea_field($_POST['mt_description']);
        update_option('mt_description', $description);

        $keywords = sanitize_text_field($_POST['mt_keywords']);
        update_option('mt_keywords', $keywords);

        $author = sanitize_text_field($_POST['mt_author']);
        update_option('mt_author', $author);

        $og_title = sanitize_text_field($_POST['mt_og_title']);
        update_option('mt_og_title', $og_title);

        $og_image = esc_url_raw($_POST['mt_og_image']);
        update_option('mt_og_image', $og_image);

        echo '<div class="updated"><p>✅ Meta tags guardados correctamente.</p></div>';
    }

    // Leer valores actuales
    $mt_description = get_option('mt_description', '');
    $mt_keywords = get_option('mt_keywords', '');
    $mt_author = get_option('mt_author', '');
    $mt_og_title = get_option('mt_og_title', '');
    $mt_og_image = get_option('mt_og_image', '');
    ?>

    <div class="wrap">
        <h1>Configuración de Meta Tags SEO</h1>
        <p>Configura los meta tags que mejorarán el SEO y la apariencia de tu sitio en redes sociales.</p>

        <form method="post">
            <?php wp_nonce_field('mt_guardar_config'); ?>

            <h2>🔍 Meta Tags Básicos (SEO)</h2>
            <table class="form-table">
                <tr>
                    <th><label for="mt_description">Meta Description:</label></th>
                    <td>
                        <textarea id="mt_description"
                                  name="mt_description"
                                  rows="3"
                                  cols="70"><?php echo esc_textarea($mt_description); ?></textarea>
                        <p class="description">Descripción breve de tu sitio (150-160 caracteres). Aparece en resultados de Google.</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="mt_keywords">Meta Keywords:</label></th>
                    <td>
                        <input type="text"
                               id="mt_keywords"
                               name="mt_keywords"
                               value="<?php echo esc_attr($mt_keywords); ?>"
                               style="width: 500px;"
                               placeholder="wordpress, desarrollo web, tutoriales">
                        <p class="description">Palabras clave separadas por comas. Nota: Google ya no usa esto para ranking.</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="mt_author">Meta Author:</label></th>
                    <td>
                        <input type="text"
                               id="mt_author"
                               name="mt_author"
                               value="<?php echo esc_attr($mt_author); ?>"
                               style="width: 300px;"
                               placeholder="Tu nombre o empresa">
                    </td>
                </tr>
            </table>

            <h2>📱 Open Graph (Redes Sociales)</h2>
            <p class="description">Controla cómo se ve tu sitio cuando se comparte en Facebook, LinkedIn, etc.</p>
            <table class="form-table">
                <tr>
                    <th><label for="mt_og_title">Título Open Graph:</label></th>
                    <td>
                        <input type="text"
                               id="mt_og_title"
                               name="mt_og_title"
                               value="<?php echo esc_attr($mt_og_title); ?>"
                               style="width: 500px;"
                               placeholder="Título que aparecerá al compartir">
                        <p class="description">Título que se mostrará cuando compartan tu sitio en redes sociales</p>
                    </td>
                </tr>

                <tr>
                    <th><label for="mt_og_image">Imagen Open Graph (URL):</label></th>
                    <td>
                        <input type="url"
                               id="mt_og_image"
                               name="mt_og_image"
                               value="<?php echo esc_attr($mt_og_image); ?>"
                               style="width: 500px;"
                               placeholder="https://tusitio.com/imagen.jpg">
                        <p class="description">URL completa de la imagen (recomendado: 1200x630 píxeles)</p>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <h2>📋 Vista previa del código generado</h2>
        <div class="card" style="padding: 15px; background: #f9f9f9;">
            <code style="display: block; white-space: pre-wrap; font-size: 12px;">
<?php
echo htmlspecialchars('<meta name="description" content="' . $mt_description . '">') . "\n";
echo htmlspecialchars('<meta name="keywords" content="' . $mt_keywords . '">') . "\n";
echo htmlspecialchars('<meta name="author" content="' . $mt_author . '">') . "\n";
echo htmlspecialchars('<meta property="og:title" content="' . $mt_og_title . '">') . "\n";
echo htmlspecialchars('<meta property="og:image" content="' . $mt_og_image . '">');
?>
            </code>
        </div>

        <h2>🧠 Concepto técnico</h2>
        <div class="card" style="padding: 15px; background: #f0f0f1;">
            <p><strong>¿Qué son los meta tags?</strong></p>
            <p>Son etiquetas HTML invisibles que van en el <code>&lt;head&gt;</code> y dan información sobre la página a:</p>
            <ul>
                <li>Motores de búsqueda (Google, Bing)</li>
                <li>Redes sociales (Facebook, Twitter, LinkedIn)</li>
                <li>Navegadores</li>
            </ul>
            <p><strong>Open Graph Protocol:</strong> Creado por Facebook para controlar cómo se muestran los enlaces compartidos en redes sociales.</p>
        </div>

        <div class="notice notice-info">
            <p><strong>💡 Consejo:</strong> Para verificar tus meta tags, usa "Ver código fuente" en tu navegador y busca <code>&lt;meta</code></p>
        </div>
    </div>

    <?php
}
