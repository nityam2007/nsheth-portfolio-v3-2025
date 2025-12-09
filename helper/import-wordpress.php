<?php
/**
 * WordPress XML to JSON Blog Import Script | NSheth Portfolio
 * Converts WordPress export XML to JSON blog post files
 */

$xmlFile = __DIR__ . '/dataforai/nsheth.WordPress.2025-12-09.xml';
$blogDir = __DIR__ . '/blog';

// Parse XML
$xml = simplexml_load_file($xmlFile);

// Register namespaces
$namespaces = $xml->getNamespaces(true);

// Get all items from channel
$items = $xml->channel->item;

$imported = 0;
$skipped = 0;

foreach ($items as $item) {
    // Get WordPress-specific data
    $wp = $item->children($namespaces['wp']);
    $content = $item->children($namespaces['content']);
    $dc = $item->children($namespaces['dc']);
    
    // Only process published posts (not attachments, pages, etc.)
    $postType = (string)$wp->post_type;
    $status = (string)$wp->status;
    
    if ($postType !== 'post' || $status !== 'publish') {
        $skipped++;
        continue;
    }
    
    // Extract post data
    $title = (string)$item->title;
    $slug = (string)$wp->post_name;
    $rawContent = (string)$content->encoded;
    $pubDate = (string)$item->pubDate;
    
    // Clean up content - remove inline styles and Blogger legacy HTML
    $cleanContent = preg_replace('/style="[^"]*"/', '', $rawContent);
    $cleanContent = preg_replace('/<span[^>]*>/', '', $cleanContent);
    $cleanContent = str_replace('</span>', '', $cleanContent);
    $cleanContent = preg_replace('/<div[^>]*style[^>]*>/', '<div>', $cleanContent);
    $cleanContent = preg_replace('/class="[^"]*"/', '', $cleanContent);
    $cleanContent = preg_replace('/\s+/', ' ', $cleanContent);
    $cleanContent = str_replace('<br /><br />', '</p><p>', $cleanContent);
    $cleanContent = str_replace('<br />', '<br>', $cleanContent);
    $cleanContent = trim($cleanContent);
    
    // Generate excerpt from content (first 200 chars of text)
    $textContent = strip_tags($cleanContent);
    $textContent = preg_replace('/\s+/', ' ', $textContent);
    $excerpt = substr($textContent, 0, 200);
    if (strlen($textContent) > 200) {
        $excerpt = preg_replace('/\s+\S*$/', '', $excerpt) . '...';
    }
    
    // Get category
    $category = 'Uncategorized';
    foreach ($item->category as $cat) {
        $domain = (string)$cat['domain'];
        if ($domain === 'category') {
            $category = (string)$cat;
            break;
        }
    }
    
    // Get tags
    $tags = [];
    foreach ($item->category as $cat) {
        $domain = (string)$cat['domain'];
        if ($domain === 'post_tag') {
            $tags[] = (string)$cat['nicename'];
        }
    }
    
    // Calculate read time (average 200 words per minute)
    $wordCount = str_word_count($textContent);
    $readMinutes = max(1, ceil($wordCount / 200));
    $readTime = $readMinutes . ' min read';
    
    // Format date
    $dateFormatted = date('Y-m-d', strtotime($pubDate));
    
    // Create JSON structure
    $post = [
        'slug' => $slug,
        'title' => html_entity_decode($title, ENT_QUOTES, 'UTF-8'),
        'excerpt' => html_entity_decode($excerpt, ENT_QUOTES, 'UTF-8'),
        'content' => $cleanContent,
        'author' => 'Nityam Sheth',
        'date' => $dateFormatted,
        'readTime' => $readTime,
        'category' => $category,
        'tags' => $tags,
        'image' => ''
    ];
    
    // Save to JSON file
    $jsonFile = $blogDir . '/' . $slug . '.json';
    $jsonContent = json_encode($post, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    
    file_put_contents($jsonFile, $jsonContent);
    echo "✓ Imported: {$title}\n";
    $imported++;
}

echo "\n=============================\n";
echo "Import complete!\n";
echo "Imported: {$imported} posts\n";
echo "Skipped: {$skipped} items (attachments, pages, drafts)\n";
