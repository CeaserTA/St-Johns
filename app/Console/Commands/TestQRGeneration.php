<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class TestQRGeneration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:qr-generation';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test QR code generation functionality';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Testing QR Code Generation...');
        $this->newLine();

        try {
            // Test basic QR code generation with SVG (no additional extensions required)
            $url = 'https://example.com/test';
            
            // Generate SVG QR code
            $svgQrCode = QrCode::format('svg')
                ->size(300)
                ->margin(2)
                ->generate($url);
            
            $this->info('✅ SVG QR Code generated successfully');
            $this->line('Size: ' . strlen($svgQrCode) . ' bytes');
            $this->newLine();
            
            // Test with different URLs
            $memberUrl = config('app.url') . '/members/create';
            $givingUrl = config('app.url') . '/give';
            $eventUrl = config('app.url') . '/events?register=1';
            
            $memberQr = QrCode::format('svg')->size(200)->generate($memberUrl);
            $givingQr = QrCode::format('svg')->size(200)->generate($givingUrl);
            $eventQr = QrCode::format('svg')->size(200)->generate($eventUrl);
            
            $this->info('✅ Member registration QR code: ' . strlen($memberQr) . ' bytes');
            $this->info('✅ Giving QR code: ' . strlen($givingQr) . ' bytes');
            $this->info('✅ Event registration QR code: ' . strlen($eventQr) . ' bytes');
            $this->newLine();
            
            // Test storage
            Storage::disk('public')->put('qr-codes/test-member.svg', $memberQr);
            Storage::disk('public')->put('qr-codes/test-giving.svg', $givingQr);
            Storage::disk('public')->put('qr-codes/test-event.svg', $eventQr);
            
            $this->info('✅ QR codes saved to storage successfully');
            $this->newLine();
            
            $this->info('🎉 All QR code generation tests passed!');
            $this->info('The QR code package is working correctly.');
            $this->info('Note: Using SVG format since PNG requires imagick extension.');
            
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            $this->line('Stack trace:');
            $this->line($e->getTraceAsString());
            
            return Command::FAILURE;
        }
    }
}
