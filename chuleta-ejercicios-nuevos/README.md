# 📚 CHULETA DE EJERCICIOS NUEVOS (Conceptos Avanzados)

Esta carpeta contiene **plugins que introducen HOOKS NUEVOS y conceptos más avanzados** que NO has practicado todavía.

Son ejercicios **POSIBLES** pero menos probables que los de la otra carpeta.

---

## 📁 Contenido de esta carpeta

### 🆕 **8 Plugins con Conceptos Nuevos**

1. **[1-modificador-titulos.php](1-modificador-titulos.php)** - Modificador de Títulos
   - 📌 Añade prefijos/sufijos o modifica títulos automáticamente
   - 🆕 **Hook nuevo:** `the_title` (filtro)
   - 🎯 **Aprenderás:** Modificar contenido antes de mostrarlo, diferencia entre actions y filters
   - ⭐ Probabilidad: **ALTA**

2. **[2-redireccion-login.php](2-redireccion-login.php)** - Redirección tras Login
   - 📌 Redirige usuarios a diferentes páginas según su rol
   - 🆕 **Hook nuevo:** `login_redirect`
   - 🎯 **Aprenderás:** Roles de usuario, función `in_array()`, trabajar con objetos de usuario
   - ⭐ Probabilidad: **MUY ALTA**

3. **[3-modificador-excerpt.php](3-modificador-excerpt.php)** - Modificador de Excerpt
   - 📌 Personaliza la longitud y texto final de los resúmenes
   - 🆕 **Hooks nuevos:** `excerpt_length`, `excerpt_more`
   - 🎯 **Aprenderás:** Qué es el excerpt, múltiples filtros relacionados
   - ⭐ Probabilidad: **ALTA**

4. **[4-desactivar-comentarios.php](4-desactivar-comentarios.php)** - Desactivador de Comentarios
   - 📌 Cierra comentarios automáticamente en posts antiguos
   - 🆕 **Hook nuevo:** `comments_open`
   - 🎯 **Aprenderás:** Cálculo de días transcurridos, `get_post()`, timestamps
   - ⭐ Probabilidad: **MEDIA-ALTA**

5. **[5-meta-tags-seo.php](5-meta-tags-seo.php)** - Meta Tags SEO
   - 📌 Añade meta tags para SEO y redes sociales
   - 🆕 **Concepto nuevo:** Open Graph, inyección de meta tags
   - 🎯 **Aprenderás:** SEO básico, meta tags, cómo funcionan las redes sociales
   - ⭐ Probabilidad: **MUY ALTA**

6. **[6-inyector-codigo.php](6-inyector-codigo.php)** - Inyector de Código
   - 📌 Permite insertar HTML/CSS/JS sin editar archivos del tema
   - 🆕 **Concepto nuevo:** `wp_unslash()`, código sin sanitizar
   - 🎯 **Aprenderás:** Cuándo NO sanitizar, inyección de scripts (Analytics, Pixel)
   - ⭐ Probabilidad: **MUY ALTA**

7. **[7-logo-login.php](7-logo-login.php)** - Logo del Login
   - 📌 Cambia el logo y apariencia de la página de login
   - 🆕 **Hooks nuevos:** `login_enqueue_scripts`, `login_headerurl`, `login_headertext`
   - 🎯 **Aprenderás:** Personalización de login, inyección de CSS en páginas específicas
   - ⭐ Probabilidad: **MEDIA**

8. **[8-ocultar-menus-admin.php](8-ocultar-menus-admin.php)** - Ocultar Menús del Admin
   - 📌 Oculta opciones del panel para no administradores
   - 🆕 **Funciones nuevas:** `remove_menu_page()`, `current_user_can()`
   - 🎯 **Aprenderás:** Control de acceso, capacidades de usuario, slugs de menús
   - ⭐ Probabilidad: **MEDIA**

---

## 🎯 ¿Por qué estos son "nuevos"?

🆕 **Introducen hooks que NO has usado antes:**
- Filtros de contenido: `the_title`, `the_content`, `the_excerpt`
- Hooks de autenticación: `login_redirect`, `login_enqueue_scripts`
- Hooks de comentarios: `comments_open`
- Funciones de control: `current_user_can()`, `remove_menu_page()`

🆕 **Conceptos más avanzados:**
- Diferencia clara entre Actions y Filters
- Roles y permisos de usuario
- Manipulación del panel de administración
- SEO y meta tags
- Open Graph Protocol

---

## 📖 Cómo estudiar estos ejercicios

### **Nivel 1 - Lectura inicial:**
1. ✅ Lee solo el README y los comentarios "CONCEPTO NUEVO"
2. ✅ Entiende QUÉ hace cada plugin (no el cómo todavía)
3. ✅ Identifica el hook principal de cada uno

### **Nivel 2 - Comprensión:**
1. ✅ Lee el código completo línea por línea
2. ✅ Busca similitudes con los plugins "probables"
3. ✅ Presta especial atención a las secciones "🧠 Concepto técnico"

### **Nivel 3 - Práctica:**
1. ✅ Activa uno de estos plugins en WordPress
2. ✅ Prueba todas las opciones
3. ✅ Observa cómo afecta al sitio
4. ✅ Intenta modificar pequeñas cosas

---

## 🔑 Conceptos clave NUEVOS

### 1. **Diferencia entre Action y Filter**

**ACTION** (hace algo):
```php
function mi_funcion() {
    echo "Hola";
}
add_action('wp_footer', 'mi_funcion');
// No devuelve nada, solo ejecuta código
```

**FILTER** (modifica y devuelve):
```php
function mi_funcion($contenido) {
    $contenido = $contenido . " - Modificado";
    return $contenido;
}
add_filter('the_title', 'mi_funcion');
// DEBE devolver el valor modificado
```

### 2. **Roles de usuario en WordPress**

```php
current_user_can('manage_options')  // ¿Es admin?
current_user_can('edit_posts')      // ¿Puede editar posts?

// Verificar rol específico
if (in_array('administrator', $user->roles)) {
    // Es administrador
}
```

Roles principales:
- **administrator** - Control total
- **editor** - Gestiona todo el contenido
- **author** - Solo sus propias entradas
- **contributor** - Escribe pero no publica
- **subscriber** - Solo lee

### 3. **Trabajar con fechas y tiempo**

```php
// Obtener timestamp actual
$ahora = time();

// Convertir fecha a timestamp
$timestamp = strtotime('2024-12-25 10:30:00');

// Calcular diferencia en días
$diferencia_segundos = time() - $timestamp;
$dias = floor($diferencia_segundos / (60 * 60 * 24));
```

### 4. **Funciones importantes nuevas**

```php
// Obtener información de un post
$post = get_post($post_id);
$fecha = $post->post_date;
$tipo = $post->post_type;

// Verificar permisos del usuario actual
current_user_can('capacidad');

// Eliminar slashes de WordPress
$codigo = wp_unslash($_POST['campo']);

// Ocultar menú del admin
remove_menu_page('edit.php');

// Obtener URL de la página principal
$url = home_url();
```

### 5. **Hooks de login**

```php
// Inyectar estilos en página de login
add_action('login_enqueue_scripts', 'mi_funcion');

// Cambiar URL del logo de login
add_filter('login_headerurl', 'mi_funcion');

// Cambiar texto alternativo del logo
add_filter('login_headertext', 'mi_funcion');

// Redirigir tras login exitoso
add_filter('login_redirect', 'mi_funcion', 10, 3);
```

---

## 📊 Probabilidad de cada concepto en el examen

### **MUY PROBABLE (80-90%):**
- ✅ Meta tags SEO (muy práctico)
- ✅ Inyector de código (muy útil)
- ✅ Modificador de títulos (concepto fundamental)
- ✅ Redirección tras login (roles de usuario)

### **PROBABLE (50-70%):**
- ✅ Modificador de excerpt
- ✅ Desactivador de comentarios

### **POSIBLE (30-50%):**
- ✅ Logo del login
- ✅ Ocultar menús del admin

---

## 💡 Estrategia de estudio recomendada

### **Si tienes POCO tiempo:**
1. Enfócate en la carpeta **"ejercicios-probables"** primero
2. De esta carpeta, estudia solo:
   - Meta Tags SEO
   - Inyector de Código
   - Modificador de Títulos
   - Redirección tras Login

### **Si tienes TIEMPO MEDIO:**
1. Domina TODOS los "ejercicios-probables"
2. Estudia los 4 de arriba de esta carpeta
3. Lee superficialmente los otros 4

### **Si tienes MUCHO tiempo:**
1. Practica TODOS los plugins de ambas carpetas
2. Intenta crear variaciones
3. Combina conceptos

---

## 🧠 Hooks nuevos - Resumen rápido

| Hook | Tipo | Qué hace | Cuándo usar |
|------|------|----------|-------------|
| `the_title` | Filtro | Modifica títulos | Añadir prefijos/sufijos automáticos |
| `the_content` | Filtro | Modifica contenido | Añadir texto antes/después del contenido |
| `the_excerpt` | Filtro | Modifica resumen | Personalizar extractos |
| `excerpt_length` | Filtro | Cambia longitud del excerpt | Controlar palabras del resumen |
| `excerpt_more` | Filtro | Cambia texto final del excerpt | Cambiar "[...]" por otra cosa |
| `comments_open` | Filtro | Decide si comentarios abiertos | Cerrar comentarios automáticamente |
| `login_redirect` | Filtro | Cambia redirección tras login | Redirigir según rol |
| `login_enqueue_scripts` | Action | Inyecta CSS/JS en login | Personalizar página de login |
| `login_headerurl` | Filtro | Cambia URL del logo login | Que logo lleve a tu sitio |
| `login_headertext` | Filtro | Cambia texto alt del logo | Cambiar tooltip del logo |

---

## ⚠️ Recordatorios importantes

### **Para el examen:**
1. ✅ Los filtros SIEMPRE deben devolver un valor (return)
2. ✅ Los actions NO devuelven nada (solo ejecutan)
3. ✅ Sanitizar inputs EXCEPTO código HTML/CSS/JS
4. ✅ Siempre usar nonces en formularios
5. ✅ current_user_can() para verificar permisos

### **Restricciones de código:**
❌ NO múltiples return en una función
❌ NO usar break ni continue
✅ Usar condicionales if/elseif/else
✅ Bucles while con incremento manual

---

## 🎓 Diferencias clave: Actions vs Filters

### **ACTIONS (add_action):**
- Ejecutan código
- NO devuelven nada
- Ejemplos: mostrar HTML, enviar email, guardar datos
- `wp_footer`, `wp_head`, `admin_menu`, `login_enqueue_scripts`

### **FILTERS (add_filter):**
- Modifican datos
- SIEMPRE devuelven algo
- Ejemplos: cambiar texto, modificar URLs, alterar valores
- `the_title`, `the_content`, `login_redirect`, `excerpt_more`

**Regla de oro:**
- Si **MUESTRA** algo → Action
- Si **CAMBIA** algo → Filter

---

## 📞 Nota final

Estos plugins están MUY bien comentados. Cada concepto nuevo tiene:
- ✅ Comentario "CONCEPTO NUEVO" al inicio
- ✅ Explicación en el código
- ✅ Sección "🧠 Concepto técnico" en la configuración

**No te agobies:** Aprende primero los "ejercicios-probables", luego estos.

**¡Mucha suerte!** 🍀🚀
