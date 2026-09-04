<?php require_once __DIR__ . '/layout/navbar.php'; ?>

<style>
    html {
        scroll-behavior: smooth;
    }

    @keyframes pulse {
        0% { box-shadow: 0 0 0 0 rgba(34, 197, 94, .5); }
        70% { box-shadow: 0 0 0 7px rgba(34, 197, 94, 0); }
        100% { box-shadow: 0 0 0 0 rgba(34, 197, 94, 0); }
    }

    .hero {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        padding: 20px 0;
    }

    .hero > div { flex: 1; }

    h1.headline {
        font-family: 'Space Grotesk', sans-serif;
        font-weight: 600;
        font-size: clamp(36px, 5vw, 54px);
        line-height: 1.08;
        margin: 22px 0 0;
        letter-spacing: -0.01em;
    }

    h1.headline .grad {
        background: var(--accent-grad);
        -webkit-background-clip: text;
        background-clip: text;
        color: transparent;
        display: block;
    }

    p.lede {
        color: var(--muted);
        font-size: 17px;
        line-height: 1.65;
        max-width: 440px;
        margin: 22px 0 32px;
    }

    .cta-row { display: flex; align-items: center; gap: 14px; margin-bottom: 38px; }

    .badge-stage {
        position: relative;
        display: flex; justify-content: center;
        padding-top: 0;
    }

    .lanyard-clip {
        position: absolute;
        top: 0; left: 50%; transform: translateX(-50%);
        width: 30px; height: 11px;
        background: var(--surface-2);
        border: 1px solid rgba(138, 43, 226, 0.4);
        border-radius: 4px 4px 2px 2px;
        z-index: 3;
        transition: background 0.3s, border-color 0.3s;
    }

    .badge-swing {
        margin-top: 11px;
        transform-origin: top center;
        animation: swing 5.5s cubic-bezier(.45, 0, .55, 1) infinite;
    }

    @keyframes swing {
        0% { transform: rotate(-3deg); }
        50% { transform: rotate(3.2deg); }
        100% { transform: rotate(-3deg); }
    }

    .lanyard-string {
        width: 2px; height: 38px;
        margin: 0 auto;
        background: linear-gradient(var(--dot), var(--muted-2));
    }

    .badge-card {
        width: 270px;
        background: var(--surface, #ffffff);
        border: 2px solid rgba(0, 0, 0, 0.4); 
        border-radius: 20px;
        padding: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12),
                    0 0 20px rgba(138, 43, 226, 0.25),
                    0 0 35px rgba(0, 191, 255, 0.2);
        transition: background 0.3s, border-color 0.3s, box-shadow 0.3s;
    }

    .badge-card:hover {
        border-color: rgba(138, 43, 226, 0.8);
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15),
                    0 0 25px rgba(138, 43, 226, 0.4),
                    0 0 45px rgba(0, 191, 255, 0.35);
    }

    .badge-photo {
        width: 100%;
        height: 150px;
        border-radius: 13px;
        background: radial-gradient(120% 100% at 20% 0%, rgba(255, 255, 255, .25), transparent 55%), var(--accent-grad);
        margin-bottom: 14px;
        position: relative;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .badge-photo::after {
        content: "";
        position: absolute; 
        inset: 0;
        background: repeating-linear-gradient(115deg, rgba(255, 255, 255, .10) 0 2px, transparent 2px 14px);
    }

    .badge-avatar{
        width: 90px;
        height: 90px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #635f5f;
        box-shadow: 0 4px 12px rgba(0, 0, 0, .25);
        position: relative;
        z-index: 1;
    }
    .badge-avatar img{
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .badge-name { font-family: 'Space Grotesk', sans-serif; font-weight: 600; font-size: 17px; }
    .badge-role { color: var(--accent-a); font-size: 12.5px; margin-top: 2px; font-weight: 500; }

    .badge-grid {
        display: grid; grid-template-columns: 1fr 1fr; gap: 10px;
        margin-top: 16px; padding-top: 14px;
        border-top: 1px dashed var(--line);
    }
    .badge-field .label { font-size: 10.5px; color: var(--muted-2); margin-bottom: 3px; }
    .badge-field .value { font-size: 12.5px; color: var(--text); font-weight: 500; }
    .badge-field .value.ok { color: var(--good); }

    .badge-bars { display: flex; align-items: flex-end; gap: 3px; height: 26px; margin-top: 14px; }
    .badge-bars span {
        flex: 1; background: var(--accent-a); opacity: .5; border-radius: 2px;
        animation: bar 2.4s ease-in-out infinite;
    }
    .badge-bars span:nth-child(odd) { animation-delay: .3s; }
    
    @keyframes bar {
        0%, 100% { transform: scaleY(.4); }
        50% { transform: scaleY(1); }
    }
    .badge-bars span:nth-child(1) { height: 40%; }
    .badge-bars span:nth-child(2) { height: 70%; }
    .badge-bars span:nth-child(3) { height: 55%; }
    .badge-bars span:nth-child(4) { height: 90%; }
    .badge-bars span:nth-child(5) { height: 65%; }
    .badge-bars span:nth-child(6) { height: 80%; }
    .badge-bars span:nth-child(7) { height: 50%; }
    .badge-bars span:nth-child(8) { height: 75%; }


    .section-title {
        font-size: 2rem;
        text-align: center;
        margin-top: 60px;
        margin-bottom: 8px;
        color: #171717;
    }

    .section-subtitle {
        text-align: center;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 40px;
        font-size: 0.95rem;
    }

    .skills-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
        gap: 20px;
        padding: 10px 0;
    }

    .skill-card {
        background: rgba(255, 255, 255, 0.03);
        border: 1px solid rgba(138, 43, 226, 0.25);
        border-radius: 16px;
        padding: 24px 16px;
        text-align: center;
        transition: all 0.3s ease;
        backdrop-filter: blur(8px);
    }

    .skill-card:hover {
        transform: translateY(-5px);
        border-color: rgba(138, 43, 226, 0.7);
        box-shadow: 0 10px 25px rgba(138, 43, 226, 0.25),
                    0 0 15px rgba(0, 191, 255, 0.2);
        background: rgba(255, 255, 255, 0.06);
    }

    .skill-icon {
        font-size: 2.2rem;
        margin-bottom: 12px;
    }

    .skill-card h3 {
        font-size: 1rem;
        color: #151414;
        font-weight: 500;
    }

.contact-section {
    max-width: 1000px;
    margin: 0 auto;
    padding: 60px 20px;
}

.contact-header {
    text-align: center;
    margin-bottom: 48px;
}

.section-title {
    font-size: 2.2rem;
    margin-bottom: 12px;
    color: var(--text);
}

.section-subtitle {
    color: var(--muted);
    font-size: 1rem;
    max-width: 600px;
    margin: 0 auto;
}

.contact-grid {
    display: grid;
    grid-template-columns: 1fr 1fr; /* Divide en dos mitades iguales para Pc */
    gap: 48px; 
    align-items: start;
}

.contact-redes h3 {
    font-size: 1.4rem;
    margin-top: 0;
    margin-bottom: 8px;
    color: var(--text);
}

.redes-desc {
    color: var(--muted);
    margin-bottom: 24px;
    font-size: 0.95rem;
}

.social-links {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.social-card {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px 20px;
    background-color: var(--surface-2);
    border: 1px solid var(--line);
    border-radius: 12px;
    text-decoration: none;
    color: var(--text);
    transition: transform 0.2s ease, border-color 0.2s ease;
}

.social-card:hover {
    transform: translateY(-3px);
    border-color: var(--accent-a);
}

.social-icon.github { color: #00bcd4; }
.social-icon.linkedin { color: #0077b5; }

.social-text {
    display: flex;
    flex-direction: column;
}

.social-text strong {
    font-size: 1.05rem;
    font-weight: 600;
}

.social-text span {
    font-size: 0.85rem;
    color: var(--muted);
}


.contact-formulario {
    background-color: var(--surface);
    padding: 32px;
    border-radius: 16px;
    border: 1px solid black;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.05);
}

.input-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 20px;
}

.input-group label {
    font-size: 0.9rem;
    font-weight: 600;
    color: var(--text);
}

.input-group input,
.input-group textarea {
    width: 100%;
    padding: 14px 16px;
    border-radius: 10px;
    border: 1px solid var(--line);
    background-color: var(--surface-2); 
    color: var(--text);
    font-size: 0.95rem;
    font-family: inherit;
    outline: none;
    transition: all 0.2s ease;
}

.input-group input:focus,
.input-group textarea:focus {
    border-color: var(--accent-a);
    background-color: var(--surface);
    box-shadow: 0 0 0 3px rgba(124, 108, 246, 0.15);
}

/* --- RESPONSIVE: ADAPTACIÓN A CELULARES --- */
@media (max-width: 768px) {
    .contact-grid {
        grid-template-columns: 1fr; /* Apila redes arriba y formulario abajo */
        gap: 32px;
    }

    .contact-formulario {
        padding: 24px; /* reduccion de tamaño */
    }
}
.btn-submit {
    position: relative;
    z-index: 0;
    padding: 16px 45px;
    border: 0;
    border-radius: 12px;
    background: #090b10;
    color: #fff;
    overflow: hidden; 
    cursor: pointer;}

.btn-submit::before {
    content: "";
    position: absolute;
    z-index: -2;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: conic-gradient(
        from 0deg,
        transparent 0%,
        #00eaff 15%,
        transparent 30%
    );
    animation: electric-spin 3.5s linear infinite;
    pointer-events: none;
}

.btn-submit::after {
    content: "";
    position: absolute;
    z-index: -1;
    inset: 3px;
    background: #090b10;
    border-radius: 9px;
    pointer-events: none;
}

@keyframes electric-spin {
    to {
        transform: rotate(360deg);
    }
}
  

    @media (max-width: 900px) {
        .hero {
            flex-direction: column;
            text-align: center;
            gap: 30px;
        }
        
        .p.lede {
            margin-left: auto;
            margin-right: auto;
        }
        
        .cta-row {
            justify-content: center;
        }
        
        .main-glass-container {
            padding: 0 20px;
            margin-top: 20px;
        }

        .contact-container {
            flex-direction: column;
            padding: 24px;
        }
    }
.alert-toast {
    background-color: #c5eaed;
    color: #090b10;
    font-weight: bold;
    padding: 12px 20px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
    box-shadow: 0 0 15px rgba(154, 204, 209, 0.45);
    transition: opacity 0.6s ease, transform 0.6s ease;
}

.al-oculto{
    opacity: 0;
    transform: translateY(-10px);
}
</style>

<div class="wrap">
    <main class="main-glass-container">
       
        <section class="hero" id="inicio">    
            <div>           
                <h1 class="headline">Hola, soy<span class="grad">Ana Victoria Alvarez</span></h1>      
                <p class="lede">Desarrolladora en formación, orientada al desarrollo de aplicaciones web accesibles, funcionales y eficientes. Me interesa incorporar nuevas tecnologías, aplicar buenas prácticas de programación y desarrollar soluciones mediante código limpio y mantenible. Motivada por el aprendizaje continuo y por afrontar nuevos desafíos en el ámbito IT.</p>      
                
                <div class="cta-row">             
                    <a href="#" class="btn btn-ghost">Descargar CV ↓</a>      
                </div>        
            </div>
            
            <div class="badge-stage">      
                <div class="lanyard-clip"></div>      
                <div class="badge-swing">        
                    <div class="lanyard-string"></div>        
                    <div class="badge-card">          
                        <div class="badge-photo">
                            <div class="badge-avatar">
                               <img src="Portafolio_Alvarez/img/perfil.png"  alt="Foto de Perfil">
                            </div>
                        </div>          
                        <div class="badge-name">Ana V. Alvarez Y.</div>          
                        <div class="badge-role">Programadora</div>
                        <div class="badge-grid">            
                            <div class="badge-field">              
                                <div class="label">Experiencia</div>              
                                <div class="value">1+ años</div>            
                            </div>            
                            <div class="badge-field">              
                                <div class="label">Ubicación</div>              
                                <div class="value">Salta</div>            
                            </div>                  
                            <div class="badge-field">              
                                <div class="label">Estado</div>              
                                <div class="value ok">● Activo</div>            
                            </div>          
                        </div>
                        <div class="badge-bars">            
                            <span></span><span></span><span></span><span></span>            
                            <span></span><span></span><span></span><span></span>          
                        </div>                  
                    </div>      
                </div>    
            </div>  
        </section>

        <!-- SKILLS -->
        <section id="skills" class="skills-section">
            <h2 class="section-title">Tecnologías & Skills</h2>
            <p class="section-subtitle">Herramientas y lenguajes que utilizo para desarrollar soluciones.</p>
            
            <div class="skills-grid">
                <div class="skill-card">
                   <div class="skill-icon">☕</div>
                   <h3>Java</h3>
                </div>
                <div class="skill-card">
                   <div class="skill-icon">⚡</div>
                   <h3>C</h3>
                </div>
                <div class="skill-card">
                  <div class="skill-icon">🎯</div>
                  <h3>C#</h3>
                </div>
                <div class="skill-card">
                  <div class="skill-icon">🐍</div>
                  <h3>Python</h3>
                </div>
                <div class="skill-card">
                  <div class="skill-icon">🐘</div>
                   <h3>PHP</h3>
                </div>
                <div class="skill-card">
                  <div class="skill-icon">🐬</div>
                  <h3>MySQL</h3>
                </div>
            </div> 
        </section>

        <section id="contacto" class="contact-section">

    <div class="contact-header">
        <h2 class="section-title">Contactos</h2>
        <p class="section-subtitle">Puedes encontrarme en mis plataformas profesionales o enviarme un mensaje directo.</p>
    </div>


    <div class="contact-grid">
    
        <div class="contact-redes">
            <h3>Redes & Enlaces</h3>
            <div class="social-links">
                <a href="https://www.linkedin.com/in/ana-victoria-alvarez-yapura-6240b7222" target="_blank" rel="noopener" class="social-card">
                    <div class="social-icon github">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 0C5.37 0 0 5.37 0 12c0 5.31 3.435 9.795 8.205 11.385.6.105.825-.255.825-.57 0-.285-.015-1.23-.015-2.235-3.015.555-3.795-.735-4.035-1.41-.135-.345-.72-1.41-1.23-1.695-.42-.225-1.02-.78-.015-.795.945-.015 1.62.87 1.845 1.23 1.08 1.815 2.805 1.305 3.495.99.105-.78.42-1.305.765-1.605-2.67-.3-5.46-1.335-5.46-5.925 0-1.305.465-2.385 1.23-3.225-.12-.3-.54-1.53.12-3.18 0 0 1.005-.315 3.3 1.23.96-.27 1.98-.405 3-.405s2.04.135 3 .405c2.295-1.56 3.3-1.23 3.3-1.23.66 1.65.24 2.88.12 3.18.765.84 1.23 1.905 1.23 3.225 0 4.605-2.805 5.625-5.475 5.925.435.375.81 1.095.81 2.22 0 1.605-.015 2.895-.015 3.3 0 .315.225.69.825.57A12.02 12.02 0 0024 12c0-6.63-5.37-12-12-12z"/>
                        </svg>
                    </div>
                    <div class="social-text">
                        <strong>GitHub</strong>
                        <span>Ver mis repositorios</span>
                    </div>
                </a>

                <a href="https://www.linkedin.com/in/ana-victoria-alvarez-yapura-6240b7222" target="_blank" rel="noopener" class="social-card">
                    <div class="social-icon linkedin">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/>
                        </svg>
                    </div>
                    <div class="social-text">
                        <strong>LinkedIn</strong>
                        <span>Perfil profesional</span>
                    </div>
                </a>
            </div>
        </div>
        
    
        <div class="contact-formulario">
            <?php if (isset($_GET['status']) && $_GET['status'] === 'success'): ?>
                 <div id="toast-success" class="alert-toast">
                      ¡Mensaje enviado con éxito! Nos pondremos en contacto pronto.
                 </div>
            <?php endif; ?>
            <form action="index.php?action=contacto_post" method="POST" onsubmit="POST">
                <div class="input-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" placeholder="Nombre y Apellido" required>
                </div>
                
                <div class="input-group">
                    <label for="email">Correo Electrónico</label>
                    <input type="email" id="email" name="email" placeholder="ejemplo@email.com" required>
                </div>
                
                <div class="input-group">
                    <label for="mensaje">Mensaje</label>
                    <textarea id="mensaje" name="mensaje" rows="4" placeholder="Escribe tu mensaje aquí..." required></textarea>
                </div>
                
                <button type="submit" class="btn-submit">Enviar Mensaje</button>
            </form>
        </div>

    </div>
</section>

        

    </main>
</div>
<script> //script para el envio de mensaje
    document.addEventListener("DOMContentLoaded", () => {
        const toast = document.getElementById("toast-success");
        if (toast) {
            // Espera 3.5 segundos antes de desvanecerlo
            setTimeout(() => {
                toast.classList.add("toast-oculto");
                
                setTimeout(() => {
                    toast.remove();
                }, 600);
            }, 3500);
        }
    });
</script>
</body>
</html>