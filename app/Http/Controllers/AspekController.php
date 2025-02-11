<?php

namespace App\Http\Controllers;

use App\Models\Aspek;
use Illuminate\Http\Request;


class AspekController extends Controller
{
    public function getAspek(){
        $id = request('id');
        $aspek = Aspek::findOrFail($id);
        $data = [
            'id' => $aspek->id,
            'pedagogik' => $aspek->pedagogik,
            'kepribadian' => $aspek->kepribadian,
            'profesional' => $aspek->profesional,
            'sosial' => $aspek->sosial,
            'surat_kinerja_id' => $aspek->surat_kinerja_id,
        ];
        return response()->json($data);
    }
    

    public function editAspek(Request $request)
    {
        $id = request('id');
        if ($id == '') {
            Aspek::create([
                'surat_kinerja_id' => $id  , 
                'pedagogik' => request('pedagogik'), 
                'kepribadian' => request('kepribadian'), 
                'profesional' => request('profesional'),
                'sosial' => request('sosial'), 
              ]);
        } else {
            Aspek::where('id', $id)->update([
                'pedagogik' => request('pedagogik'), 
                'kepribadian' => request('kepribadian'), 
                'profesional' => request('profesional'),
                'sosial' => request('sosial'), 
              ]);
        }
        
       
        
    }

    
}
