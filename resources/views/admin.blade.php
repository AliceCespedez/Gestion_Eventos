<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

<div class="container mt-5">

    <div class="card bg-secondary text-white shadow mb-4">
        <div class="card-body text-center">

            <h1>👑 Panel Admin</h1>

            <p>Bienvenido:</p>

            <h3>{{ auth()->user()->nombre ?? 'Admin' }}</h3>

            <p>
                Rol: <strong>{{ auth()->user()->rol ?? 'Sin rol' }}</strong>
            </p>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn btn-light mt-3">
                    Cerrar sesión
                </button>
            </form>

        </div>
    </div>
    
    {{--Mensajes--}}
    @if(session('success'))
        <div class="alert alert-success text-center">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center">
            {{ session('error') }}
        </div>
    @endif

    {{-- Formulario --}}
    <div class="card bg-secondary text-white shadow p-4">

        <h4 class="mb-3">➕ Crear Usuario</h4>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre">

            <input type="email" name="email" class="form-control mb-2" placeholder="Email">

            <input type="password" name="password" class="form-control mb-2" placeholder="Contraseña">

            <select name="rol" class="form-control mb-3">
                <option value="cliente">Cliente</option>

                @if(auth()->user()->rol === 'admin')
                    <option value="empleado">Empleado</option>
                @endif
            </select>

            <button class="btn btn-light w-100">
                Crear Usuario
            </button>

        </form>

    </div>

</div>

<script>
window.addEventListener('pageshow', function(event) {
    if (event.persisted) {
        window.location.reload();
    }
});
</script>

</body>
</html>