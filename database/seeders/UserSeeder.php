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
                'nama_user' => 'Guru Febri' ,
                'nip' =>  '0072198476' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => 'Jl. Amin Djakfar' , 
                'email' => 'febri.9a23@gmail.com' , 
                'poin' => 0 , 
                'username' => 'guru' , 
                'password' => bcrypt('guru') ,
                'role' => 1 ,
                
            ]
            );
        DB::table('users')->insert(
            [
                'nama_user' => 'Admin Febri' ,
                'nip' =>  '0072198476' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => 'Jl. Amin Djakfar' , 
                'email' => 'febri.9a23@gmail.com' , 
                'poin' => 0 , 

                'username' => 'admin' , 
                'password' => bcrypt('admin') ,
                'role' => 2 ,
                
            ]
            );
        DB::table('users')->insert(
            [
                'nama_user' => 'Kepala Sekolah' ,
                'nip' =>  '0072198476' ,
                'no_hp' =>  '08999920375' ,
                'alamat' => 'Jl. Amin Djakfar' , 
                'email' => 'febri.9a23@gmail.com' , 
                'poin' => 0 , 

                'username' => 'kepsek' , 
                'password' => bcrypt('kepsek') ,
                'role' => 3 ,
                
            ]
            );

            for ($i = 1; $i <= 15; $i++) {
                $fullName = $faker->name;
                $username = strtolower(Str::slug(explode(' ', $fullName)[0], ''));
            
                $users[] = [
                    'nama_user' => $fullName,
                    'nip' => '00721984' . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'no_hp' => '08999920375',
                    'alamat' => $faker->address,
                    'email' => $username . '@gmail.com',
                    'poin' => 0,
                    'username' => $username,
                    'password' => bcrypt($username),
                    'role' => 1,
                ];
            }; 

            DB::table('users')->insert($users);

    }
}
