<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use PDF;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;

use App\Models\agente;
use App\Exports\ReporteAgenteNAExport;

class ReporteAgenteController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        ini_set('memory_limit', '200M');
    }

    public function get_reporte(request $request, $age_id){

        $this->validate($request, [
            'tipo_proceso' => 'required'
        ]);

        switch ($request->tipo_proceso) {
            case '1':
                $pdf = $this->rep_pdf('1',$age_id);

                if($pdf != 'error'){
                    $sql_agente_data = "SELECT age.age_id, age.tip_id, age.age_documento, usu.id ,usu.name, usu.email
                    FROM agentes AS age
                    INNER JOIN users AS usu ON usu.id = age.user_id
                    WHERE age.age_estado = 1
                    AND age.age_id = ".$age_id;

                    $agente = DB::select($sql_agente_data);

                    return $pdf->stream($agente[0]->name.'-'.$agente[0]->age_documento.'-reporte.pdf');
                }else{
                    return redirect()->back()->with('mDanger', 'Este agente no se le ha asignado en ningun archivo!');
                }

                break;

            case '2':

                $this->validate($request, [
                    'fecha_inicio' => 'required',
                    'fecha_fin' => 'required'
                ]);

                $pdf = $this->rep_pdf('2',$age_id, $request->fecha_inicio, $request->fecha_fin);

                if($pdf != 'error'){
                    $sql_agente_data = "SELECT age.age_id, age.tip_id, age.age_documento, usu.id ,usu.name, usu.email
                    FROM agentes AS age
                    INNER JOIN users AS usu ON usu.id = age.user_id
                    WHERE age.age_estado = 1
                    AND age.age_id = ".$age_id;

                    $agente = DB::select($sql_agente_data);

                    return $pdf->stream($agente[0]->name.'-'.$agente[0]->age_documento.'-reporte.pdf');
                }else{
                    return redirect()->back()->with('mWarning', 'Este agente no se le ha asignado en ningun archivo!');
                }

                break;

            case '3':

                $this->validate($request, [
                    'nombre_archivo' => 'required'
                ]);

                $data_excel = $this->rep_archivo($age_id, $request->nombre_archivo);

                if($data_excel != 'error'){
                    $sql_agente_data = "SELECT age.age_id, age.tip_id, age.age_documento, usu.id ,usu.name, usu.email
                    FROM agentes AS age
                    INNER JOIN users AS usu ON usu.id = age.user_id
                    WHERE age.age_estado = 1
                    AND age.age_id = ".$age_id;

                    $agente = DB::select($sql_agente_data);

                    return Excel::download(new ReporteAgenteNAExport($data_excel), $agente[0]->name.'-'.$agente[0]->age_documento.'-'.$request->nombre_archivo.'-reporte.xlsx');
                }else{
                    return redirect()->back()->with('mWarning', 'Este agente no se le ha asignado en ningun proceso de este archivo!');
                }


                break;

            default:
            return redirect()->back()->with('mDanger', 'Error case!');
                break;
        }

    }

    function rep_pdf($tip_pro, $age_id, $fecha_ini = null, $fecha_fin = null){

        if($fecha_ini == null && $fecha_fin == null && $tip_pro == '1'){
            $sql_cargues = "SELECT car.car_id, car.car_fecha_cargue, acc.Acc_nombre
            FROM proceso_agentes AS pag
            INNER JOIN procesos AS pro ON pro.pro_id = pag.pro_id
            INNER JOIN cargues AS car ON car.car_id = pro.car_id
            INNER JOIN actas_cargues AS acc ON acc.car_id = car.car_id
            WHERE pag.pag_estado = 1
            AND car.car_estado = 1
            AND pag.age_id = ".$age_id."
            GROUP BY car.car_id, acc.Acc_nombre, car.car_fecha_cargue";

            $cargues_asig = DB::select($sql_cargues);
        }else{
            $sql_cargues = "SELECT car.car_id, car.car_fecha_cargue, acc.Acc_nombre
            FROM proceso_agentes AS pag
            INNER JOIN procesos AS pro ON pro.pro_id = pag.pro_id
            INNER JOIN cargues AS car ON car.car_id = pro.car_id
            INNER JOIN actas_cargues AS acc ON acc.car_id = car.car_id
            WHERE pag.pag_estado = 1
            AND car.car_estado = 1
            AND pag.age_id = ".$age_id."
            AND car.created_at BETWEEN '".$fecha_ini."' AND '".$fecha_fin."'
            GROUP BY car.car_id, acc.Acc_nombre, car.car_fecha_cargue";

            $cargues_asig = DB::select($sql_cargues);
        }


        if($cargues_asig == null){
            return 'error';
        }

        $a = 0;
        foreach ($cargues_asig as $cargue) {

            $data_report[$a]['fecha'] = $cargue->car_fecha_cargue;
            $data_report[$a]['archivo'] = $cargue->Acc_nombre;

            /* CANTIDAD DE ASIGNACION */

            $sql_pro_asig = "SELECT COUNT(pag.pag_id) AS cant_pro_asig
            FROM proceso_agentes AS pag
            INNER JOIN procesos AS pro ON pro.pro_id = pag.pro_id
            INNER JOIN cargues AS car ON car.car_id = pro.car_id
            INNER JOIN actas_cargues AS acc ON acc.car_id = car.car_id
            WHERE pag.pag_estado = 1
            AND car.car_estado = 1
            AND pag.age_id = ".$age_id."
            AND car.car_id = ".$cargue->car_id;

            $pro_asig = DB::select($sql_pro_asig);

            $pro_asig_count = count($pro_asig);

            $data_report[$a]['asignados'] = $pro_asig[0]->cant_pro_asig;


            $sql_ges_realiz = "SELECT ges.pro_id
            FROM gestiones AS ges
            INNER JOIN procesos AS pro ON pro.pro_id = ges.pro_id
            INNER JOIN cargues AS car ON car.car_id = pro.car_id
            INNER JOIN actas_cargues AS acc ON acc.car_id = car.car_id
            WHERE ges.ges_estado = 1
            AND car.car_estado = 1
            AND ges.age_id = ".$age_id."
            AND car.car_id = ".$cargue->car_id."
            GROUP BY ges.pro_id";

            $ges = DB::select($sql_ges_realiz);

            $ges_count = count($ges);

            $data_report[$a]['gestionados'] = $ges_count;

            $data_report[$a]['faltantes'] = intval($pro_asig[0]->cant_pro_asig) - intval($ges_count);

            $data_report[$a]['cumplimiento'] = round((intval($ges_count)*100)/intval($pro_asig[0]->cant_pro_asig))."%";

            $a++;
            /* dd(); */
        }

        $sql_agente_data = "SELECT age.age_id, age.tip_id, age.age_documento, usu.id ,usu.name, usu.email
        FROM agentes AS age
        INNER JOIN users AS usu ON usu.id = age.user_id
        WHERE age.age_estado = 1
        AND age.age_id = ".$age_id;

        $agente = DB::select($sql_agente_data);

        $pdf = PDF::loadView('reportes.rep_agente_pdf', compact('data_report', 'agente'))->setOptions(['defaultFont' => 'sans-serif']);

        return $pdf;
    }

    function rep_archivo($age_id, $archivo_nombre){

        $sql_archivo = "SELECT pac.pac_id, pac.pac_identificacion,
        pac.pac_nombre_completo, pag.pro_id, car.car_id,
        ges.age_id AS id_agente_gestion, pro.ges_id AS id_ultima_gestion,
        COUNT(ges.ges_id) AS total_gestiones
        FROM proceso_agentes AS pag
        INNER JOIN procesos AS pro ON pro.pro_id = pag.pro_id
        INNER JOIN cargues AS car ON car.car_id = pro.car_id
        INNER JOIN actas_cargues AS acc ON acc.car_id = car.car_id
        INNER JOIN pacientes AS pac ON pac.pac_id = pro.pac_id
        LEFT JOIN gestiones AS ges ON ges.pro_id = pro.pro_id
        WHERE pag.pag_estado = 1
        AND car.car_estado = 1
        AND pag.age_id = ".$age_id."
        AND acc.Acc_nombre = '".$archivo_nombre."'
        GROUP BY pac.pac_id, pac.pac_identificacion, pac.pac_nombre_completo,
        pag.pro_id, car.car_id, id_agente_gestion, id_ultima_gestion";

        $data_archivo = DB::select($sql_archivo);
        
        
        if($data_archivo == null){
            return 'error';
        }

        $a = 0;
        foreach ($data_archivo as $list) {

            $data_report[$a]['Identificacion'] = $list->pac_identificacion;
            $data_report[$a]['Nombre Completo'] = $list->pac_nombre_completo;

            $data_report[$a]['Total de Gestiones'] = "0";
            $data_report[$a]['Fecha Ultima Gestion'] = " ";
            $data_report[$a]['Resultado Ultima Gestion'] = " ";
            $data_report[$a]['Comentario Ultima Gestion'] = " ";

            if($list->id_ultima_gestion != null && $list->id_agente_gestion == $age_id){
                $data_report[$a]['Total de Gestiones'] = $list->total_gestiones;

                $sql_gestion = "SELECT ges.ges_id, tge.tge_id, tge.tge_nombre, ges.ges_comentario, ges.ges_fecha
                FROM gestiones AS ges
                INNER JOIN tipos_gestiones AS tge ON tge.tge_id = ges.tge_id
                WHERE ges.ges_id = ".$list->id_ultima_gestion;

                $ult_gestion = DB::select($sql_gestion);

                $data_report[$a]['Fecha Ultima Gestion'] = $ult_gestion[0]->ges_fecha;
                $data_report[$a]['Resultado Ultima Gestion'] = $ult_gestion[0]->tge_nombre;
                $data_report[$a]['Comentario Ultima Gestion'] = $ult_gestion[0]->ges_comentario;

            }
            $a++;
        }

        return $data_report;
    }

}
