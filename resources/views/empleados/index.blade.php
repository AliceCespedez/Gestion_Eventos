<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Empleados</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>

<body class="bg-white normal-body">

    <!-- Header -->
    @include('partials.header')


    <div class="section-1">

        <div class="normal-header">
                <h2 class="color-choco">Empleados</h2>
        </div>

        <div class="container mt-5">

            <a href="{{ url()->previous() }}" class="d-inline-block mb-3">🡠 Volver</a>

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
                
            {{-- BUSCADOR --}}
            <div class="bg-medio color-choco p-4 mb-4">
                <div class="card-body">

                    <h5><i class="bi bi-search color-choco"></i> Buscar empleados</h5>

                    <form method="GET" action="{{ route('empleados.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-0"
                                placeholder="Buscar por nombre o email..." value="{{ request('search') }}">

                            <button class="btn btn-search" type="submit">Buscar</button>
                            @if (request('search'))
                                <a href="{{ route('empleados.index') }}" class="btn btn-success">
                                    Limpiar
                                </a>
                            @endif
                        </div>
                    </form>

                </div>
            </div>

            {{-- EMPLEADOS --}}
             <table class="table table-choco mt-3">

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
                                        <i class="bi bi-trash3 color-white pe-1"></i> Eliminar
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    {{-- MODALES DE ELIMINACIÓN --}}
    @foreach ($empleados as $emp)
        <div class="modal fade" id="deleteModal{{ $emp->id_usuario }}" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content bg-medio text-white">

                    <div class="modal-header">
                        <h5 class="modal-title"><i class="bi bi-exclamation-triangle"></i> Confirmar la eliminación</h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>
                    </div>

                    <div class="modal-body">
                        <p>
                            ¿Estás seguro de que quieres eliminar al empleado
                            <strong>{{ $emp->nombre }}</strong>?
                        </p>

                        <form method="POST" action="{{ route('users.destroy', $emp->id_usuario) }}" class="pt-3 text-end">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger">
                                Eliminar
                            </button>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    @endforeach

    @include('partials.footer')

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>
