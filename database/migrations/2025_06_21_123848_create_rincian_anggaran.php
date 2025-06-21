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
            $table->id();
            $table->foreignId('sub_kategori_id')->constrained('sub_kategori_anggaran')->onDelete('cascade');
            $table->foreignId('tahun_id')->constrained('tahun_anggaran')->onDelete('cascade');
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
