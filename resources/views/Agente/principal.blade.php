@extends('layouts.main')

@section('title')
    Agentes
@endsection

@section('content')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Agentes</h1>
            <div class="card mb-4">
                <div class="card-body">

                </div>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="">Documento</th>
                                <th style="">Nombre</th>
                                <th style="">Opciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agentes as $age)
                                <tr>
                                    <td>{{ $age->age_documento }}</td>
                                    <td>{{ $age->name }}</td>

                                    <td>
                                        {{-- <form action="{{ route('BorrarTipoI', $ti->id) }}" method="POST"
                                            style="display: inline-block; ">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" class="btn btn-danger" rel="tooltip"
                                                onclick="return confirm('Seguro que quiere eliminar este Tipo de Personal?') ">
                                                <i class="fas fa-trash-alt" title="Eliminar Registro"></i>
                                            </button>

                                        </form> --}}

                                        <a type="submit" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#Edit_{{$age->age_id}}">
                                            <i class='bx bxs-edit-alt bx-xs'></i>
                                        </a>
                                    </td>
                                </tr>
                                @include('Agente.edit')
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
@endsection
