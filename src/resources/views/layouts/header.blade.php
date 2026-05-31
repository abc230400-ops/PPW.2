<nav class="navbar navbar-expand-lg bg-dark p-3" data-bs-theme="dark">
    <div class="container-fluid text-white">

        <span class="navbar-brand">OtakoFlix</span>

        <div class="collapse navbar-collapse">

            <!-- Menu esquerda -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/">Início</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/filmes">Filmes / Animes </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/pessoas">Celebridades</a>
                </li>
            </ul>

            <!-- Busca central -->
            <form action="/buscar_tudo" method="GET" class="mb-4">
                <div class="d-flex mx-auto w-50" role="search">
                    <input class="form-control me-2" type="search" name="busca_tudo" 
                    placeholder="Buscar por..." value="{{ request('busca_tudo') }}" />
                    <button class="btn btn-outline-light" type="submit">Buscar</button>
                </div>
            </form>

            <!-- Dropdown direita -->
            <ul class="navbar-nav ms-auto">
                <li class="nav-item dropdown">
                    <button type="button" class="btn btn-dark dropdown-toggle" data-bs-toggle="dropdown">
                        @auth
                        Olá, {{ Auth::user()->name }}
                        @else
                        <i class="bi bi-person-fill" style="color: white;"></i> acesse sua conta

                        @endauth
                    </button>

                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">

                        @auth
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Sair</button>
                            </form>

                        </li>
                        @else
                        <li><a class="dropdown-item" href="{{ route('login') }}">Login</a></li>
                        <li><a class="dropdown-item" href="{{ route('register') }}">Cadastrar</a></li>
                        @endauth

                    </ul>
                </li>
            </ul>

        </div>

    </div>
</nav>