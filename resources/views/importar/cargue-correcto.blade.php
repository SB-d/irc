<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>IRC - Error Import</title>
    <link rel="shortcut icon" href="{{ asset('img/ircicon_page_2.png') }}" type="image/x-icon">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet">
    {{-- <link rel="stylesheet" href="cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css"> --}}
    <!-- Custom styles for this template-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link href="{{ asset('css/sb-admin-2.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <div class="topbar-divider d-none d-sm-block"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-arrow-left "></i> Atras
                        </a>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="container mt-4">
                        @foreach ($acta as $list)
                            <div class="row">
                                <div class="col-sm-12 text-right mb-5">
                                    <h1 class="font-weight-bold">Acta de Validación de cargue</h1>
                                    <p class="texto"> <strong>Fecha </strong><?php echo date('F d'); ?> de <?php echo date('Y'); ?>
                                    </p>
                                    <p class="texto font-weight-bold"> Barranquilla-Atlántico </p>
                                </div>

                                <div class="col-sm-12 text-left mb-4">
                                    <h2 class="font-weight-bold">Srs. Riesgo Cardiovascular Y Obstetrico Irc S.A.S.</h2>
                                    <p class="texto font-weight-bold">NIT: 900781044</p>
                                </div>

                                <div class="col-sm-12 text-left mb-4">
                                    <p class="texto font-weight-normal">Resultados de la Validación de la Estructura del
                                        Archivo:
                                    </p>
                                    <p class="texto font-weight-normal"><mark
                                            class="resaltado">{{ $list->Acc_nombre }}</mark></p>
                                </div>

                                <div class="col-sm-12 text-left mb-4">
                                    {{-- Variable de la fecha y hora de recepcion --}}
                                    <p class="texto font-weight-normal">Fecha y Hora de Recepción:
                                        {{ $list->created_at }}</p>
                                </div>

                                <div class="col-sm-12 text-left mb-4">
                                    <p class="texto font-weight-bold">La Estructura del Archivo es Correcta</p>
                                </div>

                                <div class="col-sm-12 text-left mb-4">
                                    <p class="texto font-weight-normal">El archivo pasa a ser entregado al área de
                                        gestión para
                                        completar su procesamiento.</p>
                                </div>

                                <div class="col-sm-12 text-left mb-4">
                                    {{-- Variable de numero de registros --}}
                                    <p class="texto font-weight-normal">- Número de registros leídos:
                                        {{ $list->Acc_leidos }}</p>
                                    {{-- Variable de numero de registros duplicados --}}
                                    <p class="texto font-weight-normal">- Número de registros duplicados:
                                        {{ $list->Acc_duplicados }}
                                    </p>
                                    {{-- Variable de numero de registros cargados --}}
                                    <p class="texto font-weight-normal">- Número de registros cargados:
                                        {{ $list->Acc_cargados }}</p>
                                </div>

                                <div class="col-sm-6 text-left mt-5">
                                    <p class="texto font-weight-normal mb-4"> Contacta </p>
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
             End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
</body>

</html>
