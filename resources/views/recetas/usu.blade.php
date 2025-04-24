<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles del Usuario</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
            background-image: url('/images/recetas_usu.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .user-info {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
            text-align: center;
        }
        .recipe-list {
            list-style: none;
            padding: 0;
        }
        .recipe-item {
            background: #fff;
            border: 1px solid #ddd;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 5px;
        }
        .back-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .back-button:hover {
            background-color: #0056b3;
        }
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-item {
            background: #e9ecef;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="user-info">
            <h1>{{ $user->name }}</h1>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Miembro desde:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
        </div>

        <div class="stats">
            <div class="stat-item">
                <h3>Total Recetas</h3>
                <p>{{ $user->recetas->count() }}</p>
            </div>
        </div>

        <h2>Recetas creadas</h2>
        <ul class="recipe-list">
            @forelse($user->recetas as $receta)
                <li class="recipe-item">
                    <h3>{{ $receta->titulo }}</h3>
                    <p>{{ $receta->descripcion }}</p>
                    <small>Creada el {{ $receta->created_at->format('d/m/Y') }}</small>
                </li>
            @empty
                <p>Este usuario aún no ha creado ninguna receta.</p>
            @endforelse
        </ul>

        <a href="{{ url()->previous() }}" class="back-button">Volver atrás</a>
        <a href="{{ route('consultas.index') }}" class="back-button">Volver a Consultas</a>
        
    </div>
</body>
</html>
