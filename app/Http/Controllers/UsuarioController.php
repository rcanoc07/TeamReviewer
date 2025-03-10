<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request, $tipo)
    {
        // Filtrar usuarios según el tipo (alumno o profesor)
        $search = $request->input('search'); // Obtener el valor de búsqueda
        $direction = $request->query('direction', 'asc'); // Obtener la dirección de orden (asc o desc)

        // Filtrar usuarios por rol y búsqueda
        $usuarios = User::when($tipo, function ($query) use ($tipo) {
            return $query->whereHas('roles', function ($query) use ($tipo) {
                $query->where('name', $tipo);  // Filtrar por el nombre del rol
            });
        })
            ->when($search, function ($query) use ($search) {
                return $query->where('name', 'like', '%' . $search . '%');  // Filtro por nombre
            })
            ->orderBy('name', $direction)  // Ordenar por nombre, ascendente o descendente
            ->get();

        return view('usuarios.index', compact('usuarios', 'tipo'));
    }




    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        //
        User::find($id)->delete();
        return back();
    }

    public function perfil()
    {
        return view('usuarios.perfil');
    }

    // Método para actualizar el perfil del usuario autenticado
    public function updatePerfil(Request $request)
    {
        // Validar los datos entrantes de manera condicional
        $validated = $request->validate([
            'name' => 'nullable|string|max:255', // Permitir nombre vacío si no se cambia
            'email' => 'nullable|email|max:255|unique:users,email,' . auth()->id(), // Permitir email vacío si no se cambia
        ]);

        $user = auth()->user();

        if ($request->filled('name')) {
            $user->name = $request->name;
        }

        if ($request->filled('email')) {
            $user->email = $request->email;
        }

        $user->save();

        return redirect()->route('perfil')->with('status', 'Perfil actualizado correctamente.');
    }


}
