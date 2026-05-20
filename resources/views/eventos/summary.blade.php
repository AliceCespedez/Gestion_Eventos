<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resumen Evento</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">


    <style>

        .section {
            padding: 25px;
            margin-bottom: 20px;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 1rem 0;
            border: none;
        }
        .info-table td:first-child {
            width: 20vw;
            vertical-align: top;
        }
        .info-table td:last-child {
            padding-left: 15px;
        }

        #summary-menu-table td{
            background-color: transparent;
            color: var(--color-chocolate);
            text-align: center;
        }
        #summary-menu-table td:first-child{
            background-color: var(--color-chocolate);
            color:white !important;
            text-transform: uppercase;
            text-align: start;
            padding-left: 1rem;
        }

        .kpi {
            padding: 20px;
            border: 1px solid var(--color-chocolate);
            /*
            outline: 1px solid var(--color-chocolate);
            outline-offset: 5px;
            */
            background: var(--color-beige-claro);
            text-align: center;
        }

        .kpi-title {
            font-size: 14px;
            color: var(--color-chocolate);
        }

        /*
        .kpi-total {
            border-left: 6px solid #A8D8FF;
        }

        .kpi-ok {
            border-left: 6px solid #B8F2D3;
        }

        .kpi-pend {
            border-left: 6px solid #FFE5A8;
        }

        .kpi-no {
            border-left: 6px solid #FFB6C1;
        }

        .kpi-money {
            border-left: 6px solid #CDB4FF;
        }
        */
    </style>
</head>



<body class="bg-white normal-body">

    @include('partials.header')


    <div id="invitados-body" class="section-1">
            
        <div class="normal-header">
                <h2 class="color-choco">Resumen y presupuesto</h2>
                <h5 class="color-choco">{{ $evento->nombre_evento }}</h5>
        </div>


        <div class="container mt-4">
            <a href="{{ url()->previous() }}">🡠 Volver al evento</a>
        </div>


        <div class="container mt-4 bg-claro p-4">
            <div class="border-eventea p-4">

                <!-- HEADER -->
                <div class="section text-center">
                    <h2>{{ $evento->nombre_evento }}</h2>
                    <p>{{ \Carbon\Carbon::parse($evento->fecha)->isoFormat('D [de] MMMM [de] YYYY') }}</p>
                </div>

                <hr>

                <table class="info-table">
                    <tr>
                        <td><h5>Tipo de evento</h5></td>
                        <td><p>{{ $evento->tipo->nombre_tipo ?? '-' }}</p></td>
                    </tr>
                    <tr>
                        <td><h5>Fecha</h5></td>
                        <td><p>{{ \Carbon\Carbon::parse($evento->fecha)->isoFormat('D [de] MMMM [de] YYYY') }}</p></td>
                    </tr>
                    <tr>
                        <td><h5>Ubicación</h5></td>
                        <td>{{ $evento->local->nombre ?? '-' }}</td>
                    </tr>
                </table>

                <hr><br>

                
                <!-- TABLA MENÚS -->
                <div>
                    <h5>Catering</h5>
                    <br>

                    @if ($evento->menus->count() > 0)
                        @foreach ($evento->menus as $menu)

                            <table id="summary-menu-table" class="table table-choco mb-2">
                                <tbody>
                                    <tr>
                                        <td class="color-white">{{ $menu->nombre }}</td>
                                        <td>{{ $menu->precio_unitario }} €/unidad</td>
                                        <td>{{ $menu->pivot->cantidad }} unidades</td>
                                        <td><b>{{ $menu->precio_unitario * $menu->pivot->cantidad }} €</b></td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- CONTENIDO DEL MENÚ --}}
                            @if(isset($menu->secciones_menu) && count($menu->secciones_menu) > 0)
                                @foreach($menu->secciones_menu as $seccion)
                                    <div class="mb-2" style="margin-left: 1rem;">
                                        <h6>{{ $seccion['titulo'] }}</h6>
                                        <ul class="mb-2" style="margin-left: 1rem;">
                                            @foreach($seccion['items'] as $item)
                                                <li>{{ $item }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endforeach
                            @else
                                {{-- si no funciona el método de leer menus, leer en texto plano--}}
                                <div style="white-space: pre-line; margin-left: 1rem; margin-bottom: 1rem;">
                                    {{ $menu->descripcion }}
                                </div>
                            @endif

                            {{-- Separador entre menús --}}
                            @if(!$loop->last)
                                <hr class="my-3" style="border-color: var(--color-beige-medio);">
                            @endif
                        @endforeach
                    @else
                        <p class="text-muted"><i>No hay menús contratados</i></p>
                    @endif

                    {{--
                    @if ($evento->menus->count() > 0)
                        <table id="summary-menu-table" class="table table-choco">
                            <tbody>
                                @foreach ($evento->menus as $menu)
                                    <tr>
                                        <td>{{ $menu->nombre }}</td>
                                        <td>{{ $menu->precio_unitario }} €/unidad</td>
                                        <td>{{ $menu->pivot->cantidad }} unidades</td>
                                        <td><b>{{ $menu->precio_unitario * $menu->pivot->cantidad }} € </b></td>
                                    </tr>
                            </tbody>
                        </table>

                        
                        @if(isset($menu->secciones_menu) && count($menu->secciones_menu) > 0)
                            @foreach($menu->secciones_menu as $seccion)
                                <div class="mb-3">
                                    <h6>{{ $seccion['titulo'] }}</h6>
                                    <ul class="mb-2" style="margin-left: 1rem;">
                                        @foreach($seccion['items'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        @else
                            <div style="white-space: pre-line;">{{ $menu->descripcion }}</div>
                        @endif

                    @else
                        <p class="text-muted">No hay menús</p>
                    @endif
                    --}}

                    {{--
                    @if ($evento->menus->count() > 0)
                        <table class="table table-choco">
                            <thead>
                                <tr>
                                    <th>Menú</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($evento->menus as $menu)
                                    <tr>
                                        <td>{{ $menu->nombre }}</td>
                                        <td>{{ $menu->precio_unitario }} €/unidad</td>
                                        <td>{{ $menu->pivot->cantidad }} unidades</td>
                                        <td>{{ $menu->precio_unitario * $menu->pivot->cantidad }} €</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No hay menús</p>
                    @endif
                    --}}

                </div>

                <!-- KPI INVITADOS -->
                <div class="row g-3 mb-4">

                    <div class="col-md-3">
                        <div class="kpi kpi-total">
                            <div class="kpi-title">Total invitados</div>
                            <h2>{{ $stats['total'] }}</h2>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="kpi kpi-ok">
                            <div class="kpi-title">Confirmados</div>
                            <h2>{{ $stats['confirmados'] }}</h2>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="kpi kpi-pend">
                            <div class="kpi-title">Pendientes</div>
                            <h2>{{ $stats['pendientes'] }}</h2>
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="kpi kpi-no">
                            <div class="kpi-title">Rechazados</div>
                            <h2>{{ $stats['rechazados'] }}</h2>
                        </div>
                    </div>

                </div>

                <!-- KPI PRESUPUESTO -->
                <div class="row g-3 mb-4">

                    <div class="col-md-4">
                        <div class="kpi kpi-money">
                            <div class="kpi-title">Presupuesto</div>
                            <h2>{{ $presupuesto ?? 0 }} €</h2>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="kpi kpi-no">
                            <div class="kpi-title">Gastado</div>
                            <h2>{{ $gastado ?? 0 }} €</h2>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="kpi kpi-ok">
                            <div class="kpi-title">Restante</div>
                            <h2>{{ $restante ?? 0 }} €</h2>
                        </div>
                    </div>

                </div>

                <!-- DONUT PRESUPUESTO -->
                <div class="section text-center">
                    <h5>Tu presupuesto</h5>

                    <div style="max-width: 300px; margin: auto;">
                        <canvas id="chartPresupuesto"></canvas>
                    </div>
                </div>

                <!-- GRÁFICOS -->
                <div class="row g-3 mb-4">

                    <div class="col-md-6">
                        <div class="section">
                            <h5>👥 Invitados</h5>
                            <canvas id="chartInvitados"></canvas>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="section">
                            <h5>🍽 Menús contratados</h5>
                            <canvas id="chartMenus"></canvas>
                        </div>
                    </div>

                </div>

                <!--  GRÁFICO SERVICIOS -->
                <div class="section text-center">
                    <h5>🛠 Servicios contratados</h5>

                    <div style="max-width: 500px; height: 300px; margin:auto;">
                        <canvas id="chartServicios"></canvas>
                    </div>
                </div>

                

                <!-- TABLA SERVICIOS -->
                <div class="section">
                    <h5>🛠 Servicios contratados</h5>

                    @if ($evento->servicios->count() > 0)
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Servicio</th>
                                    <th>Precio</th>
                                    <th>Cantidad</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($evento->servicios as $servicio)
                                    <tr>
                                        <td>{{ $servicio->nombre }}</td>
                                        <td>{{ $servicio->precio_unitario }} €</td>
                                        <td>{{ $servicio->pivot->cantidad }}</td>
                                        <td>{{ $servicio->precio_unitario * $servicio->pivot->cantidad }} €</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No hay servicios</p>
                    @endif
                </div>
            </div>
    </div>

    @include ('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('chartInvitados'), {
            type: 'doughnut',
            data: {
                labels: @json($labelsInvitados),
                datasets: [{
                    data: @json($dataInvitados),
                    backgroundColor: ['#A8D8FF', '#FFE5A8', '#FFB6C1']
                }]
            }
        });

        new Chart(document.getElementById('chartMenus'), {
            type: 'bar',
            data: {
                labels: @json($labelsMenus),
                datasets: [{
                    label: 'Cantidad',
                    data: @json($dataMenus),
                    backgroundColor: '#A8D8FF'
                }]
            }
        });

        new Chart(document.getElementById('chartPresupuesto'), {
            type: 'doughnut',
            data: {
                labels: ['Gastado', 'Restante'],
                datasets: [{
                    data: [{{ $gastado ?? 0 }}, {{ $restante ?? 0 }}],
                    backgroundColor: ['#FFB6C1', '#A8D8FF']
                }]
            }
        });

        // SERVICIOS
        new Chart(document.getElementById('chartServicios'), {
            type: 'bar',
            data: {
                labels: @json($labelsServicios ?? []),
                datasets: [{
                    label: 'Cantidad',
                    data: @json($dataServicios ?? []),
                    backgroundColor: '#CDB4FF'
                }]
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
