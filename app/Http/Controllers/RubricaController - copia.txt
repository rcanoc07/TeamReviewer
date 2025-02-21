<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rubrica;
use Illuminate\Support\Facades\Auth;

class RubricaController extends Controller
{
    /**
     * Muestra la lista de rúbricas.
     */
    public function index()
    {
        $rubricas = Rubrica::all();
        return view('rubricas.index', compact('rubricas'));
    }

    /**
     * Muestra el formulario para crear una nueva rúbrica.
     */
    public function create()
    {
        return view('rubricas.create');
    }

    /**
     * Guarda una nueva rúbrica en la base de datos.
     */
    public function store(Request $request)
    {
        // Validación de los datos
        $request->validate([
            'codigo' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'claridad' => 'required|boolean',
            'comentario' => 'required|boolean',
            'num_preguntas' => 'required|integer|min:1',
            'preguntas' => 'required|array|min:1',
            'preguntas.*.pregunta' => 'required|string',
            'preguntas.*.puntuacion' => 'required|integer|min:0',
        ]);

        // Recoger las preguntas en un formato adecuado
        $preguntas = $request->preguntas;

        // Crear una nueva rúbrica
        $rubrica = new Rubrica();
        $rubrica->user_id = Auth::id();
        $rubrica->codigo = $request->codigo;
        $rubrica->titulo = $request->titulo;
        $rubrica->descripcion = $request->descripcion;
        $rubrica->claridad = $request->claridad;
        $rubrica->comentario = $request->comentario;
        $rubrica->num_preguntas = $request->num_preguntas;
        $rubrica->preguntas = json_encode($preguntas);  // Almacenar preguntas como JSON
        $rubrica->save();  // Guardar la rúbrica en la base de datos

        // Redirigir al listado de rúbricas o mostrar un mensaje de éxito
        return redirect()->route('rubricas.index')->with('success', 'Rúbrica creada correctamente.');
    }



    /**
     * Muestra los detalles de una rúbrica específica.
     */
    public function show(Rubrica $rubrica)
    {
        return view('rubricas.show', compact('rubrica'));
    }

    /**
     * Muestra el formulario para editar una rúbrica.
     */
    public function edit($id)
    {
        $rubrica = Rubrica::findOrFail($id);
        return view('rubricas.edit', compact('rubrica'));
    }

    public function update(Request $request, $id)
    {
        // Validación de datos
        $request->validate([
            'codigo' => 'required|string|max:255',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'claridad' => 'required|boolean',
            'comentario' => 'required|boolean',
            'num_preguntas' => 'required|integer|min:1',
            'preguntas' => 'required|array',
        ]);

        // Encontrar la rúbrica que se quiere actualizar
        $rubrica = Rubrica::findOrFail($id);

        // Asignar los valores del formulario a la rúbrica
        $rubrica->codigo = $request->input('codigo');
        $rubrica->titulo = $request->input('titulo');
        $rubrica->descripcion = $request->input('descripcion');
        $rubrica->claridad = $request->input('claridad');
        $rubrica->comentario = $request->input('comentario');
        $rubrica->num_preguntas = $request->input('num_preguntas');
        $rubrica->preguntas = json_encode($request->input('preguntas'));

        // Guardar la rúbrica actualizada
        $rubrica->save();

        // Redirigir con mensaje de éxito
        return redirect()->route('rubricas.index')->with('success', 'Rúbrica actualizada correctamente');
    }

    /**
     * Elimina una rúbrica.
     */
    public function destroy(Rubrica $rubrica)
    {
        $rubrica->delete();
        return redirect()->route('rubricas.index')->with('success', 'Rúbrica eliminada.');
    }
}
