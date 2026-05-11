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
            padding: 2rem 4rem 6rem 4rem;
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

        .event-card{
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
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.585) 0%, rgba(0,0,0,0) 100%);
        }
        .event-card > * {
            position: relative;
            z-index: 1;
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

                <div id="dash-nav" class="d-flex justify-content-end mb-4">
                    <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="button-a" onclick="this.form.submit();">
                                Cerrar sesión <i class="bi bi-arrow-bar-right fs-4"></i>
                            </button>
                    </form>
                </div>


                <div id="dash-hero" class="p-4 text-center">
                    <h3>Hola, {{ $user->nombre }}</h3>
                    <h2>¡Bienvenido a tu portal de eventos!</h2>
                    <p class="pt-2">Desde aquí podrás gestionar todos los detalles de<br>tus eventos en marcha con el equipo de Eventea</p>
                </div>


                <div class="text-center">
                    <a href="{{ route('eventos.create') }}" class="btn-eventea align-self-center">
                        <i class="bi bi-plus fs-4 pb-1" style="color: inherit"></i>&nbsp;&nbsp;Solicitar nuevo evento
                    </a>
                </div>

                {{-- EVENTOS --}}
                <div class="mt-5">

                    <h5 class="mb-3">MIS EVENTOS</h5>

                    @forelse($eventos as $evento)
                        <div class="event-card p-4 pt-5 d-flex column bg-medio justify-content-between align-items-end"
                            style="background-image: url('{{ asset('images/tipo-' . $evento->id_tipo . '.jpg') }}');"
                        >
                            <div class="d-flex row">

                                <h5 class="color-white">{{ $evento->tipo->nombre_tipo }}</h5>

                                <h2 class="color-white" style="font-style: normal">{{ $evento->nombre_evento }}</h2>

                                <div class="d-flex flex-row gap-3" style="margin-bottom: -1rem">
                                    <p class="color-white" style="font-weight: 600">
                                        <i class="bi bi-calendar4 fs-6 color-white"></i> {{ $evento->fecha }}
                                    </p>
                                    <p class="color-white">
                                        <i class="bi bi-geo-alt fs-6 color-white"></i> {{ $evento->local->nombre }}
                                    </p>
                                    <!--
                                    <p class="color-white">
                                        <i class="bi bi-people fs-6 color-white"></i> {{ $evento->local->nombre }} invitados
                                    </p>
                                    -->
                                </div>
                            </div>

                            <div>
                                <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn-eventea">
                                    Gestionar >
                                </a>
                            </div>
                                                            
                        </div>

                    @empty
                        <p style="font-style: italic">No tienes eventos todavía.</p>
                    @endforelse

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
