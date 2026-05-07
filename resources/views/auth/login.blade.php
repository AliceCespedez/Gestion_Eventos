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
<style>
    #login-body{
        display: flex;
        flex-direction: column;
        height: 100vh;
        justify-content: space-between;
    }
    #login-div{
        display: flex;
        width: 100%;
        align-items: center;
        justify-content: center;
    }
    #login-form-card{
        width: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    #login-card-body{
        width: 30%;
        min-width: 400px;
        border: solid 1px var(--color-chocolate);
        padding: 2rem;
    }

    #login-form input{
        border-radius: 0%;
        background-color: var(--color-beige-claro);
    }
</style>

<body id="login-body" class="bg-claro text-white">

    <!-- Header -->
    @include('partials.header')

    <!-- Login form -->
    <div id="login-div" class="">

            <div id="login-form-card">

                    <!-- Título -->
                    <div class="login-card-header text-center col gap-5">
                        <h2 class="color-choco" style="font-style: italic; font-size: 4rem;">¡Bienvenido de vuelta!</h2>
                        <h3 class="color-choco">Inicia sesión</h3>
                    </div>

                    <!-- Body -->
                    <div id="login-card-body" class="card-body">

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
                        <form id="login-form" method="POST" action="/login">

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

                            <button class="btn-eventea w-100">
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
