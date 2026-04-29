<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

    @php
        $user = auth()->user();
        $rol = strtolower($user->rol ?? '');
    @endphp

    <div class="container mt-5">

        {{-- PANEL ADMIN --}}
        <div class="card bg-secondary text-white shadow mb-4">
            <div class="card-body text-center">

                <h1>👑 Panel Admin</h1>

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

        {{-- USUARIOS --}}
        <div class="card bg-secondary text-white shadow mb-4">
            <div class="card-body text-center">

                <div class="dropdown">

                    <button class="btn btn-light dropdown-toggle w-100" type="button" data-bs-toggle="dropdown">
                        <h4 class="mb-3">👥 Ver usuarios</h4>
                    </button>

                    <ul class="dropdown-menu w-100 text-center">

                        <li>
                            <a class="dropdown-item" href="{{ route('clientes.index') }}">
                                👤 Clientes
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item" href="{{ route('empleados.index') }}">
                                👨‍💼 Empleados
                            </a>
                        </li>

                    </ul>

                </div>

                {{-- SOLO BOTÓN EVENTOS --}}
                <div class="mt-4">

                    <h4 class="mb-3">📅 Eventos</h4>

                    <a href="{{ route('eventos.index') }}" class="btn btn-light w-100">
                        📋 Ir a eventos
                    </a>
                     <a href="{{ route('eventos.admin_create') }}" class="btn btn-light w-100">
                        Crear evento
                    </a>

                </div>
                  <div class="mt-4">

                    <h4 class="mb-3">Dashboard</h4>

                    <a href="{{ route('eventos.dashboardAdmin') }}" class="btn btn-light w-100">
                        Ir a dashboard
                    </a>

                </div>

            </div>
        </div>

        {{-- MENSAJES --}}
        @if (session('success'))
            <div class="alert alert-success text-center">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger text-center">
                {{ session('error') }}
            </div>
        @endif

        {{-- FORMULARIO CREAR USUARIO --}}
        <div class="card bg-secondary text-white shadow p-4">

            <h4 class="mb-3">➕ Crear Usuario</h4>

            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre" required>

                <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>

                <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña" required>

                @if ($rol === 'admin')
                    <select name="rol" class="form-control mb-3" required>
                        <option value="cliente">Cliente</option>
                        <option value="empleado">Empleado</option>
                    </select>
                @endif

                @if ($rol === 'empleado')
                    <input type="hidden" name="rol" value="cliente">
                @endif

                <button class="btn btn-light w-100">
                    Crear Usuario
                </button>

            </form>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
