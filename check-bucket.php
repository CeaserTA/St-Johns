<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== BUCKET INVESTIGATION ===\n\n";

try {
    $disk = Storage::disk('supabase');
    
    // Try different bucket configurations
    $buckets = ['profiles', 'profile', 'members', 'images', 'public'];
    
    foreach ($buckets as $bucket) {
        echo "Testing bucket: $bucket\n";
        
        // Test URL format 1: /object/public/bucket/path
        $url1 = "https://rjzjfexjmlqqnnqseqbs.supabase.co/storage/v1/object/public/$bucket/members/member_1770288318_698474be5207c.jpg";
        echo "URL 1: $url1\n";
        
        $headers1 = @get_headers($url1, 1);
        if ($headers1 && strpos($headers1[0], '200') !== false) {
            echo "✅ SUCCESS with bucket: $bucket\n";
            break;
        } else {
            echo "❌ Failed: " . ($headers1 ? $headers1[0] : 'No response') . "\n";
        }
        
        // Test URL format 2: /object/public/path (no bucket)
        $url2 = "https://rjzjfexjmlqqnnqseqbs.supabase.co/storage/v1/object/public/members/member_1770288318_698474be5207c.jpg";
        echo "URL 2: $url2\n";
        
        $headers2 = @get_headers($url2, 1);
        if ($headers2 && strpos($headers2[0], '200') !== false) {
            echo "✅ SUCCESS without bucket name\n";
            break;
        } else {
            echo "❌ Failed: " . ($headers2 ? $headers2[0] : 'No response') . "\n";
        }
        
        echo "---\n";
    }
    
    // Also try to list all buckets/directories
    echo "\nTrying to list root directories:\n";
    $rootFiles = $disk->directories('');
    foreach ($rootFiles as $dir) {
        echo "Directory: $dir\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}