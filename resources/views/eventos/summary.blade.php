<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Resumen Evento</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #f7f9fc;
            font-family: 'Inter', sans-serif;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 16px;
            margin-bottom: 20px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        .kpi {
            border-radius: 16px;
            padding: 20px;
            background: #fff;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            text-align: center;
        }

        .kpi h2 {
            font-weight: 600;
        }

        .kpi-title {
            font-size: 14px;
            color: #888;
        }

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

        h2,
        h4,
        h5 {
            font-weight: 600;
        }
    </style>
</head>

<body>

    <div class="container mt-4">

        <!-- HEADER -->
        <div class="section text-center">
            <h2 style="color:#2d3436;">{{ $evento->nombre_evento }}</h2>
            <p style="color:#636e72;">{{ $evento->fecha }}</p>
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
            <h5>💰 Presupuesto del evento</h5>

            <div style="max-width: 300px; margin: auto;">
                <canvas id="chartPresupuesto"></canvas>
            </div>
        </div>
        <!-- GRÁFICOS -->
        <div class="row g-3 mb-4">

            <div class="col-md-6">
                <div class="section">
                    <h5>👥 Estado de invitados</h5>
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

        <!-- TABLA MENÚS -->
        <div class="section">
            <h5>🍽 Catering</h5>

            @if ($evento->menus->count() > 0)
                <table class="table table-hover">
                    <thead class="table-light">
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
                                <td>{{ $menu->precio_unitario }} €</td>
                                <td>{{ $menu->pivot->cantidad }}</td>
                                <td>{{ $menu->precio_unitario * $menu->pivot->cantidad }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">No hay menús</p>
            @endif
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

</body>

</html>
