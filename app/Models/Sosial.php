<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sosial extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function guru(){
        return $this->belongsTo(User::class , 'user_id');
     }
}
