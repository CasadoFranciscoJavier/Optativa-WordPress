<?php
/*
Plugin Name: Tiempo Estimado de Lectura
Description: Calcula y muestra el tiempo estimado de lectura de cada entrada.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= AGREGAR TIEMPO DE LECTURA ======================= //
function tel_agregar_tiempo($contenido)
{
    $tel_activo = get_option('tel_activo', false);

    if (!$tel_activo || !is_single()) {
        return $contenido;
    }

    // Contar palabras del contenido
    $texto_limpio = strip_tags($contenido);
    $palabras = str_word_count($texto_limpio);

    // Calcular minutos (promedio 200 palabras por minuto)
    $minutos = ceil($palabras / 200);

    // Crear mensaje
    $mensaje = '<div style="
        background: #f0f0f1;
        padding: 15px;
        margin-bottom: 20px;
        border-left: 4px solid #0073aa;
        font-size: 14px;
    ">
        📖 <strong>Tiempo de lectura:</strong> ' . $minutos . ' minuto' . ($minutos > 1 ? 's' : '') . ' (' . number_format($palabras) . ' palabras)
    </div>';

    return $mensaje . $contenido;
}
add_filter('the_content', 'tel_agregar_tiempo');

// ======================= CREAR MENÚ ======================= //
function tel_crear_menu()
{
    add_menu_page(
        'Tiempo de Lectura',
        'T. Lectura',
        'manage_options',
        'tiempo-lectura',
        'tel_pagina_configuracion',
        'dashicons-clock'
    );
}
add_action('admin_menu', 'tel_crear_menu');

// ======================= CONFIGURACIÓN ======================= //
function tel_pagina_configuracion()
{
    if (isset($_POST['tel_submit']) && check_admin_referer('tel_guardar')) {
        update_option('tel_activo', isset($_POST['tel_activo']));
        echo '<div class="updated"><p>✅ Guardado.</p></div>';
    }

    $tel_activo = get_option('tel_activo', false);
    ?>

    <div class="wrap">
        <h1>Tiempo Estimado de Lectura</h1>
        <p>Muestra automáticamente cuánto tiempo tomará leer cada entrada.</p>

        <form method="post">
            <?php wp_nonce_field('tel_guardar'); ?>

            <p>
                <label>
                    <input type="checkbox" name="tel_activo" <?php echo $tel_activo ? 'checked' : ''; ?>>
                    <strong>Mostrar tiempo de lectura en entradas</strong>
                </label>
            </p>

            <p class="submit">
                <input type="submit" name="tel_submit" class="button-primary" value="Guardar">
            </p>
        </form>

        <hr>

        <h2>📊 Cómo se calcula</h2>
        <div class="notice notice-info">
            <p><strong>Promedio:</strong> 200 palabras por minuto (velocidad de lectura promedio)</p>
            <p><strong>Fórmula:</strong> Total de palabras ÷ 200 = Minutos</p>
            <p><strong>Ejemplo:</strong> Un artículo de 800 palabras = 4 minutos de lectura</p>
        </div>

        <h2>💡 Beneficios</h2>
        <div class="notice notice-success">
            <p>✅ Los usuarios saben cuánto tiempo les tomará</p>
            <p>✅ Mejora la experiencia de usuario</p>
            <p>✅ Aumenta el engagement</p>
            <p>✅ Aspecto profesional</p>
        </div>
    </div>
    <?php
}
