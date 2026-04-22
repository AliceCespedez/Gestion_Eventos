<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        .hero {
            height: 60vh;
            background: url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622') center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            overflow: hidden;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.75);
        }

        .content {
            position: relative;
            text-align: center;
            max-width: 700px;
            padding: 40px;
        }

        .title-big {
            font-size: 2.5rem;
            font-style: italic;
            font-weight: 300;
        }
    </style>
</head>

<body class="bg-dark text-white">

    <div class="container mt-5">

        {{-- 👤 PANEL --}}
        <div class="card bg-secondary text-white shadow mb-4">
            <div class="card-body text-center">

                <h1>👤 Panel Usuario</h1>

                <p>Bienvenido:</p>

                <h3>{{ auth()->user()->nombre ?? 'Usuario' }}</h3>

                <p>
                    Rol: <strong>{{ auth()->user()->rol ?? 'Sin rol' }}</strong>
                </p>
                <a href="{{ route('eventos.index') }}" class="btn w-100 mt-3" style="background:#6c5f57; color:white;">
                    📅 Ver mis eventos
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light mt-3">
                        Cerrar sesión
                    </button>
                </form>

            </div>
        </div>

        {{-- 🌟 SOLO EMPLEADO --}}
        @if (auth()->user()->rol === 'empleado')
            <div class="hero mb-4">

                <div class="overlay"></div>

                <div class="content">

                    <p>⭐ ⭐ ⭐</p>

                    <p>Organizamos tu evento perfecto</p>

                    <h1 class="title-big">todo desde el mismo lugar</h1>

                    <p class="mt-3 text-muted">
                        Bienvenido al portal de eventos de EvenTea
                    </p>

                </div>

            </div>

            {{-- FORMULARIO CREAR CLIENTE (opcional aquí también) --}}
            <div class="card bg-dark text-white p-4">

                <h4>Registrar cliente</h4>

                <form method="POST" action="/clientes">
                    @csrf

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <button class="btn btn-primary w-100">
                        Crear cliente
                    </button>

                </form>

            </div>
        @endif

    </div>

    <script>
        window.addEventListener('pageshow', function(event) {
            if (event.persisted) {
                window.location.reload();
            }
        });
    </script>

</body>

</html>
