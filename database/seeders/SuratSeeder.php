<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('surat_kinerjas')->insert(
            [
                'user_id' => 1 , 
                'detail_surat' => 'Surat Kinerja 2024' , 
                'tipe' => 1 , 
                'tanggal' => '2024-11-1' , 
                
            ]
            );
    }
}
