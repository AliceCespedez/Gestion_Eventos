<style>
    .navbar {
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem 1.5rem 2rem;
        height: var(--nav-height);
    }

    .logo-container {
        width: fit-content;
    }

    .logo-placeholder {
        font-family: 'PlayfairDisplay';
        font-style: italic;
        font-weight: 500;
    }

    .nav-menu {
        width: fit-content;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: flex-end;
        gap: 2rem;
        /* Espacio entre elementos */
    }

    .nav-menu a {
        letter-spacing: 6%;
        font-weight: 500;
        font-size: 0.8rem;
        margin-top: 8px;
        /*margin-right: 2rem;*/
    }

    .nav-pill {
        text-decoration: none;
        color: #574E49;
        font-family: 'BeVietnam';
        transition: 0.3s ease;
    }

    .nav-pill:hover {
        opacity: 0.6;
    }
</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light bg-white sticky-top">
    <!--shadow-sm-->

    <!-- LOGO -->
    <div class="logo-container">
        <a class="navbar-brand" href="{{ url('/') }}">
            @if (file_exists(public_path('logo-EvenTeaPortal-PLACEHOLDER.svg')))
                <img src="{{ asset('logo-EvenTeaPortal-PLACEHOLDER.svg') }}" alt="Logo" height="40"
                    class="d-inline-block">
            @else
                <strong class="color-choco logo-placeholder">EvenTea</strong>
            @endif
        </a>
    </div>

    <!-- MENU -->
    <div class="nav-menu">

        @php
            $user = auth()->user();

            $rol = strtolower($user->rol ?? '');

            $primerEvento = $user && $rol === 'cliente' ? $user->eventos->first() : null;
        @endphp

        @if ($rol === 'admin' || $rol === 'empleado')
            <a href="{{ route('eventos.index') }}">
                EVENTOS
            </a>
        @elseif ($rol === 'cliente' && $primerEvento)
            <a href="{{ route('eventos.show', $primerEvento->id_evento) }}">
                MIS EVENTOS
            </a>
        @else
            <a href="#">
                MIS EVENTOS
            </a>
        @endif

        <a href="{{ route('eventos.create') }}" class="nav-pill">
            CONTACTO
        </a>

        @auth
            <div class="d-flex align-items-center gap-2">
                {{--  NAV ADMIN  --}}
                @if (auth()->user()->rol === 'admin')
                    <a href="{{ route('admin') }}" style="font-weight: 400; margin: 0px">
                        <b>Admin</b>
                        &nbsp;&nbsp;
                        <i class="bi bi-person color-choco nav-pill fs-4"></i>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn-link me-4"
                            style="background: none; border: none; padding: 0; text-decoration: none;">
                            <i class="bi bi-door-closed color-choco nav-pill fs-4"></i>
                        </button>
                    </form>

                    {{--  NAV CLIENTE  --}}
                @else
                    <a href="{{ route('dashboard') }}" title="Mi cuenta" style="margin: 0px">
                        Hola, <strong>{{ auth()->user()->nombre }}</strong>
                        &nbsp;&nbsp;
                        <i class="bi bi-person color-choco nav-pill fs-4"></i>
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" title="Cerrar sesión" class="btn-link"
                            style="background: none; border: none; padding: 0; text-decoration: none;">
                            <i class="bi bi-door-open color-choco nav-pill fs-4"></i>
                        </button>
                    </form>
                @endif

            </div>
        @else
            <a href="{{ route('login') }}">
                <i class="bi bi-person color-choco nav-pill fs-4"></i>
            </a>
        @endauth
        {{-- 🔔 CAMPANA (FIJA Y SIEMPRE VISIBLE) --}}
        @if (in_array($rol, ['empleado', 'admin']))

            @php
                $user = auth()->user();
                $notificaciones = $user->unreadNotifications ?? collect();
            @endphp

            <div class="position-fixed top-0 end-0 p-4 ps-0" style="z-index:9999;">
                <div class="dropdown">

                    {{-- CAMPANA --}}
                    <a href="#" class="color-choco position-relative text-decoration-none"
                        data-bs-toggle="dropdown">

                        <i class="bi bi-bell-fill fs-4"></i>

                        @if ($notificaciones->count() > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge bg-danger">
                                {{ $notificaciones->count() }}
                            </span>
                        @endif

                    </a>

                    {{-- DROPDOWN --}}
                    <ul class="dropdown-menu dropdown-menu-end p-3 rounded-0" style="width:300px;">

                        <li class="fw-bold mb-2">NOTIFICACIONES</li>

                        @forelse($user->notifications as $noti)
                            <li>

                                <form method="POST" action="{{ route('consultas.leer', $noti->id) }}">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                        class="dropdown-item small border-0 bg-transparent text-start w-100">

                                        🔔 {{ $noti->data['mensaje'] ?? 'Notificación' }}

                                        <br>

                                        <small class="text-muted">
                                            {{ $noti->read_at ? 'Leída' : 'Nueva' }}
                                        </small>

                                    </button>

                                </form>

                            </li>

                        @empty

                            <li class="text-muted small px-2 py-1 fst-italic">
                                No tienes notificaciones
                            </li>
                        @endforelse

                        <hr>

                        <li>
                            <a href="{{ route('consultas.index') }}" class="dropdown-item text-center">
                                VER TODAS LAS CONSULTAS
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        @endif
    </div>


</nav>
