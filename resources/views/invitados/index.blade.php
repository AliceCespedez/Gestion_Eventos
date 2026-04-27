<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lista de invitados</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap JS (IMPORTANTE para dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light">

    <div class="container mt-5">

        <h2>👥 Invitados del evento: {{ $evento->nombre_evento }}</h2>

        <a href="{{ route('eventos.show', $evento->id_evento) }}" class="btn btn-secondary mb-3">
            ← Volver al evento
        </a>

        <table class="table table-bordered bg-white">

            <thead class="table-dark">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>

                @forelse($evento->invitados as $inv)
                    <tr>

                        <td>{{ $inv->nombre }}</td>
                        <td>{{ $inv->email }}</td>

                        <!-- ESTADO -->
                        <td>

                            @if (in_array(auth()->user()->rol, ['admin', 'empleado']))
                                <form method="POST" action="{{ route('invitados.estado', $inv->id_invitado) }}">
                                    @csrf

                                    <div class="dropdown">

                                        <button
                                            class="btn btn-sm btn-{{ $inv->confirmacion == 'confirmado' ? 'success' : ($inv->confirmacion == 'pendiente' ? 'warning' : 'danger') }} dropdown-toggle"
                                            type="button" data-bs-toggle="dropdown">

                                            {{ ucfirst($inv->confirmacion) }}

                                        </button>

                                        <ul class="dropdown-menu">

                                            <li>
                                                <button class="dropdown-item" name="confirmacion" value="pendiente">
                                                    🟡 Pendiente
                                                </button>
                                            </li>

                                            <li>
                                                <button class="dropdown-item" name="confirmacion" value="confirmado">
                                                    🟢 Confirmado
                                                </button>
                                            </li>

                                            <li>
                                                <button class="dropdown-item" name="confirmacion" value="rechazado">
                                                    🔴 Rechazado
                                                </button>
                                            </li>

                                        </ul>

                                    </div>

                                </form>
                            @else
                                <!-- SOLO LECTURA (CLIENTE) -->
                                <span
                                    class="badge bg-{{ $inv->confirmacion == 'confirmado' ? 'success' : ($inv->confirmacion == 'pendiente' ? 'warning' : 'danger') }}">
                                    {{ ucfirst($inv->confirmacion) }}
                                </span>
                            @endif

                        </td>

                    </tr>

                @empty
                    <tr>
                        <td colspan="3" class="text-center">No hay invitados</td>
                    </tr>
                @endforelse

            </tbody>

        </table>

    </div>

</body>

</html>
