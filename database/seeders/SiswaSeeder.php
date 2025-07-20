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

   
        $namaSiswa = [
            ['AINUR ROFIK', '12 A', '2023'],
            ['ISYTI JAMILA', '12 A', '2023'],
            ['HAFIFUR ROHMAN', '12 A', '2023'],
            ['DEVINA NURAINI', '12 A', '2023'],
            ["IESYATUR RODLIYAH", '12 A', '2023'],
            ["ACH. HANAFI", '12 A', '2023'],
            ["KHALISHATUL IMAMAH", '12 A', '2023'],
            ["MOH DONI", '12 A', '2023'],
            ["DIFA MARDIYANA", '12 A', '2023'],
            ["AHMAD FAISAL RIANSYAH", '12 A', '2023'],
            ["JAMILATUL MUKARROMAH", '12 A', '2023'],
            ["MUHAMMAD AJRUL MU'MINIEN", '12 A', '2023'],
            ["ABD. RAHIM", '12 A', '2023'],
            ["INDAH MAULIDI MUKARROMAH", '11 A', '2024'],
            ["ACH. WILDANIL IHSAN", '11 A', '2024'],
            ["MOH. QUDSI SYADILI", '11 A', '2024'],
            ["ACH. FAISHOL HAFIFI", '11 A', '2024'],
            ["ACHMAD FERDIANSYAH", '11 A', '2024'],
            ["SITI 'ISYATUR RADHIYAH", '11 A', '2024'],
            ["AFIATUS SOLEHAH", '11 A', '2024'],
            ["AHMAD ALVIN RAMADHANI", '11 A', '2024'],
            ["AS ADIANTO", '11 A', '2024'],
            ["MOH. ROFIODDIN", '11 A', '2024'],
            ["MOH. ALI YAHFA", '10 A', '2025'],
            ["FAIZ SA'DI HABIBIE", '10 A', '2025'],
            ["ADDINUL MATIN", '10 A', '2025'],
            ["FAISAL ARIF", '10 A', '2025'],
            ["IBRAHIM FEBRI FAHRIANSYAH", '10 A', '2025'],
            ["MAULINAL HABIBAH", '10 A', '2025'],
            ["IGHFIRLI", '10 A', '2025'],
            ["ANISSA KANDANA AS SYARIFAH", '10 A', '2025'],
            ["ILMI REDIAN FAJAR", '10 A', '2025'],
            ["ARAINAL KIROM", '10 A', '2025'],
            ["FARIZATUL JAMILAH", '10 A', '2025'],
        ];
        
        $data = [];
        foreach ($namaSiswa as $index => $item) {
            $data[] = [
                'nama_siswa' => $item[0],
                'kelas' => $item[1],
                'no_absen' => $index + 1,
                'angkatan' => $item[2],
                'status' => 1,
                'no_hp' => '08999920375',
                'password' => bcrypt('12345'),
            ];
        }
        
        DB::table('siswas')->insert($data);



    }
}
