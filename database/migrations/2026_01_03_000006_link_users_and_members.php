<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Add user_id to link members to user accounts
            $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->onDelete('set null');
            
            // Add index for performance
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Remove the foreign key and index
            $table->dropForeign(['user_id']);
            $table->dropIndex(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};