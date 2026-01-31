<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Improve events table
        Schema::table('events', function (Blueprint $table) {
            // Add soft deletes (Issue #6)
            $table->softDeletes();
        });
        
        // Add indexes to events (Issue #5)
        Schema::table('events', function (Blueprint $table) {
            $table->index('date');
            $table->index(['date', 'time']); // Composite index for datetime queries
            $table->index('title');
        });
        
        // Improve services table
        Schema::table('services', function (Blueprint $table) {
            // Add soft deletes (Issue #6)
            $table->softDeletes();
            // Add index (Issue #5)
            $table->index('name');
        });
        
        // Improve groups table
        Schema::table('groups', function (Blueprint $table) {
            // Add soft deletes (Issue #6)
            $table->softDeletes();
        });
        
        // Add indexes to groups (Issue #5)
        Schema::table('groups', function (Blueprint $table) {
            $table->index('name');
            $table->index('meeting_day');
        });
        
        // Improve announcements table
        Schema::table('announcements', function (Blueprint $table) {
            // Add foreign key constraint (Issue #1)
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            // Add soft deletes (Issue #6)
            $table->softDeletes();
        });
        
        // Add indexes to announcements (Issue #5)
        Schema::table('announcements', function (Blueprint $table) {
            $table->index('created_by');
            $table->index('created_at');
            $table->index('title');
        });
    }

    public function down(): void
    {
        // Remove indexes from events
        Schema::table('events', function (Blueprint $table) {
            $table->dropIndex(['date']);
            $table->dropIndex(['date', 'time']);
            $table->dropIndex(['title']);
            $table->dropSoftDeletes();
        });
        
        // Remove improvements from services
        Schema::table('services', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropSoftDeletes();
        });
        
        // Remove improvements from groups
        Schema::table('groups', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['meeting_day']);
            $table->dropSoftDeletes();
        });
        
        // Remove improvements from announcements
        Schema::table('announcements', function (Blueprint $table) {
            $table->dropIndex(['created_by']);
            $table->dropIndex(['created_at']);
            $table->dropIndex(['title']);
            $table->dropSoftDeletes();
            $table->dropForeign(['created_by']);
        });
    }
};