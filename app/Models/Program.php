<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function pengajuan(){
        return $this->hasOne(Pengajuan::class);
     }
}
