<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Mail\NotificacionUsuarioNuevo;
use Mail;




class UserController extends Controller
{
    public function getUsuarios(Request $request){
        try {
            $user = Auth::user();

            $usuarios = User::where('status', 1)->where('tipo_usuario_id','!=', 1)->get();
            $array_usuarios = array();
            $cont = 1;
            foreach ($usuarios as $usuario) {
                $objectUsuario = new \stdClass();
                $objectUsuario->id = $usuario->id;
                $objectUsuario->numero_registro = $cont;
                $objectUsuario->username = $usuario->username;
                $objectUsuario->nombre = $usuario->nombre;
                $objectUsuario->apellido_paterno = $usuario->apellido_paterno;
                $objectUsuario->apellido_materno = $usuario->apellido_materno;
                $objectUsuario->nombrecompleto = $usuario->nombre.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno;
                $objectUsuario->email = $usuario->email;
                $objectUsuario->tipo_usuario_id = $usuario->tipo_usuario_id;
                $objectUsuario->tipo_usuario = $usuario->tipoUsuario->nombre;
                $objectUsuario->password = $usuario->password;

                array_push($array_usuarios, $objectUsuario);
                $cont++;
            }

            return response()->json([
                "status" => "ok",
                "message" => "Usuarios obtenidos con éxito",
                "usuarios" => $array_usuarios
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener el catalogo de usuarios",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
    public function nuevoUsuario(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
                $user = Auth::user();
                $pass = Str::random(10);
                
                $exists = User::where('email', $request->email)->exists();
                if ($exists) {
                    return response()->json([
                        "status" => "exists",
                        "message" => "Este email ya existe",
                    ], 200);
                }
                $usuario = new User;
                $usuario->nombre = $request->nombre;
                $usuario->apellido_paterno = $request->apellido_paterno;
                $usuario->apellido_materno = $request->apellido_materno;
                $usuario->email = $request->email;
                $usuario->username = $request->username;
                $usuario->password = $pass;
                $usuario->tipo_usuario_id = $request->tipo_usuario_id;
                $usuario->save();

                $usuarios = User::where('status', 1)->where('tipo_usuario_id','!=', 1)->get();
            
                $array_usuarios = array();
                $cont = 1;
                foreach ($usuarios as $usuario) {
                    $objectUsuario = new \stdClass();
                    $objectUsuario->id = $usuario->id;
                    $objectUsuario->numero_registro = $cont;
                    $objectUsuario->username = $usuario->username;
                    $objectUsuario->nombre = $usuario->nombre;
                    $objectUsuario->apellido_paterno = $usuario->apellido_paterno;
                    $objectUsuario->apellido_materno = $usuario->apellido_materno;
                    $objectUsuario->nombrecompleto = $usuario->nombre.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno;
                    $objectUsuario->email = $usuario->email;
                    $objectUsuario->tipo_usuario_id = $usuario->tipo_usuario_id;
                    $objectUsuario->tipo_usuario = $usuario->tipoUsuario->nombre;
                    $objectUsuario->password = $usuario->password;                    
                    array_push($array_usuarios, $objectUsuario);
                    $cont++;
                }


            DB::commit();
            $exito = true;
            
            Mail::to($usuario->email)->send(new NotificacionUsuarioNuevo($usuario->username,$usuario->password));
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al generar al nuevo usuario.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Nuevo Usuario guardado con éxito.",
                "usuarios" => $array_usuarios
            ], 200);
        }
    }
    public function actualizarUsuario(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $user = Auth::user();

            $usuario = User::find($request->id);
            $usuario->nombre = $request->nombre;
            $usuario->apellido_paterno = $request->apellido_paterno;
            $usuario->apellido_materno = $request->apellido_materno;
            $usuario->email = $request->email;
            $usuario->username = $request->username;
            $usuario->password = $request->password;            
            $usuario->tipo_usuario_id = $request->tipo_usuario_id;

            $usuario->save();

            $usuarios = User::where('status', 1)->where('tipo_usuario_id','!=', 1)->get();
            
            $array_usuarios = array();
            $cont = 1;
            foreach ($usuarios as $usuario) {
                $objectUsuario = new \stdClass();
                $objectUsuario->id = $usuario->id;
                $objectUsuario->numero_registro = $cont;
                $objectUsuario->username = $usuario->username;
                $objectUsuario->nombre = $usuario->nombre;
                $objectUsuario->apellido_paterno = $usuario->apellido_paterno;
                $objectUsuario->apellido_materno = $usuario->apellido_materno;
                $objectUsuario->nombrecompleto = $usuario->nombre.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno;
                $objectUsuario->email = $usuario->email;
                $objectUsuario->cede_id = $usuario->cede_id;
                $objectUsuario->nom_cede = $usuario->cede?->nombre;
                $objectUsuario->tipo_usuario_id = $usuario->tipo_usuario_id;
                $objectUsuario->tipo_usuario = $usuario->tipoUsuario->nombre;
                $objectUsuario->password = $usuario->password;
        
                array_push($array_usuarios, $objectUsuario);
                $cont++;
            }
            
            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al actualizar los datos del usuario.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Usuario actualizado con éxito.",
                "usuarios" => $array_usuarios
            ], 200);
        }
    }
    
    public function eliminarUsuario(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try {
            $user = Auth::user();

            $Usuario = User::find($request->id);
            $Usuario->status = false;
            $Usuario->save();

            $usuarios = User::where('status', 1)->where('tipo_usuario_id','!=', 1)->get();

            $array_usuarios = array();
            $cont = 1;
            foreach ($usuarios as $usuario) {
                $objectUsuario = new \stdClass();
                $objectUsuario->id = $usuario->id;
                $objectUsuario->numero_registro = $cont;
                $objectUsuario->username = $usuario->username;
                $objectUsuario->nombre = $usuario->nombre;
                $objectUsuario->apellido_paterno = $usuario->apellido_paterno;
                $objectUsuario->apellido_materno = $usuario->apellido_materno;
                $objectUsuario->nombrecompleto = $usuario->nombre.' '.$usuario->apellido_paterno.' '.$usuario->apellido_materno;
                $objectUsuario->email = $usuario->email;
                $objectUsuario->cede_id = $usuario->cede_id;
                $objectUsuario->nom_cede = $usuario->cede?->nombre;
                $objectUsuario->tipo_usuario_id = $usuario->tipo_usuario_id;
                $objectUsuario->tipo_usuario = $usuario->tipoUsuario->nombre;
                $objectUsuario->password = $usuario->password;
                
                array_push($array_usuarios, $objectUsuario);
                $cont++;
            }

            DB::commit();
            $exito = true;
        } catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al eliminar a este usuario.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Usuario eliminado con éxito.",
                "usuarios" => $array_usuarios
            ], 200);
        }
    }
}
