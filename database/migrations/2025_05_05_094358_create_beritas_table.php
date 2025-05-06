<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('beritas', function (Blueprint $table) {
        $table->id('id_berita');
        $table->string('judul_berita');
        $table->text('isi_berita');
        $table->string('gambar_cover');
        $table->date('tanggal_publish');
        $table->unsignedBigInteger('penulis'); // FK ke tabel users misalnya
        $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
        $table->string('tags')->nullable();
        $table->timestamps();

        // Kalau penulis mengacu ke tabel users:
        // $table->foreign('penulis')->references('id')->on('users')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('beritas');
    }
};
