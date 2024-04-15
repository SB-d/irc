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
                        <a class="dropdown-item" href="{{ route('importar.index') }}" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-arrow-left "></i> Atras
                        </a>
                    </ul>
                </nav>
                <!-- End of Topbar -->
                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="container-fluid justify-content-center">
                        <div class="container contenido">
                            <div class="row">

                                <div class="col-sm-12 text-justify mb-5">
                                    <h1 class="font-weight-bold">ERROR EN LOS DATOS</h1>
                                </div>


                                <div class="col-sm-12 text-left mb-4">
                                    <p class="texto"> Resultados del procesamiento del archivo: <mark
                                            class="resaltado">
                                            {{ $nombre }}</mark></p>
                                </div>

                                <div class="col-sm-12 text-left mb-4">
                                    <p class="texto"><strong>El archivo No se procesó debido a inconsistencias en el
                                            registro de
                                            control, no se cargo ningun registro</strong></p>
                                </div>

                                <div class="col-sm-12 text-left mb-4">
                                    <p class="texto"><strong>Resumen por tipo de error y/o advertencia
                                            encontrado:</strong></p>
                                    {{-- Variable por tipo/adevertencia encotrada --}}

                                    @foreach ($failures as $erros)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong> {{ $erros->errors()[0] }} en la linea {{ $erros->row() }} </strong>
                                        </div>
                                    @endforeach
                                </div>


                            </div>
                        </div>
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
