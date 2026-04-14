<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-dark text-white">

    <div class="container mt-5">
        <div class="card bg-secondary text-white shadow">
            <div class="card-body text-center">

                <h1>👑 Panel Admin</h1>

                <p>Bienvenido:</p>

                <h3>
                    {{ auth()->user()->nombre ?? 'Admin' }}
                </h3>

                <p>
                    Rol: <strong>
                        {{ auth()->user()->rol ?? 'Sin rol' }}
                    </strong>
                </p>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-light mt-3">
                        Cerrar sesión
                    </button>
                </form>

            </div>
        </div>
    </div>

</body>

</html>
