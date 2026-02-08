<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Note: Events table improvements moved to 2026_02_07_000001_merge_announcements_into_events.php
        // This migration now only handles services and groups improvements
        
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
        
        // Note: Announcements table improvements removed - announcements merged into events table
        // See migration: 2026_02_07_000001_merge_announcements_into_events.php
    }

    public function down(): void
    {
        // Note: Events rollback moved to 2026_02_07_000001_merge_announcements_into_events.php
        
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
        
        // Note: Announcements rollback removed - see 2026_02_07_000001_merge_announcements_into_events.php
    }
};