<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class RecordatorioPerExport implements FromCollection, WithHeadings
{
     protected $data;

    public function __construct($data){
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            "Documento",
            "Numero_de_documento",
            "Primer_nombre",
            "Segundo_nombre",
            "Primer_apellido",
            "Segundo_apellido",
            "Telefono",
            "Fecha_nacimiento",
            "Departamento",
            "Municipio",
            "Direccion",
            "Sexo",
            "Regimen_afiliacion_SGSS",
            "Fecha_reporte",
            "Mes",
            "Prioridad",
            "Fecha_Cita",
            "Convenio",
            "Especialidad",
            "Profesional",
            "Modalidad",
            "PYM",
            'SEGUIMIENTO 1',
            'FECHA DE SEGUIMIENTO 1',
            'AGENTE SEGUIMIENTO 1',
            'SEGUIMIENTO 2',
            'FECHA DE SEGUIMIENTO 2',
            'AGENTE SEGUIMIENTO 2',
            'SEGUIMIENTO 3',
            'FECHA DE SEGUIMIENTO 3',
            'AGENTE SEGUIMIENTO 3',
            "Archivo"
        ];
    }
}
