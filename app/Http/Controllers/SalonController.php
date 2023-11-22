<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Salones;

class SalonController extends Controller
{
    public function cargarSalones($edificioId)
{
    $salones =  DB::table('aulas')->where('edificio', $edificioId)->pluck('aula');
    
   

    return response()->json($salones);
}

}
