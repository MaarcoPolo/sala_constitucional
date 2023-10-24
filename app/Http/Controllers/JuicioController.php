<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Juicio;
use Illuminate\Support\Facades\DB;

class JuicioController extends Controller
{
    public function getJuicios(Request $request){
        try {

            $juicios = Juicio::where('status', 1)->get();
            $array_juicios = array();
            $cont = 1;
            foreach ($juicios as $juicio) {
                $objectJuicio = new \stdClass();
                $objectJuicio->id = $juicio->id;
                $objectJuicio->numero_registro = $cont;
                $objectJuicio->nombre = $juicio->nombre;
                $objectJuicio->nomenclatura = $juicio->nomenclatura;

                array_push($array_juicios, $objectJuicio);
                $cont++;
            }

            return response()->json([
                "status" => "ok",
                "message" => "Juicios obtenidos con éxito",
                "juicios" => $array_juicios
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de juicios",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
    public function nuevoJuicio(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {               
                $juicio = new Juicio;
                $juicio->nombre = $request->nombre;
                $juicio->nomenclatura = $request->nomenclatura;
                $juicio->save();

                $juicios = Juicio::where('status', 1)->get();
            
                $array_juicios = array();
                $cont = 1;
                foreach ($juicios as $juicio) {
                    $objectJuicio = new \stdClass();
                    $objectJuicio->id = $juicio->id;
                    $objectJuicio->numero_registro = $cont;
                    $objectJuicio->nombre = $juicio->nombre;
                    $objectJuicio->nomenclatura = $juicio->nomenclatura;

                    array_push($array_juicios, $objectJuicio);
                    $cont++;
                }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al generar el nuevo juicio.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo Juicio guardado con éxito.",
                "juicios" => $array_juicios
            ], 200);
        }
    }
    public function actualizarJuicio(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $juicio = Juicio::find($request->id);
            $juicio->nombre = $request->nombre;
            $juicio->nomenclatura = $request->nomenclatura;
            $juicio->save();

            $juicios = Juicio::where('status', 1)->get();
            
            $array_juicios = array();
            $cont = 1;
            foreach ($juicios as $juicio) {
                $objectJuicio = new \stdClass();
                $objectJuicio->id = $juicio->id;
                $objectJuicio->numero_registro = $cont;
                $objectJuicio->nombre = $juicio->nombre;
                $objectJuicio->nomenclatura = $juicio->nomenclatura;
        
                array_push($array_juicios, $objectJuicio);
                $cont++;
            }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos del juicio",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Juicio actualizado con éxito.",
                "juicios" => $array_juicios
            ], 200);
        }
    }
    
    public function eliminarJuicio(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {

            $juicio = Juicio::find($request->id);
            $juicio->status = false;
            $juicio->save();

            $juicios = Juicio::where('status', 1)->get();

            $array_juicios = array();
            $cont = 1;
            foreach ($juicios as $juicio) {
                $objectJuicio = new \stdClass();
                $objectJuicio->id = $juicio->id;
                $objectJuicio->numero_registro = $cont;
                $objectJuicio->nombre = $juicio->nombre;
                $objectJuicio->nomenclatura = $juicio->nomenclatura;
                
                array_push($array_juicios, $objectJuicio);
                $cont++;
            }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar este Juicio.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Juicio eliminado con éxito.",
                "juicios" => $array_juicios
            ], 200);
        }
    }
}
