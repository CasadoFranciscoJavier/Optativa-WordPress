<?php
/*
Plugin Name: Banner de Avisos Personalizables
Description: Muestra un banner configurable en la parte superior o inferior del sitio con opciones de personalización.
Version: 1.0
Author: Chuleta de Estudio
*/

if (!defined('ABSPATH')) exit;

// ======================= FUNCIÓN QUE MUESTRA EL BANNER ======================= //
function ba_mostrar_banner()
{
    // Recuperar opciones guardadas
    $ba_activo = get_option('ba_activo', false);
    $ba_texto = get_option('ba_texto', '');
    $ba_color_fondo = get_option('ba_color_fondo', '#ffcc00');
    $ba_color_texto = get_option('ba_color_texto', '#000000');
    $ba_tamano = get_option('ba_tamano', 'mediano');
    $ba_posicion = get_option('ba_posicion', 'arriba');

    // Si el banner no está activo o no hay texto, no mostramos nada
    if (!$ba_activo || empty($ba_texto)) {
        return;
    }

    // Determinar tamaño de fuente según la configuración
    $font_size = '16px';
    if ($ba_tamano === 'pequeno') {
        $font_size = '12px';
    } elseif ($ba_tamano === 'grande') {
        $font_size = '20px';
    }

    // Determinar posición del banner
    $position_style = 'top: 0;';
    if ($ba_posicion === 'abajo') {
        $position_style = 'bottom: 0;';
    }

    // Mostrar el banner con todos los estilos aplicados
    echo "<div style='
        position: fixed;
        $position_style
        left: 0;
        width: 100%;
        background-color: $ba_color_fondo;
        color: $ba_color_texto;
        text-align: center;
        padding: 15px;
        font-size: $font_size;
        z-index: 9999;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    '>" . esc_html($ba_texto) . "</div>";
}
add_action('wp_footer', 'ba_mostrar_banner');

// ======================= CREAR MENÚ EN EL ADMIN ======================= //
function ba_crear_menu()
{
    add_menu_page(
        'Banner de Avisos',           // Título de la página
        'Banner de Avisos',           // Texto del menú
        'manage_options',             // Capacidad necesaria
        'banner-avisos',              // Slug único
        'ba_pagina_configuracion'     // Función que muestra el contenido
    );
}
add_action('admin_menu', 'ba_crear_menu');

// ======================= PÁGINA DE CONFIGURACIÓN ======================= //
function ba_pagina_configuracion()
{
    // Si el formulario fue enviado y es válido
    if (isset($_POST['ba_texto']) && check_admin_referer('ba_guardar_config')) {

        // Sanitizar y guardar cada campo
        $texto = sanitize_text_field($_POST['ba_texto']);
        update_option('ba_texto', $texto);

        $color_fondo = sanitize_hex_color($_POST['ba_color_fondo']);
        update_option('ba_color_fondo', $color_fondo);

        $color_texto = sanitize_hex_color($_POST['ba_color_texto']);
        update_option('ba_color_texto', $color_texto);

        $tamano = sanitize_text_field($_POST['ba_tamano']);
        update_option('ba_tamano', $tamano);

        $posicion = sanitize_text_field($_POST['ba_posicion']);
        update_option('ba_posicion', $posicion);

        // Checkbox: si está marcado existe en $_POST, si no, no existe
        $activo = isset($_POST['ba_activo']);
        update_option('ba_activo', $activo);

        echo '<div class="updated"><p>✅ Configuración guardada correctamente.</p></div>';
    }

    // Leer valores actuales para mostrarlos en el formulario
    $ba_texto = get_option('ba_texto', '');
    $ba_color_fondo = get_option('ba_color_fondo', '#ffcc00');
    $ba_color_texto = get_option('ba_color_texto', '#000000');
    $ba_tamano = get_option('ba_tamano', 'mediano');
    $ba_posicion = get_option('ba_posicion', 'arriba');
    $ba_activo = get_option('ba_activo', false);
    ?>

    <div class="wrap">
        <h1>Configuración del Banner de Avisos</h1>
        <p>Personaliza el banner que aparecerá en tu sitio web.</p>

        <form method="post">
            <?php wp_nonce_field('ba_guardar_config'); ?>

            <table class="form-table">
                <tr>
                    <th><label for="ba_texto">Texto del aviso:</label></th>
                    <td>
                        <input type="text"
                               id="ba_texto"
                               name="ba_texto"
                               value="<?php echo esc_attr($ba_texto); ?>"
                               style="width: 400px;"
                               placeholder="Ej: ¡Oferta especial! 50% de descuento">
                    </td>
                </tr>

                <tr>
                    <th><label for="ba_color_fondo">Color de fondo:</label></th>
                    <td>
                        <input type="color"
                               id="ba_color_fondo"
                               name="ba_color_fondo"
                               value="<?php echo esc_attr($ba_color_fondo); ?>">
                    </td>
                </tr>

                <tr>
                    <th><label for="ba_color_texto">Color del texto:</label></th>
                    <td>
                        <input type="color"
                               id="ba_color_texto"
                               name="ba_color_texto"
                               value="<?php echo esc_attr($ba_color_texto); ?>">
                    </td>
                </tr>

                <tr>
                    <th>Tamaño de fuente:</th>
                    <td>
                        <label><input type="radio" name="ba_tamano" value="pequeno" <?php checked($ba_tamano, 'pequeno'); ?>> Pequeño</label><br>
                        <label><input type="radio" name="ba_tamano" value="mediano" <?php checked($ba_tamano, 'mediano'); ?>> Mediano</label><br>
                        <label><input type="radio" name="ba_tamano" value="grande" <?php checked($ba_tamano, 'grande'); ?>> Grande</label>
                    </td>
                </tr>

                <tr>
                    <th>Posición del banner:</th>
                    <td>
                        <label><input type="radio" name="ba_posicion" value="arriba" <?php checked($ba_posicion, 'arriba'); ?>> Arriba</label><br>
                        <label><input type="radio" name="ba_posicion" value="abajo" <?php checked($ba_posicion, 'abajo'); ?>> Abajo</label>
                    </td>
                </tr>

                <tr>
                    <th>Activar banner:</th>
                    <td>
                        <label>
                            <input type="checkbox"
                                   name="ba_activo"
                                   <?php echo $ba_activo ? 'checked' : ''; ?>>
                            Mostrar el banner en el sitio
                        </label>
                    </td>
                </tr>
            </table>

            <p class="submit">
                <input type="submit" class="button-primary" value="Guardar configuración">
            </p>
        </form>
    </div>

    <?php
}
