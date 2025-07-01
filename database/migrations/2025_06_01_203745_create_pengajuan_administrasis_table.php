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
        Schema::create('pengajuan_administrasis', function (Blueprint $table) {
            $table->id('id_pengajuan_administrasi');

            $table->unsignedBigInteger('id_administrasi');
            $table->foreign('id_administrasi')->references('id_administrasi')->on('administrasis');
            
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id_user')->on('users');
            
            $table->timestamp('tanggal_pengajuan');
            $table->string('form');
            $table->string('lampiran');
            $table->enum('status_pengajuan', ['baru', 'ditinjau', 'diproses', 'ditolak', 'selesai']);
            $table->string('surat_final')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_administrasis');
    }
};
