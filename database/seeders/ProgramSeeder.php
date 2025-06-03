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
                'poin' => 10,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan media interaktif berbasis digital untuk meningkatkan minat belajar siswa dalam pelajaran IPA',
                'poin' => 5,
                'pelaksanaan' => '2',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan metode diskusi kelompok untuk melatih keterampilan berpikir kritis dalam pelajaran Sejarah',
                'poin' => 15,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan media visual berbasis gambar untuk memperjelas konsep ekosistem dalam pelajaran IPA',
                'poin' => 5,
                'pelaksanaan' => '2',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan metode cerita bergambar untuk mempermudah pemahaman tema lingkungan dalam Bahasa Indonesia',
                'poin' => 10,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan game edukasi untuk meningkatkan motivasi belajar siswa dalam pelajaran Matematika',
                'poin' => 15,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan metode eksperimen langsung untuk memahami konsep perubahan zat dalam pelajaran IPA',
                'poin' => 10,
                'pelaksanaan' => '2',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan teknik debat untuk melatih keterampilan argumentasi dalam pelajaran PPKn',
                'poin' => 5,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan metode storytelling untuk memperkenalkan budaya lokal dalam pelajaran Bahasa Indonesia',
                'poin' => 15,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan proyek berbasis praktik untuk mendalami konsep energi alternatif dalam IPA',
                'poin' => 5,
                'pelaksanaan' => '2',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan kegiatan prakarya untuk memperkuat pemahaman konsep seni budaya',
                'poin' => 10,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan simulasi digital untuk mempelajari fenomena alam dalam pelajaran IPA',
                'poin' => 15,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan video edukasi untuk menjelaskan proses sejarah kemerdekaan Indonesia',
                'poin' => 5,
                'pelaksanaan' => '2',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan metode peer teaching untuk meningkatkan kolaborasi siswa dalam Matematika',
                'poin' => 10,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan metode observasi lingkungan untuk memahami konsep geografis dalam pelajaran IPS',
                'poin' => 5,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan metode tanya jawab aktif untuk mendorong partisipasi siswa dalam pembelajaran PPKn',
                'poin' => 15,
                'pelaksanaan' => '2',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan infografis interaktif untuk mempelajari konsep statistik dalam Matematika',
                'poin' => 5,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penerapan metode praktik langsung untuk memahami konsep kerja alat dalam IPA',
                'poin' => 10,
                'pelaksanaan' => '2',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        DB::table('programs')->insert(
            [
                'nama_program' => 'Penggunaan metode simulasi peran untuk melatih empati sosial siswa dalam IPS',
                'poin' => 15,
                'pelaksanaan' => '1',
                'tahun' => '2025' , 
                'status' => 1
            ]
        );
        
        // Tambahkan data hingga mencapai total 100 entri.
        
    }
}
