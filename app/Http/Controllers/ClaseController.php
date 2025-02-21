<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaseController extends Controller
{
    /**
     * Muestra la lista de clases del profesor autenticado.
     */
    public function index()
    {
        $clases = Auth::user()->clasesProfesor;
        return view('clases.index', compact('clases'));
    }

    /**
     * Muestra el formulario para crear una nueva clase.
     */
    public function create()
    {
        return view('clases.create');
    }

    /**
     * Muestra el formulario para editar una clase.
     */
    public function edit(Clase $clase)
    {
        if (Auth::id() !== $clase->profesor_id) {
            return redirect()->route('clases.index')->with('error', 'No tienes permisos para editar esta clase');
        }

        return view('clases.edit', compact('clase'));
    }

    /**
     * Actualiza el nombre de la clase en la base de datos.
     */
    public function update(Request $request, Clase $clase)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        if (Auth::id() !== $clase->profesor_id) {
            return redirect()->route('clases.index')->with('error', 'No tienes permisos para modificar esta clase');
        }

        $clase->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('clases.show', $clase)->with('success', 'Clase actualizada correctamente');
    }


    /**
     * Guarda una nueva clase en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        if (!Auth::user()->hasRole('profesor')) {
            return redirect()->route('clases.index')->with('error', 'No tienes permisos para crear una clase');
        }

        Clase::create([
            'nombre' => $request->nombre,
            'profesor_id' => Auth::id(),
        ]);

        return redirect()->route('clases.index')->with('success', 'Clase creada correctamente');
    }

    /**
     * Muestra los detalles de una clase.
     */
    public function show(Clase $clase)
    {
        $user = Auth::user();

        if ($user->id !== $clase->profesor_id && !$clase->alumnos->contains($user->id)) {
            return redirect()->route('clases.index')->with('error', 'No tienes acceso a esta clase');
        }
        // Cargar la relación de alumnos
        $alumnos = $clase->alumnos;
        $rubricas = $clase->rubricas();

        return view('clases.show', compact('clase', 'alumnos','rubricas'));
    }

    /**
     * Permite que un alumno se una a una clase.
     */
    public function join(Clase $clase)
    {
        $user = Auth::user();

        if (!$user->hasRole('alumno')) {
            return redirect()->route('clases.show', $clase)->with('error', 'Solo los alumnos pueden unirse a clases');
        }

        $clase->alumnos()->syncWithoutDetaching([$user->id]);

        return redirect()->route('clases.show', $clase)->with('success', 'Te has unido a la clase correctamente');
    }

    /**
     * Elimina una clase (solo el profesor puede hacerlo).
     */
    public function destroy(Clase $clase)
    {
        if (Auth::id() !== $clase->profesor_id) {
            return redirect()->route('clases.index')->with('error', 'No tienes permisos para eliminar esta clase');
        }

        $clase->delete();
        return redirect()->route('clases.index')->with('success', 'Clase eliminada correctamente');
    }
}
