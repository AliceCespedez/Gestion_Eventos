<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Clientes</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .btn-search{
            text-transform: uppercase !important;
            background-color: var(--color-beige-claro);
            color: var(--color-chocolate);
            font-family: 'BeVietnam';
            border-radius: 0;
        }
        .btn-search:hover{
            background-color: var(--color-beige-medio);
        }


        .table-choco thead th {
            background-color: var(--color-chocolate) !important;
            color: white !important;
            border: 1px solid white !important;
        }
        .table-choco tbody td {
            border: 1px solid var(--color-chocolate) !important;
            color: var(--color-chocolate) !important;
        }
        
        /* DESPLEGABLE */
        .eventos-dropdown {
            position: relative;
            display: inline-block;
        }
        .eventos-dropdown:hover .dropdown-content {
            display: block;
        }
        
        .dropdown-content {
            display: none;
            position: absolute;
            background-color: white;
            min-width: 300px;
            max-height: 300px;
            overflow-y: auto;
            z-index: 1000;
            border: 1px solid var(--color-chocolate);
        }        
        
        .dropdown-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            border-bottom: 1px solid var(--color-chocolate);
            gap: 10px;
        }
        .dropdown-item:last-child {
            border-bottom: none;
        }
        .dropdown-item span {
            font-size: 0.9rem;
            color: var(--color-chocolate);
        }
        
        .btn-ver-evento {
            background-color: var(--color-chocolate);
            color: white !important;
            padding: 5px 10px;
            text-decoration: none;
            font-size: 0.8rem;
            transition: all 0.3s;
            white-space: nowrap;
        }
        .btn-ver-evento:hover {
            background-color: var(--color-beige-medio);
            color: var(--color-chocolate);
        }
        
        .eventos-count {
            display: inline-block;
            background-color: var(--color-chocolate);
            color: white;
            padding: 2px 8px;
            font-size: 0.8rem;
            margin-left: 5px;
        }
        
        .eventos-link {
            color: var(--color-chocolate);
            text-decoration: none;
            cursor: pointer;
            font-weight: 500;
        }


        .btn-success{
            background-color: var(--color-beige-claro);
            color: var(--color-chocolate);
            border-radius: 0;
            border: none;
        }
        .btn-success:hover{
            background-color: var(--color-beige-medio) !important;
            color: var(--color-chocolate);
            opacity: 1;
            border: none;
        }
    </style>
</head>

<body class="bg-white normal-body text-white">

    @include('partials.header')            
        

    <div class="section-1">

        <div class="normal-header">
                <h2 class="color-choco">Clientes registrados</h2>
        </div>

        <div class="mt-5 container">

            <a href="{{ url()->previous() }}" class="d-inline-block mb-3">🡠 Volver</a>

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


            {{-- BUSCADOR --}}
            <div class="bg-medio color-choco p-4 mb-4">
                <div class="card-body">

                    <h5><i class="bi bi-search color-choco"></i> Buscar clientes</h5>

                    <form method="GET" action="{{ route('clientes.index') }}">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control rounded-0"
                                placeholder="Buscar por nombre o email..." value="{{ request('search') }}">

                            <button class="btn btn-search" type="submit">Buscar</button>
                        </div>
                    </form>

                </div>
            </div>


            {{-- TABLA CLIENTES --}}
            
            <table class="table table-choco mt-3">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Eventos</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($clientes as $cliente)
                        @php
                            $eventosCliente = $cliente->eventos ?? collect();
                            $totalEventos = $eventosCliente->count();
                        @endphp
                        
                        <tr>
                            <td>{{ $cliente->id_usuario }}</td>
                            <td>{{ $cliente->nombre }}</td>
                            <td>{{ $cliente->email }}</td>
                            
                            {{-- COLUMNA DE EVENTOS --}}
                            <td>
                                @if($totalEventos > 0)
                                    <div class="eventos-dropdown">
                                        <span class="eventos-link">
                                            <span class="eventos-count">🡣</span>
                                            {{ $totalEventos }}
                                        </span>
                                        
                                        <div class="dropdown-content">
                                            @foreach($eventosCliente as $evento)
                                                <div class="dropdown-item">
                                                    <span>
                                                        <strong>{{ $evento->nombre_evento }}</strong><br>
                                                        <small>{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</small>
                                                    </span>
                                                    <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn-ver-evento">
                                                        VER
                                                    </a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @else
                                    <span style="color: var(--color-beige-medio);">Sin eventos</span>
                                @endif
                            </td>
                            
                            <td>
                                {{-- BOTÓN CREAR EVENTO --}}
                                <a href="{{ route('eventos.admin_create', ['cliente' => $cliente->id_usuario]) }}"
                                    class="btn btn-success btn-sm">
                                    <i class="bi bi-plus-lg"></i> Crear evento
                                </a>

                                {{-- BOTÓN ELIMINAR --}}
                                @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                                    <button type="button" class="btn btn-danger btn-sm"
                                        onclick="eliminarCliente({{ $cliente->id_usuario }}, '{{ $cliente->nombre }}')">
                                        <i class="bi bi-trash3 color-white pe-1"></i> Eliminar
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
    </div>


    @include('partials.footer')        


    <!--  SCRIPTS -->
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

                        // cerrar modal
                        bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();

                        // crear alerta dinámica
                        const alert = document.createElement('div');
                        alert.className = 'alert alert-success mt-3';
                        alert.textContent = data.message;

                        document.querySelector('.container').prepend(alert);

                        // 👇 desaparece en 3 segundos
                        setTimeout(() => {
                            alert.style.transition = 'opacity 0.5s ease';
                            alert.style.opacity = '0';

                            setTimeout(() => {
                                alert.remove();
                            }, 500);
                        }, 3000);

                        // eliminar fila de la tabla sin recargar
                        document.querySelector(`button[onclick*="${clienteIdAEliminar}"]`)
                            .closest('tr')
                            .remove();
                    } else {
                        document.getElementById('errorMessage').textContent = data.message;
                        bootstrap.Modal.getInstance(document.getElementById('confirmModal')).hide();
                        new bootstrap.Modal(document.getElementById('errorModal')).show();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    document.getElementById('errorMessage').textContent =
                        'Error inesperado al eliminar el cliente.';
                    new bootstrap.Modal(document.getElementById('errorModal')).show();
                });
        });

        // Ocultar alertas de éxito del servidor después de unos segundos
        document.querySelectorAll('.alert-success').forEach(successAlert => {
            setTimeout(() => {
                successAlert.style.transition = 'opacity 0.5s ease';
                successAlert.style.opacity = '0';
                setTimeout(() => {
                    successAlert.remove();
                }, 500);
            }, 3000);
        });
    </script>

</body>

</html>
