<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->decimal('fee', 10, 2)->default(0)->after('schedule');
            $table->boolean('is_free')->default(true)->after('fee');
            $table->string('currency', 3)->default('UGX')->after('is_free');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn(['fee', 'is_free', 'currency']);
        });
    }
};
