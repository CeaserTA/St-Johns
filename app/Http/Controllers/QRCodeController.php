<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Event;
use App\Models\Service;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QRCodeController extends Controller
{
    /**
     * Display the QR code management dashboard
     */
    public function index()
    {
        $events = Event::where('date', '>=', now())->orderBy('date')->get();
        $services = Service::orderBy('name')->get();
        
        return view('admin.qr-codes.index', compact('events', 'services'));
    }

    /**
     * Helper method to store QR code on Supabase with fallback
     */
    private function storeQRCode($qrCodeContent, $filename)
    {
        try {
            // Try to upload to Supabase first
            Storage::disk('supabase')->put('qr-codes/' . $filename, $qrCodeContent);
            
            \Log::info('QR code uploaded to Supabase successfully', ['filename' => $filename]);
            
            return [
                'success' => true,
                'path' => 'qr-codes/' . $filename,
                'storage' => 'supabase'
            ];
            
        } catch (\Exception $e) {
            \Log::error('Error uploading QR code to Supabase', [
                'error' => $e->getMessage(),
                'filename' => $filename
            ]);
            
            // Fall back to local storage if Supabase fails
            try {
                Storage::disk('public')->put('qr-codes/' . $filename, $qrCodeContent);
                \Log::info('QR code uploaded to local storage as fallback', ['filename' => $filename]);
                
                return [
                    'success' => true,
                    'path' => 'qr-codes/' . $filename,
                    'storage' => 'local'
                ];
            } catch (\Exception $localError) {
                \Log::error('Both Supabase and local storage failed for QR code', [
                    'supabase_error' => $e->getMessage(),
                    'local_error' => $localError->getMessage()
                ]);
                
                return [
                    'success' => false,
                    'error' => 'Failed to store QR code'
                ];
            }
        }
    }

    /**
     * Helper method to get QR code URL
     */
    private function getQRCodeUrl($path, $storage = 'supabase')
    {
        if ($storage === 'supabase') {
            $supabaseUrl = env('SUPABASE_PUBLIC_URL');
            $bucket = env('SUPABASE_BUCKET', 'profiles');
            
            if ($supabaseUrl && $bucket) {
                return "{$supabaseUrl}/{$bucket}/{$path}";
            }
        }
        
        // Fallback to local storage URL
        return asset('storage/' . $path);
    }

    /**
     * Generate QR code for member registration
     */
    public function generateMemberRegistration(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'size' => 'nullable|integer|min:100|max:1000',
            'format' => 'nullable|in:png,svg',
        ]);

        $url = route('members.create');
        $size = $request->input('size', 300);
        $format = $request->input('format', 'png');
        $title = $request->input('title', 'Join Our Church');
        $description = $request->input('description', 'Scan to register as a member');

        try {
            // Use SVG format by default since it doesn't require additional extensions
            if ($format === 'png') {
                try {
                    $qrCode = QrCode::format('png')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'member_registration_' . Str::slug($title) . '_' . time() . '.png';
                } catch (\Exception $pngError) {
                    // Fallback to SVG if PNG fails (missing imagick extension)
                    $qrCode = QrCode::format('svg')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'member_registration_' . Str::slug($title) . '_' . time() . '.svg';
                    $format = 'svg'; // Update format for response
                }
            } else {
                $qrCode = QrCode::format('svg')
                    ->size($size)
                    ->margin(2)
                    ->generate($url);
                
                $filename = 'member_registration_' . Str::slug($title) . '_' . time() . '.svg';
            }

            // Store the QR code on Supabase
            $storageResult = $this->storeQRCode($qrCode, $filename);
            
            if (!$storageResult['success']) {
                throw new \Exception($storageResult['error']);
            }

            $previewUrl = $this->getQRCodeUrl($storageResult['path'], $storageResult['storage']);

            return response()->json([
                'success' => true,
                'message' => 'QR Code generated successfully',
                'qr_code' => $qrCode,
                'download_url' => route('qr-codes.download', ['filename' => $filename]),
                'preview_url' => $previewUrl,
                'target_url' => $url,
                'title' => $title,
                'description' => $description,
                'format' => $format,
                'size' => $size,
                'storage' => $storageResult['storage']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating QR code: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate QR code for event registration
     */
    public function generateEventRegistration(Request $request)
    {
        $request->validate([
            'event_id' => 'required|exists:events,id',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:500',
            'size' => 'nullable|integer|min:100|max:1000',
            'format' => 'nullable|in:png,svg',
        ]);

        $event = Event::findOrFail($request->event_id);
        $url = route('updates') . '?register=' . $event->id;
        $size = $request->input('size', 300);
        $format = $request->input('format', 'png');
        $title = $request->input('title', 'Register for ' . $event->title);
        $description = $request->input('description', 'Scan to register for this event');

        try {
            // Use SVG format by default since it doesn't require additional extensions
            if ($format === 'png') {
                try {
                    $qrCode = QrCode::format('png')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'event_' . $event->id . '_' . Str::slug($event->title) . '_' . time() . '.png';
                } catch (\Exception $pngError) {
                    // Fallback to SVG if PNG fails (missing imagick extension)
                    $qrCode = QrCode::format('svg')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'event_' . $event->id . '_' . Str::slug($event->title) . '_' . time() . '.svg';
                    $format = 'svg'; // Update format for response
                }
            } else {
                $qrCode = QrCode::format('svg')
                    ->size($size)
                    ->margin(2)
                    ->generate($url);
                
                $filename = 'event_' . $event->id . '_' . Str::slug($event->title) . '_' . time() . '.svg';
            }

            // Store the QR code on Supabase
            $storageResult = $this->storeQRCode($qrCode, $filename);
            
            if (!$storageResult['success']) {
                throw new \Exception($storageResult['error']);
            }

            $previewUrl = $this->getQRCodeUrl($storageResult['path'], $storageResult['storage']);

            return response()->json([
                'success' => true,
                'message' => 'QR Code generated successfully',
                'qr_code' => $qrCode,
                'download_url' => route('qr-codes.download', ['filename' => $filename]),
                'preview_url' => $previewUrl,
                'target_url' => $url,
                'event' => [
                    'id' => $event->id,
                    'title' => $event->title,
                    'date' => $event->date,
                    'location' => $event->location
                ],
                'title' => $title,
                'description' => $description,
                'format' => $format,
                'size' => $size,
                'storage' => $storageResult['storage']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating QR code: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate QR code for giving/donations
     */
    public function generateGiving(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'size' => 'nullable|integer|min:100|max:1000',
            'format' => 'nullable|in:png,svg',
        ]);

        $url = route('giving.index');
        $size = $request->input('size', 300);
        $format = $request->input('format', 'png');
        $title = $request->input('title', 'Give to Our Church');
        $description = $request->input('description', 'Scan to make a donation or tithe');

        try {
            // Use SVG format by default since it doesn't require additional extensions
            if ($format === 'png') {
                try {
                    $qrCode = QrCode::format('png')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'giving_' . Str::slug($title) . '_' . time() . '.png';
                } catch (\Exception $pngError) {
                    // Fallback to SVG if PNG fails (missing imagick extension)
                    $qrCode = QrCode::format('svg')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'giving_' . Str::slug($title) . '_' . time() . '.svg';
                    $format = 'svg'; // Update format for response
                }
            } else {
                $qrCode = QrCode::format('svg')
                    ->size($size)
                    ->margin(2)
                    ->generate($url);
                
                $filename = 'giving_' . Str::slug($title) . '_' . time() . '.svg';
            }

            // Store the QR code on Supabase
            $storageResult = $this->storeQRCode($qrCode, $filename);
            
            if (!$storageResult['success']) {
                throw new \Exception($storageResult['error']);
            }

            $previewUrl = $this->getQRCodeUrl($storageResult['path'], $storageResult['storage']);

            return response()->json([
                'success' => true,
                'message' => 'QR Code generated successfully',
                'qr_code' => $qrCode,
                'download_url' => route('qr-codes.download', ['filename' => $filename]),
                'preview_url' => $previewUrl,
                'target_url' => $url,
                'title' => $title,
                'description' => $description,
                'format' => $format,
                'size' => $size,
                'storage' => $storageResult['storage']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating QR code: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Generate custom QR code for any URL
     */
    public function generateCustom(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'size' => 'nullable|integer|min:100|max:1000',
            'format' => 'nullable|in:png,svg',
        ]);

        $url = $request->input('url');
        $size = $request->input('size', 300);
        $format = $request->input('format', 'png');
        $title = $request->input('title');
        $description = $request->input('description', 'Scan to visit this link');

        try {
            // Use SVG format by default since it doesn't require additional extensions
            if ($format === 'png') {
                try {
                    $qrCode = QrCode::format('png')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'custom_' . Str::slug($title) . '_' . time() . '.png';
                } catch (\Exception $pngError) {
                    // Fallback to SVG if PNG fails (missing imagick extension)
                    $qrCode = QrCode::format('svg')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'custom_' . Str::slug($title) . '_' . time() . '.svg';
                    $format = 'svg'; // Update format for response
                }
            } else {
                $qrCode = QrCode::format('svg')
                    ->size($size)
                    ->margin(2)
                    ->generate($url);
                
                $filename = 'custom_' . Str::slug($title) . '_' . time() . '.svg';
            }

            // Store the QR code on Supabase
            $storageResult = $this->storeQRCode($qrCode, $filename);
            
            if (!$storageResult['success']) {
                throw new \Exception($storageResult['error']);
            }

            $previewUrl = $this->getQRCodeUrl($storageResult['path'], $storageResult['storage']);

            return response()->json([
                'success' => true,
                'message' => 'QR Code generated successfully',
                'qr_code' => $qrCode,
                'download_url' => route('qr-codes.download', ['filename' => $filename]),
                'preview_url' => $previewUrl,
                'target_url' => $url,
                'title' => $title,
                'description' => $description,
                'format' => $format,
                'size' => $size,
                'storage' => $storageResult['storage']
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error generating QR code: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Download a generated QR code
     */
    public function download($filename)
    {
        $path = 'qr-codes/' . $filename;
        $file = null;
        
        // Try Supabase first
        try {
            if (Storage::disk('supabase')->exists($path)) {
                $file = Storage::disk('supabase')->get($path);
                \Log::info('QR code downloaded from Supabase', ['filename' => $filename]);
            }
        } catch (\Exception $e) {
            \Log::warning('Error checking Supabase for QR code download', [
                'filename' => $filename,
                'error' => $e->getMessage()
            ]);
        }
        
        // Fallback to local storage
        if (!$file && Storage::disk('public')->exists($path)) {
            $file = Storage::disk('public')->get($path);
            \Log::info('QR code downloaded from local storage', ['filename' => $filename]);
        }
        
        if (!$file) {
            abort(404, 'QR Code not found');
        }

        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $contentType = $extension === 'svg' ? 'image/svg+xml' : 'image/png';
        
        return response($file)
            ->header('Content-Type', $contentType)
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Clean up old QR code files (can be called via cron job)
     */
    public function cleanup()
    {
        try {
            $deletedCount = 0;
            
            // Clean up Supabase storage
            try {
                $supabaseFiles = Storage::disk('supabase')->files('qr-codes');
                
                foreach ($supabaseFiles as $file) {
                    try {
                        $lastModified = Storage::disk('supabase')->lastModified($file);
                        
                        // Delete files older than 24 hours
                        if ($lastModified < (time() - 86400)) {
                            Storage::disk('supabase')->delete($file);
                            $deletedCount++;
                            \Log::info('Deleted old QR code from Supabase', ['file' => $file]);
                        }
                    } catch (\Exception $fileError) {
                        \Log::warning('Error processing Supabase file during cleanup', [
                            'file' => $file,
                            'error' => $fileError->getMessage()
                        ]);
                    }
                }
            } catch (\Exception $supabaseError) {
                \Log::warning('Error accessing Supabase during cleanup', [
                    'error' => $supabaseError->getMessage()
                ]);
            }
            
            // Clean up local storage
            try {
                $localFiles = Storage::disk('public')->files('qr-codes');
                
                foreach ($localFiles as $file) {
                    try {
                        $lastModified = Storage::disk('public')->lastModified($file);
                        
                        // Delete files older than 24 hours
                        if ($lastModified < (time() - 86400)) {
                            Storage::disk('public')->delete($file);
                            $deletedCount++;
                            \Log::info('Deleted old QR code from local storage', ['file' => $file]);
                        }
                    } catch (\Exception $fileError) {
                        \Log::warning('Error processing local file during cleanup', [
                            'file' => $file,
                            'error' => $fileError->getMessage()
                        ]);
                    }
                }
            } catch (\Exception $localError) {
                \Log::warning('Error accessing local storage during cleanup', [
                    'error' => $localError->getMessage()
                ]);
            }
            
            return response()->json([
                'success' => true,
                'message' => "Cleaned up {$deletedCount} old QR code files from both Supabase and local storage"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error during cleanup: ' . $e->getMessage()
            ], 500);
        }
    }
}