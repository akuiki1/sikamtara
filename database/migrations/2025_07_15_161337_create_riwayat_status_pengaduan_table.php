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
        Schema::create('riwayat_status_pengaduan', function (Blueprint $table) {
            $table->id('id_riwayat_status_pengaduan');
            
            $table->unsignedBigInteger('id_pengaduan');
            $table->foreign('id_pengaduan')->references('id_pengaduan')->on('pengaduans')->cascadeOnDelete();

            $table->enum('status', ['terkirim', 'diterima', 'diproses', 'ditolak', 'selesai']);
            $table->dateTime('tanggal_perubahan');
            $table->text('keterangan')->nullable();

            $table->unsignedBigInteger('diubah_oleh');
            $table->foreign('diubah_oleh')->references('id_user')->on('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_status_pengaduan');
    }
};
