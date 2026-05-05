<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Empleados</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css"></head>

<body class="bg-dark text-white">

    <!-- Header -->
    @include('partials.header')

<div class="container mt-5">

    <h2>👨‍💼 Lista de Empleados</h2>

    {{-- MENSAJE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- FORMULARIO CREAR EMPLEADO --}}
    <div class="card bg-secondary text-white shadow mb-4">
        <div class="card-body">
            <h5>➕ Crear Empleado</h5>

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

                <input type="hidden" name="rol" value="empleado">

                <button class="btn btn-light w-100">
                    Crear empleado
                </button>
            </form>
        </div>
    </div>

    {{-- LISTADO --}}
    <div class="card bg-secondary text-white shadow">
        <div class="card-body">

            <h5>📋 Empleados registrados</h5>

            <table class="table table-dark table-striped mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($empleados as $emp)
                        <tr>
                            <td>{{ $emp->id }}</td>
                            <td>{{ $emp->nombre }}</td>
                            <td>{{ $emp->email }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</div>

</body>
</html>