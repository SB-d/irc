<!doctype html>
<html lang="en">
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link rel="shortcut icon" href="img/ircicon_page_2.png" type="image/x-icon">
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <!--<link rel="shortcut icon" href="img/ircicon_page_2.png" type="image/x-icon">-->
    <link rel="icon" href="https://directv.contacta.health/wp-content/uploads/2023/06/cropped-Favicon-Azul-192x192.png" sizes="192x192" />
    <!-- Custom fonts for this template-->
    <link href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body class="degradado-irc">
    <div class="container shadow mt-5 bg-normal w-80 rounded">
        <div class="row align-items-stretch">
            <div class="col d-none d-lg-block col-md-5 col-lg-6 col-xl-6" style="padding-left: 0">
                <img src="https://images.unsplash.com/photo-1579684385127-1ef15d508118?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=580&q=80"
                    class="img-fluid" alt="Responsive image">
            </div>
            <div class="col" style="padding-right: 3em">
                <div class="text-end">
                </div>
                <div class="container mb-5 text-center pt-3" style="height: 25%">
                    <!--<img src='https://southcentralus1-mediap.svc.ms/transform/thumbnail?provider=spo&inputFormat=png&cs=fFNQTw&docid=https%3A%2F%2Ftsgbpo-my.sharepoint.com%3A443%2F_api%2Fv2.0%2Fdrives%2Fb!Cc2kH8cukEmgC7e6R2PfjQ8H9IWw5EpLujtvifxVvroIk38oVBTTTrO0KS-mQooX%2Fitems%2F01M6W52ZPMBUATFY5CAVE2M4SN5WSDQNFX%3Fversion%3DPublished&access_token=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJhdWQiOiIwMDAwMDAwMy0wMDAwLTBmZjEtY2UwMC0wMDAwMDAwMDAwMDAvdHNnYnBvLW15LnNoYXJlcG9pbnQuY29tQGRkZDM1YTcyLWE4OTAtNDJjMC05YWMwLWJiODRmZjkxNWE5ZSIsImlzcyI6IjAwMDAwMDAzLTAwMDAtMGZmMS1jZTAwLTAwMDAwMDAwMDAwMCIsIm5iZiI6IjE2OTU4Mzc2MDAiLCJleHAiOiIxNjk1ODU5MjAwIiwiZW5kcG9pbnR1cmwiOiJ6alE4NjlNR3JoK2xCRFkrMHdrTDVCMHJqT2FQSnZROUZiYnRMdi81RG1vPSIsImVuZHBvaW50dXJsTGVuZ3RoIjoiMTE2IiwiaXNsb29wYmFjayI6IlRydWUiLCJ2ZXIiOiJoYXNoZWRwcm9vZnRva2VuIiwic2l0ZWlkIjoiTVdaaE5HTmtNRGt0TW1Wak55MDBPVGt3TFdFd01HSXRZamRpWVRRM05qTmtaamhrIiwibmFtZWlkIjoiMCMuZnxtZW1iZXJzaGlwfHVybiUzYXNwbyUzYWFub24jMjRjOGNiNDFmM2NkZTUwZjkzNmNmNWFmOTUzNGQ3NmQyNDkzNjJmNjg4MTMxODc5N2JhYmEzYTcwNWU4OWNlZCIsIm5paSI6Im1pY3Jvc29mdC5zaGFyZXBvaW50IiwiaXN1c2VyIjoidHJ1ZSIsImNhY2hla2V5IjoiMGguZnxtZW1iZXJzaGlwfHVybiUzYXNwbyUzYWFub24jMjRjOGNiNDFmM2NkZTUwZjkzNmNmNWFmOTUzNGQ3NmQyNDkzNjJmNjg4MTMxODc5N2JhYmEzYTcwNWU4OWNlZCIsInNoYXJpbmdpZCI6IlpSYnhnWlp6R0VTR0xDRmg3enQydGciLCJ0dCI6IjAiLCJpcGFkZHIiOiIxODEuMTI5LjE1Ni43NCJ9.768PCrfaU7Xv7wrI3WQi8pvLBTyvP3sEUGlHq2UmCKw&cTag="c%3A%7B32010DEC-A2E3-4905-A672-4DEDA43834B7%7D%2C2"&encodeFailures=1&width=922&height=377&srcWidth=922&srcHeight=377'-->
                    <!--    class="img-fluid" alt="Responsive Image" style="width: 80%">-->
                    <img src="{{ asset('img/LOGO_CONTACTA.jpeg') }}"
                        class="img-fluid" alt="Responsive Image" style="width: 50%">
                </div>
                <!-- form login -->
                <form method="POST" action="{{ route('login') }}" class="px-2 py-2">
                    @csrf
                    <div class="mb-4">
                        <label for="user"class="form-label fw-bold"> Usuario </label>
                        <input id="email" type="email"
                            class="form-control form-control-user @error('email') is-invalid @enderror input_login" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus
                            placeholder="Escribe un correo">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4">
                        <label for="password1" class="form-label fw-bold"> Contraseña </label>
                        <input id="password1" type="password"
                            class="form-control @error('password') is-invalid @enderror input_login" name="password" required
                            autocomplete="current-password" placeholder="Escribe una contraseña">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <input type="checkbox" id="mostrar_contrasena2" title="clic para mostrar contraseña"
                            onchange="mostrar_contraseña()" />
                        &nbsp;&nbsp;Mostrar Contraseña
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary" style="border-radius: 2px;">Iniciar sesión</button>
                    </div>
                </form>

                {{-- <div class="mb-4 py-2">
                    <a href="#" class=""> Recuperar contraseña</a>
                </div> --}}
                <!-- end form login-->
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/funcionalidades/Agentes_ajax.js') }}"></script>
</body>

</html>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous">
    </script>
</body>

</html>
