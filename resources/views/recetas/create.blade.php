<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RealFoodie-Crear Receta</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
         body {
            background-image: url('/images/crear_receta.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
        }
        
        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            border-radius: 10px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        
        .form-label {
            font-weight: bold;
        }

        .is-invalid {
            border-color: #dc3545 !important;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25) !important;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.875em;
        }
    </style>
</head>
<body>
    @include('header')

    <div class="container">
        <div class="form-container">
            <h1 class="mb-4">Crear Nueva Receta</h1>

            @if (session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger mt-3">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('recetas.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Título -->
                <div class="mb-3">
                    <label for="titulo" class="form-label">Título</label>
                    <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                        id="titulo" name="titulo" value="{{ old('titulo') }}" required maxlength="255">
                    @error('titulo')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Descripción -->
                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                            id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion') }}</textarea>
                    @error('descripcion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

               <!-- Tiempo de preparación -->
                <div class="mb-3">
                    <label for="preparacion" class="form-label">Tiempo de Preparación (minutos)</label>
                    <input type="number" class="form-control @error('preparacion') is-invalid @enderror"
                        id="preparacion" name="preparacion" value="{{ old('preparacion') }}" 
                        required min="1" max="1440">
                    @error('preparacion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tiempo de cocción -->
                <div class="mb-3">
                    <label for="coccion" class="form-label">Tiempo de Cocción (minutos)</label>
                    <input type="number" class="form-control @error('coccion') is-invalid @enderror"
                        id="coccion" name="coccion" value="{{ old('coccion') }}" 
                        required min="0" max="1440">
                    @error('coccion')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Dificultad -->
                <div class="mb-3">
                    <label for="dificultad" class="form-label">Dificultad</label>
                    <select class="form-control @error('dificultad') is-invalid @enderror" id="dificultad" name="dificultad" required>
                        <option value="">Seleccione dificultad</option>
                        <option value="Fácil" {{ old('dificultad') == 'Fácil' ? 'selected' : '' }}>Fácil</option>
                        <option value="Media" {{ old('dificultad') == 'Media' ? 'selected' : '' }}>Media</option>
                        <option value="Difícil" {{ old('dificultad') == 'Difícil' ? 'selected' : '' }}>Difícil</option>
                    </select>
                    @error('dificultad')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Porciones -->
                <div class="mb-3">
                    <label for="porciones" class="form-label">Número de Porciones</label>
                    <input type="number" class="form-control @error('porciones') is-invalid @enderror"
                        id="porciones" name="porciones" value="{{ old('porciones') }}" 
                        required min="1">
                    @error('porciones')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Categoría -->
                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoría</label>
                    <select class="form-control @error('categoria_id') is-invalid @enderror" id="categoria_id" name="categoria_id" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria)
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                    @error('categoria_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                 <!-- Imagen de la receta -->
                <div class="mb-3">
                    <label for="imagen" class="form-label">Imagen de la receta</label>
                    <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
                        id="imagen" name="imagen" accept="image/jpeg,image/png,image/jpg,image/gif">
                    <div class="form-text">Sube una imagen representativa de tu receta (opcional). Máximo 2MB.</div>
                    @error('imagen')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Ingredientes -->
                <div class="mb-3">
                    <label class="form-label">Ingredientes</label>
                    @error('ingredientes')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    @error('cantidades')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div id="ingredientes-container">
                        @if(old('ingredientes'))
                            @foreach(old('ingredientes') as $index => $ingrediente)
                                <div class="row mb-2">
                                    <div class="col-md-4">
                                        <input type="text" name="ingredientes[]" class="form-control" 
                                               placeholder="Nombre del ingrediente" 
                                               value="{{ $ingrediente }}" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="number" name="cantidades[]" class="form-control" 
                                               placeholder="Cantidad" 
                                               value="{{ old('cantidades')[$index] ?? '' }}" 
                                               step="0.01" min="0.01" required>
                                    </div>
                                    <div class="col-md-3">
                                        <input type="text" name="unidades[]" class="form-control" 
                                               placeholder="Unidad (g, ml, tazas...)" 
                                               value="{{ old('unidades')[$index] ?? '' }}" maxlength="20">
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-danger btn-sm remove-ingrediente">X</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row mb-2">
                                <div class="col-md-4">
                                    <input type="text" name="ingredientes[]" class="form-control" 
                                           placeholder="Nombre del ingrediente" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="number" name="cantidades[]" class="form-control" 
                                           placeholder="Cantidad" step="0.01" min="0.01" required>
                                </div>
                                <div class="col-md-3">
                                    <input type="text" name="unidades[]" class="form-control" 
                                           placeholder="Unidad (g, ml, tazas...)" maxlength="20">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-ingrediente">X</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-ingrediente">
                        Agregar Ingrediente
                    </button>
                </div>

                <!-- Pasos -->
                <div class="mb-3">
                    <label class="form-label">Pasos</label>
                    @error('pasos')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                    <div id="pasos-container">
                        @if(old('pasos'))
                            @foreach(old('pasos') as $paso)
                                <div class="row mb-2">
                                    <div class="col-md-11">
                                        <input type="text" name="pasos[]" class="form-control" 
                                               placeholder="Descripción del paso" 
                                               value="{{ $paso }}" required maxlength="500">
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm remove-paso">X</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="row mb-2">
                                <div class="col-md-11">
                                    <input type="text" name="pasos[]" class="form-control" 
                                           placeholder="Descripción del paso" required maxlength="500">
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-danger btn-sm remove-paso">X</button>
                                </div>
                            </div>
                        @endif
                    </div>
                    <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-paso">
                        Agregar Paso
                    </button>
                </div>

                <button type="submit" class="btn btn-primary">Crear Receta</button>
                <a href="{{ route('home') }}" class="btn btn-secondary">Volver al listado</a>
            </form>
        </div>
    </div>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Función para crear un nuevo ingrediente
        function createIngredienteRow() {
            const div = document.createElement('div');
            div.className = 'row mb-2';
            div.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="ingredientes[]" class="form-control" 
                           placeholder="Nombre del ingrediente" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="cantidades[]" class="form-control" 
                           placeholder="Cantidad" step="0.01" min="0.01" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="unidades[]" class="form-control" 
                           placeholder="Unidad (g, ml, tazas...)" maxlength="20">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-ingrediente">X</button>
                </div>
            `;
            return div;
        }

        // Función para crear un nuevo paso
        function createPasoRow() {
            const div = document.createElement('div');
            div.className = 'row mb-2';
            div.innerHTML = `
                <div class="col-md-11">
                    <input type="text" name="pasos[]" class="form-control" 
                           placeholder="Descripción del paso" required maxlength="500">
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-paso">X</button>
                </div>
            `;
            return div;
        }

        // Añadir Ingrediente
        document.getElementById('add-ingrediente').addEventListener('click', function() {
            const container = document.getElementById('ingredientes-container');
            const newRow = createIngredienteRow();
            container.appendChild(newRow);
        });

        // Retirar Ingrediente
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-ingrediente')) {
                const container = document.getElementById('ingredientes-container');
                if (container.children.length > 1) {
                    e.target.closest('.row').remove();
                }
            }
        });

        // Añadir Paso
        document.getElementById('add-paso').addEventListener('click', function() {
            const container = document.getElementById('pasos-container');
            const newRow = createPasoRow();
            container.appendChild(newRow);
        });

        // Eliminar paso
        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-paso')) {
                const container = document.getElementById('pasos-container');
                if (container.children.length > 1) {
                    e.target.closest('.row').remove();
                }
            }
        });

        // Validación de cantidad en tiempo real
        document.addEventListener('input', function(e) {
            if (e.target.name === 'cantidades[]') {
                const value = parseFloat(e.target.value);
                if (value <= 0 && e.target.value !== '') {
                    e.target.setCustomValidity('La cantidad debe ser mayor a 0');
                } else {
                    e.target.setCustomValidity('');
                }
            }
        });

        // Validación antes de enviar el formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const ingredientes = document.querySelectorAll('input[name="ingredientes[]"]');
            const cantidades = document.querySelectorAll('input[name="cantidades[]"]');
            let valid = true;

            // Verificar que haya al menos un ingrediente
            if (ingredientes.length === 0) {
                alert('Debe agregar al menos un ingrediente');
                e.preventDefault();
                return;
            }

            // Verificar que todos los ingredientes tengan nombre y cantidad válida
            for (let i = 0; i < ingredientes.length; i++) {
                const nombreIngrediente = ingredientes[i].value.trim();
                const cantidadIngrediente = parseFloat(cantidades[i].value);
                
                if (nombreIngrediente === '' || isNaN(cantidadIngrediente) || cantidadIngrediente <= 0) {
                    alert('Todos los ingredientes deben tener nombre y una cantidad mayor a 0');
                    valid = false;
                    break;
                }
            }

            // Verificar que haya al menos un paso
            const pasos = document.querySelectorAll('input[name="pasos[]"]');
            if (pasos.length === 0) {
                alert('Debe agregar al menos un paso');
                valid = false;
            } else {
                // Verificar que todos los pasos tengan contenido
                for (let i = 0; i < pasos.length; i++) {
                    if (pasos[i].value.trim() === '') {
                        alert('Todos los pasos deben tener una descripción');
                        valid = false;
                        break;
                    }
                }
            }

            if (!valid) {
                e.preventDefault();
            }
        });
    </script>
</body>
</html>
