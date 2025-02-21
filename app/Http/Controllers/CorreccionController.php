<?php

namespace App\Http\Controllers;

use App\Models\Correccion;
use Illuminate\Http\Request;

class CorreccionController extends Controller
{
    public function show($id)
    {
        $correccion = Correccion::findOrFail($id);
        return view('correcciones.show', compact('correccion'));
    }
}
