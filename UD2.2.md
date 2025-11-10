# 🧩 **UD2.2 – Menú de configuración y conexión con la base de datos**

---

## 🧠 ¿Qué vas a aprender en esta unidad?

Hasta ahora, tus plugins hacían cosas simples: mostrar mensajes o modificar partes del sitio.
En esta unidad aprenderás a que tu plugin **recuerde cosas** 🧠 y a que el usuario pueda **configurarlo desde el panel de WordPress** (sin tocar código).

Aprenderás a:

* Guardar información en la **base de datos** (sin escribir SQL).
* Crear un **menú de configuración** dentro del panel de administración.
* Mostrar en tu web los datos que el usuario guardó.
* Entender cómo WordPress gestiona los datos y la seguridad.

---

## 1️⃣ - WordPress y la base de datos

Cuando haces un plugin en PHP puro (fuera de WordPress), normalmente tienes que escribir algo como esto:

```php
$conexion = mysqli_connect('localhost', 'root', '', 'mi_base');
```

😫 Pero en WordPress **no hace falta**.
WordPress ya hace esa conexión automáticamente cada vez que se inicia.
Por eso, **no tienes que abrir ni cerrar la conexión**: solo usar las funciones que ya existen.

WordPress ya sabe:

* Dónde está la base de datos.
* Cómo conectarse.
* Cómo guardar o leer datos.

Todo eso está en el archivo `wp-config.php`.

---

### 💡 Entonces, ¿cómo guardo datos?

WordPress tiene un sistema especial para guardar configuraciones, llamado **Options API**.
Esto significa que puedes guardar valores (números, textos, listas, etc.) con un nombre y luego recuperarlos fácilmente.

Imagina que WordPress tiene una caja con etiquetas 📦:

| Etiqueta (nombre) | Contenido (valor)      |
| ----------------- | ---------------------- |
| `titulo_sitio`    | "Mi blog genial"       |
| `color_fondo`     | "#FF0000"              |
| `mdd_frases`      | ["Frase 1", "Frase 2"] |

Cada vez que guardas algo con una función como `update_option()`, WordPress lo mete dentro de esa caja.

---

## 2️⃣ - Las funciones mágicas de la base de datos

| Función                           | Qué hace                            | Ejemplo                             |
| --------------------------------- | ----------------------------------- | ----------------------------------- |
| `get_option('nombre')`            | Lee un valor guardado               | `get_option('color')`               |
| `update_option('nombre', $valor)` | Guarda o actualiza un valor         | `update_option('color', '#ffcc00')` |
| `add_option('nombre', $valor)`    | Añade un nuevo valor (si no existe) | `add_option('frase', 'Hola!')`      |
| `delete_option('nombre')`         | Borra un valor                      | `delete_option('color')`            |

📘 Todas estas funciones guardan la información en la tabla `wp_options`, que ya viene creada con WordPress.

---

### 🧩 Ejemplo rápido

Guarda algo:

```php
update_option('mi_nombre', 'Sofía');
```

Luego, en otro lugar del plugin:

```php
$nombre = get_option('mi_nombre');
echo $nombre; // Muestra: Sofía
```

👉 Y listo.
Sin escribir ni una sola línea de SQL.
WordPress se encarga de todo automáticamente: conectar, guardar, leer y cerrar.

---

## 3️⃣ - Crear el plugin “Mensaje del Día”

Vamos a hacer un plugin que muestre una **frase aleatoria** cada vez que cargas la página.
Pero ahora lo haremos de forma **personalizable** desde el panel de administración.

---

### 🔧 Preparar el entorno

1. Abre **LocalWP** y entra en tu sitio de pruebas.

2. Haz clic en **“Open Site Folder”**.

3. Entra en la carpeta:

   ```
   app/public/wp-content/plugins/
   ```

4. Crea una nueva carpeta llamada:

   ```
   mensaje-del-dia
   ```

5. Dentro, crea un archivo llamado:

   ```
   mensaje-del-dia.php
   ```

---

## 4️⃣ - Estructura básica del plugin

Abre `mensaje-del-dia.php` y escribe:

```php
<?php
/*
Plugin Name: Mensaje del Día
Description: Muestra una frase aleatoria en el pie del sitio.
Version: 1.0
Author: [Tu nombre]
*/

// Evitar acceso directo
if ( !defined('ABSPATH') ) exit;
```

Con esto, WordPress ya reconocerá tu plugin.

👉 Ve a tu panel `http://tu-sitio.local/wp-admin`, entra en
**Plugins → Plugins instalados**
y **actívalo**.

De momento, no hace nada. Vamos a darle vida 😎.

---

## 5️⃣ - Mostrar un mensaje aleatorio

Primero, haremos que el plugin muestre un texto en el pie del sitio.

Añade debajo del código anterior:

```php
function mdd_mostrar_mensaje() {
    $frases = get_option('mdd_frases', []); // Leer las frases guardadas

    // Si no hay frases, no muestra nada
    if (!empty($frases)){
        // Elegir una frase al azar
        $frase = $frases[array_rand($frases)];

        echo '<p style="text-align:center; color: gray;">🌟 ' . esc_html($frase) . ' 🌟</p>';
    }

}

add_action('wp_footer', 'mdd_mostrar_mensaje');
```

🧠 **Qué hace esto:**

* `get_option('mdd_frases', [])`: busca las frases guardadas en la base de datos.
* `array_rand()`: elige una al azar.
* `add_action('wp_footer', ...)`: le dice a WordPress que ejecute la función justo antes del `</body>`.

Por ahora no se verá nada porque todavía **no hay frases guardadas**.
Así que necesitamos una forma de añadirlas desde el panel de administración.

---

## 6️⃣ - Crear un menú en el panel de administración

Queremos que el usuario pueda escribir sus frases desde el panel, sin editar código.
Para eso usamos la función **`add_menu_page()`**.

Pega esto debajo:

```php
add_action('admin_menu', 'mdd_crear_menu');

function mdd_crear_menu() {
    add_menu_page(
        // 🅰️ 1️⃣ - TÍTULO DE LA PÁGINA (parte superior)
        // Este texto aparecerá en la barra de título del navegador
        // y también como encabezado dentro de la página de configuración.
        'Mensaje del Día',

        // 🅱️ 2️⃣ - TEXTO DEL MENÚ
        // Es el texto que se mostrará en el menú lateral de WordPress.
        // Ejemplo: En el panel verás un botón que dice "Mensaje del Día".
        'Mensaje del Día',

        // 🆎 3️⃣ - PERMISO NECESARIO
        // Define qué tipo de usuario puede ver este menú.
        // 'manage_options' significa que solo los administradores pueden verlo.
        // Si quisieras que los editores también lo vean, podrías usar 'edit_posts'.
        'manage_options',

        // 🔠 4️⃣ - SLUG (identificador interno)
        // Es una palabra única que identifica la página dentro de WordPress.
        // Aparecerá en la URL como ?page=mensaje-del-dia
        // y se usa también como "nombre interno" para este menú.
        'mensaje-del-dia',

        // 🧩 5️⃣ - FUNCIÓN QUE MOSTRARÁ EL CONTENIDO
        // Cuando el usuario haga clic en este menú,
        // WordPress llamará a esta función para generar el contenido HTML de la página.
        // Esa función la definiremos más abajo (por ejemplo, mdd_pagina_configuracion()).
        'mdd_pagina_configuracion'
    );
}
```

🔍 Qué hace:

* `admin_menu` → hook que permite añadir menús.
* `add_menu_page()` → crea un nuevo botón en el panel lateral de WordPress.
* Cuando hagas clic en “Mensaje del Día”, se ejecutará la función `mdd_pagina_configuracion()`.

---

## 7️⃣ - Crear la página de configuración

Ahora haremos la función que muestra el formulario y guarda las frases.

Añade debajo del código anterior:

```php
function mdd_pagina_configuracion() {

    // Si el formulario fue enviado...
    if ( isset($_POST['mdd_frases']) && check_admin_referer('mdd_guardar_frases') ) {

        // Limpia el texto
        $texto = sanitize_textarea_field($_POST['mdd_frases']);

        // Divide el texto en líneas (una frase por línea)
        $frases = array_filter(array_map('trim', explode("\n", $texto)));

        // Guarda las frases en la base de datos
        update_option('mdd_frases', $frases);

        echo '<div class="updated"><p>✅ Frases guardadas correctamente.</p></div>';
    }

    // Leer las frases actuales (si hay)
    $frases = get_option('mdd_frases', []);
    $contenido = implode("\n", $frases);
    ?>

    <div class="wrap">
        <h1>Configuración: Mensaje del Día</h1>
        <p>Escribe una frase por línea. Se mostrará una diferente cada vez que se cargue la página.</p>

        <form method="post">
            <?php wp_nonce_field('mdd_guardar_frases'); ?>
            <textarea name="mdd_frases" rows="10" cols="60"><?php echo esc_textarea($contenido); ?></textarea>
            <br><br>
            <input type="submit" class="button-primary" value="Guardar frases">
        </form>
    </div>

    <?php
}
```

---

## 8️⃣ - Cómo funciona todo esto

Vamos a desmenuzarlo 🪓:

### 🔹 Guardado

Cuando haces clic en **“Guardar frases”**, el formulario envía los datos a la misma página.
Luego el plugin:

1. Comprueba si el formulario es real y seguro → `check_admin_referer('mdd_guardar_frases')`
2. Limpia el texto → `sanitize_textarea_field()`
3. Divide el texto en líneas → cada línea será una frase distinta.
4. Guarda todo con → `update_option('mdd_frases', $frases)`

---

### 🔹 Lectura

Cuando abres la página del plugin:

1. Se ejecuta `get_option('mdd_frases', [])`
2. Convierte el array en texto usando `implode("\n", $frases)`
3. Muestra el contenido dentro del `<textarea>`, para que puedas editarlo.

---

### 🔹 Seguridad

WordPress tiene un sistema de seguridad llamado **nonce** (número único temporal).

El formulario incluye esta línea:

```php
<?php wp_nonce_field('mdd_guardar_frases'); ?>
```

Y cuando se procesa, se verifica con:

```php
check_admin_referer('mdd_guardar_frases');
```

👉 Esto evita que alguien intente enviar datos falsos o hackear el formulario desde fuera del panel.

---

## 9️⃣ - Prueba el plugin paso a paso 🎉

1. Ve a tu panel de WordPress.
   **Plugins → Activar “Mensaje del Día”**

2. Verás un nuevo menú en la barra lateral:
   **“Mensaje del Día”**

3. Haz clic y verás un cuadro de texto.

4. Escribe algunas frases, una por línea:

   ```
   Hoy va a ser un gran día ☀️
   Cree en ti mismo 💪
   Cada día cuenta 📅
   ```

5. Pulsa “Guardar frases”.

6. Abre tu sitio web.
   Recarga varias veces la página...
   👉 ¡Verás una frase diferente cada vez! 🎉

---

## 🔟 - Qué está pasando realmente (por dentro)

Detrás de escena, WordPress guarda tus frases en la base de datos.

### 🧱 Tabla usada: `wp_options`

Cuando haces esto:

```php
update_option('mdd_frases', $frases);
```

WordPress crea o actualiza una fila en la tabla `wp_options`:

| option_id | option_name  | option_value                                  | autoload |
| --------- | ------------ | --------------------------------------------- | -------- |
| (auto)    | `mdd_frases` | ["Hoy va...", "Cree en ti...", "Cada día..."] | yes      |

Luego, cuando el plugin se ejecuta en el frontend y hace:

```php
get_option('mdd_frases');
```

WordPress **lee directamente esa fila** y te devuelve el array con tus frases.
No tienes que hacer consultas SQL ni preocuparte por la conexión.

---

### 🔐 Seguridad incluida

* ✅ Los datos se limpian antes de guardarse (`sanitize_textarea_field`).
* ✅ El formulario está protegido (`wp_nonce_field` + `check_admin_referer`).
* ✅ No hay riesgo de inyección SQL (WordPress hace el trabajo).
