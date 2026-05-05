<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body class="bg-dark text-white">

    <!-- Header -->
    @include('partials.header')

    <!-- Login form -->
    <div class="container mt-5">

        <div class="row justify-content-center">
            <div class="col-md-5">

                <div class="card bg-secondary text-white shadow">

                    <div class="card-header text-center bg-dark">
                        <h3>🔐 Iniciar Sesión</h3>
                    </div>

                    <div class="card-body">

                        {{-- ERRORES --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success text-center">
                                {{ session('success') }}
                            </div>
                        @endif

                        {{-- FORMULARIO --}}
                        <form method="POST" action="/login">

                            @csrf

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="Introduce tu email">
                            </div>

                            <div class="mb-3">
                                <label>Contraseña</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Introduce tu contraseña">
                            </div>

                            <button class="btn btn-light w-100">
                                Entrar
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

</body>

</html>
