@extends('layouts.main')

@section('title')
    Home
@endsection

@section('content')
    <div class="container-fluid text-center">
        <div class="container  shadow-lg text-center bg-img-color rounded" style="min-height: 500px;">
            <div class="row">
                <div class="col-6 text-left p-2">
                    <!--<img src="{{ asset('img/irc_icon_white.png') }}" alt=""
                        style="max-width: 200px; max-height: 35px;">-->
                </div>
                <div class="col-6 text-right p-2">
                    <img src="{{ asset('img/contacta_white.png') }}" alt=""
                        style="max-width: 200px; max-height: 40px;">
                </div>

                <div class="col-12 text-center text-white mt-4">
                    <h1 style="font-weight: bold;" class="">Bienvenido a GDI</h1>
                    <h3 style="font-weight: bold;" class="">{{ Auth::user()->name }}</h3>
                </div>

                <div class="col-12 px-5" style="margin-top: 90px">
                    <div class="text-left text-white">
                        <h3>Panel informativo</h3>
                        <h5>13/10/2023</h5>
                        <p>
                            - Se han implementado los filtros de municipio y proceso para el modulo de gestion.<br>
                            - Se ha implementado la opcion para filtrar por documento en el modulo de gestion.<br>
                            - Se ha implementado el campo que indica quien realizo la gestion en los reportes personalizados.<br>
                            - Se han corregido errores visuales en la plataforma. <br>
                            - Se han otorgado privilegios a los agentes para ver el modulo de administracion de pacientes.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
@endsection
