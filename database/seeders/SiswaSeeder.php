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

        // $students = [];
        // foreach (['10 A' => '2025', '11 A' => '2024', '12 A' => '2023'] as $kelas => $angkatan) {
        //     for ($i = 1; $i <= 8; $i++) {
        //         $students[] = [
        //             'nama_siswa' => $faker->name,
        //             'kelas' => $kelas,
        //             'no_absen' => $i,
        //             'angkatan' => $angkatan,
        //             'status' => 1,
        //             'no_hp' => '08999920375',
        //             'password' => bcrypt('12345'),
        //         ];
        //     }
        // }
        
        // DB::table('siswas')->insert($students);

       DB::table('siswas')->insert([
    [
        'nama_siswa' => 'AINUR ROFIK',
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => 'ISYTI JAMILA',
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => 'HAFIFUR ROHMAN',
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => 'DEVINA NURAINI',
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],

    [
        'nama_siswa' => "'IESYATUR RODLIYAH",
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    
    [
        'nama_siswa' => "ACH. HANAFI",
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    
    [
        'nama_siswa' => "KHALISHATUL IMAMAH",
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    
    [
        'nama_siswa' => "MOH DONI",
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    
    [
        'nama_siswa' => "DIFA MARDIYANA",
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    
    [
        'nama_siswa' => "AHMAD FAISAL RIANSYAH",
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    
    [
        'nama_siswa' => "JAMILATUL MUKARROMAH",
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    
    [
        'nama_siswa' => "MUHAMMAD AJRUL MU'MINIEN",
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    
    [
        'nama_siswa' => "ABD. RAHIM",
        'kelas' => '12 A',
        'no_absen' => 0,
        'angkatan' => '2023',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    
     [
        'nama_siswa' => "INDAH MAULIDI MUKARROMAH",
        'kelas' => '11 A',
        'no_absen' => 0,
        'angkatan' => '2024',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "ACH. WILDANIL IHSAN",
        'kelas' => '11 A',
        'no_absen' => 0,
        'angkatan' => '2024',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "MOH. QUDSI SYADILI",
        'kelas' => '11 A',
        'no_absen' => 0,
        'angkatan' => '2024',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "ACH. FAISHOL HAFIFI",
        'kelas' => '11 A',
        'no_absen' => 0,
        'angkatan' => '2024',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "ACHMAD FERDIANSYAH",
        'kelas' => '11 A',
        'no_absen' => 0,
        'angkatan' => '2024',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "SITI 'ISYATUR RADHIYAH",
        'kelas' => '11 A',
        'no_absen' => 0,
        'angkatan' => '2024',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "AFIATUS SOLEHAH",
        'kelas' => '11 A',
        'no_absen' => 0,
        'angkatan' => '2024',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "AHMAD ALVIN RAMADHANI",
        'kelas' => '11 A',
        'no_absen' => 0,
        'angkatan' => '2024',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "AS ADIANTO",
        'kelas' => '11 A',
        'no_absen' => 0,
        'angkatan' => '2024',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "MOH. ROFIODDIN",
        'kelas' => '11 A',
        'no_absen' => 0,
        'angkatan' => '2024',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    
      [
        'nama_siswa' => "MOH. ALI YAHFA",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "FAIZ SA'DI HABIBIE",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "ADDINUL MATIN",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "FAISAL ARIF",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "IBRAHIM FEBRI FAHRIANSYAH",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "MAULINAL HABIBAH",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "IGHFIRLI",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "ANISSA KANDANA AS SYARIFAH",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "ILMI REDIAN FAJAR",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "ARAINAL KIROM",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],
    [
        'nama_siswa' => "FARIZATUL JAMILAH",
        'kelas' => '10 A',
        'no_absen' => 0,
        'angkatan' => '2025',
        'status' => 1,
        'no_hp' => '08999920375',
        'password' => bcrypt('12345'),
    ],


    ]);



    }
}
