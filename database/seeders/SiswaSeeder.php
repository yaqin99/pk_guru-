<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        $students = [];
        foreach (['10 A' => '2025', '11 A' => '2024', '12 A' => '2023'] as $kelas => $angkatan) {
            for ($i = 1; $i <= 8; $i++) {
                $students[] = [
                    'nama_siswa' => $faker->name,
                    'kelas' => $kelas,
                    'no_absen' => $i,
                    'angkatan' => $angkatan,
                    'status' => 1,
                    'no_hp' => '08999920375',
                    'password' => bcrypt('12345'),
                ];
            }
        }
        
        DB::table('siswas')->insert($students);
        // DB::table('siswas')->insert(
            
        //     [
        //         'nama_siswa' => 'Aditya Syahlan' ,
        //         'kelas' =>  '10 A' ,
        //         'no_absen' =>  '1' ,
        //         'angkatan' => '2025' , 
        //         'status' => 1 , 
        //         'no_hp' => '08999920375', 
        //         'password' => bcrypt('guru') ,
                
        //     ]
        //     );



    }
}
