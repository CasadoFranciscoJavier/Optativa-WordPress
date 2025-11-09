# 📖 GUÍA COMPLETA DE CHULETAS PARA EL EXAMEN

**¡Bienvenido a tu kit de estudio para el examen de plugins de WordPress!**

Este documento te guiará por todas las chuletas creadas para tu preparación.

---

## 📂 Estructura de las chuletas

```
plugins/
├── 📁 chuleta-ejercicios-probables/     ← EMPIEZA AQUÍ
│   ├── README.md
│   ├── 1-banner-avisos.php
│   ├── 2-modo-mantenimiento.php
│   ├── 3-contador-visitas.php
│   ├── 4-shortcode-boton.php
│   ├── 5-redes-sociales.php
│   ├── 6-cuenta-regresiva.php
│   └── 7-tema-automatico.php
│
└── 📁 chuleta-ejercicios-nuevos/        ← DESPUÉS ESTO
    ├── README.md
    ├── 1-modificador-titulos.php
    ├── 2-redireccion-login.php
    ├── 3-modificador-excerpt.php
    ├── 4-desactivar-comentarios.php
    ├── 5-meta-tags-seo.php
    ├── 6-inyector-codigo.php
    ├── 7-logo-login.php
    └── 8-ocultar-menus-admin.php
```

---

## 🎯 ¿Qué contiene cada carpeta?

### 📁 **chuleta-ejercicios-probables/** (⭐ PRIORIDAD MÁXIMA)

**7 plugins que combinan conceptos que YA conoces:**
- Basados en tus 3 plugins: Copyright Automático, Filtro Cálido, Mensaje del Día
- Usan solo hooks que has practicado: `wp_footer`, `wp_head`, `admin_menu`
- Inputs que dominas: text, color, radio, checkbox, number, textarea, date, time
- **Probabilidad en el examen: 85-95%**

### 📁 **chuleta-ejercicios-nuevos/** (⭐ PRIORIDAD MEDIA)

**8 plugins con conceptos nuevos:**
- Introducen hooks avanzados: `the_title`, `login_redirect`, `comments_open`, etc.
- Conceptos nuevos: roles de usuario, filtros de contenido, SEO
- Más complejos pero muy bien explicados
- **Probabilidad en el examen: 40-70%** (depende del plugin)

---

## 📚 Plan de estudio recomendado

### **📅 Si tienes 1 semana:**

#### **Días 1-2: Dominar los probables**
- ✅ Lee el README de `chuleta-ejercicios-probables/`
- ✅ Estudia los 7 plugins uno por uno
- ✅ Actívalos en WordPress y pruébalos
- ✅ Identifica patrones comunes

#### **Días 3-4: Practicar los probables**
- ✅ Intenta escribir uno de memoria
- ✅ Modifica alguno (cambia colores, añade opciones)
- ✅ Crea combinaciones propias

#### **Días 5-6: Conceptos nuevos**
- ✅ Lee el README de `chuleta-ejercicios-nuevos/`
- ✅ Estudia los 4 más probables:
  - Meta Tags SEO
  - Inyector de Código
  - Modificador de Títulos
  - Redirección tras Login

#### **Día 7: Repaso general**
- ✅ Repasa estructura básica de un plugin
- ✅ Memoriza funciones clave
- ✅ Revisa la hoja de referencia rápida (más abajo)

---

### **📅 Si tienes 3 días:**

#### **Día 1:**
- ✅ Ejercicios probables 1, 2, 3, 4 (los más sencillos)
- ✅ Activarlos y probarlos

#### **Día 2:**
- ✅ Ejercicios probables 5, 6, 7
- ✅ Meta Tags SEO (de los nuevos)
- ✅ Inyector de Código (de los nuevos)

#### **Día 3:**
- ✅ Repaso de estructura básica
- ✅ Practicar escribir uno desde cero
- ✅ Hoja de referencia rápida

---

### **📅 Si tienes 1 día (urgente!):**

#### **Mañana (4 horas):**
1. ✅ Banner de Avisos (30 min)
2. ✅ Modo Mantenimiento (30 min)
3. ✅ Contador de Visitas (30 min)
4. ✅ Shortcode Botón (30 min)
5. ✅ Meta Tags SEO (30 min)
6. ✅ BREAK 30 minutos
7. ✅ Repaso rápido de todos (1 hora)

#### **Tarde (3 horas):**
1. ✅ Memorizar estructura básica
2. ✅ Practicar formularios
3. ✅ Repasar hoja de referencia
4. ✅ Dormir bien (¡importante!)

---

## 🔑 Hoja de Referencia Rápida

### **Estructura mínima de TODO plugin:**

```php
<?php
/*
Plugin Name: Nombre del Plugin
Description: Qué hace el plugin
Version: 1.0
Author: Tu nombre
*/

if (!defined('ABSPATH')) exit;

// 1. FUNCIÓN PRINCIPAL (lo que hace el plugin)
function prefijo_funcion_principal() {
    // Tu código aquí
}
add_action('wp_footer', 'prefijo_funcion_principal');

// 2. CREAR MENÚ
function prefijo_crear_menu() {
    add_menu_page(
        'Título Página',
        'Título Menú',
        'manage_options',
        'slug-unico',
        'prefijo_pagina_config'
    );
}
add_action('admin_menu', 'prefijo_crear_menu');

// 3. PÁGINA DE CONFIGURACIÓN
function prefijo_pagina_config() {

    // Guardar
    if (isset($_POST['campo']) && check_admin_referer('mi_accion')) {
        $valor = sanitize_text_field($_POST['campo']);
        update_option('mi_opcion', $valor);
        echo '<div class="updated"><p>✅ Guardado</p></div>';
    }

    // Leer
    $valor = get_option('mi_opcion', 'valor_defecto');

    ?>
    <div class="wrap">
        <h1>Configuración</h1>
        <form method="post">
            <?php wp_nonce_field('mi_accion'); ?>

            <input type="text" name="campo" value="<?php echo esc_attr($valor); ?>">

            <input type="submit" class="button-primary" value="Guardar">
        </form>
    </div>
    <?php
}
```

---

### **Funciones que DEBES memorizar:**

#### **Base de datos:**
```php
get_option('nombre', 'defecto')     // Leer
update_option('nombre', $valor)     // Guardar
delete_option('nombre')             // Eliminar
```

#### **Sanitización:**
```php
sanitize_text_field()       // Input text
sanitize_textarea_field()   // Textarea
sanitize_hex_color()        // Color
esc_url_raw()              // URL para guardar
(int)                       // Convertir a número
```

#### **Mostrar en HTML:**
```php
esc_attr()         // Para atributos HTML
esc_html()         // Para texto visible
esc_textarea()     // Para textarea
esc_url()          // Para href, src
```

#### **Seguridad:**
```php
wp_nonce_field('accion')              // En el form
check_admin_referer('accion')         // Al procesar
```

#### **Helpers de formulario:**
```php
checked($actual, 'valor')    // Para radio/checkbox
selected($actual, 'valor')   // Para <select>
```

#### **Tiempo:**
```php
date('Y')          // Año actual
date('H')          // Hora actual (24h)
date('Y-m-d')      // Fecha actual
time()             // Timestamp actual
strtotime($fecha)  // Fecha a timestamp
```

---

### **Tipos de input más usados:**

```html
<!-- Texto simple -->
<input type="text" name="nombre" value="<?php echo esc_attr($valor); ?>">

<!-- Color -->
<input type="color" name="color" value="<?php echo esc_attr($color); ?>">

<!-- Número -->
<input type="number" name="numero" min="0" max="100" value="<?php echo esc_attr($num); ?>">

<!-- Fecha -->
<input type="date" name="fecha" value="<?php echo esc_attr($fecha); ?>">

<!-- Hora -->
<input type="time" name="hora" value="<?php echo esc_attr($hora); ?>">

<!-- Textarea -->
<textarea name="texto" rows="5" cols="50"><?php echo esc_textarea($texto); ?></textarea>

<!-- Radio buttons -->
<label><input type="radio" name="opcion" value="a" <?php checked($actual, 'a'); ?>> Opción A</label>
<label><input type="radio" name="opcion" value="b" <?php checked($actual, 'b'); ?>> Opción B</label>

<!-- Checkbox -->
<input type="checkbox" name="activo" <?php echo $activo ? 'checked' : ''; ?>>

<!-- Select -->
<select name="opcion">
    <option value="1" <?php selected($actual, '1'); ?>>Opción 1</option>
    <option value="2" <?php selected($actual, '2'); ?>>Opción 2</option>
</select>
```

---

### **Hooks más importantes:**

```php
// ACTIONS (ejecutan código)
add_action('wp_footer', 'funcion');      // Footer del sitio
add_action('wp_head', 'funcion');        // Head del sitio
add_action('admin_menu', 'funcion');     // Crear menús admin
add_action('init', 'funcion');           // Al iniciar WordPress

// FILTERS (modifican y devuelven)
add_filter('the_title', 'funcion', 10, 2);       // Modificar títulos
add_filter('the_content', 'funcion');             // Modificar contenido
add_filter('login_redirect', 'funcion', 10, 3);  // Redirigir tras login
```

---

## ⚠️ Errores comunes a EVITAR

❌ **Olvidar el nonce:**
```php
// MAL
if (isset($_POST['campo'])) {

// BIEN
if (isset($_POST['campo']) && check_admin_referer('mi_accion')) {
```

❌ **No sanitizar inputs:**
```php
// MAL
$valor = $_POST['campo'];

// BIEN
$valor = sanitize_text_field($_POST['campo']);
```

❌ **No escapar outputs:**
```php
// MAL
<input value="<?php echo $valor; ?>">

// BIEN
<input value="<?php echo esc_attr($valor); ?>">
```

❌ **Olvidar el if (!defined('ABSPATH')):**
```php
// SIEMPRE al inicio del plugin después del comentario
if (!defined('ABSPATH')) exit;
```

❌ **No usar prefijos en funciones:**
```php
// MAL - puede chocar con otros plugins
function mostrar_mensaje() {

// BIEN - prefijo único
function mi_plugin_mostrar_mensaje() {
```

---

## 💡 Tips para el examen

### **Antes de empezar a escribir:**
1. ✅ Lee el enunciado 2 veces
2. ✅ Haz una lista de las opciones que pide
3. ✅ Decide qué tipo de input necesitas para cada una
4. ✅ Piensa en el hook que vas a usar

### **Mientras escribes:**
1. ✅ Empieza con la estructura básica (copia de esta guía)
2. ✅ Añade el menú y la página de configuración
3. ✅ Crea el formulario con todos los inputs
4. ✅ Implementa el guardado
5. ✅ Implementa la funcionalidad principal
6. ✅ Prueba que funcione

### **Al terminar:**
1. ✅ Verifica que todos los inputs estén sanitizados
2. ✅ Verifica que todos los outputs estén escapados
3. ✅ Verifica que el nonce esté presente
4. ✅ Verifica que no haya múltiples return
5. ✅ Prueba el plugin en WordPress

---

## 🎓 Patrones de código recurrentes

### **Patrón: Checkbox**
```php
// Guardar
$activo = isset($_POST['campo_activo']);
update_option('opcion_activo', $activo);

// Leer
$activo = get_option('opcion_activo', false);

// Mostrar
<input type="checkbox" name="campo_activo" <?php echo $activo ? 'checked' : ''; ?>>
```

### **Patrón: Radio buttons**
```php
// Guardar
$opcion = sanitize_text_field($_POST['mi_opcion']);
update_option('mi_opcion', $opcion);

// Leer
$opcion = get_option('mi_opcion', 'defecto');

// Mostrar
<label><input type="radio" name="mi_opcion" value="a" <?php checked($opcion, 'a'); ?>> A</label>
<label><input type="radio" name="mi_opcion" value="b" <?php checked($opcion, 'b'); ?>> B</label>
```

### **Patrón: Condicional con horarios**
```php
$hora_inicio = 20;
$hora_fin = 7;
$hora_actual = (int)date('H');

$activo = false;

if ($hora_inicio < $hora_fin) {
    // Rango normal: 8 a 20
    if ($hora_actual >= $hora_inicio && $hora_actual < $hora_fin) {
        $activo = true;
    }
} else {
    // Rango que cruza medianoche: 20 a 7
    if ($hora_actual >= $hora_inicio || $hora_actual < $hora_fin) {
        $activo = true;
    }
}
```

### **Patrón: Aplicar estilos dinámicos**
```php
$color = get_option('mi_color', '#000000');
$tamano = get_option('mi_tamano', 'mediano');

$font_size = '16px';
if ($tamano === 'pequeno') {
    $font_size = '12px';
} elseif ($tamano === 'grande') {
    $font_size = '20px';
}

echo "<p style='color: $color; font-size: $font_size;'>Texto</p>";
```

---

## 📊 Checklist del día del examen

### **Antes de empezar:**
- [ ] He leído bien el enunciado
- [ ] Entiendo qué se pide
- [ ] Sé qué hook voy a usar
- [ ] Tengo claro qué inputs necesito

### **Durante el desarrollo:**
- [ ] Estructura básica del plugin ✓
- [ ] Comentario del encabezado ✓
- [ ] if (!defined('ABSPATH')) exit; ✓
- [ ] Función principal con add_action ✓
- [ ] Menú con add_menu_page ✓
- [ ] Página de configuración completa ✓
- [ ] Formulario con nonce ✓
- [ ] Guardado con sanitización ✓
- [ ] Lectura de opciones ✓
- [ ] Funcionalidad implementada ✓

### **Antes de entregar:**
- [ ] Todos los inputs están sanitizados
- [ ] Todos los outputs están escapados
- [ ] El nonce está presente y verificado
- [ ] No hay múltiples return en funciones
- [ ] He probado que funciona
- [ ] El código está comentado (si piden)

---

## 🚀 ¡Última palabras!

**Has estudiado 15 plugins completos** con explicaciones detalladas.

**Dominas:**
- ✅ Estructura de plugins
- ✅ Hooks básicos (wp_footer, wp_head, admin_menu)
- ✅ Formularios y configuración
- ✅ Base de datos (get_option, update_option)
- ✅ Sanitización y seguridad
- ✅ Todos los tipos de inputs

**Conoces:**
- ✅ Hooks avanzados (the_title, login_redirect, etc.)
- ✅ Roles de usuario
- ✅ SEO y meta tags
- ✅ Personalización del admin

**Tienes todo lo necesario para aprobar.** 💪

### **Recuerda:**
1. Lee bien el enunciado
2. Empieza con la estructura básica
3. No te compliques
4. Prueba tu código

**¡Mucha suerte en tu examen!** 🍀🎓✨

---

**Creado con ❤️ para tu éxito académico**
