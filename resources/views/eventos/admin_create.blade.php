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
            <div class="col-md-9">

                <div class="card shadow-lg border-0">

                    <div class="card-header bg-dark text-white text-center">
                        <h4 class="mb-0">🧾 Crear Evento Completo</h4>
                    </div>

                    <div class="card-body">

                        {{--  PRESUPUESTO EN TIEMPO REAL --}}
                        <div class="alert alert-info">
                            💰 Presupuesto inicial: <span id="presupuestoTexto">0</span> € <br>
                            💸 Gastado: <span id="gastadoTexto">0</span> € <br>
                            🧾 Restante: <span id="restanteTexto">0</span> €
                        </div>

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

                        <form method="POST" action="{{ route('eventos.store') }}">
                            @csrf

                            {{-- CLIENTE --}}
                            <div class="mb-3">
                                <label class="form-label">👤 Cliente</label>

                                @if (isset($clienteSeleccionado))
                                    @php
                                        $clienteFijo = $clientes->firstWhere('id_usuario', $clienteSeleccionado);
                                    @endphp

                                    <input type="hidden" name="id_usuario" value="{{ $clienteSeleccionado }}">

                                    <input type="text" class="form-control"
                                        value="{{ $clienteFijo ? $clienteFijo->nombre : 'Cliente seleccionado' }}"
                                        disabled>
                                @else
                                    <select name="id_usuario" class="form-select">
                                        <option value="">Seleccione cliente</option>

                                        @foreach ($clientes as $cliente)
                                            <option value="{{ $cliente->id_usuario }}">
                                                {{ $cliente->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                            {{-- PRESUPUESTO --}}
                            <div class="mb-3">
                                <label class="form-label">💰 Presupuesto</label>
                                <input type="number" name="presupuesto" id="presupuestoInput" class="form-control">
                            </div>

                            {{-- NOMBRE --}}
                            <div class="mb-3">
                                <label class="form-label">Nombre evento</label>
                                <input name="nombre_evento" value="{{ old('nombre_evento') }}" class="form-control">
                            </div>

                            {{-- FECHA --}}
                            <div class="mb-3">
                                <label class="form-label">Fecha</label>
                                <input type="date" name="fecha" value="{{ old('fecha') }}" class="form-control">
                            </div>

                            {{-- LOCAL --}}
                            <div class="mb-3">
                                <label class="form-label">🏢 Local</label>

                                <select name="local_id" id="localSelect" class="form-select">
                                    <option value="" data-precio="0">Seleccione un local</option>

                                    @foreach ($locales as $local)
                                        <option value="{{ $local->id_local }}" data-precio="{{ $local->precio ?? 0 }}">
                                            {{ $local->nombre }} - {{ $local->precio ?? 0 }} €
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- MESAS --}}
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label">🪑 Número de mesas</label>
                                    <input type="number" name="num_mesas" min="1" class="form-control">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label">💺 Asientos por mesa</label>
                                    <input type="number" name="asientos_mesa" min="1" class="form-control">
                                </div>
                            </div>

                            {{-- TIPO --}}
                            <div class="mb-3">
                                <label class="form-label">Tipo evento</label>
                                <select name="tipo_id" class="form-select">
                                    <option value="">Seleccione tipo</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id_tipo }}">
                                            {{ $tipo->nombre_tipo }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- MENÚS --}}
                            <div class="mb-3">
                                <label class="form-label">🍽 Menús</label>

                                <div class="border rounded p-3 bg-light">

                                    @foreach ($menus as $menu)
                                        <div class="d-flex align-items-center gap-2 mb-2">

                                            <input type="checkbox" name="menus[]" value="{{ $menu->id_menu }}"
                                                data-precio="{{ $menu->precio_unitario }}">

                                            <span class="flex-grow-1">{{ $menu->nombre }}</span>

                                            <input type="number" name="cantidad[{{ $menu->id_menu }}]"
                                                class="form-control form-control-sm w-25" placeholder="Cant.">
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            {{-- SERVICIOS --}}
                            <div class="mb-3">
                                <label class="form-label">Servicios (opcionales)</label>

                                <div class="border rounded p-3 bg-light">

                                    @foreach ($servicios as $servicio)
                                        <div class="d-flex align-items-center gap-2 mb-2">

                                            <input type="checkbox" name="servicios[]"
                                                value="{{ $servicio->id_servicio }}"
                                                data-precio="{{ $servicio->precio_unitario }}">

                                            <span class="flex-grow-1">
                                                {{ $servicio->nombre }} - {{ $servicio->precio_unitario }} €
                                            </span>

                                            <input type="number"
                                                name="cantidad_servicio[{{ $servicio->id_servicio }}]"
                                                class="form-control form-control-sm w-25" placeholder="Cant.">
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">👥 Invitados</label>

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

                                <button type="button" class="btn btn-secondary btn-sm" onclick="agregarInvitado()">
                                    ➕ Añadir invitado
                                </button>
                            </div>



                            {{-- BOTÓN --}}
                            <button class="btn btn-primary w-100">
                                Crear evento
                            </button>

                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        let index = 1;

        // Invitados dinámicos
        function agregarInvitado() {
            let container = document.getElementById('invitados-container');

            container.insertAdjacentHTML('beforeend', `
        <div class="row mb-2">
            <div class="col">
                <input type="text" name="invitados[${index}][nombre]" class="form-control" placeholder="Nombre">
            </div>
            <div class="col">
                <input type="email" name="invitados[${index}][email]" class="form-control" placeholder="Email">
            </div>
        </div>
    `);

            index++;
        }

        function calcularPresupuesto() {
            console.log("Calculando presupuesto");

            let presupuesto = parseFloat(document.getElementById("presupuestoInput").value) || 0;
            let gastado = 0;

            // =====================
            // MENÚS
            // =====================
            document.querySelectorAll("input[name='menus[]']:checked").forEach(cb => {

                let precio = parseFloat(cb.dataset.precio) || 0;
                let id = cb.value;

                let cantidadInput = document.querySelector(`input[name="cantidad[${id}]"]`);
                let cantidad = parseFloat(cantidadInput?.value) || 1;

                console.log("Menú", id, "precio:", precio, "cantidad:", cantidad, "total:", precio * cantidad);

                gastado += precio * cantidad;
            });

            // =====================
            // LOCAL
            // =====================
            let localSelect = document.getElementById("localSelect");

            if (localSelect && localSelect.value) {
                let localPrecio = parseFloat(
                    localSelect.options[localSelect.selectedIndex].dataset.precio
                ) || 0;

                console.log("Local precio:", localPrecio);

                gastado += localPrecio;
            }

            // =====================
            // SERVICIOS
            // =====================
            document.querySelectorAll("input[name='servicios[]']:checked").forEach(cb => {

                let precio = parseFloat(cb.dataset.precio) || 0;
                let id = cb.value;

                let cantidadInput = document.querySelector(`input[name="cantidad_servicio[${id}]"]`);
                let cantidad = parseFloat(cantidadInput?.value) || 1;

                console.log("Servicio", id, "precio:", precio, "cantidad:", cantidad, "total:", precio * cantidad);

                gastado += precio * cantidad;
            });

            console.log("Gastado total:", gastado);

            // =====================
            // RESULTADO
            // =====================
            let restante = presupuesto - gastado;

            document.getElementById("presupuestoTexto").innerText = presupuesto.toFixed(2);
            document.getElementById("gastadoTexto").innerText = gastado.toFixed(2);
            document.getElementById("restanteTexto").innerText = restante.toFixed(2);

            let restanteEl = document.getElementById("restanteTexto");

            if (restante < 0) {
                restanteEl.style.color = "red";
                restanteEl.innerText = restante.toFixed(2) + " (EXCEDIDO)";
            } else {
                restanteEl.style.color = "green";
            }
        }

        document.addEventListener("input", calcularPresupuesto);
        document.addEventListener("change", calcularPresupuesto);
    </script>

</body>

</html>
