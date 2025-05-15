<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RealFoodie - Editar Receta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            background-image: url('/images/edit_recetas.jpg');
            background-size: cover;
            background-position: center top;
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-color: #f5f5f5; /* Color de respaldo */
        }



        .container_form{
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
</head>
<body>
    @include('header')

<div class="container_form">
    <h1 class="mb-4">Editar Receta</h1>
    <form action="{{ route('recetas.update', $receta) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Título -->
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                   id="titulo" name="titulo" value="{{ old('titulo', $receta->titulo) }}">
            @error('titulo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                      id="descripcion" name="descripcion" rows="3">{{ old('descripcion', $receta->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tiempo de Preparación -->
        <div class="mb-3">
            <label for="preparacion" class="form-label">Tiempo de Preparación (minutos)</label>
            <input type="number" class="form-control @error('preparacion') is-invalid @enderror" 
                   id="preparacion" name="preparacion" value="{{ old('preparacion', $receta->preparacion) }}">
            @error('preparacion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tiempo de Cocción -->
        <div class="mb-3">
            <label for="coccion" class="form-label">Tiempo de Cocción (minutos)</label>
            <input type="number" class="form-control @error('coccion') is-invalid @enderror" 
                   id="coccion" name="coccion" value="{{ old('coccion', $receta->coccion) }}">
            @error('coccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Dificultad -->
        <div class="mb-3">
            <label for="dificultad" class="form-label">Dificultad</label>
            <select class="form-control @error('dificultad') is-invalid @enderror" 
                    id="dificultad" name="dificultad">
                <option value="1" {{ old('dificultad', $receta->dificultad) == 1 ? 'selected' : '' }}>Muy fácil</option>
                <option value="2" {{ old('dificultad', $receta->dificultad) == 2 ? 'selected' : '' }}>Fácil</option>
                <option value="3" {{ old('dificultad', $receta->dificultad) == 3 ? 'selected' : '' }}>Media</option>
                <option value="4" {{ old('dificultad', $receta->dificultad) == 4 ? 'selected' : '' }}>Difícil</option>
                <option value="5" {{ old('dificultad', $receta->dificultad) == 5 ? 'selected' : '' }}>Muy difícil</option>
            </select>
            @error('dificultad')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Número de Porciones -->
        <div class="mb-3">
            <label for="porciones" class="form-label">Número de Porciones</label>
            <input type="number" class="form-control @error('porciones') is-invalid @enderror" 
                   id="porciones" name="porciones" value="{{ old('porciones', $receta->porciones) }}">
            @error('porciones')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Categoría -->
        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select class="form-control @error('categoria_id') is-invalid @enderror" 
                    id="categoria_id" name="categoria_id">
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" 
                        {{ old('categoria_id', $receta->categoria_id) == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
            @error('categoria_id')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Imagen actual y opción para cambiarla -->
        <div class="mb-3">
            <label for="imagen" class="form-label">Imagen de la receta</label>
            
            @if($receta->imagen)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $receta->imagen) }}" alt="{{ $receta->titulo }}" 
                        class="img-thumbnail" style="max-height: 200px;">
                    <p class="text-muted">Imagen actual</p>
                </div>
            @endif
            
            <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
                id="imagen" name="imagen">
            <div class="form-text">Sube una nueva imagen si deseas cambiar la actual.</div>
            
            @error('imagen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Ingredientes -->
        <div class="mb-3">
            <label class="form-label">Ingredientes</label>
            <div id="ingredientes-container">
                @foreach($receta->ingredientes as $ingrediente)
                <div class="row mb-2">
                    <div class="col-md-4">
                        <input type="text" name="ingredientes[]" class="form-control" 
                            value="{{ $ingrediente->nombre }}" placeholder="Nombre del ingrediente">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="cantidades[]" class="form-control" 
                            value="{{ $ingrediente->pivot->cantidad }}" placeholder="Cantidad">
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="unidades[]" class="form-control" 
                            value="{{ $ingrediente->pivot->unidad ?? '' }}" placeholder="Unidad (g, ml, tazas...)">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-ingrediente">X</button>
                    </div>
                </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-ingrediente">
                Agregar Ingrediente
            </button>
        </div>

        <!-- Instrucciones/Pasos -->
        <div class="mb-3">
            <label class="form-label">Instrucciones</label>
            <div id="pasos-container">
                @forelse($receta->pasos->sortBy('orden') as $paso)
                    <div class="row mb-2">
                        <div class="col-md-1">
                            <span class="fw-bold">{{ $paso->orden }}.</span>
                        </div>
                        <div class="col-md-10">
                            <textarea name="pasos[]" class="form-control" rows="2">{{ $paso->descripcion }}</textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-paso">X</button>
                        </div>
                    </div>
                @empty
                    <div class="row mb-2">
                        <div class="col-md-1">
                            <span class="fw-bold">1.</span>
                        </div>
                        <div class="col-md-10">
                            <textarea name="pasos[]" class="form-control" rows="2" placeholder="Describe este paso"></textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-paso">X</button>
                        </div>
                    </div>
                @endforelse
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-paso">
                Agregar Paso
            </button>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar Receta</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Script para los pasos (ya existente)
        document.getElementById('add-paso').addEventListener('click', function() {
            const container = document.getElementById('pasos-container');
            const pasoCount = container.children.length + 1;
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2';
            newRow.innerHTML = `
                <div class="col-md-1">
                    <span class="fw-bold">${pasoCount}.</span>
                </div>
                <div class="col-md-10">
                    <textarea name="pasos[]" class="form-control" rows="2" placeholder="Describe este paso"></textarea>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-paso">X</button>
                </div>
            `;
            container.appendChild(newRow);
            actualizarNumerosOrden();
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-paso')) {
                const container = document.getElementById('pasos-container');
                if (container.children.length > 1) {
                    e.target.closest('.row').remove();
                    actualizarNumerosOrden();
                }
            }
        });

        function actualizarNumerosOrden() {
            const container = document.getElementById('pasos-container');
            const filas = container.children;
            for (let i = 0; i < filas.length; i++) {
                filas[i].querySelector('.fw-bold').textContent = (i + 1) + '.';
            }
        }

        // Script para los ingredientes (nuevo)
        document.getElementById('add-ingrediente').addEventListener('click', function() {
        const container = document.getElementById('ingredientes-container');
        const newRow = document.createElement('div');
        newRow.className = 'row mb-2';
        newRow.innerHTML = `
            <div class="col-md-4">
                <input type="text" name="ingredientes[]" class="form-control" placeholder="Nombre del ingrediente">
            </div>
            <div class="col-md-3">
                <input type="text" name="cantidades[]" class="form-control" placeholder="Cantidad">
            </div>
            <div class="col-md-3">
                <input type="text" name="unidades[]" class="form-control" placeholder="Unidad (g, ml, tazas...)">
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger btn-sm remove-ingrediente">X</button>
            </div>
        `;
        container.appendChild(newRow);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-ingrediente')) {
                const container = document.getElementById('ingredientes-container');
                if (container.children.length > 1) {
                    e.target.closest('.row').remove();
                }
            }
        });
    </script>
</body>
</html>