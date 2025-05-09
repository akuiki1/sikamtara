<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Berita;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BeritaSeeder extends Seeder
{
    public function run()
    {
        DB::table('beritas')->insert([
            [
                'id_berita' => 1,
                'judul_berita' => 'Pelatihan Ekonomi Rumah Tangga untuk Masyarakat Desa',
                'isi_berita' => 'Desa kita menyelenggarakan pelatihan ekonomi rumah tangga yang bertujuan meningkatkan kesejahteraan keluarga.',
                'gambar_cover' => 'gambar',
                'tanggal_publish' => Carbon::create(2025, 1, 20),
                'penulis' => 1,
                'status' => 'published',
                'tags' => 'pelatihan,ekonomi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_berita' => 2,
                'judul_berita' => 'Gotong Royong Pembangunan Posyandu Baru',
                'isi_berita' => 'Warga desa bergotong-royong membangun Posyandu baru sebagai bentuk kepedulian terhadap kesehatan balita dan ibu hamil.',
                'gambar_cover' => 'gambar',
                'tanggal_publish' => Carbon::create(2025, 2, 15),
                'penulis' => 1,
                'status' => 'published',
                'tags' => 'kesehatan,posyandu',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id_berita' => 3,
                'judul_berita' => 'Peresmian Jalan Baru Penghubung Antar Dusun',
                'isi_berita' => 'Jalan baru yang menghubungkan Dusun A dan Dusun B resmi dibuka, memudahkan akses transportasi warga.',
                'gambar_cover' => 'gambar',
                'tanggal_publish' => Carbon::create(2025, 3, 5),
                'penulis' => 1,
                'status' => 'published',
                'tags' => 'infrastruktur,jalan',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
