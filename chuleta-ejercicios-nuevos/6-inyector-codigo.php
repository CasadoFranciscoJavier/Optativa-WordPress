<?php
/*
Plugin Name: Inyector de Código Personalizado
Description: Permite insertar código HTML, CSS y JavaScript sin editar archivos del tema.
Version: 1.0
Author: Chuleta de Estudio

CONCEPTO NUEVO: Inyección de código personalizado en head y footer (útil para Google Analytics, Facebook Pixel, etc.)
*/

if (!defined('ABSPATH')) exit;

// ======================= INYECTAR CÓDIGO EN EL HEAD ======================= //
function ic_inyectar_head()
{
    $ic_codigo_head = get_option('ic_codigo_head', '');

    if (!empty($ic_codigo_head)) {
        echo $ic_codigo_head . "\n";
    }
}
add_action('wp_head', 'ic_inyectar_head');

// ======================= INYECTAR CÓDIGO EN EL FOOTER ======================= //
function ic_inyectar_footer()
{
    $ic_codigo_footer = get_option('ic_codigo_footer', '');

    if (!empty($ic_codigo_footer)) {
        echo $ic_codigo_footer . "\n";
    }
}
add_action('wp_footer', 'ic_inyectar_footer');

// ======================= INYECTAR CSS PERSONALIZADO ======================= //
function ic_inyectar_css()
{
    $ic_css = get_option('ic_css', '');

    if (!empty($ic_css)) {
        echo '<style>' . "\n" . $ic_css . "\n" . '</style>' . "\n";
    }
}
add_action('wp_head', 'ic_inyectar_css');

// ======================= INYECTAR JAVASCRIPT PERSONALIZADO ======================= //
function ic_inyectar_js()
{
    $ic_js = get_option('ic_js', '');

    if (!empty($ic_js)) {
        echo '<script>' . "\n" . $ic_js . "\n" . '</script>' . "\n";
    }
}
add_action('wp_footer', 'ic_inyectar_js');

// ======================= INYECTAR HTML EN EL BODY ======================= //
function ic_inyectar_body()
{
    $ic_body = get_option('ic_body', '');

    if (!empty($ic_body)) {
        echo $ic_body . "\n";
    }
}
add_action('wp_footer', 'ic_inyectar_body');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function ic_crear_menu()
{
    add_menu_page(
        'Inyector de Código',
        'Inyector Código',
        'manage_options',
        'inyector-codigo',
        'ic_pagina_configuracion',
        'dashicons-editor-code'
    );
}
add_action('admin_menu', 'ic_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function ic_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['ic_codigo_head']) && check_admin_referer('ic_guardar_config')) {

        // IMPORTANTE: NO sanitizar código HTML/JS/CSS ya que lo necesitamos tal cual
        // Solo verificar que sea administrador quien lo guarda (ya se hace con manage_options)
        $codigo_head = wp_unslash($_POST['ic_codigo_head']);
        update_option('ic_codigo_head', $codigo_head);

        $codigo_footer = wp_unslash($_POST['ic_codigo_footer']);
        update_option('ic_codigo_footer', $codigo_footer);

        $css = wp_unslash($_POST['ic_css']);
        update_option('ic_css', $css);

        $js = wp_unslash($_POST['ic_js']);
        update_option('ic_js', $js);

        $body = wp_unslash($_POST['ic_body']);
        update_option('ic_body', $body);

        echo '<div class="updated"><p>✅ Código guardado correctamente.</p></div>';
    }

    // Leer valores actuales
    $ic_codigo_head = get_option('ic_codigo_head', '');
    $ic_codigo_footer = get_option('ic_codigo_footer', '');
    $ic_css = get_option('ic_css', '');
    $ic_js = get_option('ic_js', '');
    $ic_body = get_option('ic_body', '');
    ?>

    <div class="wrap">
        <h1>Inyector de Código Personalizado</h1>
        <p>Inserta código HTML, CSS y JavaScript en tu sitio sin modificar archivos del tema.</p>

        <div class="notice notice-warning">
            <p><strong>⚠️ Advertencia:</strong> Solo usuarios administradores pueden usar esta herramienta. Ten cuidado al pegar código de terceros.</p>
        </div>

        <form method="post">
            <?php wp_nonce_field('ic_guardar_config'); ?>

            <h2>📄 Código en el &lt;head&gt;</h2>
            <p class="description">Se insertará antes de cerrar la etiqueta &lt;/head&gt;. Útil para: meta tags, Google Analytics, verificaciones.</p>
            <textarea name="ic_codigo_head"
                      rows="8"
                      cols="100"
                      style="font-family: monospace; width: 100%; max-width: 900px;"
                      placeholder="<!-- Google Analytics -->
<script>
  // Tu código aquí
</script>"><?php echo esc_textarea($ic_codigo_head); ?></textarea>

            <h2>📄 Código en el &lt;footer&gt;</h2>
            <p class="description">Se insertará antes de cerrar la etiqueta &lt;/body&gt;. Útil para: scripts de chat, Facebook Pixel, etc.</p>
            <textarea name="ic_codigo_footer"
                      rows="8"
                      cols="100"
                      style="font-family: monospace; width: 100%; max-width: 900px;"
                      placeholder="<!-- Facebook Pixel Code -->
<script>
  // Tu código aquí
</script>"><?php echo esc_textarea($ic_codigo_footer); ?></textarea>

            <h2>🎨 CSS Personalizado</h2>
            <p class="description">CSS que se aplicará en todo el sitio. No es necesario escribir las etiquetas &lt;style&gt;.</p>
            <textarea name="ic_css"
                      rows="8"
                      cols="100"
                      style="font-family: monospace; width: 100%; max-width: 900px;"
                      placeholder="/* Tu CSS aquí */
body {
  font-family: Arial, sans-serif;
}

.mi-clase {
  color: red;
}"><?php echo esc_textarea($ic_css); ?></textarea>

            <h2>⚡ JavaScript Personalizado</h2>
            <p class="description">JavaScript que se ejecutará en el footer. No es necesario escribir las etiquetas &lt;script&gt;.</p>
            <textarea name="ic_js"
                      rows="8"
                      cols="100"
                      style="font-family: monospace; width: 100%; max-width: 900px;"
                      placeholder="// Tu JavaScript aquí
console.log('Hola desde el plugin!');

document.addEventListener('DOMContentLoaded', function() {
  // Tu código
});"><?php echo esc_textarea($ic_js); ?></textarea>

            <h2>🌐 HTML en el Body</h2>
            <p class="description">HTML que se insertará al final del &lt;body&gt;. Útil para: páginas completas, secciones personalizadas, landing pages.</p>
            <textarea name="ic_body"
                      rows="8"
                      cols="100"
                      style="font-family: monospace; width: 100%; max-width: 900px;"
                      placeholder="<!-- Tu HTML aquí -->
<div class='mi-seccion'>
  <h1>Título</h1>
  <p>Contenido...</p>
</div>"><?php echo esc_textarea($ic_body); ?></textarea>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar código">
            </p>
        </form>

        <hr>

        <h2>📚 Casos de uso comunes</h2>
        <div class="card" style="padding: 15px;">
            <h3>Google Analytics</h3>
            <p>Pegar el código de seguimiento en "Código en el &lt;head&gt;"</p>

            <h3>Facebook Pixel</h3>
            <p>Pegar el código de pixel en "Código en el &lt;head&gt;"</p>

            <h3>Verificación de Google Search Console</h3>
            <p>Pegar la meta tag de verificación en "Código en el &lt;head&gt;"</p>

            <h3>Chat en vivo (Tawk.to, Crisp, etc.)</h3>
            <p>Pegar el código del widget en "Código en el &lt;footer&gt;"</p>

            <h3>Ajustes de diseño rápidos</h3>
            <p>Usar "CSS Personalizado" para cambiar colores, fuentes, etc. sin tocar el tema</p>

            <h3>Landing pages y portfolios</h3>
            <p>Usar "HTML en el Body" para crear páginas completas personalizadas sin modificar plantillas</p>
        </div>

        <h2>🧠 Concepto técnico</h2>
        <div class="card" style="padding: 15px; background: #f0f0f1;">
            <p><strong>Hooks utilizados:</strong></p>
            <ul>
                <li><code>wp_head</code> - Se ejecuta en el &lt;head&gt; antes de &lt;/head&gt;</li>
                <li><code>wp_footer</code> - Se ejecuta antes de &lt;/body&gt;</li>
            </ul>
            <p><strong>¿Por qué no sanitizar?</strong></p>
            <p>El código HTML/CSS/JS debe insertarse exactamente como está. La sanitización lo rompería.
               Por eso, esta función solo está disponible para administradores (manage_options).</p>
            <p><strong>Función especial:</strong> <code>wp_unslash()</code> elimina las barras invertidas que WordPress añade automáticamente.</p>
        </div>
    </div>

    <?php
}
