# 🎨 EFECTOS VISUALES Y EJEMPLOS DE CÓDIGO

Colección de efectos visuales impresionantes y ejemplos prácticos para el Inyector de Código.

---

## 📑 ÍNDICE

1. [Efectos Visuales Espectaculares](#efectos-visuales)
2. [Google Analytics](#google-analytics)
3. [Facebook Pixel](#facebook-pixel)
4. [Google Search Console](#google-search-console)
5. [Chat en Vivo](#chat-en-vivo)
6. [Ajustes de Diseño Rápidos](#ajustes-diseño)
7. [Banners y Avisos](#banners-avisos)
8. [Efectos de Cursor](#efectos-cursor)

---

# 🌟 EFECTOS VISUALES ESPECTACULARES {#efectos-visuales}

## 1. 🌧️ LLUVIA DE CORAZONES COLORIDOS

### CSS:
```css
@keyframes fall {
    to {
        transform: translateY(100vh) rotate(360deg);
    }
}

.heart {
    position: fixed;
    top: -50px;
    font-size: 30px;
    animation: fall linear infinite;
    z-index: 9999;
    pointer-events: none;
}
```

### JavaScript:
```javascript
function createHeart() {
    var heart = document.createElement('div');
    heart.className = 'heart';
    heart.innerHTML = '❤️';
    heart.style.left = Math.random() * 100 + 'vw';
    heart.style.animationDuration = (Math.random() * 3 + 2) + 's';
    heart.style.opacity = Math.random();
    document.body.appendChild(heart);

    setTimeout(function() {
        heart.remove();
    }, 5000);
}

setInterval(createHeart, 300);
```

---

## 2. 🌈 BARRA ARCOÍRIS SUPERIOR

### CSS:
```css
.rainbow-bar {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 5px;
    background: linear-gradient(90deg,
        #ff0000, #ff7f00, #ffff00, #00ff00,
        #0000ff, #4b0082, #9400d3);
    z-index: 99999;
    animation: rainbow-slide 3s linear infinite;
}

@keyframes rainbow-slide {
    0% { background-position: 0% 50%; }
    100% { background-position: 100% 50%; }
}
```

### HTML (Body):
```html
<div class="rainbow-bar"></div>
```

---

## 3. ✨ TEXTO CON EFECTO ARCOÍRIS

### CSS:
```css
.rainbow-text {
    font-size: 48px;
    font-weight: bold;
    text-align: center;
    background: linear-gradient(90deg,
        #ff0000, #ff7f00, #ffff00, #00ff00,
        #0000ff, #4b0082, #9400d3);
    background-size: 200% auto;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: rainbow-animation 3s linear infinite;
}

@keyframes rainbow-animation {
    to {
        background-position: 200% center;
    }
}
```

### HTML (Body):
```html
<h1 class="rainbow-text">¡Texto Arcoíris Increíble!</h1>
```

---

## 4. ⭐ CURSOR DE ESTRELLAS MÁGICAS

### CSS:
```css
.star-trail {
    position: fixed;
    pointer-events: none;
    font-size: 20px;
    animation: star-fade 1s ease-out forwards;
    z-index: 9999;
}

@keyframes star-fade {
    from {
        opacity: 1;
        transform: scale(1) rotate(0deg);
    }
    to {
        opacity: 0;
        transform: scale(0) rotate(360deg);
    }
}
```

### JavaScript:
```javascript
document.addEventListener('mousemove', function(e) {
    var star = document.createElement('div');
    star.className = 'star-trail';
    star.innerHTML = '⭐';
    star.style.left = e.pageX + 'px';
    star.style.top = e.pageY + 'px';
    document.body.appendChild(star);

    setTimeout(function() {
        star.remove();
    }, 1000);
});
```

---

## 5. 💡 MODO NEÓN (Fondo Oscuro + Bordes Brillantes)

### CSS:
```css
body.neon-mode {
    background: #000;
    color: #fff;
}

.neon-mode h1,
.neon-mode h2,
.neon-mode h3 {
    text-shadow:
        0 0 5px #fff,
        0 0 10px #fff,
        0 0 20px #ff00de,
        0 0 30px #ff00de,
        0 0 40px #ff00de,
        0 0 55px #ff00de,
        0 0 75px #ff00de;
    animation: neon-flicker 1.5s infinite alternate;
}

@keyframes neon-flicker {
    0%, 100% {
        text-shadow:
            0 0 5px #fff,
            0 0 10px #fff,
            0 0 20px #ff00de,
            0 0 30px #ff00de,
            0 0 40px #ff00de,
            0 0 55px #ff00de,
            0 0 75px #ff00de;
    }
    50% {
        text-shadow:
            0 0 2px #fff,
            0 0 5px #fff,
            0 0 10px #ff00de,
            0 0 15px #ff00de,
            0 0 20px #ff00de;
    }
}

.neon-button {
    border: 2px solid #ff00de;
    padding: 15px 40px;
    background: transparent;
    color: #ff00de;
    font-size: 18px;
    text-transform: uppercase;
    cursor: pointer;
    box-shadow:
        0 0 5px #ff00de,
        0 0 10px #ff00de,
        inset 0 0 5px #ff00de;
    transition: all 0.3s;
}

.neon-button:hover {
    background: #ff00de;
    color: #000;
    box-shadow:
        0 0 20px #ff00de,
        0 0 40px #ff00de,
        inset 0 0 10px #ff00de;
}
```

### JavaScript:
```javascript
document.body.classList.add('neon-mode');
```

### HTML (Body):
```html
<div style="text-align: center; margin-top: 100px;">
    <h1>BIENVENIDO AL MODO NEÓN</h1>
    <button class="neon-button">Click Aquí</button>
</div>
```

---

## 6. 🎊 CONFETI EXPLOSIVO

### JavaScript:
```javascript
function createConfetti() {
    var colors = ['#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff'];

    for (var i = 0; i < 100; i++) {
        var confetti = document.createElement('div');
        confetti.style.position = 'fixed';
        confetti.style.width = '10px';
        confetti.style.height = '10px';
        confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
        confetti.style.left = '50%';
        confetti.style.top = '50%';
        confetti.style.borderRadius = '50%';
        confetti.style.zIndex = '9999';
        confetti.style.pointerEvents = 'none';

        var angle = Math.random() * Math.PI * 2;
        var velocity = Math.random() * 10 + 5;
        var vx = Math.cos(angle) * velocity;
        var vy = Math.sin(angle) * velocity;

        document.body.appendChild(confetti);

        var x = 0;
        var y = 0;
        var interval = setInterval(function() {
            x += vx;
            y += vy;
            vy += 0.5;
            confetti.style.transform = 'translate(' + x + 'px, ' + y + 'px)';

            if (y > window.innerHeight) {
                clearInterval(interval);
                confetti.remove();
            }
        }, 16);
    }
}

// Ejecutar confeti cada 5 segundos
setInterval(createConfetti, 5000);
// O ejecutar al hacer clic
document.addEventListener('click', createConfetti);
```

---

## 7. 🔥 FONDO DEGRADADO ANIMADO

### CSS:
```css
body.gradient-animated {
    background: linear-gradient(-45deg, #ee7752, #e73c7e, #23a6d5, #23d5ab);
    background-size: 400% 400%;
    animation: gradient-shift 15s ease infinite;
    min-height: 100vh;
}

@keyframes gradient-shift {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
```

### JavaScript:
```javascript
document.body.classList.add('gradient-animated');
```

---

## 8. 💫 PARTÍCULAS FLOTANTES

### CSS:
```css
.particle {
    position: fixed;
    width: 4px;
    height: 4px;
    background: white;
    border-radius: 50%;
    pointer-events: none;
    z-index: 9999;
    animation: float-up linear infinite;
}

@keyframes float-up {
    to {
        transform: translateY(-100vh);
        opacity: 0;
    }
}
```

### JavaScript:
```javascript
function createParticle() {
    var particle = document.createElement('div');
    particle.className = 'particle';
    particle.style.left = Math.random() * 100 + 'vw';
    particle.style.bottom = '-10px';
    particle.style.animationDuration = (Math.random() * 5 + 5) + 's';
    particle.style.opacity = Math.random();
    document.body.appendChild(particle);

    setTimeout(function() {
        particle.remove();
    }, 10000);
}

setInterval(createParticle, 200);
```

---

# 📊 GOOGLE ANALYTICS {#google-analytics}

### Código en el HEAD:
```html
<!-- Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=GA_MEASUREMENT_ID"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'GA_MEASUREMENT_ID');
</script>
```

**Nota:** Reemplaza `GA_MEASUREMENT_ID` con tu ID real (ej: `G-XXXXXXXXXX`)

---

# 📘 FACEBOOK PIXEL {#facebook-pixel}

### Código en el HEAD:
```html
<!-- Facebook Pixel Code -->
<script>
!function(f,b,e,v,n,t,s)
{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
n.callMethod.apply(n,arguments):n.queue.push(arguments)};
if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
n.queue=[];t=b.createElement(e);t.async=!0;
t.src=v;s=b.getElementsByTagName(e)[0];
s.parentNode.insertBefore(t,s)}(window, document,'script',
'https://connect.facebook.net/en_US/fbevents.js');
fbq('init', 'TU_PIXEL_ID');
fbq('track', 'PageView');
</script>
<noscript>
  <img height="1" width="1" style="display:none"
       src="https://www.facebook.com/tr?id=TU_PIXEL_ID&ev=PageView&noscript=1"/>
</noscript>
```

**Nota:** Reemplaza `TU_PIXEL_ID` con tu Pixel ID real

---

# 🔍 GOOGLE SEARCH CONSOLE {#google-search-console}

### Código en el HEAD:
```html
<!-- Google Search Console Verification -->
<meta name="google-site-verification" content="TU_CODIGO_DE_VERIFICACION" />
```

**Nota:** Reemplaza `TU_CODIGO_DE_VERIFICACION` con el código que te proporciona Google Search Console

---

# 💬 CHAT EN VIVO {#chat-en-vivo}

## Tawk.to

### Código en el FOOTER:
```html
<!-- Tawk.to Live Chat -->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/TU_PROPERTY_ID/TU_WIDGET_ID';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
```

## Crisp

### Código en el FOOTER:
```html
<!-- Crisp Live Chat -->
<script type="text/javascript">
window.$crisp=[];
window.CRISP_WEBSITE_ID="TU_WEBSITE_ID";
(function(){
    d=document;
    s=d.createElement("script");
    s.src="https://client.crisp.chat/l.js";
    s.async=1;
    d.getElementsByTagName("head")[0].appendChild(s);
})();
</script>
```

## Widget de WhatsApp

### CSS:
```css
.whatsapp-button {
    position: fixed;
    bottom: 20px;
    right: 20px;
    background: #25d366;
    color: white;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 30px;
    box-shadow: 0 4px 12px rgba(37, 211, 102, 0.4);
    cursor: pointer;
    text-decoration: none;
    z-index: 9999;
    transition: all 0.3s;
}

.whatsapp-button:hover {
    transform: scale(1.1);
    box-shadow: 0 6px 20px rgba(37, 211, 102, 0.6);
}
```

### HTML (Body):
```html
<a href="https://wa.me/34XXXXXXXXX?text=Hola,%20tengo%20una%20consulta"
   class="whatsapp-button"
   target="_blank"
   rel="noopener">
    💬
</a>
```

**Nota:** Reemplaza `34XXXXXXXXX` con tu número de WhatsApp (código país + número)

---

# 🎨 AJUSTES DE DISEÑO RÁPIDOS {#ajustes-diseño}

## Cambiar Fuente Global

### CSS:
```css
/* Cambiar fuente de todo el sitio */
body {
    font-family: 'Georgia', serif !important;
}

/* O usar Google Fonts */
@import url('https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap');

body {
    font-family: 'Roboto', sans-serif !important;
}
```

---

## Cambiar Colores del Tema

### CSS:
```css
/* Cambiar color de enlaces */
a {
    color: #ff6b6b !important;
}

a:hover {
    color: #ee5a6f !important;
}

/* Cambiar color de botones */
button,
.button,
input[type="submit"] {
    background-color: #4ecdc4 !important;
    color: white !important;
    border: none !important;
}

button:hover,
.button:hover,
input[type="submit"]:hover {
    background-color: #45b7aa !important;
}

/* Cambiar color de encabezados */
h1, h2, h3, h4, h5, h6 {
    color: #2c3e50 !important;
}
```

---

## Ocultar Elementos del Tema

### CSS:
```css
/* Ocultar sidebar */
.sidebar {
    display: none !important;
}

/* Ocultar footer del tema */
.site-footer {
    display: none !important;
}

/* Ocultar barra de admin si no eres admin */
#wpadminbar {
    display: none !important;
}

/* Expandir contenido al 100% */
.content,
.main-content,
article {
    width: 100% !important;
    max-width: 100% !important;
}
```

---

## Añadir Sombras y Efectos Modernos

### CSS:
```css
/* Sombras suaves en imágenes */
img {
    border-radius: 10px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    transition: all 0.3s;
}

img:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
}

/* Sombras en tarjetas/posts */
.post,
.card,
article {
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
    padding: 20px;
    transition: all 0.3s;
}

.post:hover,
.card:hover,
article:hover {
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
    transform: translateY(-3px);
}
```

---

# 📢 BANNERS Y AVISOS {#banners-avisos}

## Banner de Promoción Superior

### CSS:
```css
.promo-banner {
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
    color: white;
    text-align: center;
    padding: 15px 20px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 9999;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
}

.promo-banner strong {
    font-weight: bold;
}

.promo-banner a {
    color: #ffd700;
    text-decoration: underline;
    margin-left: 10px;
}

body {
    padding-top: 60px !important;
}
```

### HTML (Body):
```html
<div class="promo-banner">
    🎉 <strong>OFERTA ESPECIAL:</strong> 50% de descuento en todos los productos.
    <a href="/tienda">¡Comprar Ahora!</a>
</div>
```

---

## Aviso de Cookies (RGPD)

### CSS:
```css
.cookie-notice {
    position: fixed;
    bottom: 0;
    left: 0;
    width: 100%;
    background: #2c3e50;
    color: white;
    padding: 20px;
    z-index: 9999;
    display: flex;
    justify-content: space-between;
    align-items: center;
    box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.2);
}

.cookie-notice.hidden {
    display: none;
}

.cookie-notice button {
    background: #27ae60;
    color: white;
    border: none;
    padding: 10px 30px;
    border-radius: 5px;
    cursor: pointer;
    font-weight: bold;
}

.cookie-notice button:hover {
    background: #229954;
}
```

### JavaScript:
```javascript
if (!localStorage.getItem('cookies-accepted')) {
    var cookieNotice = document.createElement('div');
    cookieNotice.className = 'cookie-notice';
    cookieNotice.innerHTML = `
        <p>🍪 Utilizamos cookies para mejorar tu experiencia. Al continuar navegando, aceptas nuestra política de cookies.</p>
        <button onclick="acceptCookies()">Aceptar</button>
    `;
    document.body.appendChild(cookieNotice);
}

function acceptCookies() {
    localStorage.setItem('cookies-accepted', 'true');
    document.querySelector('.cookie-notice').classList.add('hidden');
}
```

---

# 🖱️ EFECTOS DE CURSOR {#efectos-cursor}

## Cursor Personalizado

### CSS:
```css
body {
    cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"><circle cx="10" cy="10" r="8" fill="rgba(255,0,0,0.5)"/></svg>'), auto;
}

a, button {
    cursor: url('data:image/svg+xml;utf8,<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"><circle cx="12" cy="12" r="10" fill="rgba(0,255,0,0.5)"/></svg>'), pointer;
}
```

---

## Círculo Siguiendo el Cursor

### CSS:
```css
.cursor-follower {
    position: fixed;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    background: rgba(99, 102, 241, 0.5);
    pointer-events: none;
    z-index: 9999;
    transition: transform 0.1s ease;
}
```

### JavaScript:
```javascript
var follower = document.createElement('div');
follower.className = 'cursor-follower';
document.body.appendChild(follower);

document.addEventListener('mousemove', function(e) {
    follower.style.left = (e.pageX - 10) + 'px';
    follower.style.top = (e.pageY - 10) + 'px';
});
```

---

# 🎯 COMBINACIONES RECOMENDADAS

## Combo 1: Sitio Festivo
- Lluvia de corazones
- Barra arcoíris superior
- Confeti al hacer clic

## Combo 2: Sitio Profesional
- Google Analytics
- Chat de WhatsApp
- Aviso de cookies
- Ajustes de diseño (sombras modernas)

## Combo 3: Sitio Creativo
- Fondo degradado animado
- Cursor personalizado
- Texto arcoíris
- Partículas flotantes

## Combo 4: Sitio de E-commerce
- Facebook Pixel
- Banner de promoción
- Chat en vivo (Tawk.to)
- WhatsApp flotante

---

# 💡 TIPS IMPORTANTES

1. **No combines demasiados efectos** - Puede hacer que el sitio sea lento
2. **Prueba en móvil** - Algunos efectos no funcionan bien en dispositivos táctiles
3. **Usa !important con cuidado** - Solo cuando sea necesario para sobrescribir estilos del tema
4. **Guarda copias** - Antes de hacer cambios grandes, guarda el código anterior
5. **Comprueba la velocidad** - Usa herramientas como PageSpeed Insights después de añadir efectos

---

**¡Experimenta y crea combinaciones únicas!** 🚀
