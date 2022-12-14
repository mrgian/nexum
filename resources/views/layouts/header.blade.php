<nav class="navbar navbar-expand navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('assets/logo.svg') }}" class="d-inline-block align-top" width="30" height="30">
            Nexum
        </a>

        <ul class="navbar-nav ">
            @guest
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#features">Features</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#regolamento">Regolamento</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home') }}#contatti">Contatti</a>
                </li>
            @endguest

            @auth

                @cannot('isStaff')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user', ['username' => Auth::user()->username]) }}">Profilo</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('messages') }}">Messaggi</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('friends') }}">Amici</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('newBlog') }}">Crea un nuovo blog</a>
                    </li>
                @endcannot

                @can('isStaff')
                    @can('isAdmin')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('admin') }}">Pannello di amministrazione</a>
                        </li>
                    @endcan
                @endcannot

                @cannot('isAdmin')
                    @can('isStaff')
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('staff') }}">Pannello di amministrazione</a>
                        </li>
                    @endcan
                @endcannot
        </ul>

        @cannot('isStaff')
            <form class="d-flex" role="search" id="searchForm" action="{{ route('search') }}" method="GET">
                <input class="form-control me-2" type="search" type="text" name="q" placeholder="Cerca utenti..." aria-label="Search" required>
                <button id="buttonSearch" class="btn btn-outline-light mx-1" type="submit">Cerca</button>
            </form>
        @endcannot

        @endauth


        <div class="d-flex">
            <ul class="navbar-nav">
                @guest
                    <button type="button" onclick="location.href='{{ route('login') }}'"
                        class="btn btn-outline-light mx-1">Login</button>
                    <button type="button" onclick="location.href='{{ route('register') }}'"
                        class="btn btn-light mx-1">Registrati</button>
                @endguest

                @auth
                    <button type="button" onclick="location.href='{{ route('logout') }}'"
                        class="btn btn-outline-light mx-1">Logout</button>
                @endauth
            </ul>
        </div>
    </div>
</nav>
