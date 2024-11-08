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
                'nama_sosial' =>  'Pedagogik 2024' ,
                'dokumen' =>  'pedagogik2024.pdf' ,
                
                
            ]
            );
    }
}
