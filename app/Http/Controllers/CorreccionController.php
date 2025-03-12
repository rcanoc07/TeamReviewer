<?php

namespace App\Http\Controllers;

use App\Models\Correccion;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class CorreccionController extends Controller
{

    public function obtenerCorreccionesAlumno($cursoId)
    {
        // Validar que el usuario esté autenticado
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'error' => 'No autenticado.',
            ], 401);
        }

        // Obtener el usuario autenticado
        $user = Auth::user();

        // Verificar que el usuario tenga el rol de "alumno"
        if (!$user->hasRole('alumno')) {
            return response()->json([
                'success' => false,
                'error' => 'Acceso denegado. Solo los alumnos pueden ver correcciones.',
            ], 403);
        }

        // Verificar que el curso exista
        $curso = Curso::find($cursoId);
        if (!$curso) {
            return response()->json([
                'success' => false,
                'error' => 'El curso no existe.',
            ], 404);
        }

        // Verificar que el alumno esté inscrito en el curso
        if (!$curso->participantes->contains($user->id)) {
            return response()->json([
                'success' => false,
                'error' => 'No estás inscrito en este curso.',
            ], 403);
        }

        // Obtener las correcciones del alumno en el curso específico
        $correcciones = Correccion::where('alumno_id', $user->id)
            ->where('curso_id', $cursoId)
            ->get();

        return response()->json([
            'success' => true,
            'correcciones' => $correcciones,
        ]);
    }
}
