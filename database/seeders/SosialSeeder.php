<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SosialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sosials')->insert(
            [
                'user_id' => 1 ,
                'nama_sosial' =>  'Sosial 2024' ,
                'dokumen' =>  'sosial2024.pdf' ,
                
                
            ]
            );
    }
}
