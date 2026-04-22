<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Eventos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

<div class="container mt-5">

    <h2 class="mb-4">📅 Mis Eventos</h2>

    {{-- Mensaje --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-dark table-striped">

        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Fecha</th>
                <th>Estado</th>

                @if(auth()->user()->rol === 'empleado')
                    <th>Cliente</th>
                @endif

                {{-- NUEVA COLUMNA --}}
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($eventos as $evento)
                <tr>
                    <td>{{ $evento->id_evento }}</td>
                    <td>{{ $evento->nombre_evento }}</td>
                    <td>{{ $evento->tipo->nombre_tipo ?? 'Sin tipo' }}</td>
                    <td>{{ $evento->fecha }}</td>
                    <td>{{ $evento->estado }}</td>

                    @if(auth()->user()->rol === 'empleado')
                        <td>{{ $evento->usuario->nombre ?? 'Sin cliente' }}</td>
                    @endif

                    {{-- BOTÓN GESTIONAR --}}
                    <td>
                        <a href="{{ route('eventos.show', $evento->id_evento) }}" 
                           class="btn btn-outline-light btn-sm">
                            Gestionar
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>

    </table>

    {{-- Botón volver --}}
    <a href="{{ route('dashboard') }}" class="btn btn-outline-light mt-3">
        ⬅ Volver al dashboard
    </a>

</div>

</body>
</html>