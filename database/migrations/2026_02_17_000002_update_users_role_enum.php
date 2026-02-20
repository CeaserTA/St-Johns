<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite doesn't support ENUM or MODIFY COLUMN
            // We need to recreate the table
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_temp')->default('member')->after('role');
            });
            
            DB::statement("UPDATE users SET role_temp = role");
            
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
            
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('role_temp', 'role');
            });
        } else {
            // MySQL/PostgreSQL
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin', 'member') DEFAULT 'member'");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $driver = DB::getDriverName();
        
        if ($driver === 'sqlite') {
            // SQLite doesn't support ENUM or MODIFY COLUMN
            Schema::table('users', function (Blueprint $table) {
                $table->string('role_temp')->default('user')->after('role');
            });
            
            DB::statement("UPDATE users SET role_temp = role");
            
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role');
            });
            
            Schema::table('users', function (Blueprint $table) {
                $table->renameColumn('role_temp', 'role');
            });
        } else {
            // MySQL/PostgreSQL
            DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('user', 'admin') DEFAULT 'user'");
        }
    }
};
