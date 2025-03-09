<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;

class CursoController extends Controller
{
    public function index()
    {
        // Obtener todos los cursos disponibles
        $cursos = Curso::all(); // O puedes usar otro tipo de consulta si prefieres, como `Curso::where('activo', 1)->get();`

        return view('cursos.index', compact('cursos')); // Pasamos los cursos a la vista
    }

    public function show($id)
    {
        // Obtener el curso por su ID
        $curso = Curso::findOrFail($id);

        // Pasar los detalles del curso a la vista
        return view('cursos.show', compact('curso'));
    }

    public function participantes($id)
    {
        // Obtener el curso por ID
        $curso = Curso::findOrFail($id);

        // Obtener los participantes (usuarios) del curso
        $participantes = $curso->participantes;

        return view('cursos.participantes', compact('curso', 'participantes'));
    }

    public function removeParticipante($cursoId, $participanteId)
    {
        $curso = Curso::findOrFail($cursoId);
        $participante = User::findOrFail($participanteId);

        // Eliminar la relación entre el curso y el usuario
        $curso->participantes()->detach($participanteId);

        // Redirigir de vuelta con un mensaje de éxito
        return redirect()->route('cursos.participantes', $cursoId)
            ->with('success', 'Participante eliminado del curso.');
    }

    public function mostrarSobreCurso($cursoId)
    {
        $curso = Curso::findOrFail($cursoId);
        return view('cursos.sobre', compact('curso'));
    }











}
