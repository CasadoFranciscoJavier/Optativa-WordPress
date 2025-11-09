# 🚀 PORTFOLIO PROFESIONAL - JAVI CASADO (VERSIÓN FINAL)

Portfolio moderno y profesional para Javi Casado, desarrollador web.

**PROBLEMA SOLUCIONADO:** Las secciones ahora son visibles desde el inicio.

---

## 📄 CÓDIGO EN EL `<head>`

```html
<meta name="description" content="Javi Casado - Desarrollador Web Full Stack especializado en WordPress, PHP, JavaScript y soluciones web innovadoras.">
<meta name="keywords" content="desarrollador web, programador, WordPress, PHP, JavaScript, frontend, backend">
<meta name="author" content="Javi Casado">
<meta property="og:title" content="Javi Casado - Desarrollador Web">
<meta property="og:description" content="Portfolio profesional de Javi Casado">
<meta property="og:type" content="website">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;900&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">

<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
```

---

## 🎨 CSS PERSONALIZADO

```css
/* ==================== OCULTAR TODO WORDPRESS ==================== */
body > *:not(#portfolio-wrapper) {
    display: none !important;
}

body {
    margin: 0 !important;
    padding: 0 !important;
}

#portfolio-wrapper {
    display: block !important;
}

/* ==================== RESET Y BASE ==================== */
#portfolio-wrapper * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

:root {
    --primary-color: #6366f1;
    --secondary-color: #8b5cf6;
    --accent-color: #ec4899;
    --dark-bg: #0f172a;
    --dark-card: #1e293b;
    --text-primary: #f8fafc;
    --text-secondary: #cbd5e1;
    --gradient-1: linear-gradient(135deg, #6366f1 0%, #8b5cf6 50%, #ec4899 100%);
    --gradient-2: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
}

#portfolio-wrapper {
    font-family: 'Poppins', sans-serif;
    background: var(--dark-bg);
    color: var(--text-primary);
    overflow-x: hidden;
    min-height: 100vh;
}

/* ==================== PARTICLES BACKGROUND ==================== */
#particles-js {
    position: fixed;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    z-index: -1;
    background: var(--dark-bg);
}

/* ==================== NAVIGATION ==================== */
.portfolio-nav {
    position: fixed;
    top: 0;
    width: 100%;
    background: rgba(15, 23, 42, 0.95);
    backdrop-filter: blur(10px);
    padding: 20px 0;
    z-index: 1000;
    box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
    transition: all 0.3s ease;
}

.portfolio-nav.scrolled {
    padding: 15px 0;
    background: rgba(15, 23, 42, 0.98);
}

.portfolio-nav .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.portfolio-logo {
    font-size: 24px;
    font-weight: 700;
    background: var(--gradient-1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.portfolio-nav ul {
    display: flex;
    list-style: none;
    gap: 30px;
    margin: 0;
    padding: 0;
}

.portfolio-nav li {
    margin: 0;
    padding: 0;
}

.portfolio-nav a {
    color: var(--text-secondary);
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    position: relative;
}

.portfolio-nav a:hover {
    color: var(--primary-color);
}

.portfolio-nav a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: var(--gradient-1);
    transition: width 0.3s ease;
}

.portfolio-nav a:hover::after {
    width: 100%;
}

/* ==================== HERO SECTION ==================== */
.portfolio-hero {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    text-align: center;
    padding: 100px 20px 50px;
    position: relative;
}

.portfolio-hero-content h1 {
    font-size: 72px;
    font-weight: 900;
    margin-bottom: 20px;
    background: var(--gradient-1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: fadeInUp 1s ease;
}

.portfolio-hero-content .subtitle {
    font-size: 28px;
    color: var(--text-secondary);
    margin-bottom: 15px;
    font-weight: 300;
    animation: fadeInUp 1.2s ease;
}

.portfolio-hero-content .description {
    font-size: 18px;
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto 40px;
    line-height: 1.6;
    animation: fadeInUp 1.4s ease;
}

.portfolio-cta {
    display: flex;
    gap: 20px;
    justify-content: center;
    animation: fadeInUp 1.6s ease;
}

.portfolio-btn {
    padding: 15px 40px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    display: inline-block;
    position: relative;
    overflow: hidden;
}

.portfolio-btn-primary {
    background: var(--gradient-1);
    color: white;
    box-shadow: 0 10px 40px rgba(99, 102, 241, 0.4);
}

.portfolio-btn-primary:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 50px rgba(99, 102, 241, 0.6);
}

.portfolio-btn-secondary {
    background: transparent;
    color: var(--text-primary);
    border: 2px solid var(--primary-color);
}

.portfolio-btn-secondary:hover {
    background: var(--primary-color);
    transform: translateY(-3px);
}

.portfolio-social {
    margin-top: 40px;
    display: flex;
    gap: 20px;
    justify-content: center;
    animation: fadeInUp 1.8s ease;
}

.portfolio-social a {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--dark-card);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-primary);
    font-size: 20px;
    transition: all 0.3s ease;
    text-decoration: none;
}

.portfolio-social a:hover {
    background: var(--gradient-1);
    transform: translateY(-5px) rotate(360deg);
}

/* ==================== SECTIONS ==================== */
.portfolio-section {
    padding: 100px 20px;
    max-width: 1200px;
    margin: 0 auto;
    opacity: 1 !important;
    transform: none !important;
}

.portfolio-section-title {
    font-size: 48px;
    font-weight: 700;
    text-align: center;
    margin-bottom: 60px;
    position: relative;
}

.portfolio-section-title::after {
    content: '';
    display: block;
    width: 100px;
    height: 4px;
    background: var(--gradient-1);
    margin: 20px auto 0;
    border-radius: 2px;
}

/* ==================== ABOUT SECTION ==================== */
.portfolio-about-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 60px;
    align-items: center;
}

.portfolio-about-text h3 {
    font-size: 32px;
    margin-bottom: 20px;
    color: var(--primary-color);
}

.portfolio-about-text p {
    color: var(--text-secondary);
    line-height: 1.8;
    margin-bottom: 15px;
    font-size: 16px;
}

.portfolio-stats {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 30px;
    margin-top: 40px;
}

.portfolio-stat-item {
    background: var(--dark-card);
    padding: 30px;
    border-radius: 15px;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(99, 102, 241, 0.2);
}

.portfolio-stat-item:hover {
    transform: translateY(-5px);
    border-color: var(--primary-color);
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
}

.portfolio-stat-number {
    font-size: 48px;
    font-weight: 700;
    background: var(--gradient-1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.portfolio-stat-label {
    color: var(--text-secondary);
    margin-top: 10px;
}

/* ==================== SKILLS SECTION ==================== */
.portfolio-skills-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
}

.portfolio-skill-card {
    background: var(--dark-card);
    padding: 40px 30px;
    border-radius: 15px;
    text-align: center;
    transition: all 0.3s ease;
    border: 1px solid rgba(99, 102, 241, 0.2);
    position: relative;
    overflow: hidden;
}

.portfolio-skill-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: var(--gradient-1);
    opacity: 0.1;
    transition: all 0.5s ease;
}

.portfolio-skill-card:hover::before {
    left: 0;
}

.portfolio-skill-card:hover {
    transform: translateY(-10px);
    border-color: var(--primary-color);
    box-shadow: 0 15px 40px rgba(99, 102, 241, 0.4);
}

.portfolio-skill-icon {
    font-size: 48px;
    margin-bottom: 20px;
    background: var(--gradient-1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.portfolio-skill-card h3 {
    font-size: 24px;
    margin-bottom: 15px;
}

.portfolio-skill-card p {
    color: var(--text-secondary);
    font-size: 14px;
    line-height: 1.6;
}

/* ==================== EXPERIENCE SECTION ==================== */
.portfolio-timeline {
    position: relative;
    padding: 20px 0;
}

.portfolio-timeline::before {
    content: '';
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 2px;
    height: 100%;
    background: var(--gradient-1);
}

.portfolio-timeline-item {
    margin-bottom: 50px;
    position: relative;
}

.portfolio-timeline-item:nth-child(odd) .portfolio-timeline-content {
    margin-left: auto;
}

.portfolio-timeline-content {
    width: 45%;
    background: var(--dark-card);
    padding: 30px;
    border-radius: 15px;
    border: 1px solid rgba(99, 102, 241, 0.2);
    position: relative;
    transition: all 0.3s ease;
}

.portfolio-timeline-content:hover {
    transform: translateY(-5px);
    border-color: var(--primary-color);
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
}

.portfolio-timeline-date {
    display: inline-block;
    padding: 8px 20px;
    background: var(--gradient-1);
    color: white;
    border-radius: 20px;
    font-size: 14px;
    font-weight: 600;
    margin-bottom: 15px;
}

.portfolio-timeline-content h3 {
    font-size: 24px;
    margin-bottom: 10px;
}

.portfolio-timeline-content h4 {
    color: var(--primary-color);
    margin-bottom: 15px;
    font-size: 18px;
}

.portfolio-timeline-content p {
    color: var(--text-secondary);
    line-height: 1.6;
}

.portfolio-timeline-dot {
    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    width: 20px;
    height: 20px;
    background: var(--primary-color);
    border-radius: 50%;
    border: 4px solid var(--dark-bg);
    top: 30px;
}

/* ==================== PROJECTS SECTION ==================== */
.portfolio-projects-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 30px;
}

.portfolio-project-card {
    background: var(--dark-card);
    border-radius: 15px;
    overflow: hidden;
    transition: all 0.3s ease;
    border: 1px solid rgba(99, 102, 241, 0.2);
    position: relative;
}

.portfolio-project-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 50px rgba(99, 102, 241, 0.4);
}

.portfolio-project-image {
    width: 100%;
    height: 250px;
    background: var(--gradient-1);
    position: relative;
    overflow: hidden;
}

.portfolio-project-overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 20px;
    opacity: 0;
    transition: all 0.3s ease;
}

.portfolio-project-card:hover .portfolio-project-overlay {
    opacity: 1;
}

.portfolio-project-overlay a {
    width: 50px;
    height: 50px;
    background: white;
    color: var(--dark-bg);
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    text-decoration: none;
    transition: all 0.3s ease;
}

.portfolio-project-overlay a:hover {
    transform: scale(1.2);
    background: var(--primary-color);
    color: white;
}

.portfolio-project-info {
    padding: 30px;
}

.portfolio-project-info h3 {
    font-size: 24px;
    margin-bottom: 15px;
}

.portfolio-project-info p {
    color: var(--text-secondary);
    line-height: 1.6;
    margin-bottom: 20px;
}

.portfolio-project-tags {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.portfolio-project-tag {
    padding: 5px 15px;
    background: rgba(99, 102, 241, 0.2);
    color: var(--primary-color);
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

/* ==================== CONTACT SECTION ==================== */
.portfolio-contact-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.portfolio-contact-content p {
    color: var(--text-secondary);
    font-size: 18px;
    margin-bottom: 40px;
    line-height: 1.8;
}

.portfolio-contact-methods {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 30px;
    margin-bottom: 40px;
}

.portfolio-contact-method {
    background: var(--dark-card);
    padding: 40px 30px;
    border-radius: 15px;
    transition: all 0.3s ease;
    border: 1px solid rgba(99, 102, 241, 0.2);
}

.portfolio-contact-method:hover {
    transform: translateY(-5px);
    border-color: var(--primary-color);
    box-shadow: 0 10px 30px rgba(99, 102, 241, 0.3);
}

.portfolio-contact-method i {
    font-size: 40px;
    background: var(--gradient-1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
}

.portfolio-contact-method h3 {
    font-size: 20px;
    margin-bottom: 10px;
}

.portfolio-contact-method a {
    color: var(--text-secondary);
    text-decoration: none;
    transition: all 0.3s ease;
}

.portfolio-contact-method a:hover {
    color: var(--primary-color);
}

/* ==================== FOOTER ==================== */
.portfolio-footer {
    background: var(--dark-card);
    padding: 40px 20px;
    text-align: center;
    border-top: 1px solid rgba(99, 102, 241, 0.2);
}

.portfolio-footer p {
    color: var(--text-secondary);
    margin-bottom: 20px;
}

.portfolio-footer-social {
    display: flex;
    gap: 15px;
    justify-content: center;
    margin-bottom: 20px;
}

.portfolio-footer-social a {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(99, 102, 241, 0.2);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-primary);
    text-decoration: none;
    transition: all 0.3s ease;
}

.portfolio-footer-social a:hover {
    background: var(--gradient-1);
    transform: translateY(-3px);
}

/* ==================== ANIMATIONS ==================== */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-20px);
    }
}

/* ==================== RESPONSIVE ==================== */
@media (max-width: 768px) {
    .portfolio-hero-content h1 {
        font-size: 48px;
    }

    .portfolio-hero-content .subtitle {
        font-size: 20px;
    }

    .portfolio-about-content {
        grid-template-columns: 1fr;
    }

    .portfolio-timeline::before {
        left: 0;
    }

    .portfolio-timeline-content {
        width: 100%;
        margin-left: 30px !important;
    }

    .portfolio-timeline-dot {
        left: 0;
    }

    .portfolio-nav ul {
        gap: 15px;
        font-size: 14px;
    }

    .portfolio-cta {
        flex-direction: column;
    }

    .portfolio-projects-grid {
        grid-template-columns: 1fr;
    }
}
```

---

## ⚡ JAVASCRIPT PERSONALIZADO

```javascript
// ==================== PARTICLES.JS INIT ==================== //
particlesJS('particles-js', {
    particles: {
        number: {
            value: 80,
            density: {
                enable: true,
                value_area: 800
            }
        },
        color: {
            value: '#6366f1'
        },
        shape: {
            type: 'circle'
        },
        opacity: {
            value: 0.5,
            random: false
        },
        size: {
            value: 3,
            random: true
        },
        line_linked: {
            enable: true,
            distance: 150,
            color: '#6366f1',
            opacity: 0.4,
            width: 1
        },
        move: {
            enable: true,
            speed: 2,
            direction: 'none',
            random: false,
            straight: false,
            out_mode: 'out',
            bounce: false
        }
    },
    interactivity: {
        detect_on: 'canvas',
        events: {
            onhover: {
                enable: true,
                mode: 'grab'
            },
            onclick: {
                enable: true,
                mode: 'push'
            },
            resize: true
        },
        modes: {
            grab: {
                distance: 140,
                line_linked: {
                    opacity: 1
                }
            },
            push: {
                particles_nb: 4
            }
        }
    },
    retina_detect: true
});

// ==================== SMOOTH SCROLL ==================== //
document.querySelectorAll('.portfolio-nav a[href^="#"]').forEach(function(anchor) {
    anchor.addEventListener('click', function(e) {
        e.preventDefault();
        var target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// ==================== NAVBAR SCROLL EFFECT ==================== //
window.addEventListener('scroll', function() {
    var nav = document.querySelector('.portfolio-nav');
    if (nav) {
        if (window.scrollY > 100) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }
    }
});

// ==================== TYPING EFFECT ==================== //
document.addEventListener('DOMContentLoaded', function() {
    var subtitle = document.querySelector('.portfolio-hero-content .subtitle');
    if (subtitle) {
        var text = subtitle.textContent;
        subtitle.textContent = '';
        var i = 0;

        function typeWriter() {
            if (i < text.length) {
                subtitle.textContent += text.charAt(i);
                i++;
                setTimeout(typeWriter, 100);
            }
        }

        setTimeout(typeWriter, 500);
    }
});

// ==================== STATS COUNTER ==================== //
function animateCounter(element, target, duration) {
    var start = 0;
    var increment = target / (duration / 16);

    function updateCounter() {
        start += increment;
        if (start < target) {
            element.textContent = Math.floor(start) + '+';
            requestAnimationFrame(updateCounter);
        } else {
            element.textContent = target + '+';
        }
    }

    updateCounter();
}

var statsObserver = new IntersectionObserver(function(entries) {
    entries.forEach(function(entry) {
        if (entry.isIntersecting) {
            var statNumbers = entry.target.querySelectorAll('.portfolio-stat-number');
            statNumbers.forEach(function(stat) {
                var target = parseInt(stat.getAttribute('data-target'));
                animateCounter(stat, target, 2000);
            });
            statsObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

var statsSection = document.querySelector('.portfolio-stats');
if (statsSection) {
    statsObserver.observe(statsSection);
}
```

---

## 🌐 HTML EN EL BODY

```html
<div id="portfolio-wrapper">
    <div id="particles-js"></div>

    <!-- NAVIGATION -->
    <nav class="portfolio-nav">
        <div class="container">
            <div class="portfolio-logo">&lt;JaviCasado /&gt;</div>
            <ul>
                <li><a href="#inicio">Inicio</a></li>
                <li><a href="#sobre-mi">Sobre mí</a></li>
                <li><a href="#habilidades">Habilidades</a></li>
                <li><a href="#experiencia">Experiencia</a></li>
                <li><a href="#proyectos">Proyectos</a></li>
                <li><a href="#contacto">Contacto</a></li>
            </ul>
        </div>
    </nav>

    <!-- HERO SECTION -->
    <section id="inicio" class="portfolio-hero">
        <div class="portfolio-hero-content">
            <h1>Javi Casado</h1>
            <p class="subtitle">Desarrollador Web Full Stack</p>
            <p class="description">
                Apasionado por crear experiencias web excepcionales. Especializado en WordPress, PHP, JavaScript y soluciones innovadoras que transforman ideas en realidad digital.
            </p>
            <div class="portfolio-cta">
                <a href="#proyectos" class="portfolio-btn portfolio-btn-primary">Ver Proyectos</a>
                <a href="#contacto" class="portfolio-btn portfolio-btn-secondary">Contactar</a>
            </div>
            <div class="portfolio-social">
                <a href="https://github.com/javicasado" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
                <a href="https://linkedin.com/in/javicasado" target="_blank" rel="noopener"><i class="fab fa-linkedin"></i></a>
                <a href="https://twitter.com/javicasado" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
                <a href="mailto:javi@example.com"><i class="fas fa-envelope"></i></a>
            </div>
        </div>
    </section>

    <!-- ABOUT SECTION -->
    <section id="sobre-mi" class="portfolio-section">
        <h2 class="portfolio-section-title">Sobre Mí</h2>
        <div class="portfolio-about-content">
            <div class="portfolio-about-text">
                <h3>¡Hola! Soy Javi Casado</h3>
                <p>
                    Desarrollador web con una pasión inquebrantable por la tecnología y la innovación. Mi viaje en el desarrollo web comenzó hace varios años, y desde entonces he estado dedicado a perfeccionar mis habilidades y crear soluciones digitales que marcan la diferencia.
                </p>
                <p>
                    Me especializo en desarrollo full stack, con un enfoque particular en WordPress, PHP y JavaScript. Cada proyecto es una oportunidad para aprender algo nuevo y superar los límites de lo posible.
                </p>
                <p>
                    Cuando no estoy programando, me encontrarás explorando nuevas tecnologías, contribuyendo a proyectos open source, o compartiendo conocimientos con la comunidad de desarrolladores.
                </p>
            </div>
            <div class="portfolio-stats">
                <div class="portfolio-stat-item">
                    <div class="portfolio-stat-number" data-target="50">0</div>
                    <div class="portfolio-stat-label">Proyectos Completados</div>
                </div>
                <div class="portfolio-stat-item">
                    <div class="portfolio-stat-number" data-target="30">0</div>
                    <div class="portfolio-stat-label">Clientes Satisfechos</div>
                </div>
                <div class="portfolio-stat-item">
                    <div class="portfolio-stat-number" data-target="5">0</div>
                    <div class="portfolio-stat-label">Años de Experiencia</div>
                </div>
                <div class="portfolio-stat-item">
                    <div class="portfolio-stat-number" data-target="1000">0</div>
                    <div class="portfolio-stat-label">Tazas de Café</div>
                </div>
            </div>
        </div>
    </section>

    <!-- SKILLS SECTION -->
    <section id="habilidades" class="portfolio-section">
        <h2 class="portfolio-section-title">Habilidades Técnicas</h2>
        <div class="portfolio-skills-grid">
            <div class="portfolio-skill-card">
                <div class="portfolio-skill-icon"><i class="fab fa-wordpress"></i></div>
                <h3>WordPress</h3>
                <p>Desarrollo de temas y plugins personalizados, optimización y WooCommerce</p>
            </div>
            <div class="portfolio-skill-card">
                <div class="portfolio-skill-icon"><i class="fab fa-php"></i></div>
                <h3>PHP</h3>
                <p>Desarrollo backend, APIs RESTful y arquitecturas escalables</p>
            </div>
            <div class="portfolio-skill-card">
                <div class="portfolio-skill-icon"><i class="fab fa-js"></i></div>
                <h3>JavaScript</h3>
                <p>ES6+, React, Vue.js, Node.js y desarrollo frontend moderno</p>
            </div>
            <div class="portfolio-skill-card">
                <div class="portfolio-skill-icon"><i class="fab fa-html5"></i></div>
                <h3>HTML5 & CSS3</h3>
                <p>Diseño responsive, animaciones y mejores prácticas de accesibilidad</p>
            </div>
            <div class="portfolio-skill-card">
                <div class="portfolio-skill-icon"><i class="fas fa-database"></i></div>
                <h3>Bases de Datos</h3>
                <p>MySQL, PostgreSQL y optimización de consultas</p>
            </div>
            <div class="portfolio-skill-card">
                <div class="portfolio-skill-icon"><i class="fab fa-git-alt"></i></div>
                <h3>Git & GitHub</h3>
                <p>Control de versiones, colaboración y mejores prácticas</p>
            </div>
        </div>
    </section>

    <!-- EXPERIENCE SECTION -->
    <section id="experiencia" class="portfolio-section">
        <h2 class="portfolio-section-title">Experiencia Profesional</h2>
        <div class="portfolio-timeline">
            <div class="portfolio-timeline-item">
                <div class="portfolio-timeline-dot"></div>
                <div class="portfolio-timeline-content">
                    <span class="portfolio-timeline-date">2022 - Presente</span>
                    <h3>Desarrollador Web Senior</h3>
                    <h4>Freelance</h4>
                    <p>
                        Desarrollo de soluciones web personalizadas para clientes internacionales. Especialización en WordPress, e-commerce y aplicaciones web complejas.
                    </p>
                </div>
            </div>

            <div class="portfolio-timeline-item">
                <div class="portfolio-timeline-dot"></div>
                <div class="portfolio-timeline-content">
                    <span class="portfolio-timeline-date">2020 - 2022</span>
                    <h3>Desarrollador Full Stack</h3>
                    <h4>Tech Solutions Inc.</h4>
                    <p>
                        Desarrollo de aplicaciones web escalables utilizando PHP, JavaScript y MySQL. Implementación de sistemas de gestión y optimización de rendimiento.
                    </p>
                </div>
            </div>

            <div class="portfolio-timeline-item">
                <div class="portfolio-timeline-dot"></div>
                <div class="portfolio-timeline-content">
                    <span class="portfolio-timeline-date">2019 - 2020</span>
                    <h3>Desarrollador WordPress</h3>
                    <h4>Digital Agency</h4>
                    <p>
                        Creación de temas y plugins personalizados para WordPress. Mantenimiento y optimización de sitios web corporativos.
                    </p>
                </div>
            </div>

            <div class="portfolio-timeline-item">
                <div class="portfolio-timeline-dot"></div>
                <div class="portfolio-timeline-content">
                    <span class="portfolio-timeline-date">2018 - 2019</span>
                    <h3>Desarrollador Junior</h3>
                    <h4>StartUp Web</h4>
                    <p>
                        Inicio en el desarrollo web profesional. Aprendizaje de mejores prácticas y trabajo en equipo en proyectos diversos.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- PROJECTS SECTION -->
    <section id="proyectos" class="portfolio-section">
        <h2 class="portfolio-section-title">Proyectos Destacados</h2>
        <div class="portfolio-projects-grid">
            <div class="portfolio-project-card">
                <div class="portfolio-project-image">
                    <div class="portfolio-project-overlay">
                        <a href="#" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i></a>
                        <a href="#" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="portfolio-project-info">
                    <h3>E-Commerce Innovador</h3>
                    <p>Plataforma de comercio electrónico completa con sistema de pagos integrado, gestión de inventario y panel de administración avanzado.</p>
                    <div class="portfolio-project-tags">
                        <span class="portfolio-project-tag">WordPress</span>
                        <span class="portfolio-project-tag">WooCommerce</span>
                        <span class="portfolio-project-tag">PHP</span>
                    </div>
                </div>
            </div>

            <div class="portfolio-project-card">
                <div class="portfolio-project-image">
                    <div class="portfolio-project-overlay">
                        <a href="#" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i></a>
                        <a href="#" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="portfolio-project-info">
                    <h3>Sistema de Gestión Empresarial</h3>
                    <p>Aplicación web para gestión integral de empresas: CRM, facturación, inventario y reportes en tiempo real.</p>
                    <div class="portfolio-project-tags">
                        <span class="portfolio-project-tag">PHP</span>
                        <span class="portfolio-project-tag">JavaScript</span>
                        <span class="portfolio-project-tag">MySQL</span>
                    </div>
                </div>
            </div>

            <div class="portfolio-project-card">
                <div class="portfolio-project-image">
                    <div class="portfolio-project-overlay">
                        <a href="#" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i></a>
                        <a href="#" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="portfolio-project-info">
                    <h3>Plugin WordPress Premium</h3>
                    <p>Plugin personalizado para WordPress que permite crear formularios avanzados con lógica condicional y múltiples integraciones.</p>
                    <div class="portfolio-project-tags">
                        <span class="portfolio-project-tag">WordPress</span>
                        <span class="portfolio-project-tag">PHP</span>
                        <span class="portfolio-project-tag">JavaScript</span>
                    </div>
                </div>
            </div>

            <div class="portfolio-project-card">
                <div class="portfolio-project-image">
                    <div class="portfolio-project-overlay">
                        <a href="#" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i></a>
                        <a href="#" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="portfolio-project-info">
                    <h3>Dashboard Analítico</h3>
                    <p>Panel de control con visualizaciones interactivas de datos en tiempo real para análisis de métricas empresariales.</p>
                    <div class="portfolio-project-tags">
                        <span class="portfolio-project-tag">React</span>
                        <span class="portfolio-project-tag">Node.js</span>
                        <span class="portfolio-project-tag">API REST</span>
                    </div>
                </div>
            </div>

            <div class="portfolio-project-card">
                <div class="portfolio-project-image">
                    <div class="portfolio-project-overlay">
                        <a href="#" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i></a>
                        <a href="#" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="portfolio-project-info">
                    <h3>Sitio Web Corporativo</h3>
                    <p>Diseño y desarrollo completo de sitio web corporativo multiidioma con animaciones avanzadas y optimización SEO.</p>
                    <div class="portfolio-project-tags">
                        <span class="portfolio-project-tag">WordPress</span>
                        <span class="portfolio-project-tag">CSS3</span>
                        <span class="portfolio-project-tag">SEO</span>
                    </div>
                </div>
            </div>

            <div class="portfolio-project-card">
                <div class="portfolio-project-image">
                    <div class="portfolio-project-overlay">
                        <a href="#" target="_blank" rel="noopener"><i class="fas fa-external-link-alt"></i></a>
                        <a href="#" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
                    </div>
                </div>
                <div class="portfolio-project-info">
                    <h3>API RESTful</h3>
                    <p>Desarrollo de API robusta y escalable para aplicaciones móviles con autenticación JWT y documentación completa.</p>
                    <div class="portfolio-project-tags">
                        <span class="portfolio-project-tag">PHP</span>
                        <span class="portfolio-project-tag">REST API</span>
                        <span class="portfolio-project-tag">JWT</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section id="contacto" class="portfolio-section">
        <h2 class="portfolio-section-title">Contacto</h2>
        <div class="portfolio-contact-content">
            <p>
                ¿Tienes un proyecto en mente? ¿Quieres colaborar o simplemente charlar sobre tecnología?<br>
                ¡Me encantaría escucharte! Estoy siempre abierto a nuevas oportunidades y desafíos.
            </p>

            <div class="portfolio-contact-methods">
                <div class="portfolio-contact-method">
                    <i class="fas fa-envelope"></i>
                    <h3>Email</h3>
                    <a href="mailto:javi@example.com">javi@example.com</a>
                </div>

                <div class="portfolio-contact-method">
                    <i class="fab fa-linkedin"></i>
                    <h3>LinkedIn</h3>
                    <a href="https://linkedin.com/in/javicasado" target="_blank" rel="noopener">linkedin.com/in/javicasado</a>
                </div>

                <div class="portfolio-contact-method">
                    <i class="fab fa-github"></i>
                    <h3>GitHub</h3>
                    <a href="https://github.com/javicasado" target="_blank" rel="noopener">github.com/javicasado</a>
                </div>
            </div>

            <div class="portfolio-cta">
                <a href="mailto:javi@example.com" class="portfolio-btn portfolio-btn-primary">Enviar Mensaje</a>
                <a href="#" class="portfolio-btn portfolio-btn-secondary" download>Descargar CV</a>
            </div>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="portfolio-footer">
        <p>Diseñado y desarrollado con <i class="fas fa-heart" style="color: #ec4899;"></i> por Javi Casado</p>
        <div class="portfolio-footer-social">
            <a href="https://github.com/javicasado" target="_blank" rel="noopener"><i class="fab fa-github"></i></a>
            <a href="https://linkedin.com/in/javicasado" target="_blank" rel="noopener"><i class="fab fa-linkedin"></i></a>
            <a href="https://twitter.com/javicasado" target="_blank" rel="noopener"><i class="fab fa-twitter"></i></a>
            <a href="mailto:javi@example.com"><i class="fas fa-envelope"></i></a>
        </div>
        <p style="margin-top: 20px; font-size: 14px;">&copy; 2025 Javi Casado. Todos los derechos reservados.</p>
    </footer>
</div>
```

---

## 📄 CÓDIGO EN EL FOOTER

```html
<!-- Particles.js Library -->
<script src="https://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script>
```

---

## 🔧 CAMBIO CRÍTICO

En el CSS, he cambiado esta línea:

**ANTES:**
```css
.portfolio-fade-in {
    opacity: 0;  /* ❌ Esto ocultaba las secciones */
}
```

**AHORA:**
```css
.portfolio-section {
    opacity: 1 !important;  /* ✅ Visible siempre */
    transform: none !important;
}
```

Y también eliminé la clase `.portfolio-fade-in` de todas las secciones en el HTML.

---

## ✅ RESULTADO

Ahora **TODAS las secciones** serán visibles desde el inicio:
- ✅ Sobre mí
- ✅ Habilidades
- ✅ Experiencia
- ✅ Proyectos
- ✅ Contacto

¡Prueba ahora con este código corregido!
