<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Expediente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ExpedienteController extends Controller
{
    public function getDatos()
    {
            $dt = Carbon::now();
             //Asignacion del numero consecutivo del expediente
                $ultimo_expediente = Expediente::all()->last();
                if($ultimo_expediente){
                    $expediente = $ultimo_expediente->expediente + 1;
                }else{
                    $expediente = 1;
                }
                //año actual
                $ayo = $dt->year;
                //fecha actual
                // $fecha = Carbon::create($anio, $day->mes, $dia_fecha);
                $fecha = $dt->format('Y-m-d');


            return response()->json([
                "status" => "ok",
                "message" => "Datos obtenido con exito",
                "expediente" => $expediente,
                "ayo" => $ayo,
                "fecha" => $fecha
            ], 200);
    }
    public function guardarExpediente(Request $request)
    {
        $exito = false;

        DB::beginTransaction();
        try{
            $user = Auth::user();
                
                //Asignacion de la ponencia dependiendo del tipo de juicio
                $ultimo_juicio = Expediente::where('juicio_id', $request->juicio_id)->orderBy('id','desc')->first();
                // $ponencia = $ultimo_juicio->ponencia_id;
                switch ($request->juicio_id){

                    case 1:
                        if ($ultimo_juicio == null) {
                            $ponencia_id = 1;
                        }
                        break;
                    case 2:
                        if ($ultimo_juicio == null) {
                            $ponencia_id = 2;
                        }
                        break;
                    case 3:
                        if ($ultimo_juicio == null) {
                            $ponencia_id = 3;
                        }
                        break;
                    case 4:
                        if ($ultimo_juicio == null) {
                            $ponencia_id = 4;
                        }
                        break;
                    case 5:
                        if ($ultimo_juicio == null) {
                            $ponencia_id = 5;
                        }
                        break;
                    case 6:
                        if ($ultimo_juicio == null) {
                            $ponencia_id = 2;
                        }
                        break;
                    case 7:
                        if ($ultimo_juicio == null) {
                            $ponencia_id = 3;
                        }
                        break;
                }
                if($ultimo_juicio){
                    if($ultimo_juicio->ponencia_id < 5){
                        $ponencia_id = $ultimo_juicio->ponencia_id + 1;
                    }else{
                        $ponencia_id = 1;
                    }
                }

                $registro = new Expediente;
                $registro->expediente = $request->expediente;
                $registro->ayo = $request->ayo;
                $registro->fecha = $request->fecha;
                $registro->actor = $request->actor;
                $registro->demandado = $request->demandado;
                $registro->juicio_id = $request->juicio_id;
                $registro->ponencia_id = $ponencia_id;
                $registro->user_id = $user->id;
                $registro->save();

                if ($request->file('archivo')) {
                    $current_day = Carbon::now();
                    $fecha_hora_concatenar_archivo = $current_day->day . '_' . $current_day->month . '_' . $current_day->year . '_' . $current_day->hour . '_' . $current_day->minute . '_' . $current_day->second . '_' . $current_day->micro;
                    $file = $request->file('archivo');
                    $extension = $file[0]->getClientOriginalExtension();
                    $fileNameToStore = 'archivo_' . $fecha_hora_concatenar_archivo . '.' . $extension;
                    $path = $request->file('archivo')[0]->storeAs('public', $fileNameToStore);
                    $registro->archivo = $path;
                    $registro->save();
                }
                $array_registros = array();

                $registros = Expediente::all();
                foreach($registros as $registro){
                    $objectRegistro = new \stdClass();
                    $objectRegistro->id = $registro->id;
                    $objectRegistro->expediente = $registro->expediente; 
                    $objectRegistro->ayo = $registro->ayo; 
                    $objectRegistro->fecha = $registro->fecha; 
                    $objectRegistro->actor = $registro->actor; 
                    $objectRegistro->demandado = $registro->demandado; 
                    $objectRegistro->juicio_id = $registro->juicio_id; 
                    $objectRegistro->ponencia_id = $registro->ponencia_id; 
                    $objectRegistro->user_id = $registro->user_id; 
                    $objectRegistro->archivo = Storage::url($registro->archivo);

                    array_push($array_registros,$objectRegistro);
                }
                DB::commit();
                $exito = true;

        }catch (\Throwable $th) {
            DB::rollback();
            $exito = false;
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al guardar el registro del expediente.",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }

        if ($exito) {
            return response()->json([
                "status" => "ok",
                "message" => "Registro del expediente guardado con éxito",
                "registros" => $array_registros
            ], 200);
        }

    }
    public function consultaExp(Request $request){
        try{
            if($request->fecha_fin != null){
                $consultas = Expediente::whereBetween('fecha',[$request->fecha_inicio, $request->fecha_fin])->get();
            }else{
                $consultas = Expediente::whereDate('fecha',$request->fecha_inicio)->get();
            }
            $array_consultas = array();
            $cont = 1;
            foreach($consultas as $consulta){
                $objectConsulta = new \stdClass();
                $objectConsulta->id = $consulta->id;
                $objectConsulta->expediente = $consulta->expediente; 
                $objectConsulta->ayo = $consulta->ayo; 
                $objectConsulta->fecha = $consulta->fecha; 
                $objectConsulta->actor = $consulta->actor; 
                $objectConsulta->demandado = $consulta->demandado; 
                $objectConsulta->juicio_id = $consulta->juicio_id; 
                $objectConsulta->ponencia_id = $consulta->ponencia_id; 
                $objectConsulta->user_id = $consulta->user_id; 
                $objectConsulta->archivo = Storage::url($consulta->archivo);

                array_push($array_consultas, $objectConsulta);
                $cont++;
            }
            return response()->json([
                "status" => "ok",
                "message" => "Consulta de expedientes obtenida con éxito",
                "consultaExp" => $array_consultas
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "status" => "error",
                "message" => "Ocurrió un error al obtener los registros de los expedientes",
                "error" => $th->getMessage(),
                "location" => $th->getFile(),
                "line" => $th->getLine(),
            ], 200);
        }
    }
}
