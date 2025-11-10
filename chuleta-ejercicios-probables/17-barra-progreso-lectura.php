<?php
/*
Plugin Name: Barra de Progreso de Lectura
Description: Muestra una barra de progreso en la parte superior que indica cuánto has leído de la página.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= AGREGAR BARRA DE PROGRESO ======================= //
function bpl_agregar_barra()
{
    $bpl_activo = get_option('bpl_activo', false);
    $bpl_color = get_option('bpl_color', '#0073aa');
    $bpl_altura = get_option('bpl_altura', 4);

    if (!$bpl_activo) {
        return;
    }

    ?>
    <div id="bpl-barra" style="
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: <?php echo esc_attr($bpl_altura); ?>px;
        background-color: <?php echo esc_attr($bpl_color); ?>;
        z-index: 99999;
        transition: width 0.1s ease;
    "></div>

    <script>
        window.addEventListener('scroll', function() {
            var scrollTop = window.pageYOffset || document.documentElement.scrollTop;
            var scrollHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            var scrollPorcentaje = (scrollTop / scrollHeight) * 100;

            document.getElementById('bpl-barra').style.width = scrollPorcentaje + '%';
        });
    </script>
    <?php
}
add_action('wp_footer', 'bpl_agregar_barra');

// ======================= CREAR MENÚ ======================= //
function bpl_crear_menu()
{
    add_menu_page(
        'Barra de Progreso',
        'Progreso Lectura',
        'manage_options',
        'barra-progreso',
        'bpl_pagina_configuracion',
        'dashicons-chart-line'
    );
}
add_action('admin_menu', 'bpl_crear_menu');

// ======================= CONFIGURACIÓN ======================= //
function bpl_pagina_configuracion()
{
    if (isset($_POST['bpl_color']) && check_admin_referer('bpl_guardar')) {
        update_option('bpl_color', sanitize_hex_color($_POST['bpl_color']));
        update_option('bpl_altura', (int)sanitize_text_field($_POST['bpl_altura']));
        update_option('bpl_activo', isset($_POST['bpl_activo']));
        echo '<div class="updated"><p>✅ Guardado.</p></div>';
    }

    $bpl_color = get_option('bpl_color', '#0073aa');
    $bpl_altura = get_option('bpl_altura', 4);
    $bpl_activo = get_option('bpl_activo', false);
    ?>

    <div class="wrap">
        <h1>Barra de Progreso de Lectura</h1>
        <form method="post">
            <?php wp_nonce_field('bpl_guardar'); ?>

            <p>
                <label>
                    <input type="checkbox" name="bpl_activo" <?php echo $bpl_activo ? 'checked' : ''; ?>>
                    Activar barra de progreso
                </label>
            </p>

            <p>
                <label><strong>Color:</strong></label><br>
                <input type="color" name="bpl_color" value="<?php echo esc_attr($bpl_color); ?>">
            </p>

            <p>
                <label><strong>Altura (px):</strong></label><br>
                <input type="number" name="bpl_altura" min="1" max="20" value="<?php echo esc_attr($bpl_altura); ?>" style="width: 100px;">
            </p>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar">
            </p>
        </form>
    </div>
    <?php
}
