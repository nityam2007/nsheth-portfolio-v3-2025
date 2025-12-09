<?php
/**
 * 404 Page | NSheth Portfolio
 */
$site = [
    'name' => 'Nityam Sheth',
    'title' => '404 – Page Not Found',
    'email' => 'hello@nsheth.in',
    'linkedin' => 'https://www.linkedin.com/in/nityam-sheth/',
    'github' => 'https://github.com/nityam2007',
    'whatsapp' => 'https://wa.me/919664833459'
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">
    <title><?= htmlspecialchars($site['title']) ?></title>
    <link rel="stylesheet" href="/assets/css/fonts.css">
    <link rel="stylesheet" href="/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="/style.css">
    
    <!-- Microsoft Clarity -->
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "p64dhs1h75");
    </script>
</head>
<body>

<!-- Header -->
<header class="header scrolled" id="header">
    <div class="container">
        <div class="header-inner">
            <a href="/" class="logo">NSheth</a>
            <nav class="nav-desktop">
                <a href="/#work">Work</a>
                <a href="/#services">Services</a>
                <a href="/#about">About</a>
                <a href="/blog">Blog</a>
                <a href="/#contact">Contact</a>
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
        <a href="/#work">Work</a>
        <a href="/#services">Services</a>
        <a href="/#about">About</a>
        <a href="/blog">Blog</a>
        <a href="/#contact">Contact</a>
        <button class="theme-toggle theme-toggle-mobile" id="themeToggleMobile" aria-label="Toggle theme">
            <i class="fas fa-moon"></i>
        </button>
    </nav>
</header>

<!-- 404 Content -->
<section class="page-404">
    <div class="container">
        <div class="page-404-content">
            <span class="page-404-code">404</span>
            <h1>Page Not Found</h1>
            <p>The page you're looking for doesn't exist or has been moved.</p>
            <div class="page-404-buttons">
                <a href="/" class="btn btn-primary">
                    <i class="fas fa-home"></i> Go Home
                </a>
                <a href="/blog" class="btn btn-outline">
                    <i class="fas fa-book"></i> Read Blog
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-brand">
                <span class="footer-logo">NSheth</span>
                <p class="footer-tagline">Developer & Maker</p>
            </div>
            <div class="footer-links">
                <a href="/#work">Work</a>
                <a href="/#services">Services</a>
                <a href="/#about">About</a>
                <a href="/blog">Blog</a>
                <a href="/#contact">Contact</a>
            </div>
            <div class="footer-social">
                <a href="<?= htmlspecialchars($site['linkedin']) ?>" target="_blank" aria-label="LinkedIn">
                    <i class="fab fa-linkedin-in"></i>
                </a>
                <a href="<?= htmlspecialchars($site['github']) ?>" target="_blank" aria-label="GitHub">
                    <i class="fab fa-github"></i>
                </a>
                <a href="<?= htmlspecialchars($site['whatsapp']) ?>" target="_blank" aria-label="WhatsApp">
                    <i class="fab fa-whatsapp"></i>
                </a>
            </div>
        </div>
        <div class="footer-bottom">
            <p>© <?= date('Y') ?> <?= htmlspecialchars($site['name']) ?> · All Rights Reserved</p>
            <div class="footer-legal">
                <a href="/privacy">Privacy Policy</a>
                <a href="/terms">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>

<script src="/script.js"></script>
</body>
</html>
