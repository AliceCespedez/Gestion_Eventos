<style>
    .footer-container{
        background-color: transparent;
        width: 100vw;
        height: fit-content;
        display: flex;
        flex-direction: row;
        justify-content: space-between;
        align-items: flex-end;

        padding: 2rem 2rem 2rem 2rem;
    }
    .footer-div{
        display: flex;
        flex-direction: column;
        width: fit-content;
    }

    .footer-down a{
        font-family: 'BeVietnam';
        color: var(--color-chocolate);
    }

</style>


<footer class="footer-container">

    <div class="footer-div">
        <div>
            <a class="navbar-brand" href="{{ url('/') }}">
                @if(file_exists(public_path('logo-EvenTeaPortal-PLACEHOLDER.svg')))
                    <img src="{{ asset('logo-EvenTeaPortal-PLACEHOLDER.svg') }}" alt="Logo" height="70" class="d-inline-block">
                @else 
                    <strong class="color-choco logo-placeholder">EvenTea</strong>
                @endif
            </a>
        </div>
        <div class="footer-down">
            <a href="">Términos y condiciones</a>
            <a href="">Preguntas frecuentes</a>
        </div>

    </div>

    <div class="footer-div">

    </div>

</footer>