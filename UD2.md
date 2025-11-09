# UD2 - PLUGINS DE WORDPRESS

## 1.1 - Preparar el entorno

1. Abrir **LocalWP** → botón **"Create a new site"**

   * Nombre: `mi-primer-plugin.local`
   * Configuración por defecto.

2. Cuando el sitio se cree, hacer clic en **"Open Site Folder"**.

3. Ir a la carpeta:

   ```
   app/public/wp-content/plugins/
   ```

4. Crear una carpeta llamada:

   ```
   mi-primer-plugin
   ```

5. Dentro de esa carpeta, crear un archivo:

   ```
   mi-primer-plugin.php
   ```

---

## 2.1. - Estructura mínima del plugin

Abrir el archivo `mi-primer-plugin.php` y escribir:

```php
<?php
/*
Plugin Name: Mi Primer Plugin
Description: Nuestro primer plugin del taller.
Version: 1.0
Author: [Tu nombre]
*/
```

👉 Guarda el archivo.

Luego entra a tu sitio:

```
http://mi-primer-plugin.local/wp-admin
```

Ve a **Plugins → Plugins instalados**
Verás tu plugin en la lista 🥳

Haz clic en **Activar**.

---

## 3.1 - Hacer que "haga algo"

Debajo del bloque inicial, añade:

```php
// Evitar acceso directo
if ( !defined('ABSPATH') ) exit;

// Acción: agregar texto al pie del sitio
function mensaje_pie() {
    echo '<p style="text-align:center; color: gray;">🌟 Hecho con mi primer plugin 🌟</p>';
}

// Enganchar la función al evento del pie
add_action('wp_footer', 'mensaje_pie');
```

Guarda el archivo, recarga la página principal de tu sitio,
y mira el **pie de página** 👀
→ ¡Tu plugin ya está haciendo algo!

🧠 **Qué hemos visto aquí**

* `add_action()` = "cuando ocurra este evento, ejecuta mi función".
* `wp_footer` = evento que ocurre justo antes de cerrar el `</body>`.

---

## 4.1 - Probar otros "eventos"

1. Cambia `wp_footer` por `wp_head`:

   ```php
   add_action('wp_head', 'mensaje_pie');
   ```

   👉 Verás el texto arriba del sitio (en el encabezado).

2. Cambia por `the_content` y ajusta:

   ```php
   function mensaje_en_contenido($contenido) {
       return $contenido . '<p style="color:gray;">- Hecho con mi primer plugin</p>';
   }
   add_filter('the_content', 'mensaje_en_contenido');
   ```

   👉 Ahora el mensaje aparece al final del texto de cada entrada.

🧠 **Hemos visto que:**

* *Actions* (como `wp_footer`) ejecutan cosas.
* *Filters* (como `the_content`) modifican datos que se van a mostrar.

---

## 5.1 - Ejercicio grupal

### [Documento compartido](https://docs.google.com/document/d/1NI70A_ZvT5O2TCm9OjBXr_dDMduezc3jqakrY-36NxQ/edit?usp=sharing)

1. Busquen en Google "WordPress hooks list"
2. Entre todos, elaboren una tabla:

| Tipo   | Hook        | Qué hace / Cuándo pasa     | Qué podría hacer yo       |
| :----- | :---------- | :------------------------- | :------------------------ |
| action | `wp_footer` | Al final del HTML          | Mostrar mensaje           |
| action | `wp_head`   | Antes de cerrar `<head>`   | Añadir meta tag           |
| filter | `the_title` | Antes de mostrar el título | Añadir un emoji al título |
| action | `save_post` | Al guardar una entrada     | Enviar email o registro   |

---

## 6.1. Cierre

### Recapitulación guiada

* Un **plugin** es una carpeta con un archivo PHP que WordPress carga.
* **add_action** = ejecuta algo en un momento concreto.
* **add_filter** = cambia algo antes de mostrarlo.
* Aprendieron a activar, desactivar y modificar el comportamiento del sitio.

### Preguntas para pensar:

* ¿Qué más podría hacer mi plugin?
* ¿Qué pasaría si añadimos CSS o JS propios?