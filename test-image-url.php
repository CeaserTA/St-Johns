<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Member;

$member = Member::whereNotNull('profile_image')->first();

if ($member) {
    echo "Member: " . $member->full_name . "\n";
    echo "Image Path: " . $member->profile_image . "\n";
    echo "Image URL: " . $member->profile_image_url . "\n";
    echo "APP_URL: " . config('app.url') . "\n";
    
    // Test the actual URL
    $imageUrl = $member->profile_image_url;
    echo "Testing URL: " . $imageUrl . "\n";
    
    // Check if we can access the file via HTTP
    $context = stream_context_create([
        'http' => [
            'timeout' => 5,
            'method' => 'HEAD'
        ]
    ]);
    
    $headers = @get_headers($imageUrl, 1, $context);
    if ($headers && strpos($headers[0], '200') !== false) {
        echo "✅ Image URL is accessible!\n";
    } else {
        echo "❌ Image URL is not accessible\n";
        echo "Response: " . ($headers ? $headers[0] : 'No response') . "\n";
    }
} else {
    echo "No members with images found.\n";
}