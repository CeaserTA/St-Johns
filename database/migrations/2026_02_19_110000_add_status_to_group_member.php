<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('group_member', function (Blueprint $table) {
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('member_id');
            $table->unsignedBigInteger('approved_by')->nullable()->after('status');
            $table->timestamp('approved_at')->nullable()->after('approved_by');
            
            // Add foreign key for approved_by
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            
            // Add index for status queries
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::table('group_member', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropIndex(['status']);
            $table->dropColumn(['status', 'approved_by', 'approved_at']);
        });
    }
};
