<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .hero {
            height: 100vh;
            background: url('https://images.unsplash.com/photo-1511795409834-ef04bbd61622') center/cover no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255,255,255,0.75);
            z-index: 0;
        }

        .content {
            position: relative;
            text-align: center;
            max-width: 700px;
            padding: 40px;
            z-index: 1;
        }

        .title-small {
            letter-spacing: 3px;
            font-weight: 500;
        }

        .title-big {
            font-size: 3rem;
            font-style: italic;
            font-weight: 300;
        }

        .btn-custom {
            background-color: #6c5f57;
            color: white;
            padding: 12px 30px;
            border: none;
            margin-top: 20px;
        }

        .btn-custom:hover {
            background-color: #4e463f;
            color: white;
        }
    </style>
</head>

<body>

<div class="hero">

    <div class="overlay"></div>

    <div class="content">

        <div class="mb-3">
            ⭐ ⭐ ⭐
        </div>

        <p class="title-small">Organizamos tu evento perfecto</p>

        <h1 class="title-big">todo desde el mismo lugar</h1>

        <p class="mt-3 text-muted">
            Bienvenido al portal de eventos de EvenTea
        </p>

        @auth
            @if(auth()->user()->rol === 'admin')
                <a href="{{ route('admin') }}" class="btn btn-custom">
                    IR A PERFIL
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-custom">
                    IR A PERFIL
                </a>
            @endif
            <br>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn btn-link text-white mt-2 p-0">
                    Cerrar Sesión
                </button>
            </form>
        @else
            <a href="/login" class="btn btn-custom">
                INICIAR SESIÓN
            </a>
        @endauth

    </div>

</div>

</body>
</html>