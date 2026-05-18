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
            padding: 2rem;
        }

        .btn-even {
            background-color: #2c2c2c;
            color: #fff;
        }

        .btn-even:hover {
            background-color: #000;
        }

        .btn-back {
            border: 1px solid #2c2c2c;
            color: #2c2c2c;
            padding: 8px 18px;
        }

        .btn-back:hover {
            background-color: #2c2c2c;
            color: #fff;
        }
    </style>
</head>

<body class="bg-claro">

    @include('partials.header')

    <div class="container py-5">
        <div class="row align-items-center">

            <!-- IZQUIERDA -->
            <div class="col-md-6">

                <p class="subtitulo">¿Alguna duda? ¿Un nuevo evento?</p>

                <h1 class="titulo-principal mb-4">Ponte en contacto</h1>

                <div class="contact-box">

                    {{-- ✅ MENSAJE DE ÉXITO --}}
                    @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('consulta.store') }}">
                        @csrf

                        {{-- ASUNTO --}}
                        <div class="mb-3">
                            <input type="text" name="asunto"
                                class="form-control @error('asunto') is-invalid @enderror" placeholder="Asunto"
                                value="{{ old('asunto') }}">

                            @error('asunto')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- MENSAJE --}}
                        <div class="mb-3">
                            <label class="form-label">¿Qué necesitas?</label>

                            <textarea name="mensaje" rows="5" class="form-control @error('mensaje') is-invalid @enderror"
                                placeholder="Escribe aquí tu consulta...">{{ old('mensaje') }}</textarea>

                            @error('mensaje')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- TIPO --}}
                        <div class="mb-3">
                            <label class="form-label">Tipo de consulta</label>

                            <select name="tipo_consulta" class="form-select">

                                <option value="informacion">Información general</option>
                                <option value="evento">Organización de evento</option>
                                <option value="soporte">Soporte</option>
                                <option value="otro">Otro</option>

                            </select>
                        </div>

                        {{-- PRIORIDAD --}}
                        <div class="mb-3">
                            <label class="form-label">Prioridad</label>

                            <select name="prioridad" class="form-select">

                                <option value="baja">Baja</option>
                                <option value="media" selected>Media</option>
                                <option value="alta">Alta</option>

                            </select>
                        </div>

                        {{-- CHECK --}}
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" required>
                            <label class="form-check-label">
                                Acepto la política de privacidad
                            </label>
                        </div>

                        <button class="btn-eventea w-100">
                            ENVIAR
                        </button>

                    </form>

                </div>
            </div>

            <!-- DERECHA -->
            <div class="col-md-6 text-end" style="height: 100%;">
                <div style="background: url('/images/flores-1.jpg') center/cover no-repeat; height: 100%;" class="" alt="Imagen flores"></div>

                <a href="{{ route('dashboard') }}" class="btn btn-back">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>

                <!-- <img src="/images/flores-1.jpg" class="img-fluid mb-4"> -->

            </div>

        </div>
    </div>

    @include('partials.footer')

</body>


</html>
