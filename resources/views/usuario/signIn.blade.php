<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RealFoodie - Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('/images/signIn.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            margin: 0;
            padding: 0;
        }
        
        /*Transparente */
        .card {
            background-color: rgba(255, 255, 255, 0.5) !important; 
            backdrop-filter: blur(5px);
            border: none !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            background-color: rgba(255, 255, 255, 0.6) !important; /*!important Resalta los mensajes*/
            border-bottom: 1px solid rgba(0, 0, 0, 0.1);
        }
        
        .form-control {
            background-color: rgba(255, 255, 255, 0.5) !important; 
            border: 1px solid rgba(0, 0, 0, 0.2);
        }
        
        .form-control:focus {
            background-color: rgba(255, 255, 255, 0.7) !important; 
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        
        .btn-primary {
            background-color: rgba(13, 110, 253, 0.8) !important; 
            border-color: rgba(13, 110, 253, 0.8) !important;
        }
        
        .btn-primary:hover {
            background-color: rgba(11, 94, 215, 0.9) !important; 
            border-color: rgba(11, 94, 215, 0.9) !important;
        }
        
        .alert-danger {
            background-color: rgba(220, 53, 69, 0.8) !important; 
            border-color: rgba(220, 53, 69, 0.8) !important;
            color: white;
        }
        
        label, p, h3 {
            color: #000;
            font-weight: 500;
            text-shadow: 0 0 2px rgba(255, 255, 255, 0.8);
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Registro</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('signIn.post') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                       id="email" name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Contraseña</label>
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       id="password" name="password" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" 
                                       id="password_confirmation" name="password_confirmation" required>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary">Registrarse</button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-3">
                            <p>¿Ya tienes cuenta? <a href="{{ route('login') }}">Inicia sesión</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>