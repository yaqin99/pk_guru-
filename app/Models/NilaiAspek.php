<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NilaiAspek extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function guru()
    {
        // Kolom foreign key-nya adalah user_id di tabel nilai_aspeks
        return $this->belongsTo(User::class, 'user_id');
    }
}