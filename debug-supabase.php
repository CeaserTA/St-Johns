<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== SUPABASE DEBUG ===\n\n";

// Check configuration
echo "1. SUPABASE CONFIGURATION:\n";
echo "Endpoint: " . config('filesystems.disks.supabase.endpoint') . "\n";
echo "Bucket: " . config('filesystems.disks.supabase.bucket') . "\n";
echo "Public URL: " . config('filesystems.disks.supabase.url') . "\n";
echo "Has Access Key: " . (!empty(config('filesystems.disks.supabase.key')) ? 'Yes' : 'No') . "\n";
echo "Has Secret Key: " . (!empty(config('filesystems.disks.supabase.secret')) ? 'Yes' : 'No') . "\n\n";

// Test connection
echo "2. CONNECTION TEST:\n";
try {
    $disk = Storage::disk('supabase');
    echo "✅ Disk instance created successfully\n";
    
    // Try to list files
    $files = $disk->files('members');
    echo "✅ Successfully listed files in 'members' directory\n";
    echo "Files found: " . count($files) . "\n";
    
    if (count($files) > 0) {
        echo "Sample files:\n";
        foreach (array_slice($files, 0, 3) as $file) {
            echo "  - " . $file . "\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Connection failed: " . $e->getMessage() . "\n";
    echo "Error details: " . $e->getTraceAsString() . "\n";
}

echo "\n3. RECENT MEMBERS WITH IMAGES:\n";
try {
    $members = App\Models\Member::whereNotNull('profile_image')->latest()->take(3)->get(['id', 'full_name', 'profile_image']);
    
    if ($members->count() > 0) {
        foreach ($members as $member) {
            echo "ID: " . $member->id . "\n";
            echo "Name: " . $member->full_name . "\n";
            echo "Image Path: " . $member->profile_image . "\n";
            echo "Generated URL: " . $member->profile_image_url . "\n";
            echo "---\n";
        }
    } else {
        echo "No members with images found.\n";
    }
} catch (Exception $e) {
    echo "❌ Error checking members: " . $e->getMessage() . "\n";
}

echo "\n4. UPLOAD TEST:\n";
try {
    $disk = Storage::disk('supabase');
    $testContent = 'Test upload - ' . date('Y-m-d H:i:s');
    $testFile = 'test_' . time() . '.txt';
    
    $result = $disk->put('members/' . $testFile, $testContent);
    
    if ($result) {
        echo "✅ Test file uploaded successfully\n";
        echo "File path: members/" . $testFile . "\n";
        
        // Try to read it back
        $content = $disk->get('members/' . $testFile);
        echo "✅ Test file read successfully: " . $content . "\n";
        
        // Clean up
        $disk->delete('members/' . $testFile);
        echo "✅ Test file deleted\n";
    } else {
        echo "❌ Test file upload failed\n";
    }
    
} catch (Exception $e) {
    echo "❌ Upload test failed: " . $e->getMessage() . "\n";
}