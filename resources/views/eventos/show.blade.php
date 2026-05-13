<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $evento->nombre_evento }}</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <style>
        body {
            background: white;
            position: relative;
        }

        
        #event-header-sticky{
            width: 100%;
            height: fit-content;
            position: sticky;
            top: var(--nav-height);
            z-index: 1;
        }
        .event-header {
            width: 100%;
            height: 160px;
            color: white;
            display: flex;
            padding: 2rem 5rem 2rem 5rem;
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .event-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(90deg, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0));
        }
        .event-header>* {
            position: relative;
            z-index: 0;
        }


        #event-section{
            width: 100%;
            display: flex;
            justify-content: center;
            margin-bottom: 4rem;
        }
        #event-section-cols{
            width: 80vw;
        }

        #event-content-right{
            margin-top: -3vw;
        }
        #event-sidebar{

        }

        .sidebar {
            position: sticky;
            top: calc(var(--nav-height) + 160px);
            z-index: 1;

            background: white;
            padding: 2rem 1rem 1rem 1rem;
            height: calc(100vh - (var(--nav-height) + 160px));
            display: flex;
            flex-direction: column;
            gap: 10px;
            justify-content: flex-start;
        }
        .menu-link {
            display: block;
            padding: 10px;
            text-decoration: none;
            color: #444;
            transition: 0.2s;
        }
        .menu-link:hover {
            text-decoration: underline;
        }


        .section {
            padding: 20px 20px 0px 20px;
            scroll-margin-top: calc(var(--nav-height) + 160px);
            position: relative;
            z-index: 3;
        }
        .section-inside{
            border: solid 1px var(--color-chocolate);
            border-bottom: none;
            padding: 30px;
        }


        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>

    <!-- Header -->
    @include('partials.header')


    <!-- SECTION HEADER -->
    <div id="event-header-sticky">
        <div class="event-header d-flex justify-content-start align-items-end"
        style="background-image: url('{{ asset('images/tipo-' . $evento->id_tipo . '.jpg') }}');">

            <div id="evento-title-div" class="color-white">
                <a href="{{ route('dashboard') }}" class="a-white" style="font-weight: 300">< Todos mis eventos</a>
                <h2>{{ $evento->nombre_evento }}</h2>
            </div>
        </div>
    </div>
    

    <div id="event-section">
        <div id="event-section-cols" class="row">

            <!-- SIDEBAR -->
            <div id="event-sidebar" class="col-md-3">
                <div class="sidebar">
                    <a href="#general" class="menu-link">GENERAL</a>
                    <a href="#catering" class="menu-link">CATERING</a>
                    <a href=#servicios class="menu-link">SERVICIOS</a>
                    <a href="#localizacion" class="menu-link">LOCALIZACIÓN</a>
                    <a href="#invitados" class="menu-link">INVITADOS</a>
                    <a href="#sitting" class="menu-link">SITTING</a>
                    <a href="{{ route('eventos.summary', $evento->id_evento) }}" class="btn-eventea">RESUMEN ></a>
                </div>
            </div>



            <!--  CONTENIDO -->
            <div id="event-content-right" class="col-md-9">


                
                <!-- GENERAL -->
                <div id="general" class="section bg-claro">
                <div class="section-inside">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    <h5>{{ $evento->tipo->nombre_tipo ?? '' }}</h5>
                    <h6>{{ \Carbon\Carbon::parse($evento->fecha)->isoFormat('D [de] MMMM [de] YYYY') }}</h6>
                    @php
                        $fechaEvento = \Carbon\Carbon::parse($evento->fecha)->startOfDay();
                        $hoy = \Carbon\Carbon::now()->startOfDay();
                        $dias = $hoy->diffInDays($fechaEvento);
                    @endphp
                    <p class="detalles">
                        @if($dias == 0)
                            ¡Hoy es el evento!
                        @elseif($dias == 1)
                            Queda 1 día
                        @else
                            Quedan {{ $dias }} días
                        @endif
                    </p>
                    <h6 class="pb-3">{{ $evento->local->nombre ?? ''}}</h6>
                    <p><strong>Estado:</strong> {{ $evento->estado }}</p>
                

                    <!-- Presupuesto -->
                    <div class="row mt-3">

                        <div class="col-md-4">
                            <div class="border-eventea p-2 text-center">
                                <strong>💰 Presupuesto</strong>
                                <h5>{{ $evento->presupuesto }} €</h5>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border-eventea p-2 text-center">
                                <strong>💸 Gastado</strong>
                                <h5>{{ $costeTotal }} €</h5>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="border-eventea p-2 text-center">
                                <strong>🟢 Restante</strong>
                                <h5 class="{{ $presupuestoRestante < 0 ? 'text-danger' : 'text-success' }}">
                                    {{ $presupuestoRestante }} €
                                </h5>
                            </div>
                        </div>

                    </div>
                </div>
                </div>


                <!-- CATERING -->
                <div id="catering" class="section bg-medio">
                <div class="section-inside">
                    <h4>🍽 Catering</h4>

                    @if ($evento->menus->count() > 0)

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Menú</th>
                                    <th>Descripción</th>
                                    <th>Tipo</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>

                                    @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                                        <th>Acciones</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($evento->menus as $menu)
                                    <tr>
                                        <td>{{ $menu->nombre }}</td>
                                        <td>{{ $menu->descripcion }}</td>
                                        <td>{{ $menu->tipo_menu }}</td>
                                        <td>{{ $menu->precio_unitario }} €</td>

                                        <td>
                                            @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                                                <form method="POST"
                                                    action="{{ route('eventos.menu.update', [$evento->id_evento, $menu->id_menu]) }}">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="number" name="cantidad"
                                                        value="{{ $menu->pivot->cantidad }}" min="1"
                                                        class="form-control form-control-sm" style="width: 80px;">
                                                @else
                                                    {{ $menu->pivot->cantidad }}
                                            @endif
                                        </td>

                                        @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                                            <td class="d-flex gap-2">

                                                <button class="btn btn-sm btn-primary" type="submit">
                                                    Guardar
                                                </button>
                                                </form>

                                                <form method="POST"
                                                    action="{{ route('eventos.menu.delete', [$evento->id_evento, $menu->id_menu]) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-sm btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>

                                            </td>
                                        @endif

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No hay menú contratado para este evento</p>
                    @endif

                    {{-- BOTÓN AÑADIR MENÚ --}}
                    @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                        <button class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#addMenuModal">
                            ➕ Añadir menú
                        </button>
                    @endif
                </div>
                </div>

                <!-- MODAL AÑADIR MENÚ -->
                <div class="modal fade" id="addMenuModal" tabindex="-1">
                <div class="section-inside">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form method="POST" action="{{ route('eventos.menu.attach', $evento->id_evento) }}">
                                @csrf

                                <div class="modal-header">
                                    <h5 class="modal-title">Añadir menú al evento</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label>Menú</label>
                                        <select name="menu_id" class="form-select" required>
                                            <option value="">Seleccione menú</option>

                                            @foreach ($menus as $menu)
                                                <option value="{{ $menu->id_menu }}">
                                                    {{ $menu->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Cantidad</label>
                                        <input type="number" name="cantidad" min="1" class="form-control"
                                            required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button class="btn btn-primary">Añadir</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>
                </div>



                <!-- SERVICIOS -->
                <div id="servicios" class="section bg-claro">
                <div class="section-inside">
                    <h4>🛎 Servicios</h4>

                    @if ($evento->servicios->count())

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Servicio</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Total</th>

                                    @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                                        <th>Acciones</th>
                                    @endif
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($evento->servicios as $servicio)
                                    <tr>
                                        <td>{{ $servicio->nombre }}</td>
                                        <td>{{ $servicio->precio_unitario }} €</td>

                                        <td>
                                            @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                                                <form method="POST"
                                                    action="{{ route('eventos.servicio.update', [$evento->id_evento, $servicio->id_servicio]) }}">
                                                    @csrf
                                                    @method('PUT')

                                                    <input type="number" name="cantidad"
                                                        value="{{ $servicio->pivot->cantidad }}" min="1"
                                                        class="form-control form-control-sm" style="width:80px;">
                                                @else
                                                    {{ $servicio->pivot->cantidad }}
                                            @endif
                                        </td>

                                        <td>{{ $servicio->pivot->precio_total }} €</td>

                                        @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                                            <td class="d-flex gap-2">
                                                <button class="btn btn-primary btn-sm">Guardar</button>
                                                </form>

                                                <form method="POST"
                                                    action="{{ route('eventos.servicio.delete', [$evento->id_evento, $servicio->id_servicio]) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button class="btn btn-danger btn-sm">Eliminar</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No hay servicios contratados</p>
                    @endif

                    @if (in_array(Auth::user()->rol, ['admin', 'empleado']))
                        <button class="btn btn-success mt-3" data-bs-toggle="modal"
                            data-bs-target="#addServicioModal">
                            ➕ Añadir servicio
                        </button>
                    @endif
                </div>
                </div>


                <!-- MODAL AÑADIR SERVICIO -->
                <div class="modal fade" id="addServicioModal" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">

                            <form method="POST" action="{{ route('eventos.servicio.attach', $evento->id_evento) }}">
                                @csrf

                                <div class="modal-header">
                                    <h5 class="modal-title">Añadir servicio</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">

                                    <div class="mb-3">
                                        <label>Servicio</label>
                                        <select name="servicio_id" class="form-select" required>
                                            <option value="">Seleccione servicio</option>

                                            @foreach ($servicios as $servicio)
                                                <option value="{{ $servicio->id_servicio }}">
                                                    {{ $servicio->nombre }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label>Cantidad</label>
                                        <input type="number" name="cantidad" min="1" class="form-control"
                                            required>
                                    </div>

                                </div>

                                <div class="modal-footer">
                                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                    <button class="btn btn-primary">Añadir</button>
                                </div>

                            </form>

                        </div>
                    </div>
                </div>


                <!-- LOCALIZACION -->
                <div id="localizacion" class="section bg-medio">
                <div class="section-inside">
                    <h4>📍 Localización</h4>

                    @if ($evento->local)
                        <p><strong>Nombre:</strong> {{ $evento->local->nombre }}</p>

                        <p><strong>Dirección:</strong> {{ $evento->local->direccion }}</p>

                        <p><strong>Capacidad:</strong> {{ $evento->local->capacidad }} personas</p>

                        <p><strong>Teléfono:</strong> {{ $evento->local->telefono }}</p>

                        <p><strong>Descripción:</strong></p>
                        <p>{{ $evento->local->descripcion }}</p>
                    @else
                        <p class="text-muted">No hay local asignado a este evento</p>
                    @endif
                </div>
                </div>

                <!-- INVITADOS -->
                <div id="invitados" class="section bg-claro">
                <div class="section-inside">
                    <h4>👥 Invitados</h4>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="card p-2">
                                <strong>Total</strong>
                                <h3>{{ $stats['total'] }}</h3>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card p-2">
                                <strong>Confirmados</strong>
                                <h3>{{ $stats['confirmados'] }}</h3>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card p-2">
                                <strong>Pendientes</strong>
                                <h3>{{ $stats['pendientes'] }}</h3>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="card p-2">
                                <strong>Rechazados</strong>
                                <h3>{{ $stats['rechazados'] }}</h3>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('invitados.lista', $evento->id_evento) }}" class="btn btn-dark mt-3">
                        Ver lista de invitados
                    </a>
                </div>
                </div>


                <!-- SITTING -->
                <div id="sitting" class="section bg-medio">
                <div class="section-inside">
                    <h4>🪑 Seating Plan</h4>

                    @include('eventos.seating')
                </div>
                </div>


                <!-- RESUMEN -->
                <div id="resumen" class="section bg-claro">
                <div class="section-inside">
                    <h4>📊 Resumen</h4>
                    <p>Estado general del evento, presupuesto, etc...</p>


                    <a href="{{ route('eventos.summary', $evento->id_evento) }}" class="btn btn-light w-100">
                        Ir a resumen completo
                    </a>
                </div>
                </div>

            </div>

        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- Footer -->
    @include('partials.footer')


</body>

</html>
