<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Edificio;


// Resto del código del controlador


class FormularioController extends Controller
{
    public function index(Request $request)
{
    $datos = $request->session()->get('datos'); // O utiliza $request->old('datos');


    $edificios = Edificio::all();
    return view('recorrido/pruebascesar', compact('edificios','datos'));
}

public function obtenerSalones($edificio_id)
{
    
    $salones = Salon::where('edificio_id', $edificio_id)->get();
    return response()->json($salones);
}
}
