<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Ingrediente</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            background-image: url('/images/ingredientes_show.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            max-width: 700px;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 10px;
            margin-top: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .header {
            background-color: #f4f4f4;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
        }
        .recetas-list {
            list-style: none;
            padding: 0;
        }
        .receta-item {
            background: #fff;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 15px;
            padding-right: 120px;
            border-radius: 5px;
            position: relative;
        }
        .receta-link {
            text-decoration: none;
            color: inherit;
            display: block;
        }
        .receta-title {
            color: #2c3e50;
            margin-bottom: 10px;
            font-size: 1.2em;
            font-weight: 600;
        }
        .receta-description {
            color: #666;
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .receta-author {
            color: #495057;
            font-size: 0.9em;
            margin-bottom: 8px;
        }
        .receta-meta {
            display: flex;
            gap: 15px;
            color: #6c757d;
            font-size: 0.85em;
            margin-top: 10px;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .view-recipe-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 0.9em;
            position: absolute;
            top: 15px;
            right: 15px;
            transition: all 0.3s ease;
            z-index: 2;
        }
        .view-recipe-btn:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }
        .navigation-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 20px;
        }
        .nav-link {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .nav-link:hover {
            background-color: #0056b3;
        }
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .page-item {
            margin: 0 5px;
        }
        .page-link {
            display: inline-block;
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .page-link:hover {
            background-color: #0056b3;
        }
        .page-item.disabled .page-link {
            background-color: #6c757d;
            cursor: not-allowed;
        }
        .page-item.active .page-link {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .d-flex {
            display: flex;
        }
        .justify-content-center {
            justify-content: center;
        }
        .mt-4 {
            margin-top: 1.5rem;
        }
        .icon {
            width: 16px;
            height: 16px;
            fill: currentColor;
        }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="header">
            <h1>Ingrediente: {{ $ingrediente->nombre }}</h1>
            <p>Este ingrediente se usa en {{ $ingrediente->recetas->count() }} recetas</p>
        </div>

        <h2>Recetas que usan este ingrediente:</h2>
        <ul class="recetas-list">
            @foreach($recetas as $receta)
                <li class="receta-item">
                    <a href="{{ route('recetas.show', $receta) }}" class="receta-link">
                        <button class="view-recipe-btn">Ver Receta</button>
                        
                        <h3 class="receta-title">{{ $receta->titulo }}</h3>
                        
                        <p class="receta-description">{{ $receta->descripcion }}</p>
                        
                        <p class="receta-author">
                            <strong>Creada por:</strong> {{ $receta->user->nombre }}
                        </p>
                        
                        <div class="receta-meta">
                            @if($receta->preparacion)
                                <div class="meta-item">
                                    <svg class="icon" viewBox="0 0 24 24">
                                        <path d="M12,20A7,7 0 0,1 5,13A7,7 0 0,1 12,6A7,7 0 0,1 19,13A7,7 0 0,1 12,20M19.03,7.39L20.45,5.97C20,5.46 19.55,5 19.04,4.56L17.62,6C16.07,4.74 14.12,4 12,4A9,9 0 0,0 3,13A9,9 0 0,0 12,22C17,22 21,17.97 21,13C21,10.88 20.26,8.93 19.03,7.39M11,14H13V8H11M15,1H9V3H15V1Z"/>
                                    </svg>
                                    Prep: {{ $receta->preparacion }}min
                                </div>
                            @endif
                            
                            @if($receta->coccion)
                                <div class="meta-item">
                                    <svg class="icon" viewBox="0 0 24 24">
                                        <path d="M18.06 22.99H1.94C1.94 22.99 1.94 22.99 1.94 22.99C0.88 22.99 0 22.11 0 21.05V2.95C0 1.89 0.88 1.01 1.94 1.01H18.06C19.12 1.01 20 1.89 20 2.95V21.05C20 22.11 19.12 22.99 18.06 22.99ZM1.94 2.95V21.05H18.06V2.95H1.94Z"/>
                                    </svg>
                                    Cocción: {{ $receta->coccion }}min
                                </div>
                            @endif
                            
                            @if($receta->dificultad)
                                <div class="meta-item">
                                    <svg class="icon" viewBox="0 0 24 24">
                                        <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.46,13.97L5.82,21L12,17.27Z"/>
                                    </svg>
                                    @switch($receta->dificultad)
                                        @case(1) Muy fácil @break
                                        @case(2) Fácil @break
                                        @case(3) Media @break
                                        @case(4) Difícil @break
                                        @case(5) Muy difícil @break
                                    @endswitch
                                </div>
                            @endif
                            
                            @if($receta->porciones)
                                <div class="meta-item">
                                    <svg class="icon" viewBox="0 0 24 24">
                                        <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2Z"/>
                                    </svg>
                                    {{ $receta->porciones }} porciones
                                </div>
                            @endif
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>

        <div class="navigation-bar">
            <a href="{{ route('consultas.ingredientes-populares') }}" class="nav-link">Volver a la lista de ingredientes</a>
            
            <!-- Paginación -->
            @if($recetas->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    <nav aria-label="Navegación de páginas">
                        <ul class="pagination">
                            {{-- Números de página --}}
                            @for ($i = 1; $i <= $recetas->lastPage(); $i++)
                                @if ($i == $recetas->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $recetas->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endif
                            @endfor
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
