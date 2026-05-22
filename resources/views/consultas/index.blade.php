<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Consultas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

    <h2>Listado de Consultas</h2>

    <table class="table table-striped table-bordered align-middle">

        <thead class="table-dark">
            <tr>
                <th>ID Cliente</th>
                <th>Asunto</th>
                <th>Mensaje</th>
                <th>Tipo</th>
                <th>Prioridad</th>
                <th>Leído</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>

            @forelse($consultas as $consulta)
                <tr>

                    {{-- ID CLIENTE --}}
                    <td>
                        {{ $consulta->id_usuario }}
                    </td>

                    <td>{{ $consulta->asunto }}</td>

                    <td>{{ $consulta->mensaje }}</td>

                    <td>{{ $consulta->tipo_consulta }}</td>

                    <td>{{ $consulta->prioridad }}</td>

                    <td>
                        @if ($consulta->leido)
                            <span class="badge bg-success">
                                Sí
                            </span>
                        @else
                            <span class="badge bg-danger">
                                No
                            </span>
                        @endif
                    </td>

                    <td class="d-flex gap-2">

                        {{-- MARCAR LEÍDO --}}
                        @if (!$consulta->leido)
                            <form method="POST" action="{{ route('consultas.leer', $consulta->id_consulta) }}">

                                @csrf
                                @method('PATCH')

                                <button class="btn btn-success btn-sm">
                                    Marcar leído
                                </button>

                            </form>
                        @endif

                        {{-- ELIMINAR --}}
                        <form method="POST" action="{{ route('consultas.destroy', $consulta->id_consulta) }}">

                            @csrf
                            @method('DELETE')

                            <button class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar consulta?')">

                                Eliminar

                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="7" class="text-center">
                        No hay consultas
                    </td>
                </tr>
            @endforelse

        </tbody>

    </table>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
