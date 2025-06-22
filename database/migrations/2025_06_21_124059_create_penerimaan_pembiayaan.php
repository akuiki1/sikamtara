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
        Schema::create('penerimaan_pembiayaan', function (Blueprint $table) {
            $table->id('id_penerimaan_pembiayaan');

            $table->unsignedBigInteger('id_tahun_anggaran');
            $table->foreign('id_tahun_anggaran')->references('id_tahun_anggaran')->on('tahun_anggaran');
           
            $table->string('nama');
            $table->decimal('nilai', 20, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penerimaan_pembiayaan');
    }
};
