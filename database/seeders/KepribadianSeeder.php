<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KepribadianSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('kepribadians')->insert(
            [
                'user_id' => 1 ,
                'nama_kepribadian' =>  'kepribadian 2024' ,
                'dokumen' =>  'kepribadian2024.pdf' ,
                
                
            ]
            );
    }
}
