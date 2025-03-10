<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CursoController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();

        if ($usuario->hasRole('admin')) {
            // Administrador ve todos los cursos
            $cursos = Curso::all();
        } elseif ($usuario->hasRole('profesor')) {
            // Profesor ve solo sus cursos
            $cursos = Curso::where('profesor', $usuario->id)->get();
        } elseif ($usuario->hasRole('alumno')) {
            // Alumno ve solo los cursos en los que está inscrito
            $cursos = $usuario->cursos; // Asegúrate de tener la relación en el modelo User
        } else {
            // Si el usuario no tiene un rol válido, devolvemos una lista vacía
            $cursos = collect();
        }

        return view('cursos.index', compact('cursos'));
    }

    /**
     * Muestra el formulario para crear un nuevo curso.
     */
    public function create()
    {
        $usuario = auth()->user();
        // Verificar que el usuario es un profesor (suponiendo que hay un campo 'role')
        if (!$usuario->hasRole('profesor')) {
            abort(403, 'No tienes permiso para crear un curso.');
        }

        return view('cursos.create');
    }

    /**
     * Guarda un nuevo curso en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de datos
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        // Crear y guardar el curso
        $curso = new Curso();
        $curso->titulo = $request->titulo;
        $curso->descripcion = $request->descripcion;
        $curso->profesor= Auth::id();  // Asignar el profesor autenticado
        $curso->codigo = $request->codigo;

        $curso->save();

        return redirect()->route('cursos.index')->with('success', 'Curso creado correctamente.');
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
