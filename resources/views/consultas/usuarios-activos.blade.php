<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios Activos</title>
    <style>
        body {
            background-image: url('/images/usu_active.jpg');
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: #f5f5f5; 
        }

        .container_form {
            background-color: rgba(255, 255, 255, 0.8); 
            border-radius: 10px;
            padding: 30px;
            margin-left: 30px;
            margin-right: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-label {
            font-weight: 500; 
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="container_form">
            <h1 class="mb-4">Usuarios más activos</h1>
            
            <div class="mb-4">
                <a href="{{ route('consultas.index') }}" class="btn btn-secondary">
                    Volver a Consultas
                </a>
            </div>

            @if(!isset($usuarios) || $usuarios->isEmpty())

                <div class="alert alert-info">
                    No se encontraron usuarios activos.
                </div>

            @else

                <div class="table-responsive">
                    <table class="table">

                        <thead>
                            <tr>
                                <th>Usuario</th>
                                <th class="text-center">Recetas publicadas</th>
                                <th>Miembro desde</th>
                                <th class="text-end">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($usuarios as $usuario)
                                <tr>
                                    <td class="align-middle">{{ $usuario->nombre ?? 'Sin nombre' }}</td>
                                    <td class="text-center align-middle">{{ $usuario->recetas_count ?? 0 }}</td>
                                    <td class="align-middle">
                                        {{ $usuario->created_at ? $usuario->created_at->format('d/m/Y') : 'Fecha no disponible' }}
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('users.show', $usuario->id) }}" 
                                        class="btn btn-primary btn-sm">
                                            Ver Detalles
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>

               <!-- Paginación-->
                @if($usuarios->hasPages())
                    <div class="d-flex justify-content-center mt-4">
                        <nav aria-label="Navegación de páginas">
                            <ul class="pagination">
                                {{-- Números de página --}}
                                @for ($i = 1; $i <= $usuarios->lastPage(); $i++)
                                    @if ($i == $usuarios->currentPage())
                                        <li class="page-item active"><span class="page-link">{{ $i }}</span></li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $usuarios->url($i) }}">{{ $i }}</a>
                                        </li>
                                    @endif
                                @endfor
                            </ul>
                        </nav>
                    </div>
                @endif
                
            @endif
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
