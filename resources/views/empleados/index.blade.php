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
                                <a href="{{ route('users.edit', $emp->id_usuario) }}" class="btn btn-success btn-sm">
                                    <i class="bi bi-pencil-square"></i>
                                    Editar
                                </a>
                                @if (Auth::user()->rol === 'admin')
                                    {{-- BOTÓN ELIMINAR --}}
                                    <form action="{{ route('users.destroy', $emp->id_usuario) }}" method="POST"
                                        class="delete-form d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash3 color-white pe-1"></i>
                                            Eliminar
                                        </button>

                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    @include('partials.footer')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {

            form.addEventListener('submit', function(e) {

                e.preventDefault();

                Swal.fire({
                    title: '¿Eliminar empleado?',
                    text: 'Esta acción no se puede deshacer',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#7b2d26',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {

                    if (result.isConfirmed) {

                        // ENVÍO NORMAL DEL FORMULARIO
                        HTMLFormElement.prototype.submit.call(form);

                    }

                });

            });

        });
    </script>
    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
