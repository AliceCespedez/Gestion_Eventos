<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Evento</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-md-8">

                <div class="card shadow-lg border-0">

                    <div class="card-header bg-dark text-white text-center">
                        <h4 class="mb-0">Crear Evento Completo</h4>
                    </div>

                    <div class="card-body">

                        {{-- ERRORES GENERALES --}}
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form method="POST" action="{{ route('eventos.store') }}">
                            @csrf

                            {{-- NOMBRE --}}
                            <div class="mb-3">
                                <label class="form-label">Nombre evento</label>
                                <input name="nombre_evento" value="{{ old('nombre_evento') }}"
                                    class="form-control @error('nombre_evento') is-invalid @enderror">

                                @error('nombre_evento')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- FECHA --}}
                            <div class="mb-3">
                                <label class="form-label">Fecha</label>
                                <input type="date" name="fecha" value="{{ old('fecha') }}"
                                    class="form-control @error('fecha') is-invalid @enderror">

                                @error('fecha')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- LOCAL --}}
                            <div class="mb-3">
                                <label class="form-label">Local</label>
                                <select name="local_id" class="form-select @error('local_id') is-invalid @enderror">

                                    <option value="">Seleccione un local</option>

                                    @foreach ($locales as $local)
                                        <option value="{{ $local->id_local }}"
                                            {{ old('local_id') == $local->id_local ? 'selected' : '' }}>
                                            {{ $local->nombre }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('local_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- TIPO --}}
                            <div class="mb-3">
                                <label class="form-label">Tipo evento</label>
                                <select name="tipo_id" class="form-select @error('tipo_id') is-invalid @enderror">

                                    <option value="">Seleccione tipo</option>

                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id_tipo }}"
                                            {{ old('tipo_id') == $tipo->id_tipo ? 'selected' : '' }}>
                                            {{ $tipo->nombre_tipo }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('tipo_id')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- MENÚ --}}
                            <div class="mb-3">
                                <label class="form-label">Menú</label>

                                <div class="border rounded p-3 bg-light">

                                    @foreach ($menus as $menu)
                                        <div class="d-flex align-items-center gap-2 mb-2">

                                            <input type="checkbox" name="menus[]" value="{{ $menu->id }}"
                                                {{ is_array(old('menus')) && in_array($menu->id, old('menus')) ? 'checked' : '' }}>

                                            <span class="flex-grow-1">
                                                {{ $menu->nombre }}
                                            </span>

                                            <input type="number" name="cantidad[{{ $menu->id }}]"
                                                class="form-control form-control-sm w-25" placeholder="Cantidad"
                                                value="{{ old('cantidad.' . $menu->id) }}">
                                        </div>
                                    @endforeach

                                </div>
                            </div>

                            {{-- INVITADOS --}}
                            <div class="mb-3">
                                <label class="form-label">Invitados</label>

                                <div id="invitados-container">

                                    <div class="row mb-2">
                                        <div class="col">
                                            <input type="text" name="invitados[0][nombre]" class="form-control"
                                                placeholder="Nombre">
                                        </div>

                                        <div class="col">
                                            <input type="email" name="invitados[0][email]" class="form-control"
                                                placeholder="Email">
                                        </div>
                                    </div>

                                </div>

                                <button type="button" class="btn btn-secondary btn-sm mt-2"
                                    onclick="agregarInvitado()">
                                    ➕ Añadir invitado
                                </button>
                            </div>

                            {{-- PRESUPUESTO --}}
                            <div class="mb-3">
                                <label class="form-label">Presupuesto (€)</label>
                                <input type="number" name="presupuesto" min="1"
                                    value="{{ old('presupuesto') }}"
                                    class="form-control @error('presupuesto') is-invalid @enderror">

                                @error('presupuesto')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- BOTÓN --}}
                            <button class="btn btn-primary w-100 mt-3">
                                Crear evento completo
                            </button>

                        </form>

                    </div>
                </div>

            </div>

        </div>

    </div>

    <script>
        let index = 1;

        function agregarInvitado() {
            let container = document.getElementById('invitados-container');

            let html = `
    <div class="row mb-2">
        <div class="col">
            <input type="text" name="invitados[${index}][nombre]" class="form-control" placeholder="Nombre">
        </div>
        <div class="col">
            <input type="email" name="invitados[${index}][email]" class="form-control" placeholder="Email">
        </div>
        <div class="col">
            <input type="text" name="invitados[${index}][telefono]" class="form-control" placeholder="Teléfono">
        </div>
    </div>
    `;

            container.insertAdjacentHTML('beforeend', html);
            index++;
        }
    </script>

</body>

</html>
