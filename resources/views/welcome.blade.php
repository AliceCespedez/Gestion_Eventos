<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

    <style>
        body {
            font-family: 'BeVietnam', sans-serif;
            font-weight: 400;
            margin: 0;
            padding: 0;
        }

        .hero {
            height: calc(95vh - var(--nav-height));
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: space-between;
        }
        #welcome-header-img{
            width: 100%;
            height: 25vh;
            background: url('/images/eventea-welcome-header-img-01.png') center/cover no-repeat;
            background-size: cover;
            background-position: bottom;
            background-repeat: no-repeat;
        }

        #welcome-header-content {
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            width: 80vw;
            height: fit-content;
        }
        
        #welcome-section-2{
            width: 100vw;
            height: 70vh;
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 6rem 4rem 6rem 4rem;
        }
        #welcome-section-2 .right{
            padding: 0rem 5rem 0rem 5rem;
            width: 50%;
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        #welcome-section-2 .left{
            background: url('/images/eventea-01.jpg') center/cover no-repeat;
            width: 50%;
            height: 100%;
        }
        
        #welcome-flecha-div{
            width: 100%;
            height: 15vh;
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: pointer;
        }
        #flecha-container{
            width: 100%;
            height: fit-content;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            animation: flotar 2s ease-in-out infinite;
            transition: transform 0.3s ease;
        }
        /*
        #flecha-container:hover {
            animation: none;
            transform: translateY(5px);
        }*/
        @keyframes flotar {
            0%, 100% { 
                transform: translateY(0); 
            }
            50% { 
                transform: translateY(-10px); 
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    @include('partials.header')

<div class="hero">

    <div id="welcome-header-img"></div>
    <div id="welcome-header-content">
        <div class="mb-3 fs-3"> ★  ★  ★</div>
        <h3>Organizamos tu evento perfecto</h3>
        <h2>todo desde el mismo lugar</h1>
        <p>Bienvenido al portal de eventos de EvenTea. <br> ¡Gracias por elegirnos!</p>

        @auth
            @if(auth()->user()->rol === 'admin')
                <a href="{{ route('admin') }}" class="btn-eventea align-self-center">PANEL DE ADMINISTRACIÓN</a>
            @else
                <a href="{{ route('dashboard') }}" class="btn-eventea align-self-center">IR A MI PERFIL</a>
            @endif
            <!--
            <br>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="btn-eventea">Cerrar sesión</button>
            </form>
            -->
        @else
            <a href="/login" class="btn-eventea align-self-center">INICIAR SESIÓN</a>
        @endauth
    </div>

    <div id="welcome-flecha-div">
        <div id="flecha-container" onclick="welcomeScroll()">
            <p style="margin: 0%; font-style: italic">Descubre cómo funciona</p>
            <i class="bi bi-arrow-down-short"></i>
        </div>
    </div>
</div>

<div id="welcome-section-2">
    <div class="right">
        <h1>Tu portal personal<br>de eventos</h1>
        <p style="width: 80%">
            Esta aplicación está diseñada para facilitar la comunicación con el equipo de EvenTea. Así, podremos estar al tanto de todos los detalles que buscas en tu evento y poder organizarlo al pie de la letra.
        </p>
    </div>
    <div class="left"></div>


</div>

<!-- Footer -->
    @include('partials.footer')

<script>
    function welcomeScroll() {
        document.getElementById('welcome-section-2').scrollIntoView({ 
            behavior: 'smooth' 
        });
    }
</script>

</body>
</html>