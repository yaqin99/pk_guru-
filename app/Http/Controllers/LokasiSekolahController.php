<?php

namespace App\Http\Controllers;

use App\Models\LokasiSekolah;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LokasiSekolahController extends Controller
{
    public function setLokasiSekolah(Request $request)
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lng' => 'required|numeric'
        ]);
    
        LokasiSekolah::create([
            'latitude' => $request->lat,
            'longitude' => $request->lng
        ]);
    
        return response()->json(['status' => 'success']);
    }
}
