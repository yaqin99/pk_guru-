<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailKegiatan extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function kegiatan(){
        return $this->hasMany(Kegiatan::class);
     }
    public function dokumen(){
        return $this->hasMany(Dokumen::class);
     }
    public function guru(){
        return $this->hasMany(Guru::class);
     }
}
