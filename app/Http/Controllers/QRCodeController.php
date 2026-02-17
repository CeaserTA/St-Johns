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
                    $contentType = 'image/png';
                } catch (\Exception $pngError) {
                    // Fallback to SVG if PNG fails (missing imagick extension)
                    $qrCode = QrCode::format('svg')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'member_registration_' . Str::slug($title) . '_' . time() . '.svg';
                    $contentType = 'image/svg+xml';
                    $format = 'svg'; // Update format for response
                }
            } else {
                $qrCode = QrCode::format('svg')
                    ->size($size)
                    ->margin(2)
                    ->generate($url);
                
                $filename = 'member_registration_' . Str::slug($title) . '_' . time() . '.svg';
                $contentType = 'image/svg+xml';
            }

            // Store the QR code temporarily for download
            Storage::disk('public')->put('qr-codes/' . $filename, $qrCode);

            return response()->json([
                'success' => true,
                'message' => 'QR Code generated successfully',
                'qr_code' => $qrCode,
                'download_url' => route('qr-codes.download', ['filename' => $filename]),
                'preview_url' => asset('storage/qr-codes/' . $filename),
                'target_url' => $url,
                'title' => $title,
                'description' => $description,
                'format' => $format,
                'size' => $size
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
                    $contentType = 'image/png';
                } catch (\Exception $pngError) {
                    // Fallback to SVG if PNG fails (missing imagick extension)
                    $qrCode = QrCode::format('svg')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'event_' . $event->id . '_' . Str::slug($event->title) . '_' . time() . '.svg';
                    $contentType = 'image/svg+xml';
                    $format = 'svg'; // Update format for response
                }
            } else {
                $qrCode = QrCode::format('svg')
                    ->size($size)
                    ->margin(2)
                    ->generate($url);
                
                $filename = 'event_' . $event->id . '_' . Str::slug($event->title) . '_' . time() . '.svg';
                $contentType = 'image/svg+xml';
            }

            // Store the QR code temporarily for download
            Storage::disk('public')->put('qr-codes/' . $filename, $qrCode);

            return response()->json([
                'success' => true,
                'message' => 'QR Code generated successfully',
                'qr_code' => $qrCode,
                'download_url' => route('qr-codes.download', ['filename' => $filename]),
                'preview_url' => asset('storage/qr-codes/' . $filename),
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
                'size' => $size
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
                    $contentType = 'image/png';
                } catch (\Exception $pngError) {
                    // Fallback to SVG if PNG fails (missing imagick extension)
                    $qrCode = QrCode::format('svg')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'giving_' . Str::slug($title) . '_' . time() . '.svg';
                    $contentType = 'image/svg+xml';
                    $format = 'svg'; // Update format for response
                }
            } else {
                $qrCode = QrCode::format('svg')
                    ->size($size)
                    ->margin(2)
                    ->generate($url);
                
                $filename = 'giving_' . Str::slug($title) . '_' . time() . '.svg';
                $contentType = 'image/svg+xml';
            }

            // Store the QR code temporarily for download
            Storage::disk('public')->put('qr-codes/' . $filename, $qrCode);

            return response()->json([
                'success' => true,
                'message' => 'QR Code generated successfully',
                'qr_code' => $qrCode,
                'download_url' => route('qr-codes.download', ['filename' => $filename]),
                'preview_url' => asset('storage/qr-codes/' . $filename),
                'target_url' => $url,
                'title' => $title,
                'description' => $description,
                'format' => $format,
                'size' => $size
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
                    $contentType = 'image/png';
                } catch (\Exception $pngError) {
                    // Fallback to SVG if PNG fails (missing imagick extension)
                    $qrCode = QrCode::format('svg')
                        ->size($size)
                        ->margin(2)
                        ->generate($url);
                    
                    $filename = 'custom_' . Str::slug($title) . '_' . time() . '.svg';
                    $contentType = 'image/svg+xml';
                    $format = 'svg'; // Update format for response
                }
            } else {
                $qrCode = QrCode::format('svg')
                    ->size($size)
                    ->margin(2)
                    ->generate($url);
                
                $filename = 'custom_' . Str::slug($title) . '_' . time() . '.svg';
                $contentType = 'image/svg+xml';
            }

            // Store the QR code temporarily for download
            Storage::disk('public')->put('qr-codes/' . $filename, $qrCode);

            return response()->json([
                'success' => true,
                'message' => 'QR Code generated successfully',
                'qr_code' => $qrCode,
                'download_url' => route('qr-codes.download', ['filename' => $filename]),
                'preview_url' => asset('storage/qr-codes/' . $filename),
                'target_url' => $url,
                'title' => $title,
                'description' => $description,
                'format' => $format,
                'size' => $size
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
        
        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'QR Code not found');
        }

        $file = Storage::disk('public')->get($path);
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
            $files = Storage::disk('public')->files('qr-codes');
            $deletedCount = 0;
            
            foreach ($files as $file) {
                $lastModified = Storage::disk('public')->lastModified($file);
                
                // Delete files older than 24 hours
                if ($lastModified < (time() - 86400)) {
                    Storage::disk('public')->delete($file);
                    $deletedCount++;
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => "Cleaned up {$deletedCount} old QR code files"
            ]);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error during cleanup: ' . $e->getMessage()
            ], 500);
        }
    }
}