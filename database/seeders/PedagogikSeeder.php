<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PedagogikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('pedagogiks')->insert(
            [
                'user_id' => 1 ,
                'nama_pedagogik' =>  'Pedagogik 2024' ,
                'dokumen' =>  'pedagogik2024.pdf' ,
                
                
            ]
            );
    }
}
