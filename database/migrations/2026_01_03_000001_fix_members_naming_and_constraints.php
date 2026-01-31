<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Fix naming conventions (Issue #3)
            $table->renameColumn('fullname', 'full_name');
            $table->renameColumn('dateOfBirth', 'date_of_birth');
            $table->renameColumn('maritalStatus', 'marital_status');
            $table->renameColumn('dateJoined', 'date_joined');
            $table->renameColumn('profileImage', 'profile_image');
            
            // Data type improvements (Issue #10)
            $table->text('address')->change(); // Better for longer addresses
            $table->string('phone', 20)->change(); // Add length constraint
            
            // Add soft deletes (Issue #6)
            $table->softDeletes();
        });
        
        // Add indexes for performance (Issue #5)
        Schema::table('members', function (Blueprint $table) {
            $table->index('email');
            $table->index('cell');
            $table->index('date_joined');
            $table->index('marital_status');
        });
    }

    public function down(): void
    {
        Schema::table('members', function (Blueprint $table) {
            // Remove indexes
            $table->dropIndex(['email']);
            $table->dropIndex(['cell']);
            $table->dropIndex(['date_joined']);
            $table->dropIndex(['marital_status']);
            
            // Remove soft deletes
            $table->dropSoftDeletes();
        });
        
        Schema::table('members', function (Blueprint $table) {
            // Revert naming
            $table->renameColumn('full_name', 'fullname');
            $table->renameColumn('date_of_birth', 'dateOfBirth');
            $table->renameColumn('marital_status', 'maritalStatus');
            $table->renameColumn('date_joined', 'dateJoined');
            $table->renameColumn('profile_image', 'profileImage');
            
            // Revert data types
            $table->string('address')->change();
            $table->string('phone')->change();
        });
    }
};