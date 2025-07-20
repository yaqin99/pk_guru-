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
            ['nama_mapel' => 'Aqidah Akhlak'],
            ['nama_mapel' => 'Bimbingan dan Konseling'],
            ['nama_mapel' => 'Bahasa Indonesia'],
            ['nama_mapel' => 'Matematika'],
            ['nama_mapel' => 'Fiqih'],
            ['nama_mapel' => 'Bahasa Inggris'],
            ['nama_mapel' => 'Bahasa Arab'],
            ['nama_mapel' => 'Sejarah Kebudayaan Islam (SKI)'],
            ['nama_mapel' => 'Informatika'],
            ['nama_mapel' => "Al Qur an Hadist"],
        ]);
        
    }
}
