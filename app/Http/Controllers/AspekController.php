<?php

namespace App\Http\Controllers;

use App\Models\Aspek;
use Illuminate\Http\Request;


class AspekController extends Controller
{
    public function getAspek($id){
        $data = Aspek::where('surat_kinerja_id' , $id)->get();
        return $data ; 
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
