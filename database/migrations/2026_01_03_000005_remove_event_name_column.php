<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            // Remove the redundant event_name column if it exists
            if (Schema::hasColumn('event_registrations', 'event_name')) {
                $table->dropColumn('event_name');
            }
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            // Add back the event_name column
            $table->string('event_name')->nullable()->after('event_id');
        });
    }
};