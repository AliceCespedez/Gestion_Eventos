<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenido</title>
    
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

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


        .cards-div{
            display: flex;
            flex-direction: row;
            gap: 3rem;
            justify-content: space-between;
            margin-bottom: 3rem;
        }
        .carta{
            height: fit-content;
            min-width: 30%;
            transition: all 0.5s ease-out;
        }
        .carta:hover{
            transform: translate(0px, -8px);
        }
        .carta-img{
            height: 18vw;
            min-height: 150px;
        }


        #welcome-section-4{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;

            height: 40vh;
            margin: 3rem 0 4rem 0;
        }


        /* PASOS */
        .pasos-bg-div{
            padding: 2rem 2rem 10rem 2rem;
        }
        .pasos-titulo{
            display: flex;
            flex-direction: column;
            gap: 8rem;
            justify-content: center;
            align-items: center;
            width: 100%;
        }
        .pasos-inside{
            display: flex;
            flex-direction: column;
            gap: 8rem;
            justify-content: start;
            align-items: start;
            width: 70%;
        }
        .pasos-inside > div {
            width: 100%;
            gap: 3rem;
            justify-content: center;
        }

        .pasos-titulo h3{
            font-size: 2rem !important;
        }
        .home-number{
            font-size: clamp(5rem, calc(4rem + 7vw), 11rem ) !important;
            line-height: 0.3;
        }

        #welcome-section-6{
            display: flex;
            flex-direction: row;
            gap: 4rem;
            height: 40vh;
            padding: 0 4rem 0 4rem;
        }
        .welcome-block{
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 4rem;
            width: 30%;
            transition: all 0.5s ease-out;
        }
        .welcome-block:hover{
            background-color: var(--color-beige-claro);
            cursor: pointer;
        }
    </style>
</head>

<body class="normal-body">

    <!-- Header -->
    @include('partials.header')

    <!-- HERO -->
    <div class="hero">

        <div id="welcome-header-img"></div>
        <div id="welcome-header-content">
            <div class="mb-3 fs-3"> ★  ★  ★</div>
            <h3>Organizamos tu evento perfecto</h3>
            <h2>todo desde el mismo lugar</h1>
            <p class="mb-3">Bienvenido al portal de eventos de EvenTea. <br> ¡Gracias por elegirnos!</p>

            @auth
                @if(auth()->user()->rol === 'admin')
                    <a href="{{ route('admin') }}" class="btn-eventea align-self-center mt-3">PANEL DE ADMINISTRACIÓN</a>
                @else
                    <a href="{{ route('dashboard') }}" class="btn-eventea align-self-center">IR A MI PERFIL</a>
                @endif
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

    <!-- INTRO BANNER -->
    <div id="welcome-section-2">
        <div class="right">
            <h1>Tu portal personal<br>de eventos</h1>
            <p style="width: 80%">
                Esta aplicación está diseñada para facilitar la comunicación con el equipo de EvenTea. Así, podremos estar al tanto de todos los detalles que buscas en tu evento y poder organizarlo al pie de la letra.
            </p>
        </div>
        <div class="left"></div>
    </div>

    <!-- TARJETAS -->
    <div id="welcome-section-3" style="width: 70vw;" class="align-self-center">

        <div class="text-center" style="margin-bottom: 6rem;">
            <h2>¿Qué puedes hacer desde aquí?</h2>
            <p>Una vez que tu evento esté dado de alta,<br>podrás gestionarlo todo en un mismo sitio.</p>
        </div>

        <div class="cards-div">

            <div class="carta">
                <div style="background: url('/images/eventea-02.jpg') center/cover no-repeat;" class="carta-img" alt="Imagen mesa"></div>
                <div class="bg-claro p-3 pt-0">
                    <div class="border-eventea p-3 text-center border-top-0" style="height: fit-content">
                        <h6>Accede a tu información</h6>
                        <p>Lugar, fecha, estado de tu evento...</p>
                    </div>
                </div>
            </div>

            <div class="carta">
                <div style="background: url('/images/invitados-1.jpg') center/cover no-repeat;" class="carta-img" alt="Imagen invitaciones"></div>
                <div class="bg-claro p-3 pt-0">
                    <div class="border-eventea p-3 text-center border-top-0" style="height: fit-content">
                        <h6>Gestionar invitados</h6>
                        <p>Contactos, confirmaciones, sitting…</p>
                    </div>
                </div>
            </div>

            <div class="carta">
                <div style="background: url('/images/catering-1.jpg') center/cover no-repeat;" class="carta-img" alt="Imagen catering"></div>
                <div class="bg-claro p-3 pt-0">
                    <div class="border-eventea p-3 text-center border-top-0" style="height: fit-content">
                        <h6>Catering a tu gusto</h6>
                        <p>Elige y modifica menús fácilmente</p>
                    </div>
                </div>
            </div>

        </div> <!-- cartas div-->
        <div class="cards-div">

            <div class="carta">
                <div style="background: url('/images/presupuesto-1.jpg') center/cover no-repeat;" class="carta-img" alt="Imagen planificación"></div>
                <div class="bg-claro p-3 pt-0">
                    <div class="border-eventea p-3 text-center border-top-0" style="height: fit-content">
                        <h6>Presupuesto en tiempo real</h6>
                        <p>Controla cada gasto al instante</p>
                    </div>
                </div>
            </div>

            <div class="carta">
                <div style="background: url('/images/fotografo-1.jpg') center/cover no-repeat;" class="carta-img" alt="Imagen fotógrafa"></div>
                <div class="bg-claro p-3 pt-0">
                    <div class="border-eventea p-3 text-center border-top-0" style="height: fit-content">
                        <h6>Contrata extras</h6>
                        <p>Música, decoración, fotografía…</p>
                    </div>
                </div>
            </div>

            <div class="carta">
                <div style="background: url('/images/equipo-1.jpg') center/cover no-repeat;" class="carta-img" alt="Imagen reunión"></div>
                <div class="bg-claro p-3 pt-0">
                    <div class="border-eventea p-3 text-center border-top-0" style="height: fit-content">
                        <h6>Comunícate con el equipo</h6>
                        <p>Cambios, dudas o tu opinión</p>
                    </div>
                </div>
            </div>

        </div> <!-- cartas div-->

    </div>

    <!-- BANNER 2 -->
    <div id="welcome-section-4" class="color-white text-center" style="background: url('/images/fuegos-2.jpg') bottom/cover no-repeat;">
        <i class="bi bi-cake2 color-white fs-2"></i>
        <h3 style="width: 60%;">Todo lo que necesitas para que tu evento sea único,<br>sin contratiempos ni mensajes perdidos. </h3>
    </div>

    <!-- CÓMO FUNCIONA -->
    <div class="bg-claro m-4 w-100 pasos-bg-div">

        <div class="border-eventea p-5 d-flex flex-column gap-2 text-center">
            <h3>¿Quieres organizar un evento?</h3>
            <p>Boda, comida de empresa, cena familiar, coffee break, cóctel…<br>Sea lo que sea, estamos aquí para ayudarte.</p>
            <h2>Cómo funciona</h2>
        </div>

        <div class="pasos-titulo">

            <div class="pasos-inside">

                {{-- 01 --}}
                <div class="d-flex flex-row mt-5">
                    <h2 class="home-number">01</h2>
                    <div>
                        <h3>Descubre lo que podemos ofrecerte</h3>
                        <p>Visita nuestra web principal <a href="#"><i>www.eventea.com</i></a></p>
                    </div>
                </div>

                {{-- 02 --}}
                <div class="d-flex flex-row">
                    <h2 class="home-number">02</h2>
                    <div>
                        <h3>Ponte en contacto con nosotros</h3>
                        <p>Cuéntanos qué necesitas y qué tipo de evento tienes en mente.</p>
                    </div>
                </div>

                {{-- 03 --}}
                <div class="d-flex flex-row">
                    <h2 class="home-number">03</h2>
                    <div>
                        <h3>Nosotros te creamos una cuenta</h3>
                        <p>El equipo de EvenTea dará de alta tu evento y te enviará por email tus credenciales de acceso.</p>
                    </div>
                </div>

                {{-- 04 --}}
                <div class="d-flex flex-row">
                    <h2 class="home-number">04</h2>
                    <div>
                        <h3>Accede y gestiona todo</h3>
                        <p>Una vez dentro de este portal, tendrás el control total de tu evento.</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- TIENES CUENTA? -->
    <div id="welcome-section-6">
        <div class="welcome-block border-eventea flex-fill">
            <h3>¿Ya tienes una cuenta?</h3>
            <p class="mb-4 mt-2">Accede con tu email y contraseña<br>para empezar a gestionar tu evento.</p>
            <a href="/login" class="btn-eventea align-self-center">INICIAR SESIÓN</a>
        </div>
        <div class="welcome-block border-eventea flex-fill">
            <h3>¿Aun no tienes unevento dado de alta?</h3>
            <p class="mb-4 mt-2">No te preocupes. Contáctanos primero<br>y nosotros preparamos todo para ti.</p>
            <a href="{{ route('eventos.create') }}" class="btn-eventea align-self-center">CONTACTO</a>
        </div>
    </div>

    <!-- SLIDER -->
    <div id="welcome-slider" class="mt-4" style="padding: 0 4rem 4rem 4rem;">
        <h5 class="pb-3 pt-5 text-center">Algunos de nuestros eventos</h5>

        <div id="slider1" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            
            {{-- INDICADORES --}}
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#slider1" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#slider1" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#slider1" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>

            {{-- SLIDES --}}
            <div class="carousel-inner">
                
                <div class="carousel-item active">
                    <img src="{{ asset('images/eventea-01.jpg') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Evento 1">
                </div>

                
                <div class="carousel-item">
                    <img src="{{ asset('images/eventea-02.jpg') }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Evento 2">
                </div>

               
                <div class="carousel-item">
                    <div class="d-block w-100" style="height: 500px; background: url('{{ asset('images/fuegos-2.jpg') }}') center/cover no-repeat;"></div>
                </div>
            </div>

            {{-- CONTROLES (flechas) --}}
            <button class="carousel-control-prev" type="button" data-bs-target="#slider1" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#slider1" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
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