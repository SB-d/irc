<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ReporteAgenteNAExport implements FromCollection, WithHeadings
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
            "Identificacion",
            "Nombre Completo",
            "Total de Gestiones",
            "Fecha Ultima Gestion",
            "Resultado Ultima Gestion",
            "Comentario Ultima Gestion"
        ];
    }
}
