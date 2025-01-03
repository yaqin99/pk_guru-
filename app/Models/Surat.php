<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'surat_kinerjas';


    public function user(){
        return $this->belongsTo(User::class , 'user_id');
     }

     public function aspek(){
        return $this->hasOne(Aspek::class , 'surat_kinerja_id');
     }

}
