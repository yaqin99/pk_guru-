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
                'nama_user' => 'Moh. Ainul Yaqin' ,
                'nip' =>  '0072198476' ,
                'no_hp' =>  '085232324069' ,
                'alamat' => 'Jl. Sersam Mesrul Gg. 3B' , 
                'email' => 'yaqin.9a23@gmail.com' , 
                'username' => 'yaqin' , 
                'password' => bcrypt('yaqin') ,
                'role' => 1 ,
                
            ]
            );
        DB::table('users')->insert(
            [
                'nama_user' => 'Febri Wasilaturrahmah' ,
                'nip' =>  '0072198476' ,
                'no_hp' =>  '085232324069' ,
                'alamat' => 'Jl. Sersam Mesrul Gg. 3B' , 
                'email' => 'yaqin.9a23@gmail.com' , 
                'username' => 'febri' , 
                'password' => bcrypt('febri') ,
                'role' => 2 ,
                
            ]
            );
        DB::table('users')->insert(
            [
                'nama_user' => 'Rizal Ferlianto' ,
                'nip' =>  '0072198476' ,
                'no_hp' =>  '085232324069' ,
                'alamat' => 'Jl. Sersam Mesrul Gg. 3B' , 
                'email' => 'yaqin.9a23@gmail.com' , 
                'username' => 'rizal' , 
                'password' => bcrypt('rizal') ,
                'role' => 3 ,
                
            ]
            );
    }
}
