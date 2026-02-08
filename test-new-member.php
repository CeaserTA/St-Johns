<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

// Test with member ID 107 (Martin Charles) who has a .jpg file
$member = App\Models\Member::find(107);

if ($member && $member->profile_image) {
    $imageUrl = $member->profile_image_url;
    echo "Testing member: " . $member->full_name . "\n";
    echo "Image path: " . $member->profile_image . "\n";
    echo "Image URL: " . $imageUrl . "\n\n";
    
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
    echo "Member 107 not found or has no image.\n";
}