<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];
    public function pengajuan(){
        return $this->hasMany(Pengajuan::class);
     }
    public function surat(){
        return $this->hasMany(Surat::class);
     }
    public function pedagogik(){
        return $this->hasMany(Pedagogik::class);
     }
    public function sosial(){
        return $this->hasMany(Sosial::class);
     }
    public function kepribadian(){
        return $this->hasMany(Kepribadian::class);
     }
    public function profesional(){
        return $this->hasMany(Profesional::class);
     }
   
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
}
