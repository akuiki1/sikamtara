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
        Schema::create('detail_apbdes', function (Blueprint $table) {
            $table->id('id_rincian');
            $table->unsignedBigInteger('id_apbdes');
            $table->enum('kategori', ['pendapatan', 'belanja', 'pembiayaan']);
            $table->string('judul')->nullable();
            $table->string('sub_judul')->nullable();
            $table->decimal('anggaran', 18, 2);
            $table->decimal('realisasi', 18, 2);
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_apbdes')
                ->references('id_apbdes')
                ->on('apbdes')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_apbdes');
    }
};
