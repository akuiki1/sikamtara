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
        $table->timestamp('tanggal_publish')->nullable();
        $table->unsignedBigInteger('penulis');
        $table->foreign('penulis')->references('id_user')->on('users');
        $table->enum('status', ['draft', 'published', 'archived'])->default('draft');
        $table->timestamps();
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
