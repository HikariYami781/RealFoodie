<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RealFoodie - Bienvenido</title>
    <style>
        body {
            background-image: url('images/fondo_principal.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 90vh;
            margin: 0;
            padding: 0;
        }       
        
        .display{
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        .lead{
            font-family: Arial, Helvetica, sans-serif;
        }
        .btn {
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

     <script>
        var isUserAuthenticated = {{ Auth::check() ? 'true' : 'false' }};
    </script>

</head>
<body>
    <div class="container mt-5 welcome">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center">
                <h1 class="display-4 mb-4">Bienvenido a RealFoodie</h1>
                <p class="lead mb-5">Tu plataforma para compartir y descubrir recetas increíbles</p>
                
                <div class="d-grid gap-3 col-md-6 mx-auto">
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg">Iniciar Sesión</a>
                <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">Registrarse</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
     <script>
        // Detectar si el usuario está navegando hacia atrás
        if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
            // variable que ya tenemos arriba definida
            if (isUserAuthenticated) {
                // Si el usuario está autenticado, redirigir a home
                window.location.href = "{{ route('home') }}";
            }
        };
    </script>
</body>
</html>