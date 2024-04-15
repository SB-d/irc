<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\tipos_proceso;
use App\Models\actas_cargue;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\Failure;
use App\Imports\BrigadaImport;
use App\Imports\HospitalizadoImport;
use App\Imports\InasistidoImport;
use App\Imports\RecordatorioImport;
use App\Imports\ReprogramacionImport;
use App\Imports\SeguimientoImport;
use App\Imports\CaptacionImport;
use App\Imports\HosImport;

use PDF;
use Illuminate\Support\Facades\Mail;

class ImportarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        ini_set('memory_limit', '1000000M');
        ini_set('max_execution_time', '500');
        ini_set('upload_max_filesize', '100000M');
    }

    function index(){
        $tipos_procesos = tipos_proceso::where('tpp_estado', '=','1')->get();
        return view('importar.index', compact('tipos_procesos'));
    }

    function importar(request $request){

        return DB::transaction(function () use ($request){
            /* VALIDACIONES */
            $rango = $request->rango;
            $tipo = $request->tipo_proceso;
            $file = $request->file('file');
            $file_name = $request->file_name;
            $file_ir = substr($file_name, 0, -18);
            $file_pro = substr($file_name, 2, -15);
            $file_fecha = substr($file_name, 5, -7);
            $file_v = substr($file_name, 13, 2);
            $file_tipe = substr($file_name, 16);
            $file_len = strlen($file_name);

            $email = $request->email;

            /* VALIDAMOS QUE EL NOMBRE DEL ARCHIVO ESTE BIEN */
            if($file_len != 20 || $file_ir != "IR"){
                return back()->with('mDanger', 'El nombre del archivo no es adecuado, cambielo e intentelo nuevamente!');
            }

            $validador_car = actas_cargue::where('Acc_nombre', '=',substr($file_name, 0, -5))->where('Acc_estado', '=', '1')->count();
            if($validador_car > 0){
                return back()->with('mDanger', 'Ya subio un archivo con este mismo nombre!');
            }

            /* VALIDAMOS QUE LA FECHA EN EL NOMBRE DEL ARCHIVO ESTE BIEN */
            $year = intval(substr($file_fecha, 0, -4));
            $mes = intval(substr($file_fecha, 4, -2));
            $dia = intval(substr($file_fecha, 6));

            if($mes > 12 || $dia > 31 || $mes < 0 || $dia < 0 || $mes == 0 || $year == 0 || $dia == 0){
                return back()->with('mDanger', 'La fecha dentro del nombre es invalida!');
            }

            try {
                switch ($tipo) {
                    case '1':
                        /* inasistidos */
                        if($file_pro != "INA"){
                            return back()->with('mDanger', 'Este archivo no es de inasistidos, seleccione un tipo correcto!');
                        }
                        $fecha = date('Ymd-hms');
                        $acc_codigo = substr($file_name, 0, -5)."-".$fecha;
                        Excel::import(new InasistidoImport($acc_codigo, substr($file_name, 0, -5), $rango), $file);
                        break;
                    case '2':
                        /* seguimiento */
                        if($file_pro != "SEG"){
                            return back()->with('mDanger', 'Este archivo no es de seguimientos, seleccione un tipo correcto!');
                        }
                        $fecha = date('Ymd-hms');
                        $acc_codigo = substr($file_name, 0, -5)."-".$fecha;
                        Excel::import(new SeguimientoImport($acc_codigo, substr($file_name, 0, -5), $rango), $file);
                        break;
                    case '3':
                        /* recordatorio */
                        if($file_pro != "REC"){
                            return back()->with('mDanger', 'Este archivo no es de recordatorios, seleccione un tipo correcto!');
                        }
                        $fecha = date('Ymd-hms');
                        $acc_codigo = substr($file_name, 0, -5)."-".$fecha;
                        Excel::import(new RecordatorioImport($acc_codigo, substr($file_name, 0, -5), $rango), $file);
                        break;
                    case '4':
                        /* hospitalizados */
                        if($file_pro != "HOS"){
                            return back()->with('mDanger', 'Este archivo no es de hospitalizados, seleccione un tipo correcto!');
                        }
                        $fecha = date('Ymd-hms');
                        $acc_codigo = substr($file_name, 0, -5)."-".$fecha;
                        Excel::import(new HospitalizadoImport($acc_codigo, substr($file_name, 0, -5), $rango), $file);
                        break;
                    case '5':
                        /* brigadas */
                        if($file_pro != "BRI"){
                            return back()->with('mDanger', 'Este archivo no es de brigadas, seleccione un tipo correcto!');
                        }
                        $fecha = date('Ymd-hms');
                        $acc_codigo = substr($file_name, 0, -5)."-".$fecha;
                        Excel::import(new BrigadaImport($acc_codigo, substr($file_name, 0, -5), $rango), $file);
                        break;
                    case '6':
                        /* reprogramacion */
                        if($file_pro != "REP"){
                            return back()->with('mDanger', 'Este archivo no es de reprogramaciones, seleccione un tipo correcto!');
                        }
                        $fecha = date('Ymd-hms');
                        $acc_codigo = substr($file_name, 0, -5)."-".$fecha;
                        Excel::import(new ReprogramacionImport($acc_codigo, substr($file_name, 0, -5), $rango), $file);
                        break;
                    case '7':
                        /* captacion */
                        if($file_pro != "CAP"){
                            return back()->with('mDanger', 'Este archivo no es de captacion, seleccione un tipo correcto!');
                        }
                        $fecha = date('Ymd-hms');
                        $acc_codigo = substr($file_name, 0, -5)."-".$fecha;
                        Excel::import(new CaptacionImport($acc_codigo, substr($file_name, 0, -5), $rango), $file);
                        break;
                    default:
                        return back()->with('mDanger', 'Error en la seleccion del proceso!');
                        break;
                }
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                $failures = $e->failures();
                $nombre = substr($file_name, 0, -5);

                /* OPCION 1 */
                /*$pdf = PDF::loadView('importar.pdf-incorrecto', compact('failures','nombre'));
                return $pdf->download('Actaerror.pdf'); */

                /* OPCION 2 */
                /* return back()->with('import_error', $failures); */
                
                /* OPCION 3 */
                return view('importar.cargue-incorrecto', compact('failures','nombre'));
            }
            /* OPCION 1 */
            return redirect()->back()->with('mSucces', 'Cargue exito!');

            /* OPCION 2 */
            /* 
            $acta = actas_cargue::where('Acc_codigo', $acc_codigo)->get();
            return view('importar.cargue-correcto', compact('acta')); 
            */
            
        }, 5);


    }

}
