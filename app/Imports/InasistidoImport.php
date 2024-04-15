<?php

namespace App\Imports;

use App\Models\inasistido;
use App\Models\municipio;
use App\Models\departamento;
use App\Models\tipos_identificacione;
use App\Models\cargue;
use App\Models\proceso;
use App\Models\paciente;
use App\Models\actas_cargue;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Concerns\WithValidation;

class InasistidoImport implements ToModel, WithHeadingRow, WithValidation, WithChunkReading, WithBatchInserts
{

    protected $acc_codigo;
    protected $file_name;
    protected $r_leidos = 0;
    protected $r_duplicados = 0;
    protected $r_cargados = 0;
    protected $car_id = 0;
    protected $range;

    public function __construct(string $acc_codigo, string $file_name, int $range)
    {
        $this->acc_codigo = $acc_codigo;
        $this->file_name = $file_name;
        $this->range = intval($range);
    }

    public function model(array $row)
    {
        $this->r_leidos = $this->r_leidos+1;

        $fecha_reporte = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_reporte'])->format('Y-m-d');

        $fecha_cita = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['fecha_cita'])->format('Y-m-d');
        $mes_year = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['mes_year'])->format('M-Y');

        $paciente = paciente::select('pac_id')->where('pac_identificacion', $row['numero_de_documento'])->get();
        $pac_id = $paciente[0]->pac_id;

        $fecha = date('d-m-Y H:i:s');

        if($this->car_id == 0){
            $cargue = cargue::create([
                'car_fecha_cargue' => $fecha,
                'car_mes' => $mes_year,
                'car_fecha_reporte' => $fecha_reporte,
                'tpp_id' => '1'
            ]);

            $this->car_id = $cargue->id;
        }

        $proceso = proceso::create([
            'car_id' => $this->car_id,
            'pac_id' => $pac_id,
            'pro_prioridad' => $row['prioridad']
        ]);

        $brigada = inasistido::create([
            'pro_id' => $proceso->id,
            'ina_fecha_cita' => $fecha_cita,
            'ina_convenio_nombre' => $row['convenio'],
            'ina_medico_nombre' => $row['medico'],
            'ina_medico_especialidad' => $row['medico_especialidad'],
            'ina_rotulo' => $row['rotulo'],
            'ina_pym' => $row['pym'],
            'ina_modalidad' => $row['modalidad'],
            'ina_estado_consulta' => $row['estado_consulta']
        ]);
        $this->r_cargados = $this->r_cargados+1;

        $validador_acc = actas_cargue::where('Acc_codigo', $this->acc_codigo)->count();

        if($validador_acc == 0){
            actas_cargue::create([
                'car_id' => $this->car_id,
                'Acc_codigo' => $this->acc_codigo,
                'Acc_nombre' => $this->file_name,
                'Acc_leidos' => $this->r_leidos,
                'Acc_duplicados' => $this->r_duplicados,
                'Acc_cargados' => $this->r_cargados
            ]);
        }else{
            actas_cargue::where('Acc_codigo', $this->acc_codigo)->update([
                'Acc_leidos' => $this->r_leidos,
                'Acc_duplicados' => $this->r_duplicados,
                'Acc_cargados' => $this->r_cargados
            ]);
        }

    }

    public function batchSize(): int
    {
        return $this->range;
    }

    public function chunkSize(): int
    {
        return $this->range;
    } 

    public function rules(): array
    {
        return [
            'numero_de_documento' => 'required|exists:pacientes,pac_identificacion',
            '*.numero_de_documento' => 'required|exists:pacientes,pac_identificacion',

            /* INASISTIDOS */

            'fecha_cita' => 'required',
            '*.fecha_cita' => 'required',

            'convenio' => 'required',
            '*.convenio' => 'required',

            'medico' => 'required',
            '*.medico' => 'required',

            'medico_especialidad' => 'required',
            '*.medico_especialidad' => 'required',

            'rotulo' => 'required',
            '*.rotulo' => 'required',

            'pym' => 'required',
            '*.pym' => 'required',

            'modalidad' => 'required',
            '*.modalidad' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'numero_de_documento.required' => 'El campo numero de documento se encuentra vacio',
            'numero_de_documento.exists' => 'Numero de documento no registrado',
            'fecha_cita.required' => 'El campo fecha de cita se encuentra vacio',
            'convenio.required' => 'El campo convenio se encuentra vacio',
            'medico.required' => 'El campo medico se encuentra vacio',
            'medico_especialidad.required' => 'El campo medico especialidad se encuentra vacio',
            'rotulo.required' => 'El campo rotulo se encuentra vacio',
            'pym.required' => 'El campo pym se encuentra vacio',
            'modalidad.required' => 'El campo modalidad se encuentra vacio'
        ];
    }

}
