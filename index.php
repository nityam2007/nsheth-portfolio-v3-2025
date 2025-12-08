<?php
/**
 * NSheth Portfolio 2026
 * Award-Style • Parallax • Scroll Effects
 */

// Load projects
$projectsJson = file_get_contents(__DIR__ . '/data/projects.json');
$projectsData = json_decode($projectsJson, true);
$projects = $projectsData['projects'] ?? [];

// Config   
$site = [
    'name' => 'Nityam Sheth',
    'title' => 'Nityam Sheth – Developer & Maker',
    'email' => 'hello@nsheth.in',
    'phone' => '+919664833459',
    'photo' => 'assets/profile.jpg',
    'year_started' => 2021,
    'linkedin' => 'https://linkedin.com/in/nityamsheth',
    'github' => 'https://github.com/nityamsheth',
    'whatsapp' => 'https://wa.me/919664833459'
];

$years = date('Y') - $site['year_started'];

// Skills
$skills = [
    'Web' => ['WordPress' => 5, 'Static Sites' => 5, 'VPS' => 5, 'Cloudflare' => 5],
    'Dev' => ['HTML/CSS' => 5, 'JavaScript' => 4, 'Git' => 5, 'SSH' => 4],
    'Automation' => ['n8n' => 5, 'APIs' => 4, 'Email' => 5, 'Bash' => 4],
    'Cloud' => ['Docker' => 5, 'Linux' => 5, 'SSL' => 5, 'Backups' => 5],
    'AI' => ['OpenAI' => 5, 'RAG' => 5, 'Embeddings' => 4, 'LLMs' => 5]
];

function stars($n) {
    return str_repeat('★', $n) . str_repeat('☆', 5 - $n);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Developer & Maker building digital experiences that work.">
    <meta property="og:title" content="<?= htmlspecialchars($site['title']) ?>">
    <meta property="og:image" content="<?= htmlspecialchars($site['photo']) ?>">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <title><?= htmlspecialchars($site['title']) ?></title>
    
    <!-- Local Fonts - GDPR Compliant -->
    <link rel="stylesheet" href="assets/css/fonts.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<!-- ========== LOADING SCREEN ========== -->
<div class="loader" id="loader">
    <div class="loader-particles" id="loaderParticles"></div>
    <div class="loader-content">
        <span class="loader-logo">NSheth</span>
        <div class="loader-bar">
            <div class="loader-progress"></div>
        </div>
    </div>
</div>

<!-- ========== HEADER ========== -->
<header class="header" id="header">
    <div class="container">
        <div class="header-inner">
            <a href="#" class="logo">NSheth</a>
            <nav class="nav-desktop">
                <a href="#work">Work</a>
                <a href="#services">Services</a>
                <a href="#about">About</a>
                <a href="#contact">Contact</a>
                <button class="theme-toggle" id="themeToggle" aria-label="Toggle theme">
                    <i class="fas fa-moon"></i>
                </button>
            </nav>
            <button class="nav-toggle" id="navToggle" aria-label="Menu">
                <span></span><span></span><span></span>
            </button>
        </div>
    </div>
    <nav class="nav-mobile" id="navMobile">
        <a href="#work">Work</a>
        <a href="#services">Services</a>
        <a href="#about">About</a>
        <a href="#contact">Contact</a>
        <button class="theme-toggle theme-toggle-mobile" id="themeToggleMobile" aria-label="Toggle theme">
            <i class="fas fa-moon"></i>
        </button>
    </nav>
</header>

<!-- ========== HERO - Clean Abstract ========== -->
<section class="hero" id="hero">
    <div class="hero-content">
        <p class="hero-intro">Developer & Maker</p>
        <h1 class="hero-title">
            <span class="line">I Build</span>
            <span class="line"><span class="highlight">Digital</span> Products</span>
            <span class="line"><span class="outline">That Work.</span></span>
        </h1>
        <p class="hero-subtitle">
            Websites, tools, and systems that help businesses 
            get online and stay online. Clean code. Fast results.
        </p>
        <div class="hero-btns">
            <a href="#work" class="btn btn-primary">View My Work</a>
            <a href="#about" class="btn btn-outline">About Me</a>
        </div>
    </div>
    
    <!-- Social Links (Left Side) -->
    <div class="hero-social">
        <a href="<?= htmlspecialchars($site['linkedin']) ?>" target="_blank" aria-label="LinkedIn">
            <i class="fab fa-linkedin-in"></i>
        </a>
        <a href="<?= htmlspecialchars($site['whatsapp']) ?>" target="_blank" aria-label="WhatsApp">
            <i class="fab fa-whatsapp"></i>
        </a>
        <a href="<?= htmlspecialchars($site['github']) ?>" target="_blank" aria-label="GitHub">
            <i class="fab fa-github"></i>
        </a>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="hero-scroll">
        <span class="hero-scroll-text">scroll down</span>
        <div class="hero-scroll-line"></div>
    </div>
    
    <!-- Name on Right Side -->
    <div class="hero-name-side">NITYAM SHETH · DEVELOPER & MAKER</div>
</section>

<!-- ========== MARQUEE 1 ========== -->
<div class="marquee">
    <div class="marquee-track">
        <div class="marquee-content">
            <span class="marquee-item">Web Development</span>
            <span class="marquee-item">Cloud Hosting</span>
            <span class="marquee-item">AI Integration</span>
            <span class="marquee-item">E-Commerce</span>
            <span class="marquee-item">WordPress</span>
            <span class="marquee-item">Automation</span>
            <span class="marquee-item">VPS Setup</span>
            <span class="marquee-item">API Development</span>
        </div>
        <div class="marquee-content">
            <span class="marquee-item">Web Development</span>
            <span class="marquee-item">Cloud Hosting</span>
            <span class="marquee-item">AI Integration</span>
            <span class="marquee-item">E-Commerce</span>
            <span class="marquee-item">WordPress</span>
            <span class="marquee-item">Automation</span>
            <span class="marquee-item">VPS Setup</span>
            <span class="marquee-item">API Development</span>
        </div>
    </div>
</div>

<!-- ========== INTRO SECTION ========== -->
<section class="intro" id="intro">
    <div class="container">
        <div class="intro-content reveal-scale">
            <p class="intro-text">
                I'm <?= htmlspecialchars($site['name']) ?> — a <span class="highlight">Full Stack Developer</span> 
                crafting fast, scalable, and immersive digital experiences that 
                merge creativity with engineering precision.
            </p>
            <p class="intro-desc">
                I specialize in developing web platforms, AI-driven products, and 
                automated systems using modern technologies and clean code practices.
            </p>
            <a href="#about" class="intro-btn">
                About Me
                <span class="arrow"><i class="fas fa-arrow-right"></i></span>
            </a>
        </div>
    </div>
</section>

<!-- ========== MARQUEE 2 (Reverse) ========== -->
<div class="marquee alt reverse">
    <div class="marquee-track">
        <div class="marquee-content">
            <span class="marquee-item">Docker</span>
            <span class="marquee-item">Linux</span>
            <span class="marquee-item">OpenAI</span>
            <span class="marquee-item">n8n</span>
            <span class="marquee-item">Cloudflare</span>
            <span class="marquee-item">JavaScript</span>
            <span class="marquee-item">Git</span>
            <span class="marquee-item">RAG Systems</span>
        </div>
        <div class="marquee-content">
            <span class="marquee-item">Docker</span>
            <span class="marquee-item">Linux</span>
            <span class="marquee-item">OpenAI</span>
            <span class="marquee-item">n8n</span>
            <span class="marquee-item">Cloudflare</span>
            <span class="marquee-item">JavaScript</span>
            <span class="marquee-item">Git</span>
            <span class="marquee-item">RAG Systems</span>
        </div>
    </div>
</div>

<!-- ========== PROJECTS ========== -->
<section class="section" id="work">
    <div class="container-wide">
        <div class="section-header reveal">
            <span class="section-label">Selected Work</span>
            <h2 class="section-title">Projects</h2>
            <p class="section-desc">
                Real work for real clients. Built with care, shipped with purpose.
            </p>
        </div>
        
        <div class="projects-grid">
            <!-- Row 1: Featured -->
            <div class="project-row full">
                <article class="project-card ratio-21-9 reveal-scale" 
                         data-title="<?= htmlspecialchars($projects[0]['title'] ?? '') ?>"
                         data-image="<?= htmlspecialchars($projects[0]['image'] ?? '') ?>"
                         data-desc="<?= htmlspecialchars($projects[0]['description'] ?? '') ?>"
                         data-year="<?= htmlspecialchars($projects[0]['year'] ?? '') ?>"
                         data-category="<?= htmlspecialchars($projects[0]['category'] ?? '') ?>">
                    <div class="project-thumb">
                        <img src="<?= htmlspecialchars($projects[0]['image'] ?? '') ?>" 
                             alt="<?= htmlspecialchars($projects[0]['title'] ?? '') ?>" loading="lazy">
                    </div>
                    <div class="project-overlay">
                        <div class="project-info">
                            <h4><?= htmlspecialchars($projects[0]['title'] ?? '') ?></h4>
                            <div class="project-meta">
                                <span class="project-year"><?= htmlspecialchars($projects[0]['year'] ?? '') ?></span>
                                <span class="project-tag"><?= htmlspecialchars($projects[0]['category'] ?? '') ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="project-view"><i class="fas fa-expand"></i></div>
                </article>
            </div>
            
            <!-- Row 2: Two columns -->
            <div class="project-row half">
                <?php for ($i = 1; $i <= 2; $i++): if (isset($projects[$i])): ?>
                <article class="project-card ratio-16-9 reveal"
                         data-title="<?= htmlspecialchars($projects[$i]['title']) ?>"
                         data-image="<?= htmlspecialchars($projects[$i]['image']) ?>"
                         data-desc="<?= htmlspecialchars($projects[$i]['description']) ?>"
                         data-year="<?= htmlspecialchars($projects[$i]['year']) ?>"
                         data-category="<?= htmlspecialchars($projects[$i]['category']) ?>">
                    <div class="project-thumb">
                        <img src="<?= htmlspecialchars($projects[$i]['image']) ?>" 
                             alt="<?= htmlspecialchars($projects[$i]['title']) ?>" loading="lazy">
                    </div>
                    <div class="project-overlay">
                        <div class="project-info">
                            <h4><?= htmlspecialchars($projects[$i]['title']) ?></h4>
                            <div class="project-meta">
                                <span class="project-year"><?= htmlspecialchars($projects[$i]['year']) ?></span>
                                <span class="project-tag"><?= htmlspecialchars($projects[$i]['category']) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="project-view"><i class="fas fa-expand"></i></div>
                </article>
                <?php endif; endfor; ?>
            </div>
            
            <!-- Row 3: Wide + Narrow -->
            <div class="project-row wide-narrow">
                <?php if (isset($projects[3])): ?>
                <article class="project-card ratio-16-9 reveal-left"
                         data-title="<?= htmlspecialchars($projects[3]['title']) ?>"
                         data-image="<?= htmlspecialchars($projects[3]['image']) ?>"
                         data-desc="<?= htmlspecialchars($projects[3]['description']) ?>"
                         data-year="<?= htmlspecialchars($projects[3]['year']) ?>"
                         data-category="<?= htmlspecialchars($projects[3]['category']) ?>">
                    <div class="project-thumb">
                        <img src="<?= htmlspecialchars($projects[3]['image']) ?>" 
                             alt="<?= htmlspecialchars($projects[3]['title']) ?>" loading="lazy">
                    </div>
                    <div class="project-overlay">
                        <div class="project-info">
                            <h4><?= htmlspecialchars($projects[3]['title']) ?></h4>
                            <div class="project-meta">
                                <span class="project-year"><?= htmlspecialchars($projects[3]['year']) ?></span>
                                <span class="project-tag"><?= htmlspecialchars($projects[3]['category']) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="project-view"><i class="fas fa-expand"></i></div>
                </article>
                <?php endif; ?>
                <?php if (isset($projects[4])): ?>
                <article class="project-card ratio-4-3 reveal-right"
                         data-title="<?= htmlspecialchars($projects[4]['title']) ?>"
                         data-image="<?= htmlspecialchars($projects[4]['image']) ?>"
                         data-desc="<?= htmlspecialchars($projects[4]['description']) ?>"
                         data-year="<?= htmlspecialchars($projects[4]['year']) ?>"
                         data-category="<?= htmlspecialchars($projects[4]['category']) ?>">
                    <div class="project-thumb">
                        <img src="<?= htmlspecialchars($projects[4]['image']) ?>" 
                             alt="<?= htmlspecialchars($projects[4]['title']) ?>" loading="lazy">
                    </div>
                    <div class="project-overlay">
                        <div class="project-info">
                            <h4><?= htmlspecialchars($projects[4]['title']) ?></h4>
                            <div class="project-meta">
                                <span class="project-year"><?= htmlspecialchars($projects[4]['year']) ?></span>
                                <span class="project-tag"><?= htmlspecialchars($projects[4]['category']) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="project-view"><i class="fas fa-expand"></i></div>
                </article>
                <?php endif; ?>
            </div>
            
            <!-- Row 4: Three columns -->
            <div class="project-row thirds">
                <?php for ($i = 5; $i <= 7; $i++): if (isset($projects[$i])): ?>
                <article class="project-card ratio-16-9 reveal"
                         data-title="<?= htmlspecialchars($projects[$i]['title']) ?>"
                         data-image="<?= htmlspecialchars($projects[$i]['image']) ?>"
                         data-desc="<?= htmlspecialchars($projects[$i]['description']) ?>"
                         data-year="<?= htmlspecialchars($projects[$i]['year']) ?>"
                         data-category="<?= htmlspecialchars($projects[$i]['category']) ?>">
                    <div class="project-thumb">
                        <img src="<?= htmlspecialchars($projects[$i]['image']) ?>" 
                             alt="<?= htmlspecialchars($projects[$i]['title']) ?>" loading="lazy">
                    </div>
                    <div class="project-overlay">
                        <div class="project-info">
                            <h4><?= htmlspecialchars($projects[$i]['title']) ?></h4>
                            <div class="project-meta">
                                <span class="project-year"><?= htmlspecialchars($projects[$i]['year']) ?></span>
                                <span class="project-tag"><?= htmlspecialchars($projects[$i]['category']) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="project-view"><i class="fas fa-expand"></i></div>
                </article>
                <?php endif; endfor; ?>
            </div>
            
            <!-- Row 5: Narrow + Wide -->
            <div class="project-row narrow-wide">
                <?php if (isset($projects[8])): ?>
                <article class="project-card ratio-4-3 reveal-left"
                         data-title="<?= htmlspecialchars($projects[8]['title']) ?>"
                         data-image="<?= htmlspecialchars($projects[8]['image']) ?>"
                         data-desc="<?= htmlspecialchars($projects[8]['description']) ?>"
                         data-year="<?= htmlspecialchars($projects[8]['year']) ?>"
                         data-category="<?= htmlspecialchars($projects[8]['category']) ?>">
                    <div class="project-thumb">
                        <img src="<?= htmlspecialchars($projects[8]['image']) ?>" 
                             alt="<?= htmlspecialchars($projects[8]['title']) ?>" loading="lazy">
                    </div>
                    <div class="project-overlay">
                        <div class="project-info">
                            <h4><?= htmlspecialchars($projects[8]['title']) ?></h4>
                            <div class="project-meta">
                                <span class="project-year"><?= htmlspecialchars($projects[8]['year']) ?></span>
                                <span class="project-tag"><?= htmlspecialchars($projects[8]['category']) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="project-view"><i class="fas fa-expand"></i></div>
                </article>
                <?php endif; ?>
                <?php if (isset($projects[9])): ?>
                <article class="project-card ratio-16-9 reveal-right"
                         data-title="<?= htmlspecialchars($projects[9]['title']) ?>"
                         data-image="<?= htmlspecialchars($projects[9]['image']) ?>"
                         data-desc="<?= htmlspecialchars($projects[9]['description']) ?>"
                         data-year="<?= htmlspecialchars($projects[9]['year']) ?>"
                         data-category="<?= htmlspecialchars($projects[9]['category']) ?>">
                    <div class="project-thumb">
                        <img src="<?= htmlspecialchars($projects[9]['image']) ?>" 
                             alt="<?= htmlspecialchars($projects[9]['title']) ?>" loading="lazy">
                    </div>
                    <div class="project-overlay">
                        <div class="project-info">
                            <h4><?= htmlspecialchars($projects[9]['title']) ?></h4>
                            <div class="project-meta">
                                <span class="project-year"><?= htmlspecialchars($projects[9]['year']) ?></span>
                                <span class="project-tag"><?= htmlspecialchars($projects[9]['category']) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="project-view"><i class="fas fa-expand"></i></div>
                </article>
                <?php endif; ?>
            </div>
            
            <!-- Row 6: Last one -->
            <?php if (isset($projects[10])): ?>
            <div class="project-row full">
                <article class="project-card ratio-21-9 reveal-scale"
                         data-title="<?= htmlspecialchars($projects[10]['title']) ?>"
                         data-image="<?= htmlspecialchars($projects[10]['image']) ?>"
                         data-desc="<?= htmlspecialchars($projects[10]['description']) ?>"
                         data-year="<?= htmlspecialchars($projects[10]['year']) ?>"
                         data-category="<?= htmlspecialchars($projects[10]['category']) ?>">
                    <div class="project-thumb">
                        <img src="<?= htmlspecialchars($projects[10]['image']) ?>" 
                             alt="<?= htmlspecialchars($projects[10]['title']) ?>" loading="lazy">
                    </div>
                    <div class="project-overlay">
                        <div class="project-info">
                            <h4><?= htmlspecialchars($projects[10]['title']) ?></h4>
                            <div class="project-meta">
                                <span class="project-year"><?= htmlspecialchars($projects[10]['year']) ?></span>
                                <span class="project-tag"><?= htmlspecialchars($projects[10]['category']) ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="project-view"><i class="fas fa-expand"></i></div>
                </article>
            </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ========== SERVICES ========== -->
<section class="services" id="services">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-label">What I Do</span>
            <h2 class="section-title">Services</h2>
        </div>
        
        <div class="services-list">
            <article class="service-item reveal-left">
                <div class="service-number">01</div>
                <div class="service-content">
                    <h3>Full Stack Development</h3>
                    <p>Building scalable web applications using modern technologies. Clean code, robust architectures, and solutions that actually work.</p>
                </div>
                <div class="service-icon-wrap">
                    <i class="fas fa-code"></i>
                </div>
            </article>
            
            <article class="service-item reveal-right">
                <div class="service-number">02</div>
                <div class="service-content">
                    <h3>Cloud & Infrastructure</h3>
                    <p>Domain setup, email config, VPS management, Docker deployments. Secure, reliable infrastructure that just works.</p>
                </div>
                <div class="service-icon-wrap">
                    <i class="fas fa-cloud"></i>
                </div>
            </article>
            
            <article class="service-item reveal-left">
                <div class="service-number">03</div>
                <div class="service-content">
                    <h3>AI & Automation</h3>
                    <p>Custom chatbots, document analysis with RAG, workflow automation. Making AI actually useful for real business problems.</p>
                </div>
                <div class="service-icon-wrap">
                    <i class="fas fa-robot"></i>
                </div>
            </article>
        </div>
    </div>
</section>

<!-- ========== ABOUT ========== -->
<section class="section" id="about">
    <div class="container">
        <div class="section-header reveal">
            <span class="section-label">About</span>
            <h2 class="section-title">A Bit About Me</h2>
        </div>
        
        <div class="about-hero">
            <div class="about-image reveal-left">
                <img src="<?= htmlspecialchars($site['photo']) ?>" alt="<?= htmlspecialchars($site['name']) ?>">
            </div>
            
            <div class="about-text reveal-right">
                <h3>Driving measurable growth and engagement through thoughtful design and engineering.</h3>
                <p>
                    Every product I build starts with understanding user goals and translating 
                    them into intuitive, high-performance experiences. From concept to launch, 
                    I focus on meaningful results—boosting user engagement, retention, and 
                    overall business impact.
                </p>
                
                <div class="about-stats">
                    <div class="about-stat">
                        <div class="about-stat-label">Years of Experience</div>
                        <div class="about-stat-value"><?= $years ?><span>+</span></div>
                    </div>
                    <div class="about-stat">
                        <div class="about-stat-label">Projects Completed</div>
                        <div class="about-stat-value"><?= count($projects) ?><span>+</span></div>
                    </div>
                </div>
        </div>
        </div>
        
        <!-- Resume Section - 2 Column Layout -->
        <div class="resume-wrapper">
            <!-- Left Column: Education + Experience -->
            <div class="resume-left">
                <!-- Education -->
                <div class="resume-block reveal-left">
                    <div class="resume-block-header">
                        <span class="resume-block-icon"><i class="fas fa-graduation-cap"></i></span>
                        <h3>Education</h3>
                    </div>
                    <div class="resume-items">
                        <div class="resume-item">
                            <span class="resume-year">2023 – Now</span>
                            <div class="resume-info">
                                <h4>Diploma in Computer Engineering</h4>
                                <p>T.F. Gandhidham Polytechnic</p>
                            </div>
                        </div>
                        <div class="resume-item">
                            <span class="resume-year">2020 – 2023</span>
                            <div class="resume-info">
                                <h4>High School</h4>
                                <p>St. Xavier School, ADI</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Experience -->
                <div class="resume-block reveal-left">
                    <div class="resume-block-header">
                        <span class="resume-block-icon"><i class="fas fa-briefcase"></i></span>
                        <h3>Experience</h3>
                    </div>
                    <div class="resume-items">
                        <div class="resume-item">
                            <span class="resume-year">2021 – Now</span>
                            <div class="resume-info">
                                <h4>Founder — NSheth.in</h4>
                                <p>Building products & shipping solutions</p>
                            </div>
                        </div>
                        <div class="resume-item">
                            <span class="resume-year">2023 – Now</span>
                            <div class="resume-info">
                                <h4>Lead Developer — NSheth Agency</h4>
                                <p>Client projects & team coordination</p>
                            </div>
                        </div>
                        <div class="resume-item">
                            <span class="resume-year">2024</span>
                            <div class="resume-info">
                                <h4>Intern — IBM (Edunet)</h4>
                                <p>Cloud computing & AI/ML training</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Right Column: Tech Stack -->
            <div class="resume-right">
                <div class="skills-section reveal-right">
                    <div class="skills-section-header">
                        <span class="skills-section-icon"><i class="fas fa-code"></i></span>
                        <h3>Tech Stack</h3>
                    </div>
                    <div class="skills-tags">
                        <?php 
                        $allSkills = [];
                        foreach ($skills as $items) {
                            foreach ($items as $name => $level) {
                                $allSkills[] = $name;
                            }
                        }
                        foreach ($allSkills as $skill): ?>
                        <span class="skill-tag"><?= htmlspecialchars($skill) ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== CTA ========== -->
<section class="cta-section" id="contact">
    <div class="container">
        <h2 class="cta-title reveal">Let's Work Together</h2>
        <p class="cta-desc reveal">
            Got a project? An idea? Or just want to say hi? I'm always up for a conversation.
        </p>
        <div class="cta-buttons reveal">
            <a href="mailto:<?= htmlspecialchars($site['email']) ?>" class="btn btn-primary">
                <i class="fas fa-envelope"></i> Send Email
            </a>
            <a href="<?= htmlspecialchars($site['whatsapp']) ?>" target="_blank" class="btn btn-whatsapp">
                <i class="fab fa-whatsapp"></i> WhatsApp
            </a>
        </div>
    </div>
</section>

<!-- ========== FOOTER ========== -->
<footer class="footer">
    <div class="container">
        <p>© <?= date('Y') ?> NSheth · Made with curiosity & coffee</p>
    </div>
</footer>

<!-- ========== PROJECT MODAL ========== -->
<div class="project-modal" id="projectModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="modalTitle">Project Title</h3>
            <button class="modal-close" id="modalClose">
                <i class="fas fa-times"></i>
            </button>
        </div>
        <div class="modal-body">
            <div class="modal-image">
                <img src="" alt="" id="modalImage">
            </div>
            <div class="modal-info">
                <p class="modal-desc" id="modalDesc"></p>
                <div class="modal-meta">
                    <div class="modal-meta-item">
                        <span class="modal-meta-label">Year</span>
                        <span class="modal-meta-value" id="modalYear"></span>
                    </div>
                    <div class="modal-meta-item">
                        <span class="modal-meta-label">Category</span>
                        <span class="modal-meta-value" id="modalCategory"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="script.js"></script>
</body>
</html>
