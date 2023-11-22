<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Carbon\CarbonInterface;

class RegistroController extends Controller
{
    public function index(Request $request)
    {
     

        $registros = DB::table('grupos_asistencias')
    ->select(
        'grupos_asistencias.dia_semana',
        'materias.nombre_materia',
        'grupos_asistencias.letra_grupo',
        'grupos.num_inscritos',
        'grupos_horarios.aula',
        'grupos_asistencias.clave_plan_estudios',
        'grupos_asistencias.fecha_hora',
        'grupos_asistencias.asistencia',
        'grupos_asistencias.observacion'
    )
    ->join('materias', function ($join) {
        $join->on('materias.clave_materia', '=', 'grupos_asistencias.clave_materia')
             ->on('materias.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios');
    })
    ->join('grupos', function ($join) {
        $join->on('grupos.clave_materia', '=', 'grupos_asistencias.clave_materia')
             ->on('grupos.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios')
             ->on('grupos.letra_grupo', '=', 'grupos_asistencias.letra_grupo');
    })
    ->join('grupos_horarios', function ($join) {
        $join->on('grupos_horarios.clave_materia', '=', 'grupos_asistencias.clave_materia')
             ->on('grupos_horarios.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios')
             ->on('grupos_horarios.letra_grupo', '=', 'grupos_asistencias.letra_grupo')
             ->on('grupos_horarios.dia_semana', '=', 'grupos_asistencias.dia_semana');
    })
    ->get();




        $areas = $this->obtenerAreas($request);

        return view('recorrido/pruebasregis', compact('registros','areas'));   
    }
  
    public function obtenerAreas(Request $peticion){
        $areas = DB::table('organigrama')
        ->select('organigrama.descripcion_area')
        ->distinct()
        ->join('materias', 'materias.clave_area', '=', 'organigrama.clave_area')
        ->get();
        return $areas;
    }
    public function obtenerRegis(Request $request){
        $areaId = $request->input('areas');
        $profS = $request->input('profes');
        error_log($profS);
        error_log($areaId);

        if ($areaId == 0) {
            // Si $areaId es igual a cero, mostrar todos los registros
            $query  = DB::table('grupos_asistencias')
            ->select(
                'grupos_asistencias.dia_semana',
                'materias.nombre_materia',
                'grupos_asistencias.letra_grupo',
                'grupos.num_inscritos',
                'grupos_horarios.aula',
                'grupos_asistencias.clave_plan_estudios',
                'grupos_asistencias.fecha_hora',
                'grupos_asistencias.asistencia',
                'grupos_asistencias.observacion'
            )
            ->join('materias', function ($join) {
                $join->on('materias.clave_materia', '=', 'grupos_asistencias.clave_materia')
                     ->on('materias.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios');
            })
            ->join('grupos', function ($join) {
                $join->on('grupos.clave_materia', '=', 'grupos_asistencias.clave_materia')
                     ->on('grupos.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios')
                     ->on('grupos.letra_grupo', '=', 'grupos_asistencias.letra_grupo');
            })
            ->join('grupos_horarios', function ($join) {
                $join->on('grupos_horarios.clave_materia', '=', 'grupos_asistencias.clave_materia')
                     ->on('grupos_horarios.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios')
                     ->on('grupos_horarios.letra_grupo', '=', 'grupos_asistencias.letra_grupo')
                     ->on('grupos_horarios.dia_semana', '=', 'grupos_asistencias.dia_semana');
            })
            ->get();
           
        } else {
            // Si $edificioId no es igual a cero, filtrar por edificio
         
            $query  = DB::table('grupos_asistencias')
            ->select(
                'grupos_asistencias.dia_semana',
                'materias.nombre_materia',
                'grupos_asistencias.letra_grupo',
                'grupos.num_inscritos',
                'grupos_horarios.aula',
                'grupos_asistencias.clave_plan_estudios',
                'grupos_asistencias.fecha_hora',
                'grupos_asistencias.asistencia',
                'grupos_asistencias.observacion'
            )
            ->join('materias', function ($join) {
                $join->on('materias.clave_materia', '=', 'grupos_asistencias.clave_materia')
                    ->on('materias.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios');
            })
            ->join('grupos', function ($join) {
                $join->on('grupos.clave_materia', '=', 'grupos_asistencias.clave_materia')
                    ->on('grupos.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios')
                    ->on('grupos.letra_grupo', '=', 'grupos_asistencias.letra_grupo');
            })
            ->join('grupos_horarios', function ($join) {
                $join->on('grupos_horarios.clave_materia', '=', 'grupos_asistencias.clave_materia')
                    ->on('grupos_horarios.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios')
                    ->on('grupos_horarios.letra_grupo', '=', 'grupos_asistencias.letra_grupo')
                    ->on('grupos_horarios.dia_semana', '=', 'grupos_asistencias.dia_semana');
            })
            ->join('organigrama', 'materias.clave_area', '=', 'organigrama.clave_area')
            ->where('organigrama.descripcion_area', $areaId)
            ->get();
        
        }
        if( $profS != 0){

          
             $query  = DB::table('grupos_asistencias')
                 ->select(
                     'grupos_asistencias.dia_semana',
                     'materias.nombre_materia',
                     'grupos_asistencias.letra_grupo',
                     'grupos.num_inscritos',
                     'grupos_horarios.aula',
                     'grupos_asistencias.clave_plan_estudios',
                     'grupos_asistencias.fecha_hora',
                     'grupos_asistencias.asistencia',
                     'grupos_asistencias.observacion'
                 )
                 ->join('materias', function ($join) {
                     $join->on('materias.clave_materia', '=', 'grupos_asistencias.clave_materia')
                         ->on('materias.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios');
                 })
                 ->join('grupos', function ($join) {
                     $join->on('grupos.clave_materia', '=', 'grupos_asistencias.clave_materia')
                         ->on('grupos.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios')
                         ->on('grupos.letra_grupo', '=', 'grupos_asistencias.letra_grupo');
                 })
                 ->join('grupos_horarios', function ($join) {
                     $join->on('grupos_horarios.clave_materia', '=', 'grupos_asistencias.clave_materia')
                         ->on('grupos_horarios.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios')
                         ->on('grupos_horarios.letra_grupo', '=', 'grupos_asistencias.letra_grupo')
                         ->on('grupos_horarios.dia_semana', '=', 'grupos_asistencias.dia_semana');
                 })
                 ->join('organigrama', 'materias.clave_area', '=', 'organigrama.clave_area')
                 ->join('profesores', 'profesores.rfc', '=', 'grupos.docente')
                 ->where('organigrama.descripcion_area', $areaId)
                 ->whereRaw("CONCAT(profesores.nombre, ' ', profesores.ap_paterno, ' ', profesores.ap_materno) = '$profS'")
                 ->get();
             
             // $resultados contiene los resultados de la consulta
             
        
        }
        
    
      
    
        // Ejecutar la consulta y obtener los resultados
        #$regis = $query->get();
        return response()->json($query);
    }

    public function nombrelet(Request $request){

    
        $nombre = $request->input('nombre');
        $resultados =  DB::table('grupos_asistencias')
                 ->select(
                     'grupos_asistencias.dia_semana',
                     'materias.nombre_materia',
                     'grupos_asistencias.letra_grupo',
                     'grupos.num_inscritos',
                     'grupos_horarios.aula',
                     'grupos_asistencias.clave_plan_estudios',
                     'grupos_asistencias.fecha_hora',
                     'grupos_asistencias.asistencia',
                     'grupos_asistencias.observacion'
                 )
                 ->join('materias', function ($join) {
                     $join->on('materias.clave_materia', '=', 'grupos_asistencias.clave_materia')
                         ->on('materias.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios');
                 })
                 ->join('grupos', function ($join) {
                     $join->on('grupos.clave_materia', '=', 'grupos_asistencias.clave_materia')
                         ->on('grupos.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios')
                         ->on('grupos.letra_grupo', '=', 'grupos_asistencias.letra_grupo');
                 })
                 ->join('grupos_horarios', function ($join) {
                     $join->on('grupos_horarios.clave_materia', '=', 'grupos_asistencias.clave_materia')
                         ->on('grupos_horarios.clave_plan_estudios', '=', 'grupos_asistencias.clave_plan_estudios')
                         ->on('grupos_horarios.letra_grupo', '=', 'grupos_asistencias.letra_grupo')
                         ->on('grupos_horarios.dia_semana', '=', 'grupos_asistencias.dia_semana');
                 })
                 ->join('organigrama', 'materias.clave_area', '=', 'organigrama.clave_area')
                 ->join('profesores', 'profesores.rfc', '=', 'grupos.docente')
                 ->where(function ($query) use ($nombre) {
                    // Aplica el filtro incremental
                    $query->whereRaw("CONCAT(profesores.nombre, ' ', profesores.ap_paterno, ' ', profesores.ap_materno) LIKE ?", ["%$nombre%"]);
                })
                ->get();
       
       
               // Devuelve los resultados como JSON
       return response()->json($resultados);
}
}



?>
