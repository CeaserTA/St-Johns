<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$member = App\Models\Member::whereNotNull('profile_image')->first();

if ($member) {
    $imageUrl = $member->profile_image_url;
    echo "Testing image URL: " . $imageUrl . "\n\n";
    
    // Test if the URL is accessible
    $context = stream_context_create([
        'http' => [
            'timeout' => 10,
            'method' => 'HEAD'
        ]
    ]);
    
    $headers = @get_headers($imageUrl, 1, $context);
    
    if ($headers) {
        echo "Response: " . $headers[0] . "\n";
        
        if (strpos($headers[0], '200') !== false) {
            echo "✅ Image URL is accessible!\n";
            
            // Try to get the image size
            $imageInfo = @getimagesize($imageUrl);
            if ($imageInfo) {
                echo "Image dimensions: " . $imageInfo[0] . "x" . $imageInfo[1] . "\n";
                echo "Image type: " . $imageInfo['mime'] . "\n";
            }
        } else {
            echo "❌ Image URL returned error\n";
        }
    } else {
        echo "❌ Could not access image URL\n";
    }
} else {
    echo "No members with images found.\n";
}