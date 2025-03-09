<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        // Obtener todos los cursos disponibles
        $cursos = Curso::all(); // O puedes usar otro tipo de consulta si prefieres, como `Curso::where('activo', 1)->get();`

        return view('cursos.index', compact('cursos')); // Pasamos los cursos a la vista
    }
}
