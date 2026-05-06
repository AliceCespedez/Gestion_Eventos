<style>
    .footer-container{
        background-color: transparent;
        width: 100vw;
        height: max-content;
        display: flex;
        flex-direction: row;
        justify-content: space-between;

        padding: 2rem 2rem 2rem 2rem;
    }
    .footer-container a{
        font-family: 'BeVietnam';
        color: var(--color-chocolate);
    }
    .footer-container a:hover{
        color: black;
    }
    .footer-div{
        display: flex;
        flex-direction: column;
        width: max-content;
    }


    #footer-left{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }


    #footer-right-up-div{
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        text-align: right;
        gap: 1rem;
    }
    #footer-right{
        display: flex;
        flex-direction: column;
        justify-content: flex-end;
        align-items: flex-end;
        gap: 2rem;
    }
    #footer-right a{
        text-decoration: none;
    }
    
    #footer-right-down-div{
        display: flex;
        flex-direction: row;
        align-items: center;
        gap: 2rem;
    }
    #footer-right-down-div a {
        display: inline-flex;
        align-items: flex-start; 
        gap: 0.5rem;        
        text-decoration: none;
    }


</style>


<footer class="footer-container">

    <div class="footer-div" id="footer-left">
        <div>
            <a id="footer-logo" class="navbar-brand" href="{{ url('/') }}">
                @if(file_exists(public_path('logo-EvenTeaPortal-PLACEHOLDER.svg')))
                    <img src="{{ asset('logo-EvenTeaPortal-PLACEHOLDER.svg') }}" alt="Logo" height="70" class="d-inline-block">
                @else 
                    <strong class="color-choco logo-placeholder">EvenTea</strong>
                @endif
            </a>
        </div>

        <div class="footer-left-down-div">
            <a href="">Términos y condiciones</a>
            <a href="">Preguntas frecuentes</a>
        </div>

    </div>

    <div  id="footer-right" class="footer-div">

        <div id="footer-right-up-div" class="">
            <div><a href="{{ route('eventos.store') }}">MIS EVENTOS</a></div>
            <div><a href="{{ route('eventos.create') }}">CONTACTO</a></div>
            <div><a href="">CUENTA</a></div>
        </div>
        
        <div id="footer-right-down-div" class="">
            <a href="#" class="w-auto"><i class="bi bi-facebook"></i>&#64EVENTEA.EVENTOS</a>
            <a href="#" class="w-auto"><i class="bi bi-instagram"></i>&#64EVENTEA</a>
            <button class="btn-eventea w-auto">EVENTEA.COM</button>
        </div>

    </div>

</footer>