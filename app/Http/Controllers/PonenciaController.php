<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ponencia;
use Illuminate\Support\Facades\DB;

class PonenciaController extends Controller
{
    public function getPonencias(Request $request){
        try {

            $ponencias = Ponencia::where('status', 1)->get();
            $array_ponencias = array();
            $cont = 1;
            foreach ($ponencias as $ponencia) {
                $objectPonencia = new \stdClass();
                $objectPonencia->id = $ponencia->id;
                $objectPonencia->numero_registro = $cont;
                $objectPonencia->nombre = $ponencia->nombre;
                $objectPonencia->titular = $ponencia->titular;

                array_push($array_ponencias, $objectPonencia);
                $cont++;
            }

            return response()->json([
                "status" => "ok",
                "message" => "Ponencias obtenidas con éxito",
                "ponencias" => $array_ponencias
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de ponencias",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
    public function nuevaPonencia(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {               
                $ponencia = new Ponencia;
                $ponencia->nombre = $request->nombre;
                $ponencia->titular = $request->titular;
                $ponencia->save();

                $ponencias = Ponencia::where('status', 1)->get();
            
                $array_ponencias = array();
                $cont = 1;
                foreach ($ponencias as $ponencia) {
                    $objectPonencia = new \stdClass();
                    $objectPonencia->id = $ponencia->id;
                    $objectPonencia->numero_registro = $cont;
                    $objectPonencia->nombre = $ponencia->nombre;
                    $objectPonencia->titular = $ponencia->titular;
                    array_push($array_ponencias, $objectPonencia);
                    $cont++;
                }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al generar la nueva ponencia.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nueva Ponencia guardada con éxito.",
                "ponencias" => $array_ponencias
            ], 200);
        }
    }
    public function actualizarPonencia(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $ponencia = Ponencia::find($request->id);
            $ponencia->nombre = $request->nombre;
            $ponencia->titular = $request->titular;
            $ponencia->save();

            $ponencias = Ponencia::where('status', 1)->get();
            
            $array_ponencias = array();
            $cont = 1;
            foreach ($ponencias as $ponencia) {
                $objectPonencia = new \stdClass();
                $objectPonencia->id = $ponencia->id;
                $objectPonencia->numero_registro = $cont;
                $objectPonencia->nombre = $ponencia->nombre;
                $objectPonencia->titular = $ponencia->titular;
        
                array_push($array_ponencias, $objectPonencia);
                $cont++;
            }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos de la ponencia",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Ponencia actualizada con éxito.",
                "ponencias" => $array_ponencias
            ], 200);
        }
    }
    
    public function eliminarPonencia(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {

            $ponencia = Ponencia::find($request->id);
            $ponencia->status = false;
            $ponencia->save();

            $ponencias = Ponencia::where('status', 1)->get();

            $array_ponencias = array();
            $cont = 1;
            foreach ($ponencias as $ponencia) {
                $objectPonencia = new \stdClass();
                $objectPonencia->id = $ponencia->id;
                $objectPonencia->numero_registro = $cont;
                $objectPonencia->nombre = $ponencia->nombre;
                $objectPonencia->titular = $ponencia->titular;
                
                array_push($array_ponencias, $objectPonencia);
                $cont++;
            }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar esta Ponencia.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Ponencia eliminada con éxito.",
                "ponencias" => $array_ponencias
            ], 200);
        }
    }
}
