<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar usuario</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body class="bg-white normal-body">

    @include('partials.header')

    <div class="container mt-5">

        <h2 class="color-choco mb-4">
            Editar {{ $usuario->rol }}
        </h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('users.update', $usuario->id_usuario) }}" method="POST">

            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nombre</label>

                <input type="text" name="nombre" class="form-control" value="{{ $usuario->nombre }}">
            </div>

            <div class="mb-3">
                <label>Email</label>

                <input type="email" name="email" class="form-control" value="{{ $usuario->email }}">
            </div>

            <div class="mb-3">
                <label>Nueva contraseña (opcional)</label>

                <input type="password" name="password" class="form-control">
            </div>

            <button class="btn btn-success">
                Guardar cambios
            </button>

        </form>

    </div>
    @include('partials.footer')

</body>

</html>
