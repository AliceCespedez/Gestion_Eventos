<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

    <div class="container mt-5">

        <h1 class="text-center mb-4">Dashboard Admin</h1>

        <div class="card bg-secondary p-4">
            <canvas id="eventosChart"></canvas>
        </div>

        <a href="{{ route('admin') }}" class="btn btn-light mt-4">
            ⬅ Volver
        </a>

    </div>

    <script>
        const data = @json($eventosPorMes);

        const meses = [
            "Enero", "Febrero", "Marzo", "Abril",
            "Mayo", "Junio", "Julio", "Agosto",
            "Septiembre", "Octubre", "Noviembre", "Diciembre"
        ];

        const labels = data.map(e => meses[e.mes - 1]); 
        const valores = data.map(e => e.total);

        const ctx = document.getElementById('eventosChart');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Eventos por mes',
                    data: valores,
                    fill: false,
                    tension: 0.3,
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0
                        }
                    }
                }
            }
        });
    </script>

</body>

</html>
