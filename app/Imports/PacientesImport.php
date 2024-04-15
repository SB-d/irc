<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

use App\Models\municipio;
use App\Models\departamento;
use App\Models\tipos_identificacione;
use App\Models\paciente;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;

class PacientesImport implements ToModel, WithHeadingRow, WithValidation
{

    protected $range;
    protected $insert_range;

    public function __construct(int $range)
    {
        $this->range = intval($range);
        $this->insert_range = round($range/5, 0);
    }
    
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {

        $fecha_nacimiento = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_nacimiento'])->format('Y-m-d');
        
        $ti = tipos_identificacione::where('tip_alias', '=', $row['documento'])->get();
        $departamento = departamento::where('dep_nombre', '=', $row['departamento'])->get();
        $municipio = municipio::where('mun_nombre', '=', $row['municipio'])->get();

        $validador_pac = paciente::where('pac_identificacion', $row['numero_de_documento'])->count();
        $nombre_completo = $row['primer_nombre'].' '.$row['segundo_nombre'].' '.$row['primer_apellido'].' '.$row['segundo_apellido'];

        if($validador_pac == 0){
            $paciente = paciente::create([
                'tip_id' => $ti[0]->tip_id,
                'pac_identificacion' => $row['numero_de_documento'],
                'pac_primer_nombre' => $row['primer_nombre'],
                'pac_segundo_nombre' => $row['segundo_nombre'],
                'pac_primer_apellido' => $row['primer_apellido'],
                'pac_segundo_apellido' => $row['segundo_apellido'],
                'pac_nombre_completo' => $nombre_completo,
                'pac_telefono' => strval($row['telefono']),
                'pac_fecha_nacimiento' => $fecha_nacimiento,
                'dep_id' => $departamento[0]->dep_id,
                'mun_id' => $municipio[0]->mun_id,
                'pac_direccion' => $row['direccion'],
                'pac_sexo' => $row['sexo'],
                'pac_regimen_afiliacion_SGSS' => $row['regimen_afiliacion_sgss']
            ]);
        }else{
            $paciente = paciente::where('pac_identificacion', $row['numero_de_documento'])->get();

            /*paciente::where('pac_identificacion', $row['numero_de_documento'])->update([
                "tip_id" => $ti[0]->tip_id,
                "pac_identificacion" => $row['numero_de_documento'],
                "pac_primer_nombre" => $row['primer_nombre'],
                "pac_segundo_nombre" => $row['segundo_nombre'],
                "pac_primer_apellido" => $row['primer_apellido'],
                "pac_segundo_apellido" => $row['segundo_apellido'],
                "pac_nombre_completo" => $nombre_completo,
                "pac_telefono" => strval($row['telefono']),
                "pac_fecha_nacimiento" => $fecha_nacimiento,
                "dep_id" => $departamento[0]->dep_id,
                "mun_id" => $municipio[0]->mun_id,
                "pac_direccion" => $row['direccion'],
                "pac_sexo" => $row['sexo'],
                "pac_regimen_afiliacion_SGSS" => $row['regimen_afiliacion_sgss']
            ]);*/
        }

    }
    
    public function rules(): array
    {
        return [
            'numero_de_documento' => 'required',
            '*.numero_de_documento' => 'required',

            'primer_nombre' => 'required',
            '*.primer_nombre' => 'required',

            'primer_apellido' => 'required',
            '*.primer_apellido' => 'required',

            'telefono' => 'required',
            '*.telefono' => 'required',

            'fecha_nacimiento' => 'required',
            '*.fecha_nacimiento' => 'required',

            'documento' => 'required|exists:tipos_identificaciones,tip_alias',
            '*.documento' => 'required|exists:tipos_identificaciones,tip_alias',

            'departamento' => 'required|exists:departamentos,dep_nombre',
            '*.departamento' => 'required|exists:departamentos,dep_nombre',

            'municipio' => 'required|exists:municipios,mun_nombre',
            '*.municipio' => 'required|exists:municipios,mun_nombre',

        ];
    }
}
