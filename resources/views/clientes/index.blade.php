<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

<div class="container mt-5">

    <h2>📋 Lista de Clientes</h2>

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

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- FORMULARIO PARA CREAR CLIENTE --}}
    <div class="card bg-secondary text-white shadow mb-4">
        <div class="card-body">
            <h5 class="card-title">➕ Crear Nuevo Cliente</h5>
            <form action="{{ route('users.store') }}" method="POST">
                @csrf
                <input type="hidden" name="rol" value="cliente">
                <div class="mb-3">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}" required>
                </div>
                <div class="mb-3">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ old('email') }}" required>
                </div>
                <div class="mb-3">
                    <label>Contraseña</label>
                    <input type="password" name="password" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-light">Crear Cliente</button>
            </form>
        </div>
    </div>

    <table class="table table-dark table-striped mt-3">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
            </tr>
        </thead>

        <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id_usuario }}</td>
                    <td>{{ $cliente->nombre }}</td>
                    <td>{{ $cliente->email }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>

</body>
</html>