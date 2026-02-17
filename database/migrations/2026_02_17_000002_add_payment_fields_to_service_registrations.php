<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_registrations', function (Blueprint $table) {
            $table->decimal('amount_paid', 10, 2)->default(0)->after('guest_phone');
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'refunded'])->default('pending')->after('amount_paid');
            $table->string('payment_method')->nullable()->after('payment_status'); // mobile_money, card, cash, bank_transfer
            $table->string('transaction_reference')->nullable()->after('payment_method');
            $table->timestamp('paid_at')->nullable()->after('transaction_reference');
            $table->text('payment_notes')->nullable()->after('paid_at'); // Admin notes about payment
        });
    }

    public function down(): void
    {
        Schema::table('service_registrations', function (Blueprint $table) {
            $table->dropColumn([
                'amount_paid',
                'payment_status',
                'payment_method',
                'transaction_reference',
                'paid_at',
                'payment_notes'
            ]);
        });
    }
};
