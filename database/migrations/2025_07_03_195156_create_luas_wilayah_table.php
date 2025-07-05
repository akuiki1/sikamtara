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
        Schema::create('luas_wilayah', function (Blueprint $table) {
            $table->id();
            $table->decimal('luas', 10, 2)->comment('Luas wilayah dalam satuan Hektar (Km)');
            $table->string('satuan')->default('Km')->comment('Satuan luas wilayah, default adalah Kilometer (Km)');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('luas_wilayah');
    }
};
