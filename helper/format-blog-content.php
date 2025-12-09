<?php
/**
 * Blog Content Formatter | NSheth Portfolio
 * Cleans and formats blog content from WordPress import
 * 
 * Run: php helper/format-blog-content.php
 */

$blogDir = __DIR__ . '/../blog';

echo "Blog Content Formatter\n";
echo "======================\n\n";

$files = glob($blogDir . '/*.json');
$updated = 0;

foreach ($files as $file) {
    $json = file_get_contents($file);
    $post = json_decode($json, true);
    
    if (!$post) {
        echo "✗ Error parsing: " . basename($file) . "\n";
        continue;
    }
    
    echo "Processing: " . basename($file) . "\n";
    
    $content = $post['content'];
    $originalContent = $content;
    
    // Convert markdown-style formatting to HTML
    
    // Headers (## and ###)
    $content = preg_replace('/^### (.+)$/m', '<h3>$1</h3>', $content);
    $content = preg_replace('/^## (.+)$/m', '<h2>$1</h2>', $content);
    $content = preg_replace('/^# (.+)$/m', '<h1>$1</h1>', $content);
    
    // Bold (**text**)
    $content = preg_replace('/\*\*([^*]+)\*\*/', '<strong>$1</strong>', $content);
    
    // Italic (*text* but not **)
    $content = preg_replace('/(?<!\*)\*([^*]+)\*(?!\*)/', '<em>$1</em>', $content);
    
    // Inline code (`code`)
    $content = preg_replace('/`([^`]+)`/', '<code>$1</code>', $content);
    
    // Code blocks (```code```)
    $content = preg_replace('/```(\w+)?\n?([\s\S]*?)```/m', '<pre><code>$2</code></pre>', $content);
    
    // Bullet points (* item or - item)
    $content = preg_replace('/^\* (.+)$/m', '<li>$1</li>', $content);
    $content = preg_replace('/^- (.+)$/m', '<li>$1</li>', $content);
    
    // Wrap consecutive <li> in <ul>
    $content = preg_replace('/(<li>.*?<\/li>\n?)+/s', '<ul>$0</ul>', $content);
    $content = str_replace("</ul>\n<ul>", "\n", $content);
    
    // Numbered lists (1. item)
    $content = preg_replace('/^\d+\. (.+)$/m', '<li>$1</li>', $content);
    
    // Horizontal rules (---)
    $content = preg_replace('/^---+$/m', '<hr>', $content);
    
    // Links [text](url)
    $content = preg_replace('/\[([^\]]+)\]\(([^)]+)\)/', '<a href="$2" target="_blank" rel="noopener">$1</a>', $content);
    
    // Remove emoji shortcodes but keep emojis
    // Clean up escaped quotes
    $content = str_replace('\\"', '"', $content);
    $content = str_replace("\\'", "'", $content);
    $content = str_replace('\\n', "\n", $content);
    
    // Clean up PHP code tags that shouldn't be there
    $content = preg_replace('/\s*<\?php.*?\?>\s*/s', '', $content);
    $content = preg_replace('/\s*<\?=.*?\?>\s*/s', '', $content);
    
    // Clean up empty divs and paragraphs
    $content = preg_replace('/<div>\s*<\/div>/i', '', $content);
    $content = preg_replace('/<p>\s*<\/p>/i', '', $content);
    $content = preg_replace('/<p>\s*<br\s*\/?>\s*<\/p>/i', '', $content);
    
    // Wrap plain text blocks in paragraphs
    $lines = explode("\n", $content);
    $formatted = [];
    $inBlock = false;
    
    foreach ($lines as $line) {
        $trimmed = trim($line);
        if (empty($trimmed)) {
            continue;
        }
        
        // Check if line is already wrapped in HTML
        if (preg_match('/^<(h[1-6]|ul|ol|li|p|pre|blockquote|div|hr|figure|a)/', $trimmed)) {
            $formatted[] = $trimmed;
        } else if (preg_match('/<\/(h[1-6]|ul|ol|pre|blockquote|div|figure)>$/', $trimmed)) {
            $formatted[] = $trimmed;
        } else if (!empty($trimmed) && $trimmed !== '<hr>') {
            // Only wrap if it doesn't look like it's inside a block
            if (!preg_match('/^</', $trimmed) && !preg_match('/>$/', $trimmed)) {
                $formatted[] = '<p>' . $trimmed . '</p>';
            } else {
                $formatted[] = $trimmed;
            }
        } else {
            $formatted[] = $trimmed;
        }
    }
    
    $content = implode("\n", $formatted);
    
    // Clean up any double-wrapped paragraphs
    $content = preg_replace('/<p>\s*<p>/i', '<p>', $content);
    $content = preg_replace('/<\/p>\s*<\/p>/i', '</p>', $content);
    
    // Update excerpt - remove markdown
    $excerpt = $post['excerpt'];
    $excerpt = preg_replace('/\*\*([^*]+)\*\*/', '$1', $excerpt);
    $excerpt = preg_replace('/`([^`]+)`/', '$1', $excerpt);
    
    if ($content !== $originalContent || $excerpt !== $post['excerpt']) {
        $post['content'] = $content;
        $post['excerpt'] = $excerpt;
        
        $jsonContent = json_encode($post, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents($file, $jsonContent);
        
        echo "  ✓ Updated\n";
        $updated++;
    } else {
        echo "  - No changes needed\n";
    }
}

echo "\n======================\n";
echo "Complete! Updated: {$updated} files\n";
