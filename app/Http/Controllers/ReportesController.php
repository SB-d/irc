<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;

use App\Exports\ReporteExport;

use App\Models\tipos_proceso;
use App\Models\departamento;

class ReportesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        ini_set('memory_limit', '200M');
    }

    function index(){
        $tipos_procesos = tipos_proceso::where('tpp_estado', '=', '1')->get();
        $departamentos = departamento::where('dep_estado', '=', '1')->get();

        /* ADMINISTRAR CARGUES */

        $sql = "SELECT car.car_id, acc.Acc_id, acc.Acc_nombre, acc.Acc_codigo, car.car_mes,
        car.car_fecha_cargue, car.car_fecha_reporte, car.tpp_id, acc.Acc_cargados
        FROM cargues AS car
        INNER JOIN actas_cargues AS acc ON acc.car_id = car.car_id
        WHERE acc.Acc_estado = 1";

        $cargues = DB::select($sql);

        $sql_agentes = "SELECT age.age_id, age.tip_id, age.age_documento, usu.id ,usu.name, usu.email
        FROM agentes AS age
        INNER JOIN users AS usu ON usu.id = age.user_id
        WHERE age.age_estado = 1";

        $agentes = DB::select($sql_agentes);

        return view('reportes.index', compact('tipos_procesos', 'departamentos', 'cargues', 'agentes'));
    }

    function reporte_descarga(request $request){

        $tpp_id = $request->tipo_proceso;
        $dep_id = $request->departamento;
        $rep_formato = $request->rep_formato;
        $fecha_ini = $request->rep_fecha_ini;
        $fecha_fin = $request->rep_fecha_fin;

        if($rep_formato == "excel"){

            $gestiones = $this->gestiones_realizadas($tpp_id, $fecha_ini, $fecha_fin, $dep_id);

            if(count($gestiones) == 0){
                return back()->with('mDanger', 'No hay gestiones entre el '.$fecha_ini.' y el '.$fecha_fin.'!');
            }

            $total = $this->total_gestiones($tpp_id, $fecha_ini, $fecha_fin, $dep_id);
            $cantidad = $this->contar_gestiones($tpp_id, $fecha_ini, $fecha_fin, $dep_id);
            $faltantes = $total-$cantidad;

            $cumplimiento = round(($cantidad*100)/$total)."%";

            $meses_cargados = $this->mes_cargados($tpp_id, $fecha_ini, $fecha_fin, $dep_id);

            $sql_tpp = "SELECT tge.tge_nombre FROM tipos_gestiones AS tge";
            $tipos_gestiones = DB::select($sql_tpp);

            $a = tipos_proceso::where('tpp_id', '=', $tpp_id)->get('tpp_nombre');
            $tipos_procesos = $a[0]->tpp_nombre;

            $b = departamento::where('dep_id', '=', $dep_id)->get('dep_nombre');
            $departamentos = $b[0]->dep_nombre;

            return Excel::download(new ReporteExport($gestiones, $meses_cargados, $tipos_gestiones, $tipos_procesos, $departamentos, $fecha_ini, $fecha_fin, $total, $cantidad, $faltantes, $cumplimiento), $fecha_ini.'_'.$fecha_fin.'_REPORTE.xlsx');

        }else if ($rep_formato == "pdf") {
            $total = $this->total_gestiones($tpp_id, $fecha_ini, $fecha_fin, $dep_id);

            if($total == 0){
                return back()->with('mDanger', 'No hay registros entre el '.$fecha_ini.' y el '.$fecha_fin.'!!');
            }

            $gestiones = $this->busca_gestion($tpp_id, $fecha_ini, $fecha_fin, $dep_id);
            $cantidad = $this->contar_gestiones($tpp_id, $fecha_ini, $fecha_fin, $dep_id);
            $faltantes = $total-$cantidad;
            
            $cumplimiento = round(($cantidad*100)/$total)."%";

            $a = tipos_proceso::where('tpp_id', '=', $tpp_id)->get('tpp_nombre');
            $tipos_procesos = $a[0]->tpp_nombre;

            $b = departamento::where('dep_id', '=', $dep_id)->get('dep_nombre');
            $departamentos = $b[0]->dep_nombre;

            $pdf = PDF::loadView('reportes.pdf', compact('gestiones', 'cantidad', 'total', 'faltantes', 'cumplimiento', 'departamentos', 'tipos_procesos', 'fecha_ini', 'fecha_fin'))->setOptions(['defaultFont' => 'sans-serif']);
            $nombre = $fecha_ini."-".$fecha_fin."-";

            return $pdf->stream($nombre.'reporte.pdf');
        }else{
            dd('error '.$rep_formato);
        }

    }

    //REPORTE PDF FUNCIONES

    function busca_gestion($tpp_id, $fecha_ini, $fecha_fin, $dep_id){
        $sql = "SELECT tge.tge_nombre, IFNULL(T1.cantidad, 0) AS cantidad
                FROM tipos_gestiones AS tge
                LEFT JOIN (
                    SELECT tge.tge_nombre AS tge_nombre, count(pro.tge_id) AS cantidad
                    FROM procesos AS pro
                    INNER JOIN tipos_gestiones AS tge ON tge.tge_id = pro.tge_id
                    INNER JOIN cargues AS car ON car.car_id = pro.car_id
                    INNER JOIN pacientes AS pac ON pac.pac_id = pro.pac_id
                    WHERE pro.pro_estado = 1
                    AND car.tpp_id = ".$tpp_id."
                    AND tge.tge_estado = 1
                    AND car.car_estado = 1
                    AND pac.dep_id = ".$dep_id."
                    AND car.car_fecha_reporte BETWEEN '".$fecha_ini."' AND '".$fecha_fin."'
                    GROUP BY tge.tge_nombre
                ) T1 ON T1.tge_nombre = tge.tge_nombre ";
        return DB::select($sql);

    }

    function contar_gestiones($tpp_id, $fecha_ini, $fecha_fin, $dep_id){
        
        $sql = "SELECT count(pro.tge_id) AS cantidad
                FROM procesos AS pro
                INNER JOIN tipos_gestiones AS tge ON tge.tge_id = pro.tge_id
                INNER JOIN cargues AS car ON car.car_id = pro.car_id
                INNER JOIN pacientes AS pac ON pac.pac_id = pro.pac_id
                WHERE pro.pro_estado = 1
                AND car.car_estado = 1
                AND car.tpp_id = ".$tpp_id."
                AND pac.dep_id = ".$dep_id."
                AND car.created_at BETWEEN '".$fecha_ini." 00:00:00' AND '".$fecha_fin." 23:59:59'";
        $cantidad = DB::select($sql);
        return $cantidad[0]->cantidad;

    }

    function total_gestiones($tpp_id, $fecha_ini, $fecha_fin, $dep_id){
        $sql = "SELECT COUNT(pro.pro_id) AS cantidad
                FROM procesos AS pro
                INNER JOIN cargues AS car ON car.car_id = pro.car_id
                INNER JOIN pacientes AS pac ON pac.pac_id = pro.pac_id
                WHERE pro.pro_estado = 1
                AND car.car_estado = 1
                AND car.tpp_id = ".$tpp_id."
                AND pac.dep_id = ".$dep_id."
                AND car.created_at BETWEEN '".$fecha_ini." 00:00:00' AND '".$fecha_fin." 23:59:59'";
        $cantidad = DB::select($sql);
        return $cantidad[0]->cantidad;
    }

    //REPORTE EXCEL FUNCIONES

    function gestiones_realizadas($tpp_id, $fecha_ini, $fecha_fin, $dep_id){
        $sql = "SELECT tge.tge_nombre AS tge_nombre, count(pro.tge_id) AS cantidad, car.car_mes
                FROM procesos AS pro
                INNER JOIN tipos_gestiones AS tge ON tge.tge_id = pro.tge_id
                INNER JOIN cargues AS car ON car.car_id = pro.car_id
                INNER JOIN pacientes AS pac ON pac.pac_id = pro.pac_id
                WHERE pro.pro_estado = 1
                AND car.car_estado = 1
                AND tge.tge_estado = 1
                AND car.tpp_id = ".$tpp_id."
                AND pac.dep_id = ".$dep_id."
                AND car.created_at BETWEEN '".$fecha_ini." 00:00:00' AND '".$fecha_fin." 23:59:59'
                GROUP BY tge.tge_nombre, car.car_mes
                ORDER BY car.car_mes";
        return DB::select($sql);
    }

    function mes_cargados($tpp_id, $fecha_ini, $fecha_fin, $dep_id){
        $sql = "SELECT car.car_mes
                FROM procesos AS pro
                INNER JOIN tipos_gestiones AS tge ON tge.tge_id = pro.tge_id
                INNER JOIN cargues AS car ON car.car_id = pro.car_id
                INNER JOIN pacientes AS pac ON pac.pac_id = pro.pac_id
                WHERE pro.pro_estado = 1
                AND car.car_estado = 1
                AND car.tpp_id = ".$tpp_id."
                AND pac.dep_id = ".$dep_id."
                AND car.created_at BETWEEN '".$fecha_ini." 00:00:00' AND '".$fecha_fin." 23:59:59'
                GROUP BY car.car_mes";
        return DB::select($sql);
    }



}


