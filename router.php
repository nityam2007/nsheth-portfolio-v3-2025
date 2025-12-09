<?php
/**
 * Router for PHP Built-in Server | NSheth Portfolio
 * Usage: php -S 127.0.0.1:8000 router.php
 */

$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = urldecode($uri);

// Remove trailing slash (except for root)
if ($uri !== '/' && substr($uri, -1) === '/') {
    $uri = rtrim($uri, '/');
}

// Blog routing
if ($uri === '/blog') {
    require __DIR__ . '/blog.php';
    return true;
}

// Individual blog post: /blog/slug
if (preg_match('#^/blog/([a-z0-9\-]+)$#', $uri, $matches)) {
    $_GET['slug'] = $matches[1];
    require __DIR__ . '/blog/index.php';
    return true;
}

// Privacy page
if ($uri === '/privacy') {
    require __DIR__ . '/privacy.php';
    return true;
}

// Terms page
if ($uri === '/terms') {
    require __DIR__ . '/terms.php';
    return true;
}

// Serve static files normally
$filePath = __DIR__ . $uri;
if (is_file($filePath)) {
    return false; // Let PHP built-in server handle it
}

// Default: serve index.php
if ($uri === '/' || $uri === '') {
    require __DIR__ . '/index.php';
    return true;
}

// 404 for everything else
http_response_code(404);
require __DIR__ . '/404.php';
return true;

