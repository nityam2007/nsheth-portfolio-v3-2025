<?php
/**
 * Blog Content Deep Clean | NSheth Portfolio
 * Thoroughly cleans and restructures all blog content
 * 
 * Run: php helper/deep-clean-blogs.php
 */

$blogDir = __DIR__ . '/../blog';

echo "Deep Cleaning Blog Content...\n\n";

$files = glob($blogDir . '/*.json');

foreach ($files as $file) {
    $json = file_get_contents($file);
    $post = json_decode($json, true);
    
    if (!$post) continue;
    
    echo "Cleaning: " . basename($file) . "\n";
    
    $content = $post['content'];
    
    // Step 1: Decode escaped characters
    $content = str_replace(['\\n', '\\"', "\\'"], ["\n", '"', "'"], $content);
    
    // Step 2: Remove PHP tags and their content
    $content = preg_replace('/<\?php[\s\S]*?\?>/i', '', $content);
    $content = preg_replace('/<\?=[\s\S]*?\?>/i', '', $content);
    
    // Step 3: Clean malformed code blocks
    $content = preg_replace('/``+`?\w*/', '', $content);
    $content = preg_replace('/`{2,}/', '', $content);
    
    // Step 4: Fix markdown headers
    $content = preg_replace('/## 🔹\s*/', '<h2>', $content);
    $content = preg_replace('/## 🚀\s*/', '<h2>', $content);
    $content = preg_replace('/##\s+([^<\n]+)/', '<h2>$1</h2>', $content);
    $content = preg_replace('/###\s+([^<\n]+)/', '<h3>$1</h3>', $content);
    
    // Step 5: Fix bold and italic
    $content = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $content);
    
    // Step 6: Fix horizontal rules
    $content = preg_replace('/\n-{3,}\n/', '<hr>', $content);
    $content = preg_replace('/---+/', '<hr>', $content);
    
    // Step 7: Clean empty/broken HTML
    $content = preg_replace('/<div>\s*<\/div>/', '', $content);
    $content = preg_replace('/<p>\s*<\/p>/', '', $content);
    $content = preg_replace('/<h[1-6]>\s*<\/h[1-6]>/', '', $content);
    $content = preg_replace('/<(video|img)[^>]*src=""\s*[^>]*>/', '', $content);
    $content = preg_replace('/<h3>\s*<\/h3>/', '', $content);
    
    // Step 8: Remove empty style/script blocks
    $content = preg_replace('/<style[^>]*>[\s\S]*?<\/style>/', '', $content);
    
    // Step 9: Clean up whitespace
    $content = preg_replace('/\n{3,}/', "\n\n", $content);
    $content = preg_replace('/>\s+</', '><', $content);
    
    // Step 10: Wrap orphan text in paragraphs
    $lines = preg_split('/(<[^>]+>)/', $content, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
    $result = [];
    
    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;
        
        // If it starts with < it's a tag
        if (preg_match('/^</', $line)) {
            $result[] = $line;
        } else {
            // Plain text - wrap in <p> if substantial
            if (strlen($line) > 10) {
                $result[] = '<p>' . $line . '</p>';
            }
        }
    }
    
    $content = implode('', $result);
    
    // Step 11: Fix nested paragraphs
    $content = preg_replace('/<p>\s*<p>/', '<p>', $content);
    $content = preg_replace('/<\/p>\s*<\/p>/', '</p>', $content);
    $content = preg_replace('/<p>\s*<(h[1-6]|ul|ol|pre|hr)/', '<$1', $content);
    $content = preg_replace('/<\/(h[1-6]|ul|ol|pre)>\s*<\/p>/', '</$1>', $content);
    
    // Step 12: Clean excerpt
    $excerpt = $post['excerpt'];
    $excerpt = preg_replace('/\*\*([^*]+)\*\*/', '$1', $excerpt);
    $excerpt = strip_tags($excerpt);
    $excerpt = trim($excerpt);
    if (strlen($excerpt) > 200) {
        $excerpt = substr($excerpt, 0, 197) . '...';
    }
    
    // Save
    $post['content'] = trim($content);
    $post['excerpt'] = $excerpt;
    
    $jsonOut = json_encode($post, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    file_put_contents($file, $jsonOut);
    
    echo "  ✓ Done\n";
}

echo "\nAll blogs cleaned!\n";
