<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .dash-container {
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


        /* EMPLEADO */
        
        .admin-div-1{
            display: flex;
            flex-direction: row;
            gap: 3rem;
            width: 100%;
            padding: 4rem;
            height: fit-content;
        }
        
        .admin-carta{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-width: 30%;
        }

        .admin-carta:first-child{
            heigth: 100%;
        }

        .admin-carta:last-child{
            height: fit-content;
        }
        
        .admin-carta-img{
            min-height: 20vh;
            height: 100%;
            width: 100%;
        }
    </style>
</head>

<body>

    <div class="bg-claro normal-body">
    
    @php
        $user = auth()->user();
        $rol = strtolower(trim($user->rol ?? ''));
        $eventos = $eventos ?? collect();
    @endphp

    @include('partials.header')

    

        @if (!$user)
            <div class="alert alert-danger">
                <i>No hay usuario autenticado</i>
            </div>

        @else
            
            {{--  CLIENTE --}}
            @if ($rol === 'cliente')

            <div class="dash-container">

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

            </div>





            {{--  EMPLEADO  --}}
            @elseif ($rol === 'empleado')
                <div class="section-1 bg-white">

                    <div class="normal-header d-flex flex-row justify-content-between align-items-center">
                        <h2 class="color-choco">Panel de administración</h2>
                        <div class="d-flex flex-column align-items-end">
                            <h3>Hola, {{ $user->nombre }}</h3>
                            <p><b>Rol:</b> {{ $user->rol }}</p>
                        </div>
                    </div>

                    <div class="dash-container">

                        {{-- LOGOUT EMPLEADO --}}
                        <div class="text-end mb-2">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="button-a">
                                    Cerrar sesión <i class="bi bi-door-closed fs-4"></i>
                                </button>
                            </form>
                        </div>
                                    
                        <div class="admin-div-1">

                            {{-- CARTA EVENTOS --}}
                            <div class="admin-carta flex-fill">
                                <h4>Eventos</h4>

                                <div class="mt-2">
                                    <a href="{{ route('eventos.index') }}" class="btn-eventea" title="Abrir panel de eventos">
                                        Ver todos los eventos
                                    </a>
                                    <a href="{{ route('eventos.admin_create') }}" class="btn-claro ms-2" title="Crear nuevo evento">
                                        <i class="bi bi-plus-lg"></i>
                                    </a>
                                </div>

                                <div style="background: url('/images/eventea-03.jpg') center/cover no-repeat;" class="admin-carta-img mt-4" alt="Imagen mesa"></div>
                            </div>


                            {{-- CARTA CLIENTES --}}
                            <div class="admin-carta flex-fill">
                                <h4>Clientes</h4>

                                <div class="mt-2">
                                    <a href="{{ route('clientes.index') }}" class="btn-eventea">
                                        <i class="bi bi-people-fill me-2"></i> Ver clientes
                                    </a>
                                </div>

                                {{-- Formulario --}}
                                <div class="bg-claro p-4 mt-4 w-100">
                                    <div class="border-eventea p-4">
                                        <h5 class="mb-4"><i class="bi bi-plus fs-4"></i>Nuevo cliente</h5>

                                        <form method="POST" action="{{ route('users.store') }}">
                                            @csrf

                                            <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>
                                            <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                                            <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña" required>

                                            <button class="btn-eventea w-100">
                                                Crear
                                            </button>

                                        </form>
                                    </div>
                                </div> <!-- form -->
                            </div>

                        </div>


                    </div>
                </div>

            @endif

        @endif

    </div>

    <!-- Footer -->
    @include('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
