<?php

// Simple test script to check member creation
require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Member;

try {
    echo "Testing member creation...\n";
    
    // Test data
    $testData = [
        'full_name' => 'Test User ' . time(),
        'date_of_birth' => '1990-01-01',
        'gender' => 'male',
        'marital_status' => 'single',
        'phone' => '+256700000000',
        'email' => 'test' . time() . '@example.com',
        'address' => 'Test Address',
        'date_joined' => date('Y-m-d'),
        'cell' => 'north',
    ];
    
    echo "Creating member with data:\n";
    print_r($testData);
    
    $member = Member::create($testData);
    
    echo "✅ Member created successfully!\n";
    echo "Member ID: " . $member->id . "\n";
    echo "Member Name: " . $member->full_name . "\n";
    
    // Test image URL methods
    echo "\nTesting image URL methods:\n";
    echo "Has profile image: " . ($member->hasProfileImage() ? 'Yes' : 'No') . "\n";
    echo "Profile image URL: " . $member->profile_image_url . "\n";
    echo "Default image URL: " . $member->default_profile_image_url . "\n";
    
} catch (Exception $e) {
    echo "❌ Error creating member:\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . ":" . $e->getLine() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}