<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('givings')) {
            return;
        }

        Schema::create('givings', function (Blueprint $table) {
            $table->id();
            
            // Giver Information (supports both members and guests)
            $table->foreignId('member_id')->nullable()->constrained('members')->onDelete('set null');
            $table->string('guest_name')->nullable(); // For non-members
            $table->string('guest_email')->nullable(); // For receipts to guests
            $table->string('guest_phone')->nullable(); // Contact for guests
            
            // Giving Details
            $table->enum('giving_type', ['tithe', 'offering', 'donation', 'special_offering'])->default('offering');
            $table->decimal('amount', 10, 2); // Up to 99,999,999.99
            $table->string('currency', 3)->default('UGX'); // ISO currency code
            $table->text('purpose')->nullable(); // What the giving is for (building fund, missions, etc.)
            $table->text('notes')->nullable(); // Additional notes from giver
            
            // Payment Information
            $table->enum('payment_method', ['cash', 'mobile_money', 'bank_transfer', 'card', 'check'])->default('cash');
            $table->string('transaction_reference')->nullable(); // Mobile money/bank reference
            $table->string('payment_provider')->nullable(); // MTN, Airtel, Bank name, etc.
            $table->string('payment_account')->nullable(); // Phone number or account used
            
            // Transaction Status & Tracking
            $table->enum('status', ['pending', 'completed', 'failed', 'cancelled'])->default('pending');
            $table->timestamp('payment_date')->nullable(); // When payment was made
            $table->timestamp('confirmed_at')->nullable(); // When admin confirmed
            $table->foreignId('confirmed_by')->nullable()->constrained('users')->onDelete('set null');
            
            // Financial Accountability
            $table->string('receipt_number')->unique()->nullable(); // Generated receipt number
            $table->boolean('receipt_sent')->default(false); // Track if receipt was sent
            $table->decimal('processing_fee', 8, 2)->nullable(); // Any processing fees
            $table->decimal('net_amount', 10, 2)->nullable(); // Amount after fees
            
            // Audit Trail
            $table->ipAddress('ip_address')->nullable(); // For security tracking
            $table->text('user_agent')->nullable(); // Browser/device info
            $table->json('metadata')->nullable(); // Additional data (payment gateway response, etc.)
            
            // Standard Laravel timestamps
            $table->timestamps();
            $table->softDeletes(); // For financial records, never hard delete
            
            // Indexes for performance
            $table->index('member_id');
            $table->index('giving_type');
            $table->index('payment_method');
            $table->index('status');
            $table->index('payment_date');
            $table->index('confirmed_at');
            $table->index('receipt_number');
            $table->index(['giving_type', 'status']); // Composite index
            $table->index(['member_id', 'giving_type']); // Member giving history
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('givings');
    }
};