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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('fullname');
            $table->date('dateOfBirth');
            $table->enum('gender', ['male', 'female']);
            $table->enum('maritalStatus', ['single', 'married', 'divorced', 'widowed']);
            $table->string('phone');
            $table->string('email')->unique();
            $table->string('address');
            $table->date('dateJoined');
            
            $table->enum('cell', ['north', 'east', 'south', 'west']);
            // image upload field
            $table->string('profileImage')->nullable();
            $table->timestamps();
        });
    }

    
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
