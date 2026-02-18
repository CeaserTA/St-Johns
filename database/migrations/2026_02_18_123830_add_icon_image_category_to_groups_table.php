<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            // Add new optional fields for group customization
            $table->string('icon')->nullable()->after('sort_order');
            $table->string('image_url')->nullable()->after('icon');
            $table->string('category')->nullable()->after('image_url');
            
            // Add indexes for performance on frequently queried columns
            $table->index('is_active');
            $table->index('sort_order');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('groups', function (Blueprint $table) {
            // Drop indexes first
            $table->dropIndex(['is_active']);
            $table->dropIndex(['sort_order']);
            
            // Drop columns
            $table->dropColumn(['icon', 'image_url', 'category']);
        });
    }
};
