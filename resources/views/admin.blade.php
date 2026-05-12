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
</head>

<body class="bg-dark text-white">

    @include('partials.header')

    @php
        $user = auth()->user();
        $rol = strtolower($user->rol ?? '');
        $notificaciones = $user->unreadNotifications ?? collect();
    @endphp

    <div class="container mt-5">

        {{-- PANEL ADMIN --}}
        <div class="card bg-secondary text-white shadow mb-4">
            <div class="card-body text-center">

                <h2>Panel de Administrador</h2>
                <h3>{{ $user->nombre }}</h3>
                <p>Rol: <strong>{{ $user->rol }}</strong></p>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light mt-3">
                        Cerrar sesión
                    </button>
                </form>

            </div>
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
                    <a href="#" class="text-dark position-relative text-decoration-none"
                        data-bs-toggle="dropdown">

                        <i class="bi bi-bell fs-3"></i>

                        @if ($notificaciones->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                                {{ $notificaciones->count() }}
                            </span>
                        @endif

                    </a>

                    {{-- DROPDOWN --}}
                    <ul class="dropdown-menu dropdown-menu-end p-2" style="width:300px;">

                        <li class="fw-bold mb-2">Notificaciones</li>

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
                            <li class="text-muted small px-2 py-1">
                                No tienes notificaciones
                            </li>
                        @endforelse

                        <hr>

                        <li>
                            <a href="{{ route('consultas.index') }}" class="dropdown-item text-center fw-bold">
                                Ver todas las consultas
                            </a>
                        </li>

                    </ul>

                </div>

            </div>

        @endif
        {{-- USUARIOS --}}
        <div class="card bg-secondary text-white shadow mb-4">
            <div class="card-body text-center">

                <div class="dropdown">

                    <button class="btn btn-light dropdown-toggle w-100" data-bs-toggle="dropdown">
                        👥 Ver usuarios
                    </button>

                    <ul class="dropdown-menu w-100 text-center">
                        <li><a class="dropdown-item" href="{{ route('clientes.index') }}">👤 Clientes</a></li>
                        <li><a class="dropdown-item" href="{{ route('empleados.index') }}">👨‍💼 Empleados</a></li>
                    </ul>

                </div>

                <div class="mt-4">
                    <h4>📅 Eventos</h4>

                    <a href="{{ route('eventos.index') }}" class="btn btn-light w-100 mt-2">
                        Ir a eventos
                    </a>

                    <a href="{{ route('eventos.admin_create') }}" class="btn btn-light w-100 mt-2">
                        Crear evento
                    </a>
                </div>

                <div class="mt-4">
                    <h4>Dashboard</h4>

                    <a href="{{ route('eventos.dashboardAdmin') }}" class="btn btn-light w-100">
                        Ir a dashboard
                    </a>
                </div>

            </div>
        </div>

        {{-- FORMULARIO --}}
        <div class="card bg-secondary text-white shadow p-4">

            <h4>➕ Crear Usuario</h4>

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

                <button class="btn btn-light w-100">
                    Crear Usuario
                </button>

            </form>

        </div>

    </div>

</body>

</html>
