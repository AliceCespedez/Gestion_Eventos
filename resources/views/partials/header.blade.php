<style>
    .navbar{
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 2rem 1.5rem 2rem;
    }
    .logo-container{
        width: fit-content;
    }
    .logo-placeholder{
        font-family: 'PlayfairDisplay';
        font-style: italic;
        font-weight: 500;
    }
    .nav-menu{
        width: fit-content;
    }
    .nav-menu a{
        letter-spacing: 6%;
        font-weight: 500;
        font-size: 0.8rem;
        margin-right: 2rem;
    }

    .nav-pill{
        text-decoration: none;
        color: #574E49;
        font-family: 'BeVietnam';
        transition: 0.3s ease;
    }
    .nav-pill:hover{
        opacity: 0.6;
    }

</style>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm bg-white">

    <!-- LOGO -->
    <div class="logo-container">
        <a class="navbar-brand" href="{{ url('/') }}">
            @if(file_exists(public_path('logo-EvenTeaPortal-PLACEHOLDER.svg')))
                <img src="{{ asset('logo-EvenTeaPortal-PLACEHOLDER.svg') }}" alt="Logo" height="40" class="d-inline-block">
            @else 
                <strong class="color-choco logo-placeholder">EvenTea</strong>
            @endif
        </a>
    </div>

    <!-- MENU -->
    <div class="nav-menu">
        <a href="{{ route('eventos.store') }}" class="nav-pill">
            MIS EVENTOS
        </a>
        <a href="{{ route('eventos.create') }}" class="nav-pill">
            CONTACTO
        </a>
        <a href="{{ route('dashboard') }}">
            <i class="bi bi-person color-choco nav-pill fs-4"></i>
        </a>
    </div>
    

</nav>