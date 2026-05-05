<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacto - EvenTea</title>

    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <style>
        body {
            background-color: #f2eee9;
            font-family: 'Arial', sans-serif;
        }

        .titulo-principal {
            font-size: 3rem;
            font-style: italic;
            font-weight: 500;
        }

        .subtitulo {
            font-size: 1.2rem;
            color: #555;
        }

        .contact-box {
            background: #fff;
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
        }

        .btn-even {
            background-color: #2c2c2c;
            color: #fff;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-even:hover {
            background-color: #000;
            transform: translateY(-1px);
        }

        /* BOTÓN BONITO */
        .btn-back {
            border: 1px solid #2c2c2c;
            color: #2c2c2c;
            border-radius: 30px;
            padding: 8px 18px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-back i {
            margin-right: 6px;
        }

        .btn-back:hover {
            background-color: #2c2c2c;
            color: #fff;
            transform: translateY(-2px);
        }

        .image-side img {
            width: 100%;
            border-radius: 12px;
            object-fit: cover;
        }
    </style>
</head>

<body>

    <!-- Header -->
    @include('partials.header')

    <div class="container py-5">

        <div class="row align-items-center">

            <!-- IZQUIERDA -->
            <div class="col-md-6">

                <p class="subtitulo">¿Alguna duda? ¿Un nuevo evento?</p>

                <h1 class="titulo-principal mb-4">Ponte en contacto</h1>

                <div class="contact-box">

                    <form method="POST" action="#">
                        @csrf

                        <div class="mb-3">
                            <input type="text" name="asunto" class="form-control" placeholder="Asunto">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">¿Qué necesitas?</label>
                            <textarea name="mensaje" rows="5" class="form-control" placeholder="Escribe aquí tu consulta..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tipo de consulta</label>
                            <select name="tipo_consulta" class="form-select">
                                <option value="informacion">Información general</option>
                                <option value="evento">Organización de evento</option>
                                <option value="soporte">Soporte</option>
                                <option value="otro">Otro</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Prioridad</label>
                            <select name="prioridad" class="form-select">
                                <option value="baja">Baja</option>
                                <option value="media" selected>Media</option>
                                <option value="alta">Alta</option>
                            </select>
                        </div>

                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" required>
                            <label class="form-check-label">
                                Acepto la política de privacidad
                            </label>
                        </div>

                        <button class="btn btn-even w-100">
                            Enviar mensaje
                        </button>

                    </form>

                </div>
            </div>

            <!-- DERECHA -->
            <div class="col-md-6 image-side mt-4 mt-md-0 text-end">

                <img src="https://images.unsplash.com/photo-1527529482837-4698179dc6ce?auto=format&fit=crop&w=800&q=80"
                    alt="Evento floral" class="img-fluid mb-4">

                <a href="{{ route('dashboard') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Volver al perfil
                </a>

            </div>

        </div>

    </div>

</body>

</html>
