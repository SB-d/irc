@extends('layouts.main')

@section('title')
    Pacientes
@endsection


@section('content')
    <div class="row">
        <div class="col-12">
            <div class="row">
                <div class="col-4">
                    <input type="text" class="form-control" placeholder="Buscar..." id="serch_paciente" name="serch_paciente">
                </div>
                <div class="col-8">
                    <button class="btn btn-success" style="float: right;" data-toggle="modal"
                        data-target="#importar_paciente">
                        <i class="fas fa-file-excel"></i> Importar Paciente</button>
                    <button class="btn btn-primary" style="float: right;" data-toggle="modal" data-target="#crear_paciente">
                        <i class="fas fa-plus"></i> Nuevo Paciente</button>
                </div>
            </div>

            <br>
        </div>
        <div class="table-responsive">

            @include('layouts.msj')

            @include('consultar-pacientes.msj')

            <table class="table table-bordered">
                <thead style="background-color: #E22A3D; color:#ffff; text-align:center;">
                    <tr>
                        <th style="text-align: center;">identificacion</th>
                        <th style="text-align: center;">Nombre</th>
                        <th style="text-align: center;">Teléfono</th>
                        <th style="text-align: center;">Opciones</th>
                    </tr>
                </thead>
                <tbody style="background-color: #ffff; text-align: center;" name="tbody_pac">
                    @foreach ($pacientes as $list)
                        <tr>
                            <!-- Esta es la variable -->
                            <td>{{ $list->pac_identificacion }}</td>
                            <td>{{ $list->pac_primer_nombre }} {{ $list->pac_primer_apellido }}</td>
                            <td>{{ $list->pac_telefono }}</td>
                            <td>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal_proceso" onclick="modal_proceso({{ $list->pac_id }});">
                                    Proceso
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#modal_perfil" onclick="modal_perfil({{ $list->pac_id }});">
                                    Perfil
                                </button>
                                <button type="button" class="btn btn-primary" data-toggle="modal"
                                    data-target="#editar_paciente" onclick="modal_editar({{ $list->pac_id }});">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    @include('consultar-pacientes.create')

    @include('consultar-pacientes.importar')

    @include('gestionar.proceso')

    @include('gestionar.perfil')

    @include('consultar-pacientes.edit')
@endsection

@section('script')
    <script type="text/javascript" src="{{ asset('js/funcionalidades/paciente.js') }}"></script>
@endsection
