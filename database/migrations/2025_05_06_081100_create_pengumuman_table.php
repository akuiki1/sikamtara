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
        Schema::create('pengumuman', function (Blueprint $table) {
            $table->id('id_pengumuman');
            $table->string('judul_pengumuman');
            $table->text('isi_pengumuman');
            $table->string('file_lampiran')->nullable();
            $table->timestamp('tanggal_publish')->nullable();
            
            $table->unsignedBigInteger('penulis'); // FK ke tabel users misalnya
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
        Schema::dropIfExists('pengumuman');
    }
};
