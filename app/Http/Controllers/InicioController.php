<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InicioController extends Controller
{
    public function index(Request $peticion){
        $arreglo =['nombre'=>$peticion->query('nombre','ANA')];
        return view('/recorrido/pruebascesar')->with($arreglo);
    }
}
