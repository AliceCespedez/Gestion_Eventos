<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>

    
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .form-control{
            border-radius: 0;
        }
    </style>
</head>

<body class="bg-white normal-body">

    @include('partials.header')

    @php
        $user = auth()->user();
        $rol = strtolower($user->rol ?? '');
        $notificaciones = $user->unreadNotifications ?? collect();
    @endphp

    <div class="section-1">
            
        <div class="normal-header d-flex flex-row justify-content-between align-items-center">
                <h2 class="color-choco">Panel de administrador</h2>
                <div class="d-flex flex-column align-items-end">
                    <h3>{{ $user->nombre }}</h3>
                    <p><b>Rol:</b> {{ $user->rol }}</p>
                </div>
        </div>

    
        
        <div class="container mt-4">

            {{-- CERRAR SESIÓN --}}
                <div class="text-end mb-4">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-eventea">
                            Cerrar sesión
                        </button>
                    </form>
                </div>

            
            {{-- 🔔 CAMPANA (FIJA Y SIEMPRE VISIBLE) --}}
            @if (in_array($rol, ['empleado', 'admin']))

                @php
                    $user = auth()->user();
                    $notificaciones = $user->unreadNotifications ?? collect();
                @endphp

                <div class="position-fixed top-0 end-0 p-3" style="z-index:9999;">
                    <div class="dropdown">

                        {{-- CAMPANA --}}
                        <a href="#" class="color-choco position-relative text-decoration-none"
                            data-bs-toggle="dropdown">

                            <i class="bi bi-bell-fill fs-4"></i>

                            @if ($notificaciones->count() > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                                    {{ $notificaciones->count() }}
                                </span>
                            @endif

                        </a>

                        {{-- DROPDOWN --}}
                        <ul class="dropdown-menu dropdown-menu-end p-3 rounded-0" style="width:300px;">

                            <li class="fw-bold mb-2">NOTIFICACIONES</li>

                            @forelse($user->notifications as $noti)
                                <li>
                                    <a href="{{ route('consultas.leer', $noti->id) }}" class="dropdown-item small">

                                        🔔 {{ $noti->data['mensaje'] ?? 'Notificación' }}

                                        <br>

                                        <small class="text-muted">
                                            {{ $noti->read_at ? 'Leída' : 'Nueva' }}
                                        </small>

                                    </a>
                                </li>
                            @empty
                                <li class="text-muted small px-2 py-1 fst-italic">
                                    No tienes notificaciones
                                </li>
                            @endforelse

                            <hr>

                            <li>
                                <a href="{{ route('consultas.index') }}" class="dropdown-item text-center">
                                    VER TODAS LAS CONSULTAS
                                </a>
                            </li>

                        </ul>

                    </div>

                </div>

            @endif


            {{-- USUARIOS --}}
            <div class="mb-4 bg-claro p-4">
                <div class="text-center border-eventea p-4">

                    <div class="dropdown">

                        <button class="btn-eventea dropdown-toggle w-100" data-bs-toggle="dropdown">
                            👥 Ver usuarios
                        </button>

                        <ul class="dropdown-menu text-start">
                            <li><a class="dropdown-item" href="{{ route('clientes.index') }}">👤 Clientes</a></li>
                            <li><a class="dropdown-item" href="{{ route('empleados.index') }}">👨‍💼 Empleados</a></li>
                        </ul>

                    </div>

                    <div class="mt-4">
                        <h4>Eventos</h4>

                        <a href="{{ route('eventos.index') }}" class="btn-eventea w-100 mt-2">
                            Ir a eventos
                        </a>
                        <a href="{{ route('eventos.admin_create') }}" class="btn-eventea w-100 mt-2">
                            Crear evento
                        </a>
                    </div>
                </div>
            </div>

            {{-- FORMULARIO --}}
            <div class="mb-4 bg-claro p-4">
                <div class="border-eventea p-4">

                    <h5 class="mb-4"><i class="bi bi-plus fs-4"></i>Crear usuario</h5>

                    <form method="POST" action="{{ route('users.store') }}">
                        @csrf

                        <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>
                        <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
                        <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña" required>

                        @if ($rol === 'admin')
                            <select name="rol" class="form-control mb-3">
                                <option value="cliente">Cliente</option>
                                <option value="empleado">Empleado</option>
                            </select>
                        @endif

                        <button class="btn-eventea w-100">
                            Crear
                        </button>

                    </form>
                </div>
            </div>


            
            {{-- STATS DE EVENTOS --}}
            <div class="container mt-5">
                <div class="card bg-secondary p-4">
                    <canvas id="eventosChart"></canvas>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
            <script>
                const data = @json($eventosPorMes);

                const meses = [
                    "Enero", "Febrero", "Marzo", "Abril",
                    "Mayo", "Junio", "Julio", "Agosto",
                    "Septiembre", "Octubre", "Noviembre", "Diciembre"
                ];

                const labels = data.map(e => meses[e.mes - 1]); 
                const valores = data.map(e => e.total);

                const ctx = document.getElementById('eventosChart');

                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Eventos por mes',
                            data: valores,
                            fill: false,
                            tension: 0.3,
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                }
                            }
                        }
                    }
                });
            </script>

    </div>

     @include('partials.footer')

</body>

</html>
