<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="shortcut icon" href="images/Favicon64x64 (3).png" type="image/x-icon">

    <!-- CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- JavaScript de jQuery y Bootstrap -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="{{ asset('csss/detalles.css') }}">
</head>
<body>

    <!-- BARRA DE NAVEGACIÓN -->
    <nav>
        <div>
            <img class="logo" src="images/Contacta heath AZUL.svg" alt="">
        </div>

        <div class="back-logo-user">
            <!-- USUARIO -->
            <div class="text-image">
                <span>Demo</span>
                <div class="image-user"></div>
            </div>
        </div>
    </nav>
    <!-- BARRA DE NAVEGACIÓN -->


    <!-- OPCIONES -->
    <div class="back-options">
        <div class="back-arrow">
            <img src="images/arrow-left.svg" alt="">
        </div>

        <div class="option">
            <img src="images/Administrar procesos.png" alt="">
            <p>Administrar proceso</p>
        </div>

        <div class="option">
            <img src="images/Gestionar-icono.png" alt="">
            <p>Gestionar</p>
        </div>

        <div class="option">
            <img src="images/Administrar pacientes.png" alt="">
            <p>Administrar pacientes</p>
        </div>

        <div class="option">
            <img src="images/Importar.png" alt="">
            <p>Importar</p>
        </div>
    </div>
    <!-- OPCIONES -->

    <script src="{{ asset('jss/detalles.js') }}"></script>
</body>
</html>
