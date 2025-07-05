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
        Schema::create('program_pembangunan_desa', function (Blueprint $table) {
            $table->id();
            $table->string('nama_program');
            $table->string('jenis_program');
            $table->string('lokasi');
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable();
            $table->bigInteger('anggaran');
            $table->string('sumber_dana');
            $table->string('penanggung_jawab');
            $table->enum('status', ['perencanaan', 'pelaksanaan', 'selesai', 'batal'])->default('perencanaan');
            $table->text('deskripsi')->nullable();
            $table->string('foto_dokumentasi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_pembangunan_desa');
    }
};
