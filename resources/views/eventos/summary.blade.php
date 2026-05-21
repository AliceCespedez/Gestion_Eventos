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
            width: 25vw;
            vertical-align: top;
        }
        .info-table td:last-child {
            padding-left: 15px;
        }

        .summary-menu-table td{
            background-color: transparent;
            color: var(--color-chocolate);
            text-align: center;
        }
        .summary-menu-table td:first-child{
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

                            <table class="summary-menu-table table table-choco mb-2">
                                <tbody>
                                    <tr>
                                        <td class="color-white">{{ $menu->nombre }}</td>
                                        <td>{{ $menu->precio_unitario }} €/unidad</td>
                                        <td>x{{ $menu->pivot->cantidad }}</td>
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

                </div>
                <br><hr><br>


                <h5>INVITADOS</h5>
                <div class="row g-3 mb-4">
                    
                    <!-- INFO -->
                    <div style="width: 45%" class="d-flex align-items-center">
                        <table class="info-table">
                            <tr>
                                <td>TOTAL</td>
                                <td><p>{{ $stats['total'] }}</p></td>
                            </tr>
                            <tr>
                                <td>CONFIRMADOS</td>
                                <td><p>{{ $stats['confirmados'] }}</p></td>
                            </tr>
                            <tr>
                                <td>PENDIENTES</td>
                                <td>{{ $stats['pendientes'] }}</td>
                            </tr>
                            <tr>
                                <td>RECHAZADOS</td>
                                <td>{{ $stats['rechazados'] }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="col-md-6">
                        <div class="section">
                                <canvas id="chartInvitados"></canvas>
                            </div>
                    </div>

                </div>


                <br><hr><br>
                

                <h5>SERVICIOS</h5>
                <div class="section">

                    @if ($evento->servicios->count() > 0)
                        <table class="table table-choco mb-2 summary-menu-table">
                            <tbody>
                                @foreach ($evento->servicios as $servicio)
                                    <tr>
                                        <td>{{ $servicio->nombre }}</td>
                                        <td>{{ $servicio->precio_unitario }} € /unidad</td>
                                        <td>x{{ $servicio->pivot->cantidad }}</td>
                                        <td><b>{{ $servicio->precio_unitario * $servicio->pivot->cantidad }} €</b></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No hay servicios</p>
                    @endif
                </div>

                <div class="section text-center">
                    <h5>Servicios contratados</h5>

                    <div style="max-width: 500px; height: 300px; margin:auto;">
                        <canvas id="chartServicios"></canvas>
                    </div>
                </div>

                <hr><br>

                

                <h5>PRESUPUESTO</h5>
                <div class="row g-3 mb-4">

                    <!-- INFO -->
                    <div style="width: 45%" class="d-flex align-items-center">
                        <table class="info-table col-md-6">
                            <tr>
                                <td>INICIAL</td>
                                <td><p>{{ $presupuesto ?? 0 }} €</p></td>
                            </tr>
                            <tr>
                                <td>GASTADO</td>
                                <td><p><b>{{ $gastado ?? 0 }} €</b></p></td>
                            </tr>
                            <tr>
                                <td>RESTANTE</td>
                                <td>{{ $restante ?? 0 }} €</td>
                            </tr>
                        </table>
                    </div>
                
                    <!-- DONUT PRESUPUESTO -->
                    <div class="col-md-6">
                        <div style="max-width: 300px; margin: auto;">
                            <canvas id="chartPresupuesto"></canvas>
                        </div>
                    </div>

                </div>

                <br><hr><br>

                <div class="d-flex flex-row gap-4 justify-content-center pt-4 pb-3 bg-choco">
                    <h5 class="color-white">TOTAL:</h5>
                    <p class="color-white">{{ $gastado ?? 0 }} €</p>
                </div>

                <div class="py-4">
                    <p><b>Condiciones y forma de pago</b></p>
                    <p>
                        El presente resumen forma parte del compromiso entre el cliente y EvenTea. Para formalizar el encargo, se requiere el pago de una reserva del 30% del importe total. El resto se abonará 7 días antes del evento.

                        Forma de pago: transferencia bancaria a la cuenta:
                        ESXX XXXX XXXX XXXX XXXX (IBAN)
                        En concepto: "Nombre del evento + fecha"
                    </p>
                    <br>
                    <p><b>El servicio incluye:</b></p>
                    <p>
                        · Menaje completo: vajilla, cubertería, copas y servilletas.
                        <br>
                        · Mobiliario básico: mesas y sillas según número de asistentes y tipo de evento.
                        <br>
                        · Decoración básica para mesa adaptada al tipo de evento (más información en nuestra web <a href="#"><i>eventea.com</i></a>)
                        <br>
                        · Transporte del equipo necesario para servir en caliente.
                        <br>
                        · Servicio de camareros (1 por cada 20 comensales, incluido dentro del precio)
                        <br>
                        · Limpieza del espacio durante y al finalizar el evento (recogida de menaje, residuos y mobiliario básico)
                    </p>
                    <br>
                    <p><b>No incluye:</b></p>
                    <p>
                        · Decoración adicional, centros de mesa especiales o personalizaciones fuera del pack básico
                        <br>
                        · Equipos de sonido o iluminación (salvo que se especifique en servicios contratados).
                        <br>
                        · Servicios no contratados expresamente en este resumen.
                    </p>
                    <br>
                    <p><b>Importante:</b></p>
                    <p>
                        El cliente se compromete a proveer de suministro eléctrico suficiente y accesible para la correcta ejecución del evento (cocina caliente, iluminación extra, equipos de sonido, pirotecnia, hinchables...). EvenTea no se hace responsable de la falta de electricidad ni de los cortes de suministro ajenos a la organización.
                    </p>
                    <br>
                    <p>
                        Para cualquier duda o comentario contacta con nuestro equipo desde el <a href=""><i>formulario de contacto</i></a> a través de <i>eventea.com</i>. Estaremos encantados de ayudarte.
                    </p>
                </div>

                
                {{--
                <!-- KPI INVITADOS -->
                <div class="row g-3 mb-4">

                    <div class="col-md-3">
                        <div class="kpi kpi-total">
                            <div class="kpi-title">Total de invitados</div>
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
                --}}

                {{--
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
                --}}

                

                {{--
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
                --}}

                {{--
                <!--  GRÁFICO SERVICIOS -->
                <div class="section text-center">
                    <h5>🛠 Servicios contratados</h5>

                    <div style="max-width: 500px; height: 300px; margin:auto;">
                        <canvas id="chartServicios"></canvas>
                    </div>
                </div>
                --}}               

                

            </div>
    </div>

    @include ('partials.footer')

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

        // INVITADOS
        new Chart(document.getElementById('chartInvitados'), {
            type: 'doughnut',
            data: {
                labels: @json($labelsInvitados),
                datasets: [{
                    data: @json($dataInvitados),
                    backgroundColor: ['#574E49', '#D8D5CF', '#FFB6C1']
                }]
            }
        });

        // MENUS
        new Chart(document.getElementById('chartMenus'), {
            type: 'bar',
            data: {
                labels: @json($labelsMenus),
                datasets: [{
                    label: 'Cantidad',
                    data: @json($dataMenus),
                    backgroundColor: '#574E49'
                }]
            }
        });

        // PRESUPUESTO
        new Chart(document.getElementById('chartPresupuesto'), {
            type: 'doughnut',
            data: {
                labels: ['Gastado', 'Restante'],
                datasets: [{
                    data: [{{ $gastado ?? 0 }}, {{ $restante ?? 0 }}],
                    backgroundColor: ['#D8D5CF', '#574E49']
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
                    backgroundColor: '#574E49'
                }]
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>
