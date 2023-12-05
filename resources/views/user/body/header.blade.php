<!-- Page Loader -->



<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand logo" href="{{ route('home') }}">
            <img src="{{ asset('backend/img/Logo Dipersip.png') }}" alt="">
            SIARSI
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link nav-link-1" aria-current="page" href="{{ route('home') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-3" href="{{ route('about.index') }}">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link nav-link-4" href="{{ route('loginadmin') }}">Login</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
