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
        Schema::create('rincian_anggaran', function (Blueprint $table) {
            $table->id('id_rincian_anggaran');
            
            $table->unsignedBigInteger('id_sub_kategori_anggaran');
            $table->foreign('id_sub_kategori_anggaran')->references('id_sub_kategori_anggaran')->on('sub_kategori_anggaran');

            
            $table->unsignedBigInteger('id_tahun_anggaran');
            $table->foreign('id_tahun_anggaran')->references('id_tahun_anggaran')->on('tahun_anggaran');

            $table->string('nama');
            $table->decimal('anggaran', 20, 2)->default(0);
            $table->decimal('realisasi', 20, 2)->default(0);
            $table->decimal('selisih', 20, 2)->storedAs('anggaran - realisasi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rincian_anggaran');
    }
};
