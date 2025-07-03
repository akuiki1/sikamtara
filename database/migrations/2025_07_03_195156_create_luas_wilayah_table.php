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
            $table->decimal('luas', 10, 2)->comment('Luas wilayah dalam satuan Hektar (Ha)');
            $table->string('satuan')->default('Ha')->comment('Satuan luas wilayah, default adalah Hektar (Ha)');
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
