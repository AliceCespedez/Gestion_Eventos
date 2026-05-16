<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo evento</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
         .progress-bar-container {
            background-color: var(--color-beige-claro);
            border: 1px solid var(--color-chocolate);
            height: 20px;
            width: 100%;
            overflow: hidden;
        }
        
        .progress-bar-fill {
            background-color: var(--color-chocolate);
            width: 100%;
            height: 100%;
            transition: width 0.3s ease;
        }
        .progress-bar-fill.excedido {
            background-color: #dc3545;
        }
        .progress-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 0.75rem;
            color: var(--color-chocolate);
        }

        hr{
            border: none;
            opacity: 1;
            margin: 3rem 0;
            border: solid 1px var(--color-beige-medio);
        }
    </style>
</head>

<body class="bg-white">



    @include ('partials.header')



    <div class="section-1">

        <div class="normal-header">
                <h2 class="color-choco">Nuevo evento</h2>
        </div>


        <div class="mt-5 row justify-content-center">
            <div class="col-md-9">
                <div class="border-0">
                    <div class="d-flex flex-row align-items-start gap-4">

                        {{--  PRESUPUESTO EN TIEMPO REAL --}}
                        <div id="crear-presu-div" class="mb-4 border-eventea p-4" style="width: 30%">

                            <div>
                                <h5>PRESUPUESTO</h5>
                                <span id="presupuestoTexto">0</span> € <br>
                                <b>Gastado: </b><span id="gastadoTexto">0</span> € <br>
                                <b>Restante: </b><span id="restanteTexto">0</span> €
                            </div>

                            {{-- BARRA DE PROGRESO --}}
                            <div class="mt-3">
                                <div class="progress-bar-container">
                                    <div id="barraPresupuesto" class="progress-bar-fill"></div>
                                </div>
                                <div class="progress-labels">
                                    <span>0%</span>
                                    <span id="porcentajeTexto">100%</span>
                                    <span>100%</span>
                                </div>
                            </div>

                        </div>



                        <div class="bg-claro p-4">

                    
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


                            {{-- FORMULARIO --}}
                            <form method="POST" action="{{ route('eventos.store') }}" class="border-eventea p-4">
                                @csrf

                                <div class="d-flex d-flex flex-row gap-4">
                                    {{-- CLIENTE --}}
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Cliente</label>

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

                                    {{-- TIPO --}}
                                    <div class="mb-3 flex-fill">
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
                                </div>


                                <div class="d-flex d-flex flex-row gap-4">
                                    {{-- PRESUPUESTO --}}
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Presupuesto</label>
                                        <input type="number" name="presupuesto" id="presupuestoInput" class="form-control">
                                    </div>

                                    {{-- NOMBRE --}}
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Nombre evento</label>
                                        <input name="nombre_evento" value="{{ old('nombre_evento') }}" class="form-control">
                                    </div>
                                </div>


                                <div class="d-flex d-flex flex-row gap-4">
                                    {{-- FECHA --}}
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Fecha</label>
                                        <input type="date" name="fecha" value="{{ old('fecha') }}" class="form-control">
                                    </div>

                                    {{-- LOCAL --}}
                                    <div class="mb-3 flex-fill">
                                        <label class="form-label">Local</label>

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
                                    <div class="row mb-3 flex-fill">
                                        <div class="col-md-6">
                                            <label class="form-label">Número de mesas</label>
                                            <input type="number" name="num_mesas" min="1" class="form-control">
                                        </div>

                                        <div class="col-md-6 flex-fill">
                                            <label class="form-label">Asientos por mesa</label>
                                            <input type="number" name="asientos_mesa" min="1" class="form-control">
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                {{-- MENÚS --}}
                                <div class="mb-3">
                                    <label class="form-label"><h5>Menús</h5></label>

                                    <div class="border rounded p-3 bg-light">

                                        @foreach ($menus as $menu)
                                            <div class="d-flex align-items-center gap-2 mb-2">

                                                <input type="checkbox" name="menus[]" value="{{ $menu->id_menu }}"
                                                    data-precio="{{ $menu->precio_unitario }}" class="menu-checkbox">

                                                <span class="flex-grow-1">{{ $menu->nombre }}</span>

                                                <input type="number" name="cantidad[{{ $menu->id_menu }}]"
                                                    class="form-control form-control-sm w-25 cantidad-input"
                                                    placeholder="Cant." min="1" value="" step="1">
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

                                <hr>

                                {{-- INVITADOS --}}
                                <div class="mb-3">
                                    <label class="form-label"><h5>Invitados</h5></label>

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

                                    <button type="button" class="btn-small btn-sm" onclick="agregarInvitado()">
                                        <i class="bi bi-plus-lg"></i> Añadir invitado
                                    </button>
                                </div>

                                <hr>

                                {{-- BOTÓN --}}
                                <button class="btn-eventea" style="width: 100% !important; max-width: 100% !important;">
                                    Crear evento
                                </button>

                            </form>
                        </div> <!--Form div-->

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include ('partials.footer')

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
                let cantidad = parseFloat(cantidadInput?.value) || 0;

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

            // =====================
            // BARRA DE PROGRESO
            // =====================
            let barra = document.getElementById("barraPresupuesto");
            let porcentajeTexto = document.getElementById("porcentajeTexto");

            if (presupuesto > 0) {
                let porcentajeRestante = ((presupuesto - gastado) / presupuesto) * 100;
                porcentajeRestante = Math.min(100, Math.max(0, porcentajeRestante));
                
                barra.style.width = porcentajeRestante + "%";
                porcentajeTexto.innerText = Math.round(porcentajeRestante) + "%";
                
                if (gastado > presupuesto) {
                    barra.classList.add('excedido');
                    porcentajeTexto.style.color = "red";
                } else {
                    barra.classList.remove('excedido');
                    porcentajeTexto.style.color = "var(--color-chocolate)";
                }
            } else {
                barra.style.width = "0%";
                porcentajeTexto.innerText = "0%";
            }
        }

        document.addEventListener("input", calcularPresupuesto);
        document.addEventListener("change", calcularPresupuesto);
    </script>

</body>

</html>
