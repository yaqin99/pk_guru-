<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('mapels')->insert([
            ['nama_mapel' => 'Pendidikan Agama dan Budi Pekerti'],
            ['nama_mapel' => 'Pendidikan Pancasila dan Kewarganegaraan'],
            ['nama_mapel' => 'Bahasa Indonesia'],
            ['nama_mapel' => 'Matematika'],
            ['nama_mapel' => 'Sejarah Indonesia'],
            ['nama_mapel' => 'Bahasa Inggris'],
            ['nama_mapel' => 'Seni Budaya'],
            ['nama_mapel' => 'Pendidikan Jasmani, Olahraga, dan Kesehatan'],
            ['nama_mapel' => 'Prakarya dan Kewirausahaan'],
        
            // Peminatan MIPA
            ['nama_mapel' => 'Matematika (Peminatan)'],
            ['nama_mapel' => 'Fisika'],
            ['nama_mapel' => 'Kimia'],
            ['nama_mapel' => 'Biologi'],
        
            // Peminatan IPS
            ['nama_mapel' => 'Geografi'],
            ['nama_mapel' => 'Sejarah'],
            ['nama_mapel' => 'Sosiologi'],
            ['nama_mapel' => 'Ekonomi'],
        
            // Peminatan Bahasa (opsional)
            ['nama_mapel' => 'Bahasa dan Sastra Indonesia'],
            ['nama_mapel' => 'Bahasa dan Sastra Inggris'],
            ['nama_mapel' => 'Bahasa Asing (opsional)'],
        
            // Tambahan (opsional sekolah)
            ['nama_mapel' => 'Teknologi Informasi dan Komunikasi'],
            ['nama_mapel' => 'Mulok (Muatan Lokal)'],
        ]);
        
    }
}
