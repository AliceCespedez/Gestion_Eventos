<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

@php
    $user = auth()->user();
    $rol = strtolower(trim($user->rol ?? ''));
@endphp

<div class="container mt-5">

    <div class="card bg-secondary text-white shadow">
        <div class="card-body">

            <h1 class="text-center mb-4">➕ Crear Usuario</h1>

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

            {{-- 🚨 SOLO ADMIN Y EMPLEADO PUEDEN VER --}}
            @if(in_array($rol, ['admin', 'empleado']))

                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    {{-- 🔴 ADMIN puede elegir rol --}}
                    @if($rol === 'admin')
                        <div class="mb-3">
                            <label>Rol</label>
                            <select name="rol" class="form-control">
                                <option value="cliente">Cliente</option>
                                <option value="empleado">Empleado</option>
                            </select>
                        </div>
                    @endif

                    {{-- 👨‍💼 EMPLEADO SOLO CLIENTE --}}
                    @if($rol === 'empleado')
                        <input type="hidden" name="rol" value="cliente">
                    @endif

                    <button class="btn btn-light w-100">
                        Crear Usuario
                    </button>

                </form>

            @else

                <div class="alert alert-danger text-center">
                    No tienes permisos para acceder a este formulario
                </div>

            @endif

        </div>
    </div>

</div>

</body>
</html>