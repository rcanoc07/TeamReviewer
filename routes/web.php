<?php

use App\Http\Controllers\AmigoController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\GrupoAmigoController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\RubricaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Models\Grupo;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SorteoController;
use App\Http\Controllers\IntromasivaController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    if (auth()->user()) {
        return view("home");
    } else {
        return view('welcome'); // Venía con welcome
    }
});

Auth::routes();


//Lista de Usuarios de ejemplo
// resources/views/usuarios/lista.blade.app
// https://laravel.com/docs/9.x/views
// Proteccion middleware
// https://spatie.be/docs/laravel-permission/v5/basic-usage/middleware
// Añadimos los 3 middleware en la variable $routeMiddleware del archivo app/Http/Kernel.php

Route::group(['middleware' => ['role:admin']], function () {
    Route::get("listausuarios", [UsuarioController::class, "index"])->name("usuariostodos");

    Route::get("listagrupos", function () {
        return view("grupos.todos", ["grupos" => Grupo::all()]);
    });
 });

Route::group(['middleware' => ['auth']], function (){
    Route::get('/home', [HomeController::class, 'index'])->name('home');
    Route::get("grupos/{grupoid}/sortear", [SorteoController::class, 'sortear'])->name("grupos.sortear");
    Route::get("grupos/{grupoid}/anularsorteo", [SorteoController::class, 'anularsorteo'])->name("grupos.anularsorteo");
    Route::resource("grupos", GrupoController::class);
    Route::resource('grupos.participantes',GrupoAmigoController::class);
    Route::resource("amigos", AmigoController::class);
});

Route::get('grupos/{grupoid}/intromasiva', [IntromasivaController::class,"intro"])->name("grupos.intromasiva");
Route::post('grupos/{grupoid}/store', [IntromasivaController::class, "store"])->name("grupos.storemasiva");

Route::get('about', function () {
    return view("about.index");
});

Route::get('borrarusuario/{id}', [UsuarioController::class, "destroy"])->name("borrarusu");
Route::get('cambiarrol/{id}', [UsuarioController::class, "cambiarRol"])->name("cambiarrol");



Route::get('exportarusuarios', [ExcelController::class, "ExportarUsuariosXLS"]);
Route::get('exportarpdf', [ExcelController::class, "ExportarPDF"]);



//**********************************************************************************************************//


// Ruta para mostrar el formulario de creación
Route::get('rubricas/create', [RubricaController::class, 'create'])->name('rubrica.create');

// Ruta para almacenar la rúbrica (POST)
Route::post('rubricas', [RubricaController::class, 'store'])->name('rubrica.store');



//Ejercicio
//Route::resource('ejercicio', EjercicioController::class);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//Route::post('/rubrica', [RubricaController::class, 'store'])->name('rubrica.store');


//Rubricas
// Ruta para crear rubrica asociada a una clase
Route::get('rubrica/create/{clase}', [RubricaController::class, 'create'])->name('rubricas.create');
Route::get('/rubrica/{rubrica}/edit/{clase}', [RubricaController::class, 'edit'])->name('rubricas.edit');
Route::resource('rubricas', RubricaController::class)->middleware('auth');



// ROLES

Route::post('/user/{id}/assign-role', [UsuarioController::class, 'assignRoleToUser']);



// CLASES
Route::middleware(['auth'])->group(function () {
    Route::get('/clases/{clase}/edit', [ClaseController::class, 'edit'])->name('clases.edit'); // Formulario de edición
    Route::put('/clases/{clase}', [ClaseController::class, 'update'])->name('clases.update'); // Actualizar clase

    Route::get('/clases', [ClaseController::class, 'index'])->name('clases.index'); // Lista de clases
    Route::get('/clases/create', [ClaseController::class, 'create'])->name('clases.create'); // Formulario para crear clase
    Route::post('/clases', [ClaseController::class, 'store'])->name('clases.store'); // Guardar nueva clase
    Route::get('/clases/{clase}', [ClaseController::class, 'show'])->name('clases.show'); // Ver una clase
    Route::post('/clases/{clase}/join', [ClaseController::class, 'join'])->name('clases.join'); // Unirse a una clase
    Route::delete('/clases/{clase}', [ClaseController::class, 'destroy'])->name('clases.destroy'); // Eliminar clase
});
