<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>@yield('title', config('app.name', 'RealFoodie'))</title>
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    
    <!-- Styles -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <style>
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }
        
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            padding: 0;
            margin: 0;
        }
        
        main {
            flex: 1 0 auto;
            padding: 0;
            margin: 0;
        }
        
        footer {
            flex-shrink: 0;
        }
    </style>
</head>
<body>
    <!-- Incluir el header -->
    @include('header')

    <!-- Contenido principal -->
    <main>
        @yield('content')
    </main>
    
    <!-- Incluir el footer -->
    @include('footer')

    <!-- Bootstrap JS- Dropdown -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>