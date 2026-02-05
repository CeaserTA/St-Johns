<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Member;

echo "=== CHECKING MEMBER IMAGES ===\n\n";

// Get members with images
$members = Member::whereNotNull('profile_image')->latest()->take(5)->get(['id', 'full_name', 'profile_image']);

if ($members->count() > 0) {
    echo "Found " . $members->count() . " members with images:\n\n";
    
    foreach ($members as $member) {
        echo "ID: " . $member->id . "\n";
        echo "Name: " . $member->full_name . "\n";
        echo "Image Path: " . $member->profile_image . "\n";
        echo "Profile Image URL: " . $member->profile_image_url . "\n";
        echo "Has Profile Image: " . ($member->hasProfileImage() ? 'Yes' : 'No') . "\n";
        
        // Check if file exists
        $fullPath = storage_path('app/public/' . $member->profile_image);
        echo "Full File Path: " . $fullPath . "\n";
        echo "File Exists: " . (file_exists($fullPath) ? 'Yes' : 'No') . "\n";
        
        if (file_exists($fullPath)) {
            echo "File Size: " . number_format(filesize($fullPath) / 1024, 2) . " KB\n";
        }
        
        echo "Expected URL: " . asset('storage/' . $member->profile_image) . "\n";
        echo "---\n\n";
    }
} else {
    echo "No members with images found.\n";
}

// Check storage link
$publicStoragePath = public_path('storage');
echo "=== STORAGE LINK CHECK ===\n";
echo "Public storage path: " . $publicStoragePath . "\n";
echo "Storage link exists: " . (is_link($publicStoragePath) || is_dir($publicStoragePath) ? 'Yes' : 'No') . "\n";

if (is_dir($publicStoragePath)) {
    $membersDir = $publicStoragePath . '/members';
    echo "Members directory exists: " . (is_dir($membersDir) ? 'Yes' : 'No') . "\n";
    
    if (is_dir($membersDir)) {
        $files = glob($membersDir . '/*');
        echo "Files in members directory: " . count($files) . "\n";
        
        if (count($files) > 0) {
            echo "Sample files:\n";
            foreach (array_slice($files, 0, 3) as $file) {
                echo "  - " . basename($file) . " (" . number_format(filesize($file) / 1024, 2) . " KB)\n";
            }
        }
    }
}