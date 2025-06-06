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
            background-color: #f5f5f5;
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

        .image-preview {
            max-height: 200px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            margin-top: 10px;
        }

        .preview-container {
            display: none;
        }
    </style>
</head>
<body>
    @include('header')

<div class="container_form">
    <h1 class="mb-4">Editar Receta</h1>
    <form action="{{ route('recetas.update', $receta) }}" method="POST" enctype="multipart/form-data" id="receta-form">
        @csrf
        @method('PUT')

        <!-- Título -->
        <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control @error('titulo') is-invalid @enderror" 
                   id="titulo" name="titulo" value="{{ old('titulo', $receta->titulo) }}" required>
            @error('titulo')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Descripción -->
        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                      id="descripcion" name="descripcion" rows="3" required>{{ old('descripcion', $receta->descripcion) }}</textarea>
            @error('descripcion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tiempo de Preparación -->
        <div class="mb-3">
            <label for="preparacion" class="form-label">Tiempo de Preparación (minutos)</label>
            <input type="number" class="form-control @error('preparacion') is-invalid @enderror" 
                   id="preparacion" name="preparacion" value="{{ old('preparacion', $receta->preparacion) }}" 
                   min="1" max="1440" required>
            @error('preparacion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Tiempo de Cocción -->
        <div class="mb-3">
            <label for="coccion" class="form-label">Tiempo de Cocción (minutos)</label>
            <input type="number" class="form-control @error('coccion') is-invalid @enderror" 
                   id="coccion" name="coccion" value="{{ old('coccion', $receta->coccion) }}" 
                   min="0" max="1440" required>
            @error('coccion')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Dificultad -->
        <div class="mb-3">
            <label for="dificultad" class="form-label">Dificultad</label>
            <select class="form-control @error('dificultad') is-invalid @enderror" 
                    id="dificultad" name="dificultad" required>
                <option value="">Selecciona la dificultad</option>
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
                   id="porciones" name="porciones" value="{{ old('porciones', $receta->porciones) }}" 
                   min="1" required>
            @error('porciones')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Categoría -->
        <div class="mb-3">
            <label for="categoria_id" class="form-label">Categoría</label>
            <select class="form-control @error('categoria_id') is-invalid @enderror" 
                    id="categoria_id" name="categoria_id" required>
                <option value="">Selecciona una categoría</option>
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
                    <img src="{{ asset($receta->imagen) }}" alt="{{ $receta->titulo }}" 
                        class="img-thumbnail image-preview" id="current-image">
                    <p class="text-muted">Imagen actual</p>
                </div>
            @endif
            
            <input type="file" class="form-control @error('imagen') is-invalid @enderror" 
                id="imagen" name="imagen" accept="image/*">
            <div class="form-text">Sube una nueva imagen si deseas cambiar la actual. Formatos permitidos: JPG, PNG, GIF (máx. 2MB)</div>
            
            <!-- Preview de nueva imagen -->
            <div class="preview-container" id="preview-container">
                <p class="text-success mt-2">Nueva imagen seleccionada:</p>
                <img id="image-preview" class="img-thumbnail image-preview" alt="Preview">
            </div>
            
            @error('imagen')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Ingredientes -->
        <div class="mb-3">
            <label class="form-label">Ingredientes <span class="text-danger">*</span></label>
            <div class="form-text mb-2">Debe tener al menos un ingrediente</div>
            <div id="ingredientes-container">
                @forelse($receta->ingredientes as $index => $ingrediente)
                <div class="row mb-2 ingrediente-row">
                    <div class="col-md-4">
                        <input type="text" name="ingredientes[]" class="form-control ingrediente-input" 
                            value="{{ $ingrediente->nombre }}" placeholder="Nombre del ingrediente" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="cantidades[]" class="form-control cantidad-input" 
                            value="{{ $ingrediente->pivot->cantidad }}" placeholder="Cantidad" 
                            step="0.01" min="0.01" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="unidades[]" class="form-control" 
                            value="{{ $ingrediente->pivot->unidad ?? '' }}" placeholder="Unidad (g, ml, tazas...)" maxlength="20">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-ingrediente" 
                                title="Eliminar ingrediente">X</button>
                    </div>
                </div>
                @empty
                <div class="row mb-2 ingrediente-row">
                    <div class="col-md-4">
                        <input type="text" name="ingredientes[]" class="form-control ingrediente-input" 
                            placeholder="Nombre del ingrediente" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="cantidades[]" class="form-control cantidad-input" 
                            placeholder="Cantidad" step="0.01" min="0.01" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="unidades[]" class="form-control" 
                            placeholder="Unidad (g, ml, tazas...)" maxlength="20">
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-sm remove-ingrediente" 
                                title="Eliminar ingrediente">X</button>
                    </div>
                </div>
                @endforelse
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-ingrediente">
                + Agregar Ingrediente
            </button>
            <div class="invalid-feedback" id="ingredientes-error" style="display: none;">
                Debe agregar al menos un ingrediente válido.
            </div>
        </div>

        <!-- Instrucciones/Pasos -->
        <div class="mb-3">
            <label class="form-label">Instrucciones <span class="text-danger">*</span></label>
            <div class="form-text mb-2">Debe tener al menos un paso</div>
            <div id="pasos-container">
                @forelse($receta->pasos->sortBy('orden') as $paso)
                    <div class="row mb-2 paso-row">
                        <div class="col-md-1">
                            <span class="fw-bold step-number">{{ $paso->orden }}.</span>
                        </div>
                        <div class="col-md-10">
                            <textarea name="pasos[]" class="form-control paso-input" rows="2" 
                                    placeholder="Describe este paso" required>{{ $paso->descripcion }}</textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-paso" 
                                    title="Eliminar paso">X</button>
                        </div>
                    </div>
                @empty
                    <div class="row mb-2 paso-row">
                        <div class="col-md-1">
                            <span class="fw-bold step-number">1.</span>
                        </div>
                        <div class="col-md-10">
                            <textarea name="pasos[]" class="form-control paso-input" rows="2" 
                                    placeholder="Describe este paso" required></textarea>
                        </div>
                        <div class="col-md-1">
                            <button type="button" class="btn btn-danger btn-sm remove-paso" 
                                    title="Eliminar paso">X</button>
                        </div>
                    </div>
                @endforelse
            </div>
            <button type="button" class="btn btn-secondary btn-sm mt-2" id="add-paso">
                + Agregar Paso
            </button>
            <div class="invalid-feedback" id="pasos-error" style="display: none;">
                Debe agregar al menos un paso válido.
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Actualizar Receta</button>
            <a href="{{ route('recetas.show', $receta) }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Preview de imagen
        document.getElementById('imagen').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const previewContainer = document.getElementById('preview-container');
            const imagePreview = document.getElementById('image-preview');
            
            if (file) {
                // Validar tipo de archivo
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
                if (!validTypes.includes(file.type)) {
                    alert('Por favor selecciona un archivo de imagen válido (JPG, PNG, GIF)');
                    e.target.value = '';
                    previewContainer.style.display = 'none';
                    return;
                }
                
                // Validar tamaño (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('La imagen es demasiado grande. El tamaño máximo es 2MB.');
                    e.target.value = '';
                    previewContainer.style.display = 'none';
                    return;
                }
                
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    previewContainer.style.display = 'block';
                };
                reader.readAsDataURL(file);
            } else {
                previewContainer.style.display = 'none';
            }
        });

        // Funciones para ingredientes
        document.getElementById('add-ingrediente').addEventListener('click', function() {
            const container = document.getElementById('ingredientes-container');
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2 ingrediente-row';
            newRow.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="ingredientes[]" class="form-control ingrediente-input" 
                        placeholder="Nombre del ingrediente" required>
                </div>
                <div class="col-md-3">
                    <input type="number" name="cantidades[]" class="form-control cantidad-input" 
                        placeholder="Cantidad" step="0.01" min="0.01" required>
                </div>
                <div class="col-md-3">
                    <input type="text" name="unidades[]" class="form-control" 
                        placeholder="Unidad (g, ml, tazas...)" maxlength="20">
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-sm remove-ingrediente" 
                            title="Eliminar ingrediente">X</button>
                </div>
            `;
            container.appendChild(newRow);
        });

        document.addEventListener('click', function(e) {
            if (e.target.classList.contains('remove-ingrediente')) {
                const container = document.getElementById('ingredientes-container');
                if (container.children.length > 1) {
                    e.target.closest('.row').remove();
                } else {
                    alert('Debe mantener al menos un ingrediente');
                }
            }
        });

        // Funciones para pasos
        document.getElementById('add-paso').addEventListener('click', function() {
            const container = document.getElementById('pasos-container');
            const pasoCount = container.children.length + 1;
            const newRow = document.createElement('div');
            newRow.className = 'row mb-2 paso-row';
            newRow.innerHTML = `
                <div class="col-md-1">
                    <span class="fw-bold step-number">${pasoCount}.</span>
                </div>
                <div class="col-md-10">
                    <textarea name="pasos[]" class="form-control paso-input" rows="2" 
                            placeholder="Describe este paso" required></textarea>
                </div>
                <div class="col-md-1">
                    <button type="button" class="btn btn-danger btn-sm remove-paso" 
                            title="Eliminar paso">X</button>
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
                } else {
                    alert('Debe mantener al menos un paso');
                }
            }
        });

        function actualizarNumerosOrden() {
            const container = document.getElementById('pasos-container');
            const filas = container.children;
            for (let i = 0; i < filas.length; i++) {
                const stepNumber = filas[i].querySelector('.step-number');
                if (stepNumber) {
                    stepNumber.textContent = (i + 1) + '.';
                }
            }
        }

        // Validación antes de enviar el formulario
        document.getElementById('receta-form').addEventListener('submit', function(e) {
            let valid = true;
            
            // Validar ingredientes
            const ingredientesInputs = document.querySelectorAll('.ingrediente-input');
            const cantidadesInputs = document.querySelectorAll('.cantidad-input');
            let ingredientesValidos = 0;
            
            for (let i = 0; i < ingredientesInputs.length; i++) {
                const nombreIngrediente = ingredientesInputs[i].value.trim();
                const cantidad = cantidadesInputs[i].value.trim();
                
                if (nombreIngrediente && cantidad && parseFloat(cantidad) > 0) {
                    ingredientesValidos++;
                }
            }
            
            if (ingredientesValidos === 0) {
                document.getElementById('ingredientes-error').style.display = 'block';
                ingredientesInputs[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                valid = false;
            } else {
                document.getElementById('ingredientes-error').style.display = 'none';
            }
            
            // Validar pasos
            const pasosInputs = document.querySelectorAll('.paso-input');
            let pasosValidos = 0;
            
            pasosInputs.forEach(input => {
                if (input.value.trim()) {
                    pasosValidos++;
                }
            });
            
            if (pasosValidos === 0) {
                document.getElementById('pasos-error').style.display = 'block';
                pasosInputs[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                valid = false;
            } else {
                document.getElementById('pasos-error').style.display = 'none';
            }
            
            if (!valid) {
                e.preventDefault();
                alert('Por favor corrige los errores antes de continuar');
            }
        });

        // Validación en tiempo real para ingredientes
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('ingrediente-input') || e.target.classList.contains('cantidad-input')) {
                const ingredientesInputs = document.querySelectorAll('.ingrediente-input');
                const cantidadesInputs = document.querySelectorAll('.cantidad-input');
                let ingredientesValidos = 0;
                
                for (let i = 0; i < ingredientesInputs.length; i++) {
                    const nombreIngrediente = ingredientesInputs[i].value.trim();
                    const cantidad = cantidadesInputs[i].value.trim();
                    
                    if (nombreIngrediente && cantidad && parseFloat(cantidad) > 0) {
                        ingredientesValidos++;
                    }
                }
                
                if (ingredientesValidos > 0) {
                    document.getElementById('ingredientes-error').style.display = 'none';
                }
            }
        });

        // Validación en tiempo real para pasos
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('paso-input')) {
                const pasosInputs = document.querySelectorAll('.paso-input');
                let pasosValidos = 0;
                
                pasosInputs.forEach(input => {
                    if (input.value.trim()) {
                        pasosValidos++;
                    }
                });
                
                if (pasosValidos > 0) {
                    document.getElementById('pasos-error').style.display = 'none';
                }
            }
        });
    </script>
</body>
</html>
