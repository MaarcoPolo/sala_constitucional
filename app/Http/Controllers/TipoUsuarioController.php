<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoUsuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class TipoUsuarioController extends Controller
{
    public function getTipoUsuarios()
    {
        try{
            $tipos = TipoUsuario::where('status', 1)->where('id', '!=', 1)->get();

            $array = array();
            $cont = 1;
            foreach($tipos as $tipo){
                $object = new \stdClass();
                $object->id = $tipo->id;
                $object->numero_registro = $cont;
                $object->nombre = $tipo->nombre;
                array_push($array, $object);
                $cont++;
            }

            return response()->json([
                "status" => "ok",
                "message" => "Tipos de usuario obtenidas con éxito",
                "tipoUsuarios" => $array
            ], 200);

        }catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener los tipos de usuarios",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
    public function nuevoTipoUsuario(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
                $tipoUsuario = new TipoUsuario;
                $tipoUsuario->nombre = $request->nombre;
                $tipoUsuario->save();

                $tipoUsuarios = TipoUsuario::where('status', 1)->where('id', '!=', 1)->get();
            
                $array_tipoUsuarios = array();
                $cont = 1;
                foreach ($tipoUsuarios as $tipoUsuario) {
                    $objecttipoUsuario = new \stdClass();
                    $objecttipoUsuario->id = $tipoUsuario->id;
                    $objecttipoUsuario->numero_registro = $cont;
                    $objecttipoUsuario->nombre = $tipoUsuario->nombre;                   
                    array_push($array_tipoUsuarios, $objecttipoUsuario);
                    $cont++;
                }


            DB::commit();
            $exito = true;
            
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al generar el nuevo tipo de usuario.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo tipo de usuario guardado con éxito.",
                "tipoUsuarios" => $array_tipoUsuarios
            ], 200);
        }
    }
    public function actualizarTipoUsuario(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {

            $tipoUsuario = TipoUsuario::find($request->id);
            $tipoUsuario->nombre = $request->nombre;
            $tipoUsuario->save();

            $tipoUsuarios = TipoUsuario::where('status', 1)->where('id', '!=', 1)->get();
            
            $array_tipoUsuarios = array();
            $cont = 1;
            foreach ($tipoUsuarios as $tipoUsuario) {
                $objecttipoUsuario = new \stdClass();
                $objecttipoUsuario->id = $tipoUsuario->id;
                $objecttipoUsuario->numero_registro = $cont;
                $objecttipoUsuario->nombre = $tipoUsuario->nombre;        
                array_push($array_tipoUsuarios, $objecttipoUsuario);
                $cont++;
            }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos del tipo de usuario.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Tipo de usuario actualizado con éxito.",
                "tipoUsuarios" => $array_tipoUsuarios
            ], 200);
        }
    }
    
    public function eliminarTipoUsuario(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {

            $tipoUsuario = TipoUsuario::find($request->id);
            $tipoUsuario->status = false;
            $tipoUsuario->save();

            $tipoUsuarios = TipoUsuario::where('status', 1)->where('id', '!=', 1)->get();

            $array_tipoUsuarios = array();
            $cont = 1;
            foreach ($tipoUsuarios as $tipoUsuario) {
                $objecttipoUsuario = new \stdClass();
                $objecttipoUsuario->id = $tipoUsuario->id;
                $objecttipoUsuario->numero_registro = $cont;
                $objecttipoUsuario->nombre = $tipoUsuario->nombre;                
                array_push($array_tipoUsuarios, $objecttipoUsuario);
                $cont++;
            }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar a este tipo de usuario.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Tipo de usuario eliminado con éxito.",
                "tipoUsuarios" => $array_tipoUsuarios
            ], 200);
        }
    }
}
