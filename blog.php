<?php
/**
 * Blog Listing Page | NSheth Portfolio
 * Clean, modern blog with award-style design
 */

// Load all blog posts from JSON files
$blogDir = __DIR__ . '/blog';
$posts = [];

if (is_dir($blogDir)) {
    $files = glob($blogDir . '/*.json');
    foreach ($files as $file) {
        $json = file_get_contents($file);
        $post = json_decode($json, true);
        if ($post && isset($post['slug'])) {
            $posts[] = $post;
        }
    }
}

// Sort by date (newest first)
usort($posts, function($a, $b) {
    return strtotime($b['date']) - strtotime($a['date']);
});

// Site config
$site = [
    'name' => 'Nityam Sheth',
    'title' => 'Blog – Nityam Sheth',
    'description' => 'Articles about web development, cloud hosting, Docker, AI, and building digital products.',
    'email' => 'hello@nsheth.in',
    'linkedin' => 'https://www.linkedin.com/in/nityam-sheth/',
    'github' => 'https://github.com/nityam2007',
    'whatsapp' => 'https://wa.me/919664833459'
];

// Get unique categories
$categories = [];
foreach ($posts as $post) {
    $cat = $post['category'] ?? 'Uncategorized';
    if (!isset($categories[$cat])) {
        $categories[$cat] = 0;
    }
    $categories[$cat]++;
}
arsort($categories);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="<?= htmlspecialchars($site['description']) ?>">
    <meta property="og:title" content="<?= htmlspecialchars($site['title']) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($site['description']) ?>">
    <link rel="icon" type="image/svg+xml" href="assets/favicon.svg">
    <title><?= htmlspecialchars($site['title']) ?></title>
    
    <link rel="stylesheet" href="assets/css/fonts.css">
    <link rel="stylesheet" href="assets/css/fontawesome.min.css">
    <link rel="stylesheet" href="style.css">
    
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

<!-- ========== HEADER ========== -->
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

<!-- ========== BLOG HERO ========== -->
<section class="blog-hero">
    <div class="blog-hero-bg"></div>
    <div class="container">
        <div class="blog-hero-content">
            <span class="section-label">Articles & Insights</span>
            <h1 class="blog-hero-title">
                <span class="line">Thoughts on</span>
                <span class="line"><span class="highlight">Code</span> & Cloud</span>
            </h1>
            <p class="blog-hero-subtitle">
                Deep dives into development, Docker, hosting, and building things that work.
            </p>
            <div class="blog-stats">
                <div class="blog-stat">
                    <span class="blog-stat-value"><?= count($posts) ?></span>
                    <span class="blog-stat-label">Articles</span>
                </div>
                <div class="blog-stat">
                    <span class="blog-stat-value"><?= count($categories) ?></span>
                    <span class="blog-stat-label">Topics</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ========== CATEGORY FILTER ========== -->
<section class="blog-filter">
    <div class="container">
        <div class="filter-scroll">
            <button class="filter-btn active" data-category="all">All Posts</button>
            <?php foreach (array_slice(array_keys($categories), 0, 6) as $cat): ?>
            <button class="filter-btn" data-category="<?= htmlspecialchars(strtolower($cat)) ?>">
                <?= htmlspecialchars($cat) ?>
            </button>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- ========== BLOG POSTS ========== -->
<section class="blog-section">
    <div class="container">
        <?php if (empty($posts)): ?>
            <div class="blog-empty">
                <i class="fas fa-feather-alt"></i>
                <h3>No posts yet</h3>
                <p>Check back soon for new articles!</p>
            </div>
        <?php else: ?>
            <!-- Featured Post (First Post) -->
            <?php $featured = $posts[0]; ?>
            <article class="blog-featured" data-category="<?= htmlspecialchars(strtolower($featured['category'] ?? 'uncategorized')) ?>">
                <a href="/blog/<?= htmlspecialchars($featured['slug']) ?>" class="blog-featured-link">
                    <div class="blog-featured-image">
                        <?php if (!empty($featured['image'])): ?>
                            <img src="<?= htmlspecialchars($featured['image']) ?>" alt="<?= htmlspecialchars($featured['title']) ?>" loading="lazy">
                        <?php else: ?>
                            <div class="blog-featured-placeholder">
                                <i class="fas fa-newspaper"></i>
                            </div>
                        <?php endif; ?>
                        <div class="blog-featured-overlay">
                            <span class="blog-featured-tag">Featured</span>
                        </div>
                    </div>
                    <div class="blog-featured-content">
                        <div class="blog-card-meta">
                            <span class="blog-card-category"><?= htmlspecialchars($featured['category'] ?? 'Uncategorized') ?></span>
                            <span class="blog-card-date"><?= date('M d, Y', strtotime($featured['date'])) ?></span>
                        </div>
                        <h2 class="blog-featured-title"><?= htmlspecialchars($featured['title']) ?></h2>
                        <p class="blog-featured-excerpt"><?= htmlspecialchars($featured['excerpt']) ?></p>
                        <div class="blog-card-footer">
                            <span class="blog-card-read"><?= htmlspecialchars($featured['readTime']) ?></span>
                            <span class="blog-card-arrow"><i class="fas fa-arrow-right"></i></span>
                        </div>
                    </div>
                </a>
            </article>

            <!-- Blog Grid -->
            <div class="blog-grid">
                <?php foreach (array_slice($posts, 1) as $post): ?>
                <article class="blog-card" data-category="<?= htmlspecialchars(strtolower($post['category'] ?? 'uncategorized')) ?>">
                    <a href="/blog/<?= htmlspecialchars($post['slug']) ?>" class="blog-card-link">
                        <div class="blog-card-image">
                            <?php if (!empty($post['image'])): ?>
                                <img src="<?= htmlspecialchars($post['image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="lazy">
                            <?php else: ?>
                                <div class="blog-card-placeholder">
                                    <i class="fas fa-file-alt"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="blog-card-content">
                            <div class="blog-card-meta">
                                <span class="blog-card-category"><?= htmlspecialchars($post['category'] ?? 'Uncategorized') ?></span>
                                <span class="blog-card-date"><?= date('M d, Y', strtotime($post['date'])) ?></span>
                            </div>
                            <h2 class="blog-card-title"><?= htmlspecialchars($post['title']) ?></h2>
                            <p class="blog-card-excerpt"><?= htmlspecialchars($post['excerpt']) ?></p>
                            <div class="blog-card-footer">
                                <span class="blog-card-read"><?= htmlspecialchars($post['readTime']) ?></span>
                                <span class="blog-card-arrow"><i class="fas fa-arrow-right"></i></span>
                            </div>
                        </div>
                    </a>
                </article>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- ========== CTA ========== -->
<section class="blog-cta">
    <div class="container">
        <div class="blog-cta-content">
            <h2>Want to work together?</h2>
            <p>Got a project or just want to say hi? Let's connect.</p>
            <a href="/#contact" class="btn btn-primary">
                <i class="fas fa-envelope"></i> Get in Touch
            </a>
        </div>
    </div>
</section>

<!-- ========== FOOTER ========== -->
<footer class="footer">
    <div class="container">
        <p>© <?= date('Y') ?> NSheth · All Rights Reserved</p>
    </div>
</footer>

<script src="script.js"></script>
<script>
// Category filter functionality
document.querySelectorAll('.filter-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const category = this.dataset.category;
        
        // Update active button
        document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
        this.classList.add('active');
        
        // Filter posts
        document.querySelectorAll('.blog-card, .blog-featured').forEach(card => {
            if (category === 'all' || card.dataset.category === category) {
                card.style.display = '';
                card.style.animation = 'fadeIn 0.4s ease forwards';
            } else {
                card.style.display = 'none';
            }
        });
    });
});
</script>
</body>
</html>
