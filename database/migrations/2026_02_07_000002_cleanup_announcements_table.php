<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * 
     * This migration drops the announcements table after data has been migrated to events.
     * Run this ONLY after confirming the data migration was successful.
     */
    public function up(): void
    {
        // Drop announcements table (data already migrated to events)
        Schema::dropIfExists('announcements');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate announcements table structure
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('message');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->timestamps();
            
            // Add indexes
            $table->index('created_by');
            $table->index('created_at');
            
            // Add foreign key
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
        });

        // Note: Data restoration would need to be done manually or via backup
        // as we can't reliably restore from events table in down() method
    }
};
