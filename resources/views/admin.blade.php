<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Administrador</title>


    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        .form-control {
            border-radius: 0;
        }

        .admin-div-1 {
            display: flex;
            flex-direction: row;
            gap: 3rem;
            width: 100%;
            padding: 4rem;
            height: fit-content;
        }

        .admin-carta {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            min-width: 30%;
        }

        .admin-carta:first-child {
            heigth: 100%;
        }

        .admin-carta:last-child {
            height: fit-content;
        }

        .admin-carta-img {
            min-height: 20vh;
            height: 100%;
            width: 100%;
        }

        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            padding-right: 45px;
        }

        .toggle-password {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            border: none;
            background: transparent;
            cursor: pointer;
            color: #6b5d55;
            font-size: 1.1rem;
        }

        .toggle-password:focus {
            outline: none;
        }
    </style>
</head>

<body class="bg-white normal-body">

    @include('partials.header')

    @php
        $user = auth()->user();
        $rol = strtolower($user->rol ?? '');
        $notificaciones = $user->unreadNotifications ?? collect();
    @endphp

    <div class="section-1">

        <div class="normal-header d-flex flex-row justify-content-between align-items-center">
            <h2 class="color-choco">Panel de administrador</h2>
            <div class="d-flex flex-column align-items-end">
                <h3>{{ $user->nombre }}</h3>
                <p><b>Rol:</b> {{ $user->rol }}</p>
            </div>
        </div>



        <div class="container my-4">

            {{-- CERRAR SESIÓN --}}
            <div class="text-end mb-2">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="button-a">
                        Cerrar sesión <i class="bi bi-door-closed fs-4"></i>
                    </button>
                </form>
            </div>

            <div class="admin-div-1">

                {{-- CARTA EVENTOS --}}
                <div class="admin-carta flex-fill">
                    <h4>Eventos</h4>

                    <div class="mt-2">
                        <a href="{{ route('eventos.index') }}" class="btn-eventea" title="Abrir panel de eventos">
                            Ver todos los eventos
                        </a>
                        <a href="{{ route('eventos.admin_create') }}" class="btn-claro ms-2" title="Crear nuevo evento">
                            <i class="bi bi-plus-lg"></i>
                        </a>
                    </div>

                    <div style="background: url('/images/eventea-03.jpg') center/cover no-repeat;"
                        class="admin-carta-img mt-4" alt="Imagen mesa"></div>
                </div>


                {{-- CARTA USUARIOS --}}
                <div class="admin-carta flex-fill">
                    <h4>Usuarios</h4>

                    <div class="dropdown mt-2">
                        <button class="btn-eventea dropdown-toggle w-100" data-bs-toggle="dropdown">
                            <i class="bi bi-people-fill me-2"></i> Ver usuarios
                        </button>

                        <ul class="dropdown-menu text-start">
                            <li><a class="dropdown-item" href="{{ route('clientes.index') }}"><i
                                        class="bi bi-person-fill me-2"></i> Clientes</a></li>
                            <li><a class="dropdown-item" href="{{ route('empleados.index') }}"><i
                                        class="bi bi-person-vcard me-2"></i> Empleados</a></li>
                        </ul>
                    </div>

                    {{-- Formulario --}}
                    <div class="bg-claro p-4 mt-4 w-100">
                        <div class="border-eventea p-4">
                            <h5 class="mb-4"><i class="bi bi-plus fs-4"></i>Crear usuario</h5>
                            @if (session('success'))
                                <div class="alert alert-success mb-3">
                                    {{ session('success') }}
                                </div>
                            @endif
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

                            <form method="POST" action="{{ route('users.store') }}">
                                @csrf

                                <input type="text" name="nombre" class="form-control mb-2" placeholder="Nombre"
                                    required>
                                <input typegit ="email" name="email" class="form-control mb-2" placeholder="Email"
                                    required>
                                <div class="password-container">

                                    <input type="password" name="password" id="password" class="form-control"
                                        placeholder="Contraseña" required>

                                    <button type="button" class="toggle-password" onclick="togglePassword()">

                                        <i id="eyeIcon" class="bi bi-eye"></i>

                                    </button>

                                </div>


                                @if ($rol === 'admin')
                                    <select name="rol" class="form-control mb-3">
                                        <option value="cliente">Cliente</option>
                                        <option value="empleado">Empleado</option>
                                    </select>
                                @endif

                                <button class="btn-eventea w-100">
                                    Crear
                                </button>

                            </form>
                        </div>
                    </div> <!-- form -->
                </div>

            </div>

            {{-- STATS DE EVENTOS --}}
            <div class="container mt-4">
                <div class="bg-claro p-4">
                    <canvas id="eventosChart"></canvas>
                </div>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        </div>

        @include('partials.footer')
        <script>
            function togglePassword() {

                const passwordInput = document.getElementById('password');
                const eyeIcon = document.getElementById('eyeIcon');

                if (passwordInput.type === 'password') {

                    passwordInput.type = 'text';

                    eyeIcon.classList.remove('bi-eye');
                    eyeIcon.classList.add('bi-eye-slash');

                } else {

                    passwordInput.type = 'password';

                    eyeIcon.classList.remove('bi-eye-slash');
                    eyeIcon.classList.add('bi-eye');
                }
            }
        </script>
</body>

</html>
