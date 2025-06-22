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
        Schema::create('sub_kategori_anggaran', function (Blueprint $table) {
            $table->id('id_sub_kategori_anggaran');

            $table->unsignedBigInteger('id_kategori_anggaran');
            $table->foreign('id_kategori_anggaran')->references('id_kategori_anggaran')->on('kategori_anggaran');
            
            $table->string('nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_kategori_anggaran');
    }
};
