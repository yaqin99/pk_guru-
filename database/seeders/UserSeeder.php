<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
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
    }
}
