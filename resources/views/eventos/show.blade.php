<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ $evento->nombre_evento }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f5f5;
        }

        .sidebar {
            position: sticky;
            top: 20px;
            background: white;
            padding: 20px;
            border-radius: 10px;
            height: fit-content;
        }

        .menu-link {
            display: block;
            padding: 10px;
            margin-bottom: 8px;
            text-decoration: none;
            color: #444;
            border-radius: 6px;
            transition: 0.2s;
        }

        .menu-link:hover {
            background: #eee;
        }

        .section {
            background: white;
            padding: 30px;
            margin-bottom: 20px;
            border-radius: 10px;
            scroll-margin-top: 20px;
        }

        .hero {
            background: url('https://images.unsplash.com/photo-1505236858219-8359eb29e329') center/cover;
            height: 180px;
            border-radius: 10px;
            color: white;
            display: flex;
            align-items: center;
            padding: 30px;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</head>

<body>

    <div class="container mt-4">

        <div class="row">

            <!--  SIDEBAR -->
            <div class="col-md-3">
                <div class="sidebar">

                    <h5 class="mb-3">📋 Menú</h5>

                    <a href="#general" class="menu-link">🏠 General</a>
                    <a href="#catering" class="menu-link">🍽 Catering</a>
                    <a href="#localizacion" class="menu-link">📍 Localización</a>
                    <a href="#invitados" class="menu-link">👥 Invitados</a>
                    <a href="#sitting" class="menu-link">🪑 Sitting</a>
                    <a href="#resumen" class="menu-link">📊 Resumen</a>

                </div>
            </div>

            <!--  CONTENIDO -->
            <div class="col-md-9">

                <!-- HERO -->
                <div class="hero">
                    {{ $evento->nombre_evento }}
                </div>

                <!-- GENERAL -->
                <div id="general" class="section">
                    <h4>🎉 General</h4>

                    <p><strong>Evento:</strong> {{ $evento->nombre_evento }}</p>
                    <p><strong>Fecha:</strong> {{ $evento->fecha }}</p>
                    <p><strong>Estado:</strong> {{ $evento->estado }}</p>
                </div>

                <!-- CATERING -->
                <div id="catering" class="section">
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
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($evento->menus as $menu)
                                    <tr>
                                        <td>{{ $menu->nombre }}</td>
                                        <td>{{ $menu->descripcion }}</td>
                                        <td>{{ $menu->tipo_menu }}</td>
                                        <td>{{ $menu->precio_unitario }} €</td>
                                        <td>{{ $menu->pivot->cantidad }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <p class="text-muted">No hay menú contratado para este evento</p>
                    @endif

                </div>

                <!-- LOCALIZACION -->
                <div id="localizacion" class="section">
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

                <!-- INVITADOS -->
                <div id="invitados" class="section">
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

                <!-- SITTING -->
                <div id="sitting" class="section">
                    <h4>🪑 Seating Plan</h4>

                    @include('eventos.seating')
                </div>

                <!-- RESUMEN -->
                <div id="resumen" class="section">
                    <h4>📊 Resumen</h4>
                    <p>Estado general del evento, presupuesto, etc...</p>
                    

                    <a href="{{ route('eventos.summary', $evento->id_evento) }}" class="btn btn-light w-100">
                        Ir a resumen completo
                    </a>
                </div>

            </div>

        </div>

    </div>

</body>

</html>
