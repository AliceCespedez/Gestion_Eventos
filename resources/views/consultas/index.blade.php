<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Consultas</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="p-4">

<h2>Listado de Consultas</h2>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Asunto</th>
            <th>Mensaje</th>
            <th>Tipo</th>
            <th>Prioridad</th>
            <th>Leído</th>
        </tr>
    </thead>

    <tbody>
        @foreach($consultas as $consulta)
            <tr>
                <td>{{ $consulta->asunto }}</td>
                <td>{{ $consulta->mensaje }}</td>
                <td>{{ $consulta->tipo_consulta }}</td>
                <td>{{ $consulta->prioridad }}</td>
                <td>
                    {{ $consulta->leido ? 'Sí' : 'No' }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

</body>
</html>