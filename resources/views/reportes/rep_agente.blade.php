<div class="col-lg-12">
    <div class="row p-3">
        <div class="col-12">
            <h1 style="font-weight: bold;">Generador de reportes de agente</h1>
        </div>

        <div class="col-12">
            <div class="table-responsive">
                <table id="table3" class="table table-bordered">
                    <thead style="background-color: #E22A3D; color:#ffff; text-align:center;">
                        <tr>
                            <th style="text-align: center;">Identificacion</th>
                            <th style="text-align: center;">Nombre Completo</th>
                            <th style="text-align: center;">Opciones</th>
                        </tr>
                    </thead>
                    <tbody style="background-color: #ffff; text-align: center;">
                        @foreach ($agentes as $agente)
                            <tr>
                                <td>{{ $agente->age_documento }}</td>
                                <td>{{ $agente->name }}</td>
                                <td class="mr-3" style="padding-left: 40px;">

                                    <button type="button" class="btn btn-primary" data-toggle="modal"
                                        data-target="#reportes_modal_{{$agente->age_id}}">
                                        <i class="fas fa-download"></i> Descargar Reporte
                                    </button>

                                </td>
                            </tr>

                            <!-- Modal -->
                            <div class="modal fade" id="reportes_modal_{{$agente->age_id}}" tabindex="-1"
                                aria-labelledby="reportes_modalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header" style="background-color: #E22A3D; color:#ffff; text-align:center;">
                                            <button type="button" class="close" data-dismiss="modal"
                                                aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">

                                            <form action="{{ route('reportes.agente.get', $agente->age_id) }}" method="GET"
                                                style="display: inline-block;">
                                                @csrf
                                                
                                                <div class="col-12">
                                                    <label for="">Tipo de Reporte</label>
                                                    <div class="select col-12  align-items-center shadow-sm"
                                                        id="select_tipo_reporte_div">
                                                        <select id="select_tipo_reporte_{{$agente->age_id}}" onchange="formulario_opciones({{$agente->age_id}});" name="tipo_proceso"
                                                            style="font-weight: bold;" required>
                                                            <option value="" selected disabled>-- Seleccionar --</option>
                                                            <option value="1">General</option>
                                                            <option value="2">Rango de Fecha</option>
                                                            <!-- <option value="3">Nombre Archivo</option> -->
                                                        </select>
                                                    </div>
                                                    <br>
                                                </div>

                                                <div class="col-12" name="div_fechas_{{$agente->age_id}}" style="display: none;">
                                                    <label for="">Fecha Inicio</label>
                                                    <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                                                    <br>
                                                    <label for="">Fecha Fin</label>
                                                    <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                                                    <br>
                                                </div>

                                                <div class="col-12" name="div_archivo_{{$agente->age_id}}" style="display: none;">
                                                    <label for="">Nombre del archivo</label>
                                                    <input type="text" class="form-control" id="nombre_archivo" name="nombre_archivo">
                                                    <br>
                                                </div>


                                                <button type="submit" class="btn btn-primary" rel="tooltip">
                                                    Descargar
                                                </button>

                                            </form>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>

        function formulario_opciones(id) {

            let $select_tipo_reporte = document.getElementById('select_tipo_reporte_'+id);
            const opcion = $select_tipo_reporte.value
            switch (opcion) {
                case '1':
                    $('[name=div_fechas_'+id+']').css("display", "none");
                    $('[name=div_archivo_'+id+']').css("display", "none");
                    break;
                case '2':
                    $('[name=div_fechas_'+id+']').css("display", "block");
                    $('[name=div_archivo_'+id+']').css("display", "none");
                    break;
                case '3':
                    $('[name=div_archivo_'+id+']').css("display", "block");
                    $('[name=div_fechas_'+id+']').css("display", "none");
                    break;

                default:
                    break;
            }

        }

    </script>
@endsection
