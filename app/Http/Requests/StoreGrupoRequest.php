<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreGrupoRequest extends FormRequest
{
// protected $redirectRoute = 'post.create';
//ruta que puedes definir en alguno de los archivos de la carpeta routes/
// por si falla la validación

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'name' => ['required', Rule::unique('grupos')->ignore(request()->oldname, "name")],
            'importe' => 'required|decimal:0,2|min:0',
            'fechasorteo' => 'required|date',
            'fechaentregaregalos' => 'required|date',
            'comentario' => 'max:255'
        ];
    }

    public function messages()
    {
        return [
            'name.unique' => 'El :attribute ya existe, pon otro nombre.',
            'name.required' => 'El :attribute es obligatorio',
            'importe.required' => 'Pon el :attribute aprox. del regalo',
            'importe.min' => 'El :attribute debe ser mínimo 0',
            'importe.decimal' => 'El :attribute debe ser una cantidad',
            'fechasorteo' => ':attribute debe ser una fecha',
            'fechaentregaregalos' => ':attribute debe ser una fecha',
            'comentario.max' => 'El :attribute debe ser como mucho de 255 caracteres',
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'nombre del grupo',
            'importe' => 'precio',
            'comentario' => 'rollo que sueltes',
            'fechasorteo' => 'fecha del sorteo',
            'fechaentregaregalos' => 'fecha de entrega del regalo'
        ];
    }

}

/**
 * Leer:
 * https://styde.net/como-trabajar-con-form-requests-en-laravel/
 * https://laravel.com/docs/9.x/validation
 */
