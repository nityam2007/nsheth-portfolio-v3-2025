<?php
/**
 * Individual Blog Post Page | NSheth Portfolio
 * Clean, modern post layout with wider content area
 */

// Get slug from URL parameter
$slug = $_GET['slug'] ?? '';
$slug = preg_replace('/[^a-z0-9\-]/', '', strtolower($slug));

// Load post
$postFile = __DIR__ . '/' . $slug . '.json';
$post = null;

if (!empty($slug) && file_exists($postFile)) {
    $json = file_get_contents($postFile);
    $post = json_decode($json, true);
}

// 404 if post not found
if (!$post) {
    http_response_code(404);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">
    <title>404 – Post Not Found</title>
    <link rel="stylesheet" href="/assets/css/fonts.css">
    <link rel="stylesheet" href="/assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="/style.css">
</head>
<body>
<header class="header scrolled" id="header">
    <div class="container">
        <div class="header-inner">
            <a href="/" class="logo">NSheth</a>
            <nav class="nav-desktop">
                <a href="/#work">Work</a>
                <a href="/#services">Services</a>
                <a href="/blog">Blog</a>
                <a href="/#contact">Contact</a>
            </nav>
        </div>
    </div>
</header>
<section class="blog-404">
    <div class="container">
        <div class="blog-404-content">
            <span class="blog-404-code">404</span>
            <h1>Post Not Found</h1>
            <p>The article you're looking for doesn't exist or has been moved.</p>
            <a href="/blog" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Back to Blog
            </a>
        </div>
    </div>
</section>
<script src="/script.js"></script>
</body>
</html>
<?php
    exit;
}

$postDate = date('F j, Y', strtotime($post['date']));
$pageTitle = htmlspecialchars($post['title']) . ' – Nityam Sheth';
$shareUrl = 'https://nsheth.in/blog/' . $post['slug'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($post['excerpt']) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($post['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($post['excerpt']) ?>">
    <?php if (!empty($post['image'])): ?>
    <meta property="og:image" content="https://nsheth.in/<?= htmlspecialchars($post['image']) ?>">
    <?php endif; ?>
    <link rel="icon" type="image/svg+xml" href="/assets/favicon.svg">
    <title><?= $pageTitle ?></title>
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
                <a href="/blog" class="active">Blog</a>
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

<!-- Blog Post -->
<article class="blog-post">
    <!-- Post Header -->
    <header class="blog-post-header">
        <div class="container">
            <a href="/blog" class="blog-back">
                <i class="fas fa-arrow-left"></i> All Posts
            </a>
            <div class="blog-post-meta">
                <span class="blog-post-category"><?= htmlspecialchars($post['category'] ?? 'Uncategorized') ?></span>
                <span class="blog-post-date"><?= $postDate ?></span>
                <span class="blog-post-read"><?= htmlspecialchars($post['readTime']) ?></span>
            </div>
            <h1 class="blog-post-title"><?= htmlspecialchars($post['title']) ?></h1>
            <p class="blog-post-excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
        </div>
    </header>

    <?php if (!empty($post['image'])): ?>
    <!-- Featured Image -->
    <div class="blog-post-cover">
        <div class="container">
            <img src="/<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>">
        </div>
    </div>
    <?php endif; ?>

    <!-- Post Content -->
    <div class="blog-post-body">
        <div class="container">
            <div class="blog-post-content">
                <?= $post['content'] ?>
            </div>
        </div>
    </div>

    <!-- Post Footer -->
    <footer class="blog-post-footer">
        <div class="container">
            <div class="blog-post-footer-inner">
                <?php if (!empty($post['tags'])): ?>
                <div class="blog-post-tags">
                    <span class="blog-post-tags-label">Tags:</span>
                    <?php foreach ($post['tags'] as $tag): ?>
                    <span class="blog-post-tag"><?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
                
                <div class="blog-post-share">
                    <span class="blog-post-share-label">Share:</span>
                    <div class="blog-post-share-btns">
                        <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title']) ?>&url=<?= urlencode($shareUrl) ?>" 
                           target="_blank" rel="noopener" class="blog-share-btn" aria-label="Share on Twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode($shareUrl) ?>" 
                           target="_blank" rel="noopener" class="blog-share-btn" aria-label="Share on LinkedIn">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://wa.me/?text=<?= urlencode($post['title'] . ' - ' . $shareUrl) ?>" 
                           target="_blank" rel="noopener" class="blog-share-btn" aria-label="Share on WhatsApp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</article>

<!-- CTA -->
<section class="blog-cta">
    <div class="container">
        <div class="blog-cta-content">
            <h2>Enjoyed this article?</h2>
            <p>Let's connect and discuss ideas or work on something together.</p>
            <a href="/#contact" class="btn btn-primary">
                <i class="fas fa-envelope"></i> Get in Touch
            </a>
        </div>
    </div>
</section>

<!-- Footer -->
<footer class="footer">
    <div class="container">
        <p>© <?= date('Y') ?> NSheth · All Rights Reserved</p>
    </div>
</footer>

<script src="/script.js"></script>
</body>
</html>
