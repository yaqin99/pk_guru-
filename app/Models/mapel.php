<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mapel extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function guru()
{
    return $this->hasMany(User::class, 'mapel_id');
}
}
