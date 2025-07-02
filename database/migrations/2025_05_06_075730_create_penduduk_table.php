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
        Schema::create('penduduk', function (Blueprint $table) {
            $table->char('nik', 16)->primary();
            $table->string('nama', 100);
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan']);
            $table->string('tempat_lahir', 100)->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('agama', 20)->nullable();
            $table->string('pendidikan', 50)->nullable();
            $table->string('pekerjaan', 255)->nullable();
            $table->enum('status_perkawinan', ['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati', 'Kawin Tercatat', 'Kawin Tidak Tercatat'])->nullable();
            $table->string('golongan_darah', 3)->nullable();
            $table->string('kewarganegaraan', 10)->default('WNI');
            
            $table->enum('hubungan', ['Kepala Keluarga', 'Suami', 'Istri', 'Anak', 'Menantu', 'Orang tua', 'Mertua', 'Pembantu'])->nullable();
            
            $table->char('kode_keluarga', 16); // Foreign key ke KK
            $table->foreign('kode_keluarga')->references('kode_keluarga')->on('keluarga')->onDelete('cascade');

            $table->enum('status_tinggal', ['Tetap', 'Pindah', 'Meninggal'])->default('Tetap');

            $table->timestamps();
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penduduk');
    }
};
