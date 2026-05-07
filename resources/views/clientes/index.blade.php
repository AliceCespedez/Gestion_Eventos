<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clientes</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
</head>

<body class="bg-dark text-white">

    <!-- Header -->
    @include('partials.header')

    <div class="container mt-5">

        <h2>📋 Lista de Clientes</h2>

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

        {{-- MENSAJE DE ÉXITO --}}
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- FORMULARIO CREAR CLIENTE --}}
        <div class="card bg-secondary text-white shadow mb-4">
            <div class="card-body">
                <h5 class="card-title">➕ Crear Nuevo Cliente</h5>

                <form action="{{ route('users.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="rol" value="cliente">

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-light">
                        Crear Cliente
                    </button>
                </form>

            </div>
        </div>

        {{-- TABLA CLIENTES --}}
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

                @foreach ($clientes as $cliente)
                    <tr>
                        <td>{{ $cliente->id_usuario }}</td>
                        <td>{{ $cliente->nombre }}</td>
                        <td>{{ $cliente->email }}</td>

                        <td>
                            {{-- BOTÓN CREAR EVENTO --}}
                            <a href="{{ route('eventos.admin_create', ['cliente' => $cliente->id_usuario]) }}"
                                class="btn btn-success btn-sm">
                                ➕ Crear evento
                            </a>

                            {{-- BOTÓN ELIMINAR --}}
                            @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                                <button type="button" class="btn btn-danger btn-sm"
                                    onclick="eliminarCliente({{ $cliente->id_usuario }}, '{{ $cliente->nombre }}')">
                                    🗑 Eliminar
                                </button>
                            @endif
                        </td>
                    </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    <!-- MODAL DE ERROR -->
    <div class="modal fade" id="errorModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">❌ Error al eliminar</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p id="errorMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL DE CONFIRMACIÓN -->
    <div class="modal fade" id="confirmModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-white">
                <div class="modal-header">
                    <h5 class="modal-title">🗑 Confirmar eliminación</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>¿Estás seguro de que quieres eliminar al cliente <strong id="clienteNombre"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Eliminar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let clienteIdAEliminar = null;

        function eliminarCliente(id, nombre) {
            clienteIdAEliminar = id;
            document.getElementById('clienteNombre').textContent = nombre;
            new bootstrap.Modal(document.getElementById('confirmModal')).show();
        }

        document.getElementById('confirmDeleteBtn').addEventListener('click', function() {
            if (!clienteIdAEliminar) return;

            fetch(`/users/${clienteIdAEliminar}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    document.getElementById('errorMessage').textContent = data.message;
                    bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
                    new bootstrap.Modal(document.getElementById('errorModal')).show();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('errorMessage').textContent = 'Error inesperado al eliminar el cliente.';
                new bootstrap.Modal(document.getElementById('errorModal')).show();
            });
        });
    </script>

</body>

</html>
