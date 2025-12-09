<?php
/**
 * WordPress XML Full Reimport | NSheth Portfolio
 * Properly imports posts with images from WordPress XML
 * 
 * Run: php helper/reimport-wordpress.php
 */

$xmlFile = __DIR__ . '/../dataforai/nsheth.WordPress.2025-12-09.xml';
$blogDir = __DIR__ . '/../blog';
$imageDir = __DIR__ . '/../assets/blog';

// Ensure directories exist
if (!is_dir($imageDir)) mkdir($imageDir, 0755, true);

echo "WordPress Full Reimport\n";
echo "========================\n\n";

// Parse XML
$xml = simplexml_load_file($xmlFile);
$namespaces = $xml->getNamespaces(true);

// First pass: collect all attachments (images) by post ID
$attachments = [];
foreach ($xml->channel->item as $item) {
    $wp = $item->children($namespaces['wp']);
    $postType = (string)$wp->post_type;
    
    if ($postType === 'attachment') {
        $postParent = (string)$wp->post_parent;
        $attachmentUrl = (string)$wp->attachment_url;
        
        if (!empty($attachmentUrl) && $postParent !== '0') {
            if (!isset($attachments[$postParent])) {
                $attachments[$postParent] = [];
            }
            $attachments[$postParent][] = $attachmentUrl;
        }
    }
}

echo "Found " . count($attachments) . " posts with attachments\n\n";

// Second pass: process posts
$imported = 0;

foreach ($xml->channel->item as $item) {
    $wp = $item->children($namespaces['wp']);
    $content = $item->children($namespaces['content']);
    
    $postType = (string)$wp->post_type;
    $status = (string)$wp->status;
    
    if ($postType !== 'post' || $status !== 'publish') continue;
    
    $postId = (string)$wp->post_id;
    $title = html_entity_decode((string)$item->title, ENT_QUOTES, 'UTF-8');
    $slug = (string)$wp->post_name;
    $rawContent = (string)$content->encoded;
    $pubDate = (string)$item->pubDate;
    
    echo "Processing: $title\n";
    
    // Clean slug
    $slug = preg_replace('/[^a-z0-9\-]/', '', strtolower(trim($slug)));
    if (empty($slug)) {
        $slug = preg_replace('/[^a-z0-9]+/', '-', strtolower($title));
        $slug = trim($slug, '-');
    }
    
    // Get featured image from attachments
    $featuredImage = '';
    if (isset($attachments[$postId]) && !empty($attachments[$postId])) {
        $imgUrl = $attachments[$postId][0];
        $featuredImage = downloadImage($imgUrl, $slug, $imageDir);
        echo "  ↳ Featured: $featuredImage\n";
    }
    
    // Also extract first image from content if no featured
    if (empty($featuredImage)) {
        if (preg_match('/src=["\']([^"\']+\.(jpg|jpeg|png|gif|webp))["\']/', $rawContent, $match)) {
            $featuredImage = downloadImage($match[1], $slug, $imageDir);
            echo "  ↳ From content: $featuredImage\n";
        }
    }
    
    // Clean content
    $cleanContent = cleanWordPressContent($rawContent, $slug, $imageDir);
    
    // Get category
    $category = 'Uncategorized';
    foreach ($item->category as $cat) {
        if ((string)$cat['domain'] === 'category' && (string)$cat !== 'Uncategorized') {
            $category = (string)$cat;
            break;
        }
    }
    
    // Get tags
    $tags = [];
    foreach ($item->category as $cat) {
        if ((string)$cat['domain'] === 'post_tag') {
            $tags[] = (string)$cat['nicename'];
        }
    }
    
    // Generate excerpt
    $textContent = strip_tags($cleanContent);
    $textContent = preg_replace('/\s+/', ' ', $textContent);
    $excerpt = substr(trim($textContent), 0, 180);
    if (strlen($textContent) > 180) {
        $excerpt = preg_replace('/\s+\S*$/', '', $excerpt) . '...';
    }
    
    // Calculate read time
    $wordCount = str_word_count($textContent);
    $readMinutes = max(1, ceil($wordCount / 200));
    
    // Create post data
    $post = [
        'slug' => $slug,
        'title' => $title,
        'excerpt' => $excerpt,
        'content' => $cleanContent,
        'author' => 'Nityam Sheth',
        'date' => date('Y-m-d', strtotime($pubDate)),
        'readTime' => $readMinutes . ' min read',
        'category' => $category,
        'tags' => $tags,
        'image' => $featuredImage
    ];
    
    // Save
    $jsonFile = $blogDir . '/' . $slug . '.json';
    file_put_contents($jsonFile, json_encode($post, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
    
    echo "  ✓ Saved\n\n";
    $imported++;
}

echo "========================\n";
echo "Imported: $imported posts\n";

/**
 * Download image and return local path
 */
function downloadImage($url, $slug, $imageDir) {
    if (empty($url) || strpos($url, 'http') !== 0) return '';
    
    $ext = pathinfo(parse_url($url, PHP_URL_PATH), PATHINFO_EXTENSION);
    if (!in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
        $ext = 'jpg';
    }
    
    $filename = $slug . '-featured.' . $ext;
    $localPath = $imageDir . '/' . $filename;
    $webPath = 'assets/blog/' . $filename;
    
    if (!file_exists($localPath)) {
        $ctx = stream_context_create([
            'http' => ['timeout' => 15, 'user_agent' => 'Mozilla/5.0'],
            'ssl' => ['verify_peer' => false, 'verify_peer_name' => false]
        ]);
        $data = @file_get_contents($url, false, $ctx);
        if ($data !== false) {
            file_put_contents($localPath, $data);
        } else {
            return '';
        }
    }
    
    return $webPath;
}

/**
 * Clean WordPress content
 */
function cleanWordPressContent($content, $slug, $imageDir) {
    // Remove inline styles
    $content = preg_replace('/\s*style="[^"]*"/i', '', $content);
    
    // Remove class attributes
    $content = preg_replace('/\s*class="[^"]*"/i', '', $content);
    
    // Remove blogger legacy attributes
    $content = preg_replace('/\s*data-[a-z-]+="[^"]*"/i', '', $content);
    $content = preg_replace('/\s*border="[^"]*"/i', '', $content);
    $content = preg_replace('/\s*imageanchor="[^"]*"/i', '', $content);
    
    // Clean up span tags (remove them, keep content)
    $content = preg_replace('/<span[^>]*>/i', '', $content);
    $content = str_replace('</span>', '', $content);
    
    // Remove link-wrapped images (keep just the image)
    $content = preg_replace('/<a[^>]*>(<img[^>]+>)<\/a>/i', '$1', $content);
    
    // Clean up divs with separators
    $content = preg_replace('/<div[^>]*separator[^>]*>/i', '<figure>', $content);
    $content = preg_replace('/<div[^>]*>/i', '', $content);
    $content = str_replace('</div>', '', $content);
    
    // Fix images - ensure they have good attributes
    $content = preg_replace('/<img([^>]*)>/i', '<img$1 loading="lazy">', $content);
    $content = preg_replace('/loading="lazy"\s+loading="lazy"/', 'loading="lazy"', $content);
    
    // Clean up multiple line breaks
    $content = preg_replace('/<br\s*\/?>\s*<br\s*\/?>/i', '</p><p>', $content);
    $content = preg_replace('/<br\s*\/?>/i', '<br>', $content);
    
    // Clean up empty paragraphs
    $content = preg_replace('/<p>\s*<\/p>/i', '', $content);
    $content = preg_replace('/<p>\s*&nbsp;\s*<\/p>/i', '', $content);
    
    // Clean whitespace
    $content = preg_replace('/\s+/', ' ', $content);
    $content = preg_replace('/>\s+</', '><', $content);
    
    // Add paragraph wrapping for orphan text
    $content = preg_replace('/^([^<])/', '<p>$1', $content);
    $content = preg_replace('/([^>])$/', '$1</p>', $content);
    
    return trim($content);
}
