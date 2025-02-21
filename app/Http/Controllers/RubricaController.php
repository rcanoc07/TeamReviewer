<?php

namespace App\Http\Controllers;

use App\Models\Clase;
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
    public function create(Clase $clase)
    {
        return view('rubricas.create', compact('clase'));
    }



    /**
     * Guarda una nueva rúbrica en la base de datos.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|unique:rubricas',
            'titulo' => 'required',
            'descripcion' => 'required',
            'claridad' => 'required|boolean',
            'comentario' => 'required|boolean',
            'num_preguntas' => 'required|integer|min:1',
            'preguntas' => 'required|array',
            'clase_id' => 'required|exists:clases,id', // Validar que el clase_id existe
        ]);

        // Obtener el user_id del usuario autenticado
        $user_id = auth()->user()->id;

        // Crear la rubrica asociada a la clase y con el usuario autenticado
        $rubrica = Rubrica::create([
            'codigo' => $data['codigo'],
            'titulo' => $data['titulo'],
            'descripcion' => $data['descripcion'],
            'claridad' => $data['claridad'],
            'comentario' => $data['comentario'],
            'num_preguntas' => $data['num_preguntas'],
            'preguntas' => json_encode($data['preguntas']),
            'clase_id' => $data['clase_id'],  // Guardar la relación con la clase
            'user_id' => $user_id,  // Guardar el user_id del profesor
        ]);

        return redirect()->route('clases.show', $data['clase_id']);
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
    public function edit(Rubrica $rubrica, Clase $clase)
    {
        // Aquí puedes hacer lo que necesites, como cargar la rubrica
        // y asociarla a la clase
        return view('rubricas.edit', compact('rubrica', 'clase'));
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
