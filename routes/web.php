<?php

use App\Http\Controllers\AmigoController;
use App\Http\Controllers\CursoController;
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
});

Route::get('about', function () {
    return view("about.index");
});

Route::get('borrarusuario/{id}', [UsuarioController::class, "destroy"])->name("borrarusu");
Route::get('cambiarrol/{id}', [UsuarioController::class, "cambiarRol"])->name("cambiarrol");



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
Route::resource('rubricas', RubricaController::class)->middleware('auth');
Route::get('/usuarios/{tipo}', [UsuarioController::class, 'index'])->name('usuarios.index');
Route::get('/cursos', [CursoController::class, 'index'])->name('cursos.index');
Route::get('/curso/{id}', [CursoController::class, 'show'])->name('cursos.show');
Route::get('/cursos/{id}/participantes', [CursoController::class, 'participantes'])->name('cursos.participantes');
Route::delete('/cursos/{curso}/participantes/{participante}', [CursoController::class, 'removeParticipante'])->name('cursos.remove_participante');
Route::get('/cursos/{curso}/sobre', [CursoController::class, 'mostrarSobreCurso'])->name('cursos.sobre');
