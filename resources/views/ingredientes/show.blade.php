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
            border-radius: 5px;
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
                    <h3>{{ $receta->titulo }}</h3>
                    <p>{{ $receta->descripcion }}</p>
                    <p><strong>Creada por:</strong> {{ $receta->user->nombre }}</p>
                </li>
            @endforeach
        </ul>


       <div class="navigation-bar">
            <a href="{{ route('consultas.ingredientes-populares') }}" class="nav-link">Volver a la lista de ingredientes</a>
            
            {{ $recetas->links('pagination::simple-bootstrap-4') }}
        </div>

        
    </div>
</body>
</html>