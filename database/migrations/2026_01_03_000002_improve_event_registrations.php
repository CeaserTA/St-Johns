<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            // Add foreign key constraint (Issue #1)
            $table->foreign('event_id')->references('id')->on('events')->onDelete('cascade');
            
            // Add member_id to support existing members (Issue #2)
            $table->foreignId('member_id')->nullable()->after('event_id')->constrained('members')->onDelete('cascade');
            
            // Rename existing columns to indicate they're for guests (Issue #2)
            $table->renameColumn('first_name', 'guest_first_name');
            $table->renameColumn('last_name', 'guest_last_name');
            $table->renameColumn('email', 'guest_email');
            $table->renameColumn('phone', 'guest_phone');
            
            // Make guest fields nullable since members will use member_id
            $table->string('guest_first_name')->nullable()->change();
            $table->string('guest_last_name')->nullable()->change();
        });
        
        // Add indexes for performance (Issue #5)
        Schema::table('event_registrations', function (Blueprint $table) {
            $table->index('event_id');
            $table->index('member_id');
            $table->index('guest_email');
        });
    }

    public function down(): void
    {
        Schema::table('event_registrations', function (Blueprint $table) {
            // Remove indexes
            $table->dropIndex(['event_id']);
            $table->dropIndex(['member_id']);
            $table->dropIndex(['guest_email']);
        });
        
        Schema::table('event_registrations', function (Blueprint $table) {
            // Remove foreign keys
            $table->dropForeign(['event_id']);
            $table->dropForeign(['member_id']);
            $table->dropColumn('member_id');
            
            // Revert column names
            $table->renameColumn('guest_first_name', 'first_name');
            $table->renameColumn('guest_last_name', 'last_name');
            $table->renameColumn('guest_email', 'email');
            $table->renameColumn('guest_phone', 'phone');
            
            // Make fields required again
            $table->string('first_name')->nullable(false)->change();
            $table->string('last_name')->nullable(false)->change();
        });
    }
};