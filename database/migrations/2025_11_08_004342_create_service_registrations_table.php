<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('service_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('email');
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->enum('service', ['Counseling', 'Baptism', 'Youth Retreat']);
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('service_registrations');
    }
};