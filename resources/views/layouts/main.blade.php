<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacta Health</title>

    <link rel="shortcut icon" href="images/Favicon64x64 (3).png" type="image/x-icon">

    <!-- CSS de Bootstrap -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <!-- JavaScript de jQuery y Bootstrap -->
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script> -->
    <!-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> -->

    <link href="{{ asset('csss/style.css') }}" rel="stylesheet">
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
                <span>{{ Auth::user()->name }}</span>
                <div class="image-user"></div>
                <img class="icon-logout" src="/images/arrow-down.svg" alt="">
            </div>

            <div class="changePass-logout">
                <div class="box">
                    <img src="/images/Contraseña.png" alt="">
                    <p>Cambiar contraseña</p>
                </div>
                <div class="box">
                    <img src="/images/cerrar-sesion.png" alt="">
                    <p>Salir</p>
                </div>
            </div>
        </div>
    </nav>
    <!-- BARRA DE NAVEGACIÓN -->

    <div class="background">
        <div class="welcome-name">
            <p>Bienvenido a</p>
        <h1>CONTACTA HEALTH</h1>
        </div>

        <!-- SERVICIOS -->
        <div class="services">
            <button class="card" id="prevencion">
                <img class="icon-prevencion" src="images/medico-1 1.svg" alt="">
                <p>Gestión y prevención en salud</p>
            </button>
            <button class="card">
                <img src="images/Recurso-3.svg" alt="">
                <p>Telesalud</p>
            </button>
            <button class="card">
                <img src="images/Recurso-5.svg" alt="">
                <p>Telemonitoreo</p>
            </button>
        </div>
        <!-- SERVICIOS -->
    </div>

    <!-- PROCESOS -->
    <!-- Navegación de pestañas -->
    <div class="tab">
        <div class="views">
            <button class="tablinks" onclick="openTab(event, 'centro-ayuda')">
                <img src="images/soporte-tecnico (1).png" alt="">
                Centro de ayuda
            </button>
            <button class="tablinks" onclick="openTab(event, 'dashboard')">
                <img src="images/analisis-web.png" alt="">
                Dashboard
            </button>
            <button class="tablinks" onclick="openTab(event, 'reportes')">
                <img src="images/reporte.png" alt="">
                Reportes
            </button>
            <button class="tablinks" onclick="openTab(event, 'administrar')">
                <img src="images/red.png" alt="">
                Administrar
            </button>
        </div>
    </div>

    <div class="all-functions">
        <!-- Contenido de la pestaña Centro de ayuda -->
        <div id="centro-ayuda" class="tab-content">
            <img src="" alt="">
            <p>Contenido centro-ayuda</p>
        </div>

        <!-- Contenido de la pestaña Dasboard Telesalud Tendencias -->
        <div id="dashboard" class="tab-content">
            <img src="" alt="">
            <p>Contenido dashboard</p>
        </div>

        <!-- Contenido de la pestaña Reportes -->
        <div id="reportes" class="tab-content">
            <img src="" alt="">
            <p>Contenido reportes</p>
        </div>

        <!-- Contenido de la pestaña Administrar -->
        <div id="administrar" class="tab-content">
            <img src="" alt="">
            <p>Contenido administrar</p>
        </div>
    </div>
    <!-- PROCESOS -->

    <script src="{{ asset('jss/index.js') }}"></script>
</body>
</html>
