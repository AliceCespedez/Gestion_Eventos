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
        #dash-container{
            padding: 6rem 4rem 6rem 4rem;
        }

        #dash-hero{
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 100%;
            height: 50vh;
            margin-bottom: 3rem;
            border: solid 2px var(--color-chocolate);
        }
    </style>
</head>

<body class="bg-claro">

    @php
        $user = auth()->user();
        $rol = strtolower(trim($user->rol ?? ''));
    @endphp

    <!-- Header -->
    @include('partials.header')

    <div id="dash-container">

        @if (!$user)
            <div class="alert alert-danger">
                No hay usuario autenticado
            </div>
        @else
            {{-- CLIENTE --}}
            @if ($rol === 'cliente')

                <div id="dash-nav align-self-end">
                    <form method="POST" action="{{ route('logout') }}">
                            <button type="submit">Cerrar sesión</button>
                            <i class="bi bi-arrow-bar-right"></i>
                    </form>
                </div>


                <div id="dash-hero" class="p-4 text-center">
                    <h3>Hola, {{ $user->nombre }}</h3>
                    <h2>¡Bienvenido a tu portal de eventos!</h2>
                    <p class="pt-2">Desde aquí podrás gestionar todos los detalles de<br>tus eventos en marcha con el equipo de Eventea</p>
                </div>

                <a href="{{ route('eventos.create') }}" class="btn-eventea align-self-center">
                    <i class="bi bi-plus fs-4 pb-1 color-white"></i>&nbsp;&nbsp;Solicitar nuevo evento
                </a>

                {{-- EVENTOS --}}
                <div class="mt-5">

                    <h5 class="mb-3">MIS EVENTOS</h5>

                    @forelse($eventos as $evento)
                        <div class="card mb-3 shadow">
                            <div class="card-body">

                                <h5>{{ $evento->nombre_evento }}</h5>

                                <p>📅 {{ $evento->fecha }}</p>

                                <p>📍 {{ $evento->ubicacion }}</p>

                                <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn btn-dark btn-sm">
                                    Gestionar
                                </a>

                            </div>
                        </div>

                    @empty
                        <p>No tienes eventos todavía.</p>
                    @endforelse

                </div>

                {{-- LOGOUT --}}
                <div class="card bg-secondary text-white shadow mb-4 mt-3">
                    <div class="card-body text-center">

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-light w-100">
                                Cerrar sesión
                            </button>
                        </form>

                    </div>
                </div>

                {{-- EMPLEADO --}}
            @elseif ($rol === 'empleado')
                <div class="card bg-secondary text-white shadow mb-4">
                    <div class="card-body text-center">

                        <h1>👨‍💼 Panel Administrativo</h1>
                        <h2>Hola, {{ $user->nombre }}</h2>

                        <p>Rol: <strong>{{ $user->rol }}</strong></p>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="btn btn-light mt-3">
                                Cerrar sesión
                            </button>
                        </form>

                    </div>
                </div>

                {{-- VER CLIENTES --}}
                <div class="card bg-secondary text-white shadow mb-4">
                    <div class="card-body text-center">


                        <a href="{{ route('clientes.index') }}" class="btn btn-light w-100">
                            <h4>👤 Clientes</h4>
                        </a>
                        <a href="{{ route('eventos.index') }}" class="btn btn-light w-100 mt-3">
                            📅 Ver eventos
                        </a>
                        <a href="{{ route('eventos.admin_create') }}" class="btn btn-light w-100 mt-3">
                            ➕ Crear evento

                    </div>
                </div>

                {{-- CREAR CLIENTE --}}
                <div class="card bg-secondary text-white shadow p-4">

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
    <br><br>
    @include('partials.footer')

</body>

</html>
