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

        .section {
            background: white;
            padding: 30px;
            margin-bottom: 20px;
            border-radius: 10px;
        }

        .sidebar {
            position: sticky;
            top: 20px;
        }

        .menu-link {
            display: block;
            margin-bottom: 10px;
            text-decoration: none;
            color: #555;
        }
    </style>
</head>

<body>

<div class="container mt-4">

    <div class="row">

        <!-- MENU -->
        <div class="col-md-3 sidebar">
            <a href="#general" class="menu-link">General</a>
            <a href="#invitados-section" class="menu-link">Invitados</a>
            <a href="#sitting" class="menu-link">Sitting</a>
        </div>

        <!-- CONTENIDO -->
        <div class="col-md-9">

            <div id="general" class="section">
                <h4>General</h4>
                <p>{{ $evento->nombre_evento }}</p>
            </div>

            <!--  ID CORREGIDO -->
            <div id="invitados-section" class="section">
                <h4>Invitados</h4>
                <p>Total: {{ $evento->invitados->count() }}</p>
            </div>

            <div id="sitting" class="section">
                <h4>Seating</h4>

                @include('eventos.seating')

            </div>

        </div>

    </div>

</div>

</body>
</html>