<?php
/**
 * Final Blog Cleanup | NSheth Portfolio
 * Fixes nbsp, bad slugs, and other issues
 * 
 * Run: php helper/final-cleanup.php
 */

$blogDir = __DIR__ . '/../blog';

echo "Final Blog Cleanup\n==================\n\n";

$files = glob($blogDir . '/*.json');

foreach ($files as $file) {
    $json = file_get_contents($file);
    $post = json_decode($json, true);
    
    if (!$post) continue;
    
    echo "Cleaning: " . basename($file) . "\n";
    
    // Fix content
    $content = $post['content'];
    
    // Remove &nbsp;
    $content = str_replace(['&nbsp;', '&#160;'], ' ', $content);
    
    // Fix broken img tags
    $content = preg_replace('/<img([^>]*)\/ loading/', '<img$1 loading', $content);
    
    // Remove external image URLs (we have local copies)
    $content = preg_replace('/<img[^>]*src="https?:\/\/[^"]*blogger[^"]*"[^>]*>/i', '', $content);
    
    // Clean up multiple spaces
    $content = preg_replace('/\s{2,}/', ' ', $content);
    
    // Fix escaped quotes in attributes
    $content = str_replace('\\"', '"', $content);
    
    // Remove empty figure/p tags
    $content = preg_replace('/<figure>\s*<\/figure>/i', '', $content);
    $content = preg_replace('/<p>\s*<\/p>/i', '', $content);
    $content = preg_replace('/<p>\s*<br>\s*<\/p>/i', '', $content);
    
    // Fix duplicati slug issue
    if (strpos($post['image'], '20duplicati') !== false) {
        $post['image'] = str_replace('20duplicati', 'duplicati', $post['image']);
    }
    if (strpos($post['slug'], '20duplicati') !== false) {
        $post['slug'] = str_replace('20duplicati', 'duplicati', $post['slug']);
    }
    
    // Clean excerpt
    $excerpt = $post['excerpt'];
    $excerpt = str_replace(['&nbsp;', '&#160;'], ' ', $excerpt);
    $excerpt = preg_replace('/\s{2,}/', ' ', $excerpt);
    $excerpt = html_entity_decode($excerpt, ENT_QUOTES, 'UTF-8');
    
    $post['content'] = trim($content);
    $post['excerpt'] = trim($excerpt);
    
    file_put_contents($file, json_encode($post, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    echo "  ✓ Done\n";
}

// Rename problematic file
$badFile = $blogDir . '/20duplicati-docker.json';
$goodFile = $blogDir . '/duplicati-docker.json';
if (file_exists($badFile)) {
    $content = file_get_contents($badFile);
    $post = json_decode($content, true);
    $post['slug'] = 'duplicati-docker';
    $post['image'] = str_replace('20duplicati', 'duplicati', $post['image']);
    file_put_contents($goodFile, json_encode($post, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    unlink($badFile);
    echo "\nFixed: duplicati-docker.json\n";
}

echo "\n==================\nCleanup complete!\n";
