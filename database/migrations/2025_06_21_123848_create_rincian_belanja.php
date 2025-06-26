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
        Schema::create('rincian_belanja', function (Blueprint $table) {
            $table->id('id_rincian_belanja');

            $table->unsignedBigInteger('id_belanja');
            $table->foreign('id_belanja')->references('id_belanja')->on('belanja')->onDelete('cascade');


            $table->unsignedBigInteger('id_tahun_anggaran');
            $table->foreign('id_tahun_anggaran')->references('id_tahun_anggaran')->on('tahun_anggaran')->onDelete('cascade');

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
        Schema::dropIfExists('rincian_belanja');
    }
};
