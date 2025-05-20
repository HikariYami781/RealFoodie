<?php
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ColeccionController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IngredienteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
require __DIR__.'/auth.php';

//Página Bienvenida
Route::get('/', [LoginController::class, 'welcome'])->name('welcome');

// Rutas de autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/register', [LoginController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [LoginController::class, 'register'])->name('register.post');

// Aplicamos 'auth' y 'prevent-back' a todas las rutas protegidas
Route::middleware(['auth', \App\Http\Middleware\PreventBackHistory::class])->group(function () {
    // Página principal
    Route::get('/home', [RecetaController::class, 'index'])->name('home');
    
    // Búsqueda
    Route::get('/buscar', [RecetaController::class, 'search'])->name('recetas.search');
    
    // Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
    
    //Recetas
    Route::get('/recetas', [RecetaController::class, 'index'])->name('recetas.index');
    Route::get('/recetas/nueva', [RecetaController::class, 'create'])->name('recetas.create');
    Route::post('/recetas', [RecetaController::class, 'store'])->name('recetas.store');
    Route::get('/recetas/{receta}', [RecetaController::class, 'show'])->name('recetas.show');
    Route::get('/recetas/{receta}/editar', [RecetaController::class, 'edit'])->name('recetas.edit');
    Route::put('/recetas/{receta}', [RecetaController::class, 'update'])->name('recetas.update');
    Route::delete('/recetas/{receta}', [RecetaController::class, 'destroy'])->name('recetas.destroy');
    Route::post('/recetas/{receta}/favorito', [RecetaController::class, 'favorite'])->name('recetas.favorite');
    Route::post('/recetas/{receta}/valorar', [RecetaController::class, 'rate'])->name('recetas.rate');
    
    // Ingredientes 
    Route::get('/ingredientes/{ingrediente}', [IngredienteController::class, 'show'])->name('ingredientes.show');
    
    // Comentarios
    Route::post('/recetas/{receta}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store');
    Route::put('/comentarios/{comentario}', [ComentarioController::class, 'update'])->name('comentarios.update');
    Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy');
    
    // Colecciones
    Route::get('/colecciones', [ColeccionController::class, 'index'])->name('colecciones.index');
    Route::get('/colecciones/crear', [ColeccionController::class, 'create'])->name('colecciones.create');
    Route::post('/colecciones', [ColeccionController::class, 'store'])->name('colecciones.store');
    Route::get('/colecciones/{coleccion}', [ColeccionController::class, 'show'])->name('colecciones.show');
    Route::get('/colecciones/{coleccion}/editar', [ColeccionController::class, 'edit'])->name('colecciones.edit');
    Route::put('/colecciones/{coleccion}', [ColeccionController::class, 'update'])->name('colecciones.update');
    Route::delete('/colecciones/{coleccion}', [ColeccionController::class, 'destroy'])->name('colecciones.destroy');
    Route::post('/colecciones/{coleccion}/recetas', [ColeccionController::class, 'addReceta'])->name('colecciones.addReceta');
    Route::delete('/colecciones/{coleccion}/recetas/{receta}', [ColeccionController::class, 'removeReceta'])->name('colecciones.removeReceta');
    
    //Consultas
    Route::get('/consultas', [ConsultasController::class, 'index'])->name('consultas.index');
    Route::get('/consultas/recetas-fecha', [ConsultasController::class, 'recetasPorFecha'])->name('consultas.recetas-fecha');
    Route::get('/consultas/recetas-ingredientes', [ConsultasController::class, 'recetasPorIngredientes'])->name('consultas.recetas-ingredientes');
    Route::get('/consultas/recetas-por-ingredientes', [ConsultasController::class, 'buscarPorIngredientes'])->name('consultas.recetas-por-ingredientes');
    Route::get('/consultas/usuarios-activos', [ConsultasController::class, 'usuariosActivos'])->name('consultas.usuarios-activos');
    Route::get('/consultas/ingredientes-populares', [ConsultasController::class, 'ingredientesPopulares'])->name('consultas.ingredientes-populares');
    
    // Usuarios
    Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');
    Route::post('/usuarios/{user}/seguir', [UserController::class, 'toggleFollow'])->name('users.toggleFollow');
    Route::get('/usuarios/{user}/seguidores', [UserController::class, 'followers'])->name('users.followers');
    Route::get('/usuarios/{user}/siguiendo', [UserController::class, 'following'])->name('users.following');
    
    //Perfil
    Route::get('/perfil', [ProfileController::class, 'show'])->name('profile.show');
    Route::put('/perfil', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/perfil/password', [ProfileController::class, 'updatePassword'])->name('profile.updatePassword');
    Route::delete('/perfil', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    /** Laravel a menudo configura /dashboard como la página predeterminada después del inicio de sesión 
     * (especialmente en versiones más recientes o cuando se usan los paquetes de autenticación de Laravel).*/ 
    Route::get('/dashboard', function () {
        return redirect()->route('home');
    })->name('dashboard');
});