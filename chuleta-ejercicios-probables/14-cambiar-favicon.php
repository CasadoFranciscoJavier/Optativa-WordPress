<?php
/*
Plugin Name: Cambiar Favicon Personalizado
Description: Permite cambiar el favicon del sitio desde el panel de administración sin editar código.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= AGREGAR FAVICON PERSONALIZADO ======================= //
function cf_agregar_favicon()
{
    $cf_favicon_url = get_option('cf_favicon_url', '');

    if (!empty($cf_favicon_url)) {
        echo '<link rel="icon" href="' . esc_url($cf_favicon_url) . '" type="image/x-icon">' . "\n";
        echo '<link rel="shortcut icon" href="' . esc_url($cf_favicon_url) . '" type="image/x-icon">' . "\n";
    }
}
add_action('wp_head', 'cf_agregar_favicon');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function cf_crear_menu()
{
    add_menu_page(
        'Cambiar Favicon',
        'Favicon',
        'manage_options',
        'cambiar-favicon',
        'cf_pagina_configuracion',
        'dashicons-format-image'
    );
}
add_action('admin_menu', 'cf_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function cf_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['cf_favicon_url']) && check_admin_referer('cf_guardar_config')) {

        $favicon_url = esc_url_raw($_POST['cf_favicon_url']);
        update_option('cf_favicon_url', $favicon_url);

        echo '<div class="updated"><p>✅ Favicon guardado correctamente.</p></div>';
    }

    // Leer valor actual
    $cf_favicon_url = get_option('cf_favicon_url', '');
    ?>

    <div class="wrap">
        <h1>Configuración del Favicon</h1>
        <p>El favicon es el pequeño icono que aparece en la pestaña del navegador junto al título de tu sitio.</p>

        <form method="post">
            <?php wp_nonce_field('cf_guardar_config'); ?>

            <h2>🖼️ Configuración</h2>

            <p>
                <label for="cf_favicon_url"><strong>URL de la imagen del favicon:</strong></label><br>
                <input type="url"
                       id="cf_favicon_url"
                       name="cf_favicon_url"
                       value="<?php echo esc_attr($cf_favicon_url); ?>"
                       style="width: 100%; max-width: 600px;"
                       placeholder="https://tusitio.com/wp-content/uploads/favicon.ico">
            </p>

            <p class="description">
                Pega aquí la URL completa de tu imagen favicon. Puede ser formato .ico, .png o .jpg
            </p>

            <?php if (!empty($cf_favicon_url)): ?>
                <h3>Vista previa actual:</h3>
                <div style="padding: 20px; background: #f9f9f9; display: inline-block;">
                    <img src="<?php echo esc_url($cf_favicon_url); ?>"
                         alt="Favicon"
                         style="width: 32px; height: 32px; image-rendering: pixelated;">
                    <p><small>Tamaño real (ampliado para ver mejor)</small></p>
                </div>
            <?php endif; ?>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar favicon">
            </p>
        </form>

        <hr>

        <h2>📖 Cómo subir una imagen</h2>
        <div class="notice notice-info">
            <p><strong>Paso 1:</strong> Ve a <strong>Medios → Añadir nuevo</strong> en el menú de WordPress</p>
            <p><strong>Paso 2:</strong> Sube tu imagen (recomendado: 32x32 píxeles o 16x16 píxeles)</p>
            <p><strong>Paso 3:</strong> Haz clic en la imagen subida y copia la URL del archivo</p>
            <p><strong>Paso 4:</strong> Pega esa URL en el campo de arriba</p>
        </div>

        <h2>✨ Recomendaciones</h2>
        <div class="notice notice-warning">
            <p><strong>Tamaño ideal:</strong> 32x32 píxeles o 16x16 píxeles</p>
            <p><strong>Formatos soportados:</strong> .ico (mejor compatibilidad), .png (buena calidad), .jpg</p>
            <p><strong>Diseño:</strong> Usa formas simples y colores contrastantes. El favicon es muy pequeño.</p>
            <p><strong>Fondo transparente:</strong> Recomendado usar PNG con transparencia</p>
        </div>

        <h2>🛠️ Herramientas útiles</h2>
        <div style="background: #f0f0f1; padding: 15px;">
            <p><strong>Generadores online de favicon:</strong></p>
            <ul>
                <li>favicon.io - Crea favicons desde texto o emoji</li>
                <li>realfavicongenerator.net - Generador completo con vista previa</li>
                <li>canva.com - Diseña tu favicon personalizado</li>
            </ul>
            <p><small>Busca estos sitios en Google para acceder a ellos</small></p>
        </div>

        <h2>💡 Casos de uso</h2>
        <div class="notice notice-success">
            <p>✅ Dar identidad visual a tu sitio</p>
            <p>✅ Facilitar que usuarios identifiquen tu pestaña entre muchas abiertas</p>
            <p>✅ Profesionalizar la apariencia del sitio</p>
            <p>✅ Reforzar branding con el logo de tu marca</p>
        </div>

        <h2>🔧 Concepto técnico</h2>
        <div style="background: #f0f0f1; padding: 15px;">
            <p><strong>Código generado:</strong></p>
            <code>&lt;link rel="icon" href="URL" type="image/x-icon"&gt;</code>
            <p style="margin-top: 10px;">Esta etiqueta se inserta en el <code>&lt;head&gt;</code> del HTML usando el hook <code>wp_head</code></p>
        </div>
    </div>

    <?php
}
