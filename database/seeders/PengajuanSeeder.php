<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PengajuanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('pengajuans')->insert(
            [
                'nama_kegiatan' => 'Meningkatkan Pembelajaran Bahasa Inggris' , 
                'user_id' => 1 , 
                'catatan' => 'Sistem ini akan dilaksanakan dalam waktu seharian full' , 
                'estimasi' => '2 Semester' , 
                'jumlah_poin' => '10' , 
                'rpp' => 'contoh_rpp.pdf' , 
                'bukti' => 'contoh_bukti.pdf' , 
                
            ]
            );
       
    }
}
