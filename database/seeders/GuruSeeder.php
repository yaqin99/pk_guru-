<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('gurus')->insert(
            [
                'nama_guru' => 'Moh. Ainul Yaqin' ,
                'nip' =>  '0072198476' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => 'Jl. Sersam Mesrul Gg. 3B' , 
                'email' => 'yaqin.9a23@gmail.com' , 
                'username' => 'yaqin' , 
                'password' => bcrypt('yaqin') ,
                
            ]
            );
    }
}
