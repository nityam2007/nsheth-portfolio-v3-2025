<?php
/**
 * Sitemap Generator | NSheth Portfolio
 * Generates sitemap.xml including blog posts
 * 
 * Run: php helper/generate-sitemap.php
 */

$baseUrl = 'https://nsheth.in';
$blogDir = __DIR__ . '/../blog';
$outputFile = __DIR__ . '/../sitemap.xml';

echo "Sitemap Generator\n";
echo "==================\n\n";

// Start XML
$sitemap = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
$sitemap .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";

// Static pages
$pages = [
    ['url' => '/', 'priority' => '1.0', 'changefreq' => 'weekly'],
    ['url' => '/blog', 'priority' => '0.9', 'changefreq' => 'daily'],
];

$date = date('Y-m-d');

foreach ($pages as $page) {
    $sitemap .= "  <url>\n";
    $sitemap .= "    <loc>{$baseUrl}{$page['url']}</loc>\n";
    $sitemap .= "    <lastmod>{$date}</lastmod>\n";
    $sitemap .= "    <changefreq>{$page['changefreq']}</changefreq>\n";
    $sitemap .= "    <priority>{$page['priority']}</priority>\n";
    $sitemap .= "  </url>\n";
    echo "✓ Added: {$page['url']}\n";
}

// Blog posts
if (is_dir($blogDir)) {
    $files = glob($blogDir . '/*.json');
    
    foreach ($files as $file) {
        $json = file_get_contents($file);
        $post = json_decode($json, true);
        
        if ($post && isset($post['slug'])) {
            $postDate = $post['date'] ?? $date;
            $url = '/blog/' . $post['slug'];
            
            $sitemap .= "  <url>\n";
            $sitemap .= "    <loc>{$baseUrl}{$url}</loc>\n";
            $sitemap .= "    <lastmod>{$postDate}</lastmod>\n";
            $sitemap .= "    <changefreq>monthly</changefreq>\n";
            $sitemap .= "    <priority>0.7</priority>\n";
            $sitemap .= "  </url>\n";
            
            echo "✓ Added: {$url}\n";
        }
    }
}

$sitemap .= '</urlset>';

// Save sitemap
file_put_contents($outputFile, $sitemap);

echo "\n==================\n";
echo "Sitemap saved to: sitemap.xml\n";
echo "Total URLs: " . substr_count($sitemap, '<url>') . "\n";
