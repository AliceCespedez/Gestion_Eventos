<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Empleados</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body class="bg-dark text-white">

    <!-- Header -->
    @include('partials.header')

    <div class="container mt-5">

        <h2>👨‍💼 Lista de Empleados</h2>

        {{-- MENSAJES --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form method="GET" action="{{ route('empleados.index') }}" class="mb-3">

            <div class="input-group">

                <input type="text" name="search" class="form-control"
                    placeholder="Buscar empleado por nombre o email..." value="{{ request('search') }}">

                <button class="btn btn-light">
                    🔍 Buscar
                </button>

                @if (request('search'))
                    <a href="{{ route('empleados.index') }}" class="btn btn-secondary">
                        Limpiar
                    </a>
                @endif

            </div>

        </form>

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
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($empleados as $emp)
                            <tr>
                                <td>{{ $emp->id_usuario }}</td>
                                <td>{{ $emp->nombre }}</td>
                                <td>{{ $emp->email }}</td>

                                <td>
                                    @if (Auth::user()->rol === 'admin')
                                        <!-- Botón eliminar -->
                                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal{{ $emp->id_usuario }}">
                                            🗑 Eliminar
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>

    {{-- MODALES DE ELIMINACIÓN --}}
    @foreach ($empleados as $emp)
        <div class="modal fade" id="deleteModal{{ $emp->id_usuario }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-white">

                    <div class="modal-header">
                        <h5 class="modal-title">Eliminar empleado</h5>

                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">

                        <p>
                            ¿Estás seguro de que quieres eliminar al empleado
                            <strong>{{ $emp->nombre }}</strong>?
                        </p>

                        <form method="POST" action="{{ route('users.destroy', $emp->id_usuario) }}">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger w-100">
                                🗑 Confirmar eliminación
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    @endforeach

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
