<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Invitados</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Bootstrap JS (IMPORTANTE para dropdown) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        #invitados-body {
            justify-content: flex-start;
        }
    </style>
</head>


<body class="bg-white normal-body">

    @include('partials.header')



    @if (in_array(auth()->user()->rol, ['admin', 'empleado']))
        <button class="btn btn-success mb-3" data-bs-toggle="modal" data-bs-target="#addInvitadoModal">
            <i class="bi bi-plus-lg"></i> Añadir invitado
        </button>
    @endif

    <div id="invitados-body" class="section-1">

        <div class="normal-header">
            <h2 class="color-choco">Invitados</h2>
            <h5 class="color-choco">{{ $evento->nombre_evento }}</h5>
        </div>

        <div class="container mt-5">
            <a href="{{ url()->previous() }}" class="d-inline-block mb-3">🡠 Volver al evento</a>

            <table class="table table-choco border-eventea bg-white">
                <thead class="">
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
            </table>

            
            <!-- MODAL AÑADIR INVITADO -->
            <div class="modal fade" id="addInvitadoModal" tabindex="-1">

                <div class="modal-dialog">

                    <div class="modal-content">

                        <form method="POST" action="{{ route('invitados.store', $evento->id_evento) }}">

                            @csrf

                            <div class="modal-header">

                                <h5 class="modal-title">
                                    Añadir invitado
                                </h5>

                                <button type="button" class="btn-close" data-bs-dismiss="modal">
                                </button>

                            </div>

                            <div class="modal-body">

                                <div class="mb-3">
                                    <label>Nombre</label>

                                    <input type="text" name="nombre" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label>Email</label>

                                    <input type="email" name="email" class="form-control">
                                </div>

                            </div>

                            <div class="modal-footer">

                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                                    Cancelar
                                </button>

                                <button class="btn btn-primary">
                                    Guardar invitado
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

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
    </div>

    @include('partials.footer')

</body>

</html>
