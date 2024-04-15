<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

use App\Models\paciente;
use App\Models\departamento;
use App\Models\municipio;
use App\Models\tipos_identificacione;
use App\Models\cargue;
use App\Models\proceso;

use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\Failure;
use App\Imports\PacientesImport;

class PacientesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        ini_set('memory_limit', '200M');
    }

    public function index(){

        $pacientes = paciente::where('pac_estado', '=', '1')->take(50)->get();

        $departamentos = departamento::all();

        $tipos_identificacion = tipos_identificacione::where('tip_estado', '=', '1')->get();

        return view('consultar-pacientes.index', compact('pacientes', 'departamentos', 'tipos_identificacion'));

    }

    public function dep_mun(request $request){

        $sql = "SELECT * FROM `municipios` WHERE `dep_id` = ".$request->dep_id;

        $municipios = DB::select($sql);

        echo json_encode(
            array(
                "success" => true,
                "municipios" => $municipios
            )
        );

    }

    public function create(request $request){

        $this->validate($request, [
            'tip_id' => 'required',
            'pac_identificacion' => 'required',
            'pac_primer_nombre' => 'required',
            'pac_segundo_nombre' => '',
            'pac_primer_apellido' => 'required',
            'pac_segundo_apellido' => '',
            'pac_telefono' => 'required',
            'pac_fecha_nacimiento' => '',
            'dep_id' => 'required',
            'mun_id' => 'required',
            'pac_direccion' => '',
            'pac_sexo' => 'required',
            'pac_regimen_afiliacion_SGSS' => ''
        ]);

        $nombre_completo = $request->pac_primer_nombre.' '.$request->pac_segundo_nombre.' '.$request->pac_primer_apellido.' '.$request->pac_segundo_apellido;

            $paciente = paciente::create([
                'tip_id' => $request->tip_id,
                'pac_identificacion' => $request->pac_identificacion,
                'pac_primer_nombre' => $request->pac_primer_nombre,
                'pac_segundo_nombre' => $request->pac_segundo_nombre,
                'pac_primer_apellido' => $request->pac_primer_apellido,
                'pac_segundo_apellido' => $request->pac_segundo_apellido,
                'pac_nombre_completo' => $nombre_completo,
                'pac_telefono' => $request->pac_telefono,
                'pac_fecha_nacimiento' => $request->pac_fecha_nacimiento,
                'dep_id' => $request->dep_id,
                'mun_id' => $request->mun_id,
                'pac_direccion' => $request->pac_direccion,
                'pac_sexo' => $request->pac_sexo,
                'pac_regimen_afiliacion_SGSS' => $request->pac_regimen_afiliacion_SGSS,
            ]);

            /* $pac_id = $paciente->id;

            $n_mes = date("m");

            $meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", "MAYO", "JUNIO", "JULIO", "AGOSTO", "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];

            $mes = $meses[$n_mes - 1];

            $fecha = date('d-m-Y H:i:s');
            $fecha2 = date('Y-m-d');

            $validador = cargue::where('car_estado', '=', '1')->where('tpp_id', '=', '7')->where('car_mes', '=', $mes)->where('sys', '=', '1')->count();

            if($validador == 0){
                $cargue = cargue::create([
                    'car_fecha_cargue' => $fecha,
                    'car_mes' => $mes,
                    'car_fecha_reporte' => $fecha2,
                    'tpp_id' => '7',
                    'car_activo' => 'SI',
                    'sys' => 1
                ]);

                $car_id = $cargue->id;
            }else{
                $cargue = cargue::where('car_estado', '=', '1')->where('tpp_id', '=', '7')->where('car_mes', '=', $mes)->where('sys', '=', '1')->get();
                $car_id = $cargue[0]->car_id;
            }

            $proceso = proceso::create([
                'car_id' => $car_id,
                'pac_id' => $pac_id,
                'pro_prioridad' => $request->pro_prioridad
            ]); */


            return back()->with('mSucces', 'Paciente registrado correctamente');

    }

    /* MODAL EDIT */
    public function modal_edit(request $request){

        $sql = "SELECT tpi.tip_alias, pac.*, mun.mun_id, mun.mun_nombre, dep.dep_id, dep.dep_nombre
        FROM pacientes AS pac
        INNER JOIN tipos_identificaciones AS tpi ON tpi.tip_id = pac.tip_id
        INNER JOIN departamentos AS dep ON dep.dep_id = pac.dep_id
        INNER JOIN municipios AS mun ON mun.mun_id = pac.mun_id
        WHERE pac.pac_id = ".$request->pac_id;

        $paciente = DB::select($sql);

        $departamentos = departamento::all();

        echo json_encode(
            array(
                "success" => true,
                "paciente" => $paciente[0],
                "departamentos" => $departamentos
            )
        );

    }

    public function post_edit(request $request){
        $user_id = $request->user_id;
        paciente::where('pac_id', $request->pac_id)->update(["pac_telefono" => $request->pac_telefono]);
        paciente::where('pac_id', $request->pac_id)->update(["pac_direccion" => $request->pac_direccion]);
        paciente::where('pac_id', $request->pac_id)->update(["dep_id" => $request->dep_id]);
        paciente::where('pac_id', $request->pac_id)->update(["mun_id" => $request->mun_id]);
        paciente::where('pac_id', $request->pac_id)->update(["user_updated" => $user_id]);

        return back()->with('mSucces', 'Paciente actualizado correctamente');

    }

    /* IMPORTAR */
    public function importar(request $request){
        
        try{
            $file = $request->file('file');
            $rango = $request->rango;
            Excel::import(new PacientesImport($rango), $file);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $nombre = "Archivo de Pacientes";

            /* OPCION 1 */
            /*$pdf = PDF::loadView('importar.pdf-incorrecto', compact('failures','nombre'));
            return $pdf->download('Actaerror.pdf'); */

            /* OPCION 2 */
            /* return back()->with('import_error', $failures); */
                
            /* OPCION 3 */
            return view('importar.cargue-incorrecto', compact('failures','nombre'));
        }
        return back()->with('mSucces', 'Pacientes importados correctamente');
    }


    /* SEARCH */
    public function search(request $request){

        $sql = 'SELECT pac_id, pac_primer_nombre, pac_identificacion, pac_nombre_completo, pac_telefono
        FROM pacientes
        WHERE pac_estado = 1
        AND pac_identificacion LIKE "%'.$request->busqueda.'%"
        OR pac_nombre_completo LIKE "%'.$request->busqueda.'%"
        ORDER BY pac_primer_nombre ASC LIMIT 50';

        $pacientes = DB::select($sql);

        echo json_encode(
            array(
                "success" => true,
                "data" => $pacientes
            )
        );

    }


}
