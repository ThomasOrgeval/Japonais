<!-- Navbar -->
<nav class="navbar navbar-expand-lg bg-light navbar-light fixed-top">
    <!-- Container wrapper -->
    <div class="container-fluid">

        <!-- Navbar brand -->
        <a class="navbar-brand" href="{{ route('/') }}">
            <img src="{{ asset('images/sakura.webp') }}" alt="sakura" height="40">
        </a>

        <!-- Toggle button -->
        <button class="navbar-toggler" type="button" data-mdb-toggle="collapse"
                data-mdb-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Collapsible wrapper -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <!-- Link -->
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link {{ request()->is('/') ? 'on' : '' }}" href="{{ route('/') }}">Accueil</a>
                </li>

                <!-- Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdown" role="button" data-mdb-toggle="dropdown"
                       aria-expanded="false">
                        Plus
                    </a>
                    <!-- Dropdown menu -->
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if(session()->has('pseudo'))
                            <li><a class="dropdown-item" href="#">Mes listes</a></li>
                            <li><a class="dropdown-item" href="#">Mes thèmes</a></li>
                            <li><a class="dropdown-item" href="#">Historique</a></li>
                            <li>
                                <hr class="my-2">
                            </li>
                        @endif
                        <li><a class="dropdown-item" href="#">Cours</a></li>
                    </ul>
                </li>

                @if(session()->has('admin'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin') }}">Admin</a>
                    </li>
                @endif

            </ul>

            <!-- Icons -->
            <ul class="navbar-nav d-flex flex-row me-1">

                <li class="nav-item me-3 me-lg-0 dropdown">
                    <a class="nav-link" id="language" role="button" data-mdb-toggle="dropdown"
                       aria-expanded="false">
                        @switch(Cookie::get('lang'))
                            @case('cn')
                            <i class="flag-china flag"></i>
                            @break
                            @case('kr')
                            <i class="flag-south-korea flag"></i>
                            @break
                            @default
                            <i class="flag-japan flag"></i>
                        @endswitch
                    </a>

                    <ul class="dropdown-menu" aria-labelledby="language">
                        <li>
                            <a class="dropdown-item" href="{{ url('lang/jp') }}">
                                <i class="flag-japan flag"></i> 日本語
                            </a>
                        </li>
                        <li>
                            <hr class="my-0">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('lang/cn') }}">
                                <i class="flag-china flag"></i> 中文
                            </a>
                        </li>
                        <li>
                            <hr class="my-0">
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ url('lang/kr') }}">
                                <i class="flag-south-korea flag"></i> 한국어
                            </a>
                        </li>
                    </ul>
                </li>

                @if(session()->has('pseudo'))
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link" href="{{ route('logout') }}"><i class="fas fa-sign-out-alt"></i></a>
                    </li>
                @else
                    <li class="nav-item me-3 me-lg-0">
                        <a class="nav-link" data-mdb-toggle="modal" data-mdb-target="#connect" role="button">
                            <i class="fas fa-user"></i>
                        </a>
                    </li>
                @endif
            </ul>

            <!-- Search -->
            <form class="ms-md-2 w-auto">
                <input type="search" class="form-control" placeholder="Recherche" aria-label="Search">
            </form>
        </div>
    </div>
    <!-- Container wrapper -->
</nav>
<!-- Navbar -->
