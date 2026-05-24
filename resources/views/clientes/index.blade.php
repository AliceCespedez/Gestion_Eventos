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
        .btn-search {
            text-transform: uppercase !important;
            background-color: var(--color-beige-claro);
            color: var(--color-chocolate);
            font-family: 'BeVietnam';
            border-radius: 0;
        }

        .btn-search:hover {
            background-color: var(--color-beige-medio);
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


            {{-- CREAR USUARIO --}}
            <div>
                <a href="{{ route('dashboard') }}" class="btn-claro" title="Nuevo usuario"><i
                        class="bi bi-plus-lg"></i></a>
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
                                @if ($totalEventos > 0)
                                    <div class="eventos-dropdown">
                                        <span class="eventos-link">
                                            <span class="eventos-count">🡣</span>
                                            {{ $totalEventos }}
                                        </span>

                                        <div class="dropdown-content">
                                            @foreach ($eventosCliente as $evento)
                                                <div class="dropdown-item">
                                                    <span>
                                                        <strong>{{ $evento->nombre_evento }}</strong><br>
                                                        <small>{{ \Carbon\Carbon::parse($evento->fecha)->format('d/m/Y') }}</small>
                                                    </span>
                                                    <a href="{{ route('eventos.show', $evento->id_evento) }}"
                                                        class="btn-ver-evento">
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
                                <a href="{{ route('users.edit', $cliente->id_usuario) }}"
                                    class="btn btn-success btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                    Editar
                                </a>

                                {{-- BOTÓN ELIMINAR --}}
                                @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                                    <button type="button" class="btn btn-danger btn-sm delete-btn"
                                        data-id="{{ $cliente->id_usuario }}" data-nombre="{{ $cliente->nombre }}">

                                        <i class="bi bi-trash3 color-white pe-1"></i>
                                        Eliminar
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>


    </div>


    @include('partials.footer')


    <!--  SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.delete-btn').forEach(button => {

            button.addEventListener('click', function() {

                const clienteId = this.dataset.id;
                const nombre = this.dataset.nombre;

                Swal.fire({
                    title: '¿Eliminar cliente?',
                    html: `
                <p>
                    Vas a eliminar a 
                    <strong>${nombre}</strong>.
                </p>
                <small>Esta acción no se puede deshacer.</small>
            `,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7b2d26',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {

                    if (result.isConfirmed) {

                        fetch(`/users/${clienteId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector(
                                        'meta[name="csrf-token"]').content,
                                    'Content-Type': 'application/json',
                                    'Accept': 'application/json'
                                }
                            })

                            .then(response => response.json())

                            .then(data => {

                                // ERROR → TIENE EVENTOS
                                if (!data.success) {

                                    Swal.fire({
                                        title: 'No se puede eliminar',
                                        text: data.message,
                                        icon: 'error',
                                        confirmButtonColor: '#7b2d26'
                                    });

                                    return;
                                }

                                // ÉXITO
                                Swal.fire({
                                    title: 'Cliente eliminado',
                                    text: data.message,
                                    icon: 'success',
                                    timer: 1800,
                                    showConfirmButton: false
                                });

                                // eliminar fila visualmente
                                button.closest('tr').remove();

                            })

                            .catch(error => {

                                Swal.fire({
                                    title: 'Error',
                                    text: 'Ha ocurrido un error inesperado.',
                                    icon: 'error',
                                    confirmButtonColor: '#7b2d26'
                                });

                                console.error(error);

                            });
                    }

                });

            });

        });
    </script>

</body>

</html>
