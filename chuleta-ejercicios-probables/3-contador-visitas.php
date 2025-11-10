<?php
/*
Plugin Name: Contador de Visitas Personalizable
Description: Muestra un contador de visitas en el footer con opciones de personalización completas.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= INCREMENTAR CONTADOR AL CARGAR LA PÁGINA ======================= //
function cv_incrementar_contador()
{
    // Obtener el número actual de visitas
    $visitas = (int)get_option('cv_total_visitas', 0);

    // Incrementar en 1
    $visitas = $visitas + 1;

    // Guardar el nuevo valor
    update_option('cv_total_visitas', $visitas);
}
add_action('wp_footer', 'cv_incrementar_contador');

// ======================= MOSTRAR CONTADOR EN EL FOOTER ======================= //
function cv_mostrar_contador()
{
    // Recuperar configuración
    $cv_texto = get_option('cv_texto', 'Visitas totales:');
    $cv_alineacion = get_option('cv_alineacion', 'center');
    $cv_color_texto = get_option('cv_color_texto', '#666666');
    $cv_tamano = get_option('cv_tamano', 'mediano');
    $cv_total_visitas = get_option('cv_total_visitas', 0);

    // Determinar tamaño de fuente
    $font_size = '16px';
    if ($cv_tamano === 'pequeno') {
        $font_size = '12px';
    } elseif ($cv_tamano === 'grande') {
        $font_size = '20px';
    }

    // Determinar alineación
    $text_align = 'center';
    if ($cv_alineacion === 'left') {
        $text_align = 'left';
    } elseif ($cv_alineacion === 'right') {
        $text_align = 'right';
    }

    // Mostrar el contador
    echo "<p style='
        text-align: $text_align;
        color: $cv_color_texto;
        font-size: $font_size;
        margin: 10px 0;
        padding: 10px;
    '>" . esc_html($cv_texto) . " <strong>" . number_format($cv_total_visitas) . "</strong></p>";
}
add_action('wp_footer', 'cv_mostrar_contador');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function cv_crear_menu()
{
    add_menu_page(
        'Contador de Visitas',
        'Contador Visitas',
        'manage_options',
        'contador-visitas',
        'cv_pagina_configuracion',
        'dashicons-visibility'
    );
}
add_action('admin_menu', 'cv_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function cv_pagina_configuracion()
{
    // Guardar configuración
    if (isset($_POST['cv_texto']) && check_admin_referer('cv_guardar_config')) {

        $texto = sanitize_text_field($_POST['cv_texto']);
        update_option('cv_texto', $texto);

        $alineacion = sanitize_text_field($_POST['cv_alineacion']);
        update_option('cv_alineacion', $alineacion);

        $color_texto = sanitize_hex_color($_POST['cv_color_texto']);
        update_option('cv_color_texto', $color_texto);

        $tamano = sanitize_text_field($_POST['cv_tamano']);
        update_option('cv_tamano', $tamano);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Resetear contador si se solicita
    if (isset($_POST['cv_resetear']) && check_admin_referer('cv_resetear_contador')) {
        update_option('cv_total_visitas', 0);
        echo '<div class="updated"><p>✅ Contador reseteado a cero.</p></div>';
    }

    // Leer valores actuales
    $cv_texto = get_option('cv_texto', 'Visitas totales:');
    $cv_alineacion = get_option('cv_alineacion', 'center');
    $cv_color_texto = get_option('cv_color_texto', '#666666');
    $cv_tamano = get_option('cv_tamano', 'mediano');
    $cv_total_visitas = get_option('cv_total_visitas', 0);
    ?>

    <div class="wrap">
        <h1>Configuración del Contador de Visitas</h1>
        <p>Personaliza cómo se mostrará el contador en el pie de página.</p>

        <!-- FORMULARIO DE CONFIGURACIÓN -->
        <h2>Personalización</h2>
        <form method="post">
            <?php wp_nonce_field('cv_guardar_config'); ?>

            <table class="form-table">
                <tr>
                    <th><label for="cv_texto">Texto antes del contador:</label></th>
                    <td>
                        <input type="text"
                               id="cv_texto"
                               name="cv_texto"
                               value="<?php echo esc_attr($cv_texto); ?>"
                               style="width: 300px;"
                               placeholder="Ej: Visitas totales:">
                        <p class="description">El número de visitas aparecerá después de este texto</p>
                    </td>
                </tr>

                <tr>
                    <th>Alineación del texto:</th>
                    <td>
                        <label><input type="radio" name="cv_alineacion" value="left" <?php checked($cv_alineacion, 'left'); ?>> Izquierda</label><br>
                        <label><input type="radio" name="cv_alineacion" value="center" <?php checked($cv_alineacion, 'center'); ?>> Centro</label><br>
                        <label><input type="radio" name="cv_alineacion" value="right" <?php checked($cv_alineacion, 'right'); ?>> Derecha</label>
                    </td>
                </tr>

                <tr>
                    <th><label for="cv_color_texto">Color del texto:</label></th>
                    <td>
                        <input type="color"
                               id="cv_color_texto"
                               name="cv_color_texto"
                               value="<?php echo esc_attr($cv_color_texto); ?>">
                    </td>
                </tr>

                <tr>
                    <th>Tamaño de fuente:</th>
                    <td>
                        <label><input type="radio" name="cv_tamano" value="pequeno" <?php checked($cv_tamano, 'pequeno'); ?>> Pequeño (12px)</label><br>
                        <label><input type="radio" name="cv_tamano" value="mediano" <?php checked($cv_tamano, 'mediano'); ?>> Mediano (16px)</label><br>
                        <label><input type="radio" name="cv_tamano" value="grande" <?php checked($cv_tamano, 'grande'); ?>> Grande (20px)</label>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>

        <hr>

        <!-- SECCIÓN DE ESTADÍSTICAS -->
        <h2>Estadísticas</h2>
        <div class="card">
            <h3>Total de visitas: <span style="color: #0073aa; font-size: 24px;"><?php echo number_format($cv_total_visitas); ?></span></h3>
        </div>

        <!-- FORMULARIO PARA RESETEAR -->
        <h2>Resetear Contador</h2>
        <form method="post" onsubmit="return confirm('¿Estás seguro de que quieres resetear el contador a cero?');">
            <?php wp_nonce_field('cv_resetear_contador'); ?>
            <p>
                <input type="submit"
                       name="cv_resetear"
                       class="button button-secondary"
                       value="Resetear contador a 0">
            </p>
            <p class="description">⚠️ Esta acción no se puede deshacer.</p>
        </form>
    </div>

    <?php
}
