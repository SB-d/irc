<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteCampanaExport implements FromCollection, WithHeadings
{
    protected $CAM_ID;
    protected $fecha;

    public function __construct($CAM_ID, $fecha)
    {
        $this->fecha = $fecha;
        $this->CAM_ID = $CAM_ID;
    }

    public function headings(): array
    {
        return [
            'Cedula',
            'Nombre',
            'Campaña',
            'Horas'
        ];
    }
    public function collection()
    {

        $sql = 'SELECT emp.EMP_CEDULA, emp.EMP_NOMBRES, cam.CAM_NOMBRE, COUNT(mal.MAL_ID) AS horas
        FROM mallas AS mal
        INNER JOIN empleados AS emp ON emp.EMP_ID = mal.EMP_ID
        INNER JOIN campanas AS cam ON cam.CAM_ID = mal.CAM_ID
        WHERE mal.MAL_DIA = "'.$this->fecha.'"
        AND mal.MAL_ESTADO = 1
        AND mal.CAM_ID = '.$this->CAM_ID.'
        GROUP BY cam.CAM_NOMBRE, emp.EMP_NOMBRES, emp.EMP_CEDULA';

        $reporte = DB::select($sql);
        return collect($reporte);
    }
}
