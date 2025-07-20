<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $users = [];
        DB::table('users')->insert(
            [
                'nama_user' => 'ARINA PUSPITA S.Pd.I,' ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'arinapuspita@madrasah.kemenag.go.id', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 1 , 
                'username' => 'arina' , 
                'password' => bcrypt('arina') ,
                'role' => 1 ,
                
            ]
            );
        DB::table('users')->insert(
            [
                'nama_user' => 'BAMBANG HARIYANTO S.E' ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'bambanghariyanto@madrasah.kemenag.go.id', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 2 , 
                'username' => 'bambang' , 
                'password' => bcrypt('bambang') ,
                'role' => 1 ,
                
            ]
            );
        DB::table('users')->insert(
            [
                'nama_user' => "ABD. MUIZ" ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'muiztembem@gmail.com', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 6 , 
                'username' => "muiz" , 
                'password' => bcrypt("muiz") ,
                'role' => 1 ,
                
            ]
            );

        DB::table('users')->insert(
            [
                'nama_user' => "ELIBSIN NUR KHALISOH S.Si, " ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'elibsinnurkholisah@madrasah.kemenag.go.id', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 4 , 
                'username' => "elibsin" , 
                'password' => bcrypt("elibsin") ,
                'role' => 1 ,
                
            ]
            );
        

        DB::table('users')->insert(
            [
                'nama_user' => "ZAIFUDDIN S.Pd.I," ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'zaifuddin4@madrasah.kemenag.go.id', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 5 , 
                'username' => "zaifuddin" , 
                'password' => bcrypt("zaifuddin") ,
                'role' => 1 ,
                
            ]
            );

        DB::table('users')->insert(
            [
                'nama_user' => "NOR AINI S.Pd." ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'nor.4iny.ef@gmail.com', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 3 , 
                'username' => "noraini" , 
                'password' => bcrypt("noraini") ,
                'role' => 1 ,
            ]
            );
        DB::table('users')->insert(
            [
                'nama_user' => "SYAMSUL HADI S.Pd.I, " ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'syamsulhadi93@madrasah.kemenag.go.id', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 7, 
                'username' => "syamsul" , 
                'password' => bcrypt("syamsul") ,
                'role' => 1 ,
                
            ]
            );
        
        DB::table('users')->insert(
            [
                'nama_user' => "SYAMSUL HADI S.Pd.I," ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'syamsulhadi93@madrasah.kemenag.go.id', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 7, 
                'username' => "syamsul" , 
                'password' => bcrypt("syamsul") ,
                'role' => 1 ,
                
            ]
            );
        
        DB::table('users')->insert(
            [
                'nama_user' => "MAISARATUL HASANAH S.Pd." ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'bastianmei22@gmail.com', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 8, 
                'username' => "maisaratul" , 
                'password' => bcrypt("maisaratul") ,
                'role' => 1 ,
                
            ]
            );
        
        DB::table('users')->insert(
            [
                'nama_user' => "MISRIYADI S.Pd." ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'misri.yadi200599@gmail.com', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 9, 
                'username' => "misri" , 
                'password' => bcrypt("misri") ,
                'role' => 1 ,
                
            ]
            );
        
        DB::table('users')->insert(
            [
                'nama_user' => "ROFIQ ROMADLAN S.Pd, M.Pd." ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'rofiqrama1@gmail.com', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 10, 
                'username' => "rofiq" , 
                'password' => bcrypt("rofiq") ,
                'role' => 1 ,
                
            ]
            );
        
        DB::table('users')->insert(
            [
                'nama_user' => "ACH. MUBASSYIR S.Ag." ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'rbassyir@gmail.com', 
                'poin' => 0 , 
                'kelas' => 1 , 
                'mapel_id' => 10, 
                'username' => "rofiq" , 
                'password' => bcrypt("rofiq") ,
                'role' => 1 ,
                
            ]
            );
        

        DB::table('users')->insert(
            [
                'nama_user' => 'Admin' ,
                'nip' =>  '0072198476' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'febri.9a23@gmail.com' , 
                'poin' => 0 , 

                'username' => 'admin' , 
                'password' => bcrypt('admin') ,
                'role' => 2 ,
                
            ]
            );
        DB::table('users')->insert(
            [
                'nama_user' => 'AHMAD AINUL FURQAN S.IP.' ,
                'nip' =>  '-' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => '-' , 
                'email' => 'ahmadainulfurqan@madrasah.kemenag.go.id' , 
                'poin' => 0 , 

                'username' => 'kepsek' , 
                'password' => bcrypt('kepsek') ,
                'role' => 3 ,
                
            ]
            );

            // $totalMapel = 22;

            // for ($i = 1; $i <= 50; $i++) {
            //     $fullName = $faker->name;
            //     $username = strtolower(Str::slug(explode(' ', $fullName)[0], ''));

            //     $users[] = [
            //         'nama_user' => $fullName,
            //         'nip' => '00721984' . str_pad($i, 2, '0', STR_PAD_LEFT),
            //         'no_hp' => '08999920375',
            //         'alamat' => $faker->address,
            //         'email' => $username . '@gmail.com',
            //         'poin' => 0,
            //         'username' => $username,
            //         'password' => bcrypt($username),
            //         'role' => 1,
            //         'mapel_id' => rand(1, $totalMapel), // acak antara 1 - 22
            //         'kelas' => rand(1, 3), // 1: kelas 10, 2: kelas 11, 3: kelas 12
            //     ];
            // }

            // DB::table('users')->insert($users);

    }
}
