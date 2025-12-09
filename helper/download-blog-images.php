<?php
/**
 * Blog Image Downloader & Content Cleaner | NSheth Portfolio
 * Downloads images from blog posts and updates references to local paths
 * 
 * Run: php helper/download-blog-images.php
 */

$blogDir = __DIR__ . '/../blog';
$imageDir = __DIR__ . '/../assets/blog';

// Ensure image directory exists
if (!is_dir($imageDir)) {
    mkdir($imageDir, 0755, true);
}

// Get all blog JSON files
$files = glob($blogDir . '/*.json');

echo "Blog Image Downloader & Cleaner\n";
echo "================================\n\n";

$totalImages = 0;
$downloadedImages = 0;

foreach ($files as $file) {
    $json = file_get_contents($file);
    $post = json_decode($json, true);
    
    if (!$post) {
        echo "✗ Error parsing: " . basename($file) . "\n";
        continue;
    }
    
    echo "Processing: {$post['title']}\n";
    
    $content = $post['content'];
    $modified = false;
    
    // Find all images in content
    preg_match_all('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $matches);
    
    if (!empty($matches[1])) {
        foreach ($matches[1] as $imgUrl) {
            $totalImages++;
            
            // Skip already local images
            if (strpos($imgUrl, 'assets/blog/') !== false) {
                echo "  ↳ Already local: " . basename($imgUrl) . "\n";
                continue;
            }
            
            // Skip data URLs
            if (strpos($imgUrl, 'data:') === 0) {
                continue;
            }
            
            // Generate local filename from URL
            $urlParts = parse_url($imgUrl);
            $pathParts = pathinfo($urlParts['path'] ?? 'image.jpg');
            $extension = strtolower($pathParts['extension'] ?? 'jpg');
            
            // Validate extension
            if (!in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'])) {
                $extension = 'jpg';
            }
            
            // Create clean filename
            $baseName = preg_replace('/[^a-z0-9\-]/', '', strtolower($pathParts['filename'] ?? 'image'));
            $baseName = substr($baseName, 0, 50); // Limit length
            $localFilename = $post['slug'] . '-' . $baseName . '.' . $extension;
            $localPath = $imageDir . '/' . $localFilename;
            $webPath = 'assets/blog/' . $localFilename;
            
            // Download if not exists
            if (!file_exists($localPath)) {
                echo "  ↳ Downloading: " . $imgUrl . "\n";
                
                $ctx = stream_context_create([
                    'http' => [
                        'timeout' => 30,
                        'user_agent' => 'Mozilla/5.0 (compatible; BlogImageDownloader/1.0)'
                    ],
                    'ssl' => [
                        'verify_peer' => false,
                        'verify_peer_name' => false
                    ]
                ]);
                
                $imageData = @file_get_contents($imgUrl, false, $ctx);
                
                if ($imageData !== false) {
                    file_put_contents($localPath, $imageData);
                    echo "    ✓ Saved: {$localFilename}\n";
                    $downloadedImages++;
                } else {
                    echo "    ✗ Failed to download\n";
                    continue;
                }
            } else {
                echo "  ↳ Already downloaded: {$localFilename}\n";
            }
            
            // Update content with local path
            $content = str_replace($imgUrl, $webPath, $content);
            $modified = true;
        }
    }
    
    // Set featured image from first image in content
    if (empty($post['image'])) {
        preg_match('/<img[^>]+src=["\']([^"\']+)["\'][^>]*>/i', $content, $firstImg);
        if (!empty($firstImg[1]) && strpos($firstImg[1], 'assets/blog/') !== false) {
            $post['image'] = $firstImg[1];
            $modified = true;
            echo "  ↳ Set featured image: {$post['image']}\n";
        }
    }
    
    // Clean up content - remove excessive HTML
    $content = cleanBlogContent($content);
    
    if ($content !== $post['content']) {
        $modified = true;
    }
    
    // Save updated post
    if ($modified) {
        $post['content'] = $content;
        $jsonContent = json_encode($post, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        file_put_contents($file, $jsonContent);
        echo "  ✓ Updated JSON\n";
    }
    
    echo "\n";
}

echo "================================\n";
echo "Complete!\n";
echo "Total images found: {$totalImages}\n";
echo "Images downloaded: {$downloadedImages}\n";

/**
 * Clean blog content HTML
 */
function cleanBlogContent($content) {
    // Remove inline styles
    $content = preg_replace('/\s*style="[^"]*"/i', '', $content);
    
    // Remove class attributes
    $content = preg_replace('/\s*class="[^"]*"/i', '', $content);
    
    // Remove empty spans
    $content = preg_replace('/<span[^>]*>\s*<\/span>/i', '', $content);
    
    // Clean up nested divs (remove attributes)
    $content = preg_replace('/<div[^>]*>/i', '<div>', $content);
    
    // Remove separator divs
    $content = preg_replace('/<div>\s*<\/div>/i', '', $content);
    
    // Clean up image tags
    $content = preg_replace('/<img([^>]*)border="[^"]*"([^>]*)>/i', '<img$1$2>', $content);
    $content = preg_replace('/<img([^>]*)data-[a-z-]+="[^"]*"([^>]*)>/i', '<img$1$2>', $content);
    
    // Clean up anchor tags in images
    $content = preg_replace('/<a[^>]*imageanchor[^>]*>(<img[^>]+>)<\/a>/i', '$1', $content);
    
    // Remove empty paragraphs
    $content = preg_replace('/<p>\s*<\/p>/i', '', $content);
    $content = preg_replace('/<p>\s*<br\s*\/?>\s*<\/p>/i', '', $content);
    
    // Normalize line breaks
    $content = preg_replace('/<br\s*\/?>\s*<br\s*\/?>/i', '</p><p>', $content);
    
    // Clean whitespace
    $content = preg_replace('/\s+/', ' ', $content);
    $content = preg_replace('/>\s+</', '><', $content);
    
    // Add proper paragraph structure
    $content = preg_replace('/(<\/?(h[1-6]|ul|ol|li|pre|blockquote|div|figure)[^>]*>)/i', "\n$1\n", $content);
    
    return trim($content);
}
