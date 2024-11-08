<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfesionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('profesionals')->insert(
            [
                'user_id' => 1 ,
                'nama_profesional' =>  'profesional 2024' ,
                'dokumen' =>  'profesional2024.pdf' ,
                
                
            ]
            );
    }
}
