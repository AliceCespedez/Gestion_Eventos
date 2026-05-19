<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Eventos</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

@php
    $user = auth()->user();
    $rol = $user->rol;
@endphp


<body class="bg-white normal-body">

    @include('partials.header')


    <div class="section-1">

        <div class="normal-header">
            <h2 class="color-choco">Eventos</h2>
        </div>

        <div class="mt-5 container">

            <a href="{{ url()->previous() }}" class="d-inline-block mb-3">🡠 Volver</a>

            {{-- Mensaje --}}
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            {{-- BUSCADOR --}}
            <div class="bg-medio color-choco p-4 mb-4">
                <div class="card-body">

                    <h5><i class="bi bi-search color-choco"></i> Buscar eventos</h5>

                    <form method="GET" action="{{ route('eventos.index') }}" class="mb-2">
                        <div class="input-group">
                            <input type="text" name="buscar" class="form-control"
                                placeholder="Buscar evento por nombre..." value="{{ request('buscar') }}">

                            <button class="btn btn-search" type="submit">Buscar</button>
                        </div>
                    </form>

                </div>
            </div>


            <table class="table table-choco mt-3">

                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Tipo</th>
                        <th>Fecha</th>
                        <th>Estado</th>

                        {{-- Cliente solo lo ve empleado o admin --}}
                        @if (in_array($rol, ['empleado', 'admin']))
                            <th>Cliente</th>
                        @endif

                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($eventos as $evento)
                        <tr>
                            <td>{{ $evento->id_evento }}</td>
                            <td>{{ $evento->nombre_evento }}</td>
                            <td>{{ $evento->tipo->nombre_tipo ?? 'Sin tipo' }}</td>
                            <td>{{ $evento->fecha }}</td>
                            <td>{{ $evento->estado }}</td>

                            {{--  Cliente visible para admin y empleado --}}
                            @if (in_array($rol, ['empleado', 'admin']))
                                <td>{{ $evento->usuario->nombre ?? 'Sin cliente' }}</td>
                            @endif

                            <td class="d-flex gap-2">

                                <a href="{{ route('eventos.show', $evento->id_evento) }}"
                                    class="btn btn-success btn-sm">
                                    Gestionar
                                </a>

                                @if (in_array($rol, ['admin', 'empleado']))
                                    <form action="{{ route('eventos.destroy', $evento->id_evento) }}" method="POST"
                                        class="delete-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="bi bi-trash3 color-white pe-1"></i>Eliminar
                                        </button>
                                    </form>
                                @endif

                            </td>
                        </tr>
                    @endforeach
                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

                    <script>
                        document.querySelectorAll('.delete-form').forEach(form => {

                            form.addEventListener('submit', function(e) {

                                e.preventDefault();

                                Swal.fire({
                                    title: '¿Eliminar evento?',
                                    text: 'Esta acción no se puede deshacer',
                                    icon: 'warning',
                                    showCancelButton: true,
                                    confirmButtonColor: '#7b2d26',
                                    cancelButtonColor: '#6c757d',
                                    confirmButtonText: 'Sí, eliminar',
                                    cancelButtonText: 'Cancelar'
                                }).then((result) => {

                                    if (result.isConfirmed) {
                                        form.submit();
                                    }

                                });

                            });

                        });
                    </script>
                </tbody>

            </table>

            {{--
            @php
                $user = auth()->user();
            @endphp

            @if ($user->rol === 'admin')
                <a href="{{ route('admin') }}" class="btn btn-outline-light mt-3">
                    ⬅ Volver al panel admin
                </a>
            @elseif($user->rol === 'empleado')
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light mt-3">
                    ⬅ Volver al dashboard
                </a>
            @else
                <a href="{{ route('dashboard') }}" class="btn btn-outline-light mt-3">
                    ⬅ Volver
                </a>
            @endif
            --}}

        </div>

    </div>

    @include('partials.footer')
    
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
