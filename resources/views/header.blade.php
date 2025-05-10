<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container">
        <a class="navbar-brand me-auto" href="/">RealFoodie</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('recetas.create') }}">
                        <span><i class="fa-solid fa-plus"></i></span>
                        <span class="ms-1">Crear Receta</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('consultas.index') }}">
                        <span><i class="fa-solid fa-magnifying-glass"></i></span>
                        <span class="ms-1">Consultas Avanzadas</span>
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <span><i class="fa-solid fa-user"></i></span>
                        <span class="ms-1">{{ Auth::user()->nombre }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <span><i class="fa-solid fa-user"></i></span>
                                <span class="ms-2">Mi Perfil</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                <span><i class="fa-solid fa-pen-to-square"></i></span>
                                <span class="ms-2">Editar Perfil</span>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                <span><i class="fa-solid fa-right-from-bracket"></i></span>
                                <span class="ms-2">Cerrar Sesión</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>