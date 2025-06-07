<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan metode mind mapping untuk meningkatkan pemahaman konsep dalam pelajaran Matematika',
                'poin' => 5,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan simulasi role play untuk memahami peran sosial dalam pembelajaran Pendidikan Kewarganegaraan',
                'poin' => 5,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan media interaktif berbasis digital untuk meningkatkan minat belajar siswa dalam pelajaran IPA',
                'poin' => 10,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan metode diskusi kelompok untuk melatih keterampilan berpikir kritis dalam pelajaran Sejarah',
                'poin' => 15,
                'pelaksanaan' => '2',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan media visual berbasis gambar untuk memperjelas konsep ekosistem dalam pelajaran IPA',
                'poin' => 20,
                'pelaksanaan' => '2',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        // Tambahkan data hingga mencapai total 100 entri.
        
    }
}
