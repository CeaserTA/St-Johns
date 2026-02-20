<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'price') && !Schema::hasColumn('services', 'fee')) {
                $table->renameColumn('price', 'fee');
            }
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            if (Schema::hasColumn('services', 'fee') && !Schema::hasColumn('services', 'price')) {
                $table->renameColumn('fee', 'price');
            }
        });
    }
};
