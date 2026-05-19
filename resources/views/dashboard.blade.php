<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        #dash-container {
            padding: 2rem 4rem 6rem 4rem;
        }

        #dash-hero {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 50vh;
            margin-bottom: 3rem;
            border: solid 2px var(--color-chocolate);
        }

        .event-card {
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .event-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0));
        }
        .event-card>* {
            position: relative;
            z-index: 1;
        }
    </style>
</head>

<body class="bg-claro">

    @php
        $user = auth()->user();
        $rol = strtolower(trim($user->rol ?? ''));
        $eventos = $eventos ?? collect();
    @endphp

    @include('partials.header')

    <div id="dash-container">

        @if (!$user)

            <div class="alert alert-danger">
                No hay usuario autenticado
            </div>
        @else
            {{--  CLIENTE --}}
            @if ($rol === 'cliente')

                {{-- LOGOUT CLIENTE --}}
                <!--
                <div class="container mt-5">
                    <a href="{{ route('logout') }}">🡠 Cerrar sesión</a>
                </div>

                <div class="d-flex justify-content-end mb-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-dark">
                            Cerrar sesión
                        </button>
                    </form>
                </div>
                -->

                <div id="dash-hero" class="p-4 text-center">
                    <h3>Hola, {{ $user->nombre }}</h3>
                    <h2>¡Bienvenido a tu portal de eventos!</h2>
                </div>

                {{-- EVENTOS CLIENTE --}}
                <div class="mt-5">
                    <h5 class="mb-3">MIS EVENTOS</h5>

                    @forelse($eventos as $evento)
                        <div class="event-card p-4 d-flex justify-content-between align-items-end mb-3"
                            style="background-image: url('{{ asset('images/tipo-' . $evento->id_tipo . '.jpg') }}');">

                            <div>
                                <h5 class="text-white">{{ $evento->tipo->nombre_tipo ?? '' }}</h5>
                                <h2 class="text-white">{{ $evento->nombre_evento }}</h2>
                                <p class="text-white">
                                    📅 {{ $evento->fecha }} | 📍 {{ $evento->local->nombre ?? '' }}
                                </p>
                            </div>

                            <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn btn-light">
                                Gestionar
                            </a>

                        </div>

                    @empty
                        <p>No tienes eventos todavía.</p>
                    @endforelse
                </div>

                {{--  EMPLEADO  --}}
            @elseif ($rol === 'empleado')
                {{-- HEADER EMPLEADO --}}
                <div class="d-flex justify-content-between align-items-center mb-4">

                    <div>
                        <h2>👨‍💼 Panel Administrativo</h2>
                        <p>Hola, {{ $user->nombre }}</p>
                    </div>

                    <div class="d-flex align-items-center gap-3">

                       
                        {{-- LOGOUT EMPLEADO --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-dark">
                                Cerrar sesión
                            </button>
                        </form>

                    </div>

                </div>

                {{-- BOTONES ADMIN --}}
                <div class="card bg-secondary text-white shadow mb-4">
                    <div class="card-body text-center">

                        <a href="{{ route('clientes.index') }}" class="btn btn-light w-100">👤 Clientes</a>
                        <a href="{{ route('eventos.index') }}" class="btn btn-light w-100 mt-2">📅 Eventos</a>
                        <a href="{{ route('eventos.admin_create') }}" class="btn btn-light w-100 mt-2">➕ Crear
                            evento</a>

                    </div>
                </div>

                {{-- CREAR CLIENTE (IMPORTANTE) --}}
                <div class="card bg-secondary text-white shadow p-4 mt-3">

                    <h4>➕ Crear Cliente</h4>

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>

                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

                        <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña"
                            required>

                        <input type="hidden" name="rol" value="cliente">

                        <button class="btn btn-light w-100">
                            Crear cliente
                        </button>

                    </form>

                </div>

            @endif

        @endif

    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
