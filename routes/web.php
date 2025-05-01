<?php
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\ColeccionController;
use App\Http\Controllers\RecetaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ConsultasController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\IngredienteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
require __DIR__.'/auth.php';

//Welcome
Route::get('/', [LoginController::class, 'welcome'])->name('welcome');

// Página principal
Route::get('/home', [RecetaController::class, 'index'])->name('home');

// Búsqueda
Route::get('/buscar', [RecetaController::class, 'search'])->name('recetas.search');

// Rutas de autenticación (generadas por Laravel Breeze)
// Autenticación
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/signIn', [LoginController::class, 'showRegisterForm'])->name('signIn');
Route::post('/signIn', [LoginController::class, 'register'])->name('signIn.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout'); 


//Recetas 
Route::get('/recetas/nueva', [RecetaController::class, 'create'])->name('recetas.create');
Route::post('/recetas', [RecetaController::class, 'store'])->name('recetas.store')->middleware('auth');
Route::get('/recetas/{receta}', [RecetaController::class, 'show'])->name('recetas.show');
Route::get('/recetas/{receta}/editar', [RecetaController::class, 'edit'])->name('recetas.edit');
Route::put('/recetas/{receta}', [RecetaController::class, 'update'])->name('recetas.update');
Route::delete('/recetas/{receta}', [RecetaController::class, 'destroy'])->name('recetas.destroy');
Route::post('/recetas/{receta}/favorito', [RecetaController::class, 'favorite'])->name('recetas.favorite')->middleware('auth');
Route::post('/recetas/{receta}/valorar', [RecetaController::class, 'rate'])->name('recetas.rate')->middleware('auth');

//Ingredientes
Route::get('/ingredientes/{ingrediente}', [IngredienteController::class, 'show'])->name('ingredientes.show');


// Comentarios
Route::post('/recetas/{receta}/comentarios', [ComentarioController::class, 'store'])->name('comentarios.store')->middleware('auth');
Route::put('/comentarios/{comentario}', [ComentarioController::class, 'update'])->name('comentarios.update')->middleware('auth');
Route::delete('/comentarios/{comentario}', [ComentarioController::class, 'destroy'])->name('comentarios.destroy')->middleware('auth');

// Colecciones (Aún no está acabado)
Route::get('/colecciones', [ColeccionController::class, 'index'])->name('colecciones.index')->middleware('auth');
Route::get('/colecciones/crear', [ColeccionController::class, 'create'])->name('colecciones.create')->middleware('auth');
Route::post('/colecciones', [ColeccionController::class, 'store'])->name('colecciones.store')->middleware('auth');
Route::get('/colecciones/{coleccion}', [ColeccionController::class, 'show'])->name('colecciones.show')->middleware('auth');
Route::get('/colecciones/{coleccion}/editar', [ColeccionController::class, 'edit'])->name('colecciones.edit')->middleware('auth');
Route::put('/colecciones/{coleccion}', [ColeccionController::class, 'update'])->name('colecciones.update')->middleware('auth');
Route::delete('/colecciones/{coleccion}', [ColeccionController::class, 'destroy'])->name('colecciones.destroy')->middleware('auth');
Route::post('/colecciones/{coleccion}/recetas', [ColeccionController::class, 'addReceta'])->name('colecciones.addReceta')->middleware('auth');
Route::delete('/colecciones/{coleccion}/recetas/{receta}', [ColeccionController::class, 'removeReceta'])->name('colecciones.removeReceta')->middleware('auth');

//Consultas
Route::get('/consultas', [ConsultasController::class, 'index'])->name('consultas.index')->middleware('auth');
Route::get('/consultas/recetas-fecha', [ConsultasController::class, 'recetasPorFecha'])->name('consultas.recetas-fecha')->middleware('auth');
Route::get('/consultas/recetas-ingredientes', [ConsultasController::class, 'recetasPorIngredientes'])->name('consultas.recetas-ingredientes')->middleware('auth');
Route::get('/consultas/recetas-por-ingredientes', [ConsultasController::class, 'buscarPorIngredientes'])->name('consultas.recetas-por-ingredientes')->middleware('auth');
Route::get('/consultas/usuarios-activos', [ConsultasController::class, 'usuariosActivos'])->name('consultas.usuarios-activos')->middleware('auth');
Route::get('/consultas/ingredientes-populares', [ConsultasController::class, 'ingredientesPopulares'])->name('consultas.ingredientes-populares')->middleware('auth');

// Usuarios (Aún no está acabado)
Route::get('/usuarios/{user}', [UserController::class, 'show'])->name('users.show');
Route::get('/perfil/editar', [UserController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::put('/perfil', [UserController::class, 'update'])->name('profile.update')->middleware('auth');
Route::put('/perfil/password', [UserController::class, 'updatePassword'])->name('profile.updatePassword')->middleware('auth');
Route::post('/usuarios/{user}/seguir', [UserController::class, 'toggleFollow'])->name('users.toggleFollow')->middleware('auth');
Route::get('/usuarios/{user}/seguidores', [UserController::class, 'followers'])->name('users.followers');
Route::get('/usuarios/{user}/siguiendo', [UserController::class, 'following'])->name('users.following');
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout');
