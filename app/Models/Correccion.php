<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correccion extends Model
{
    use HasFactory;

    /**
     * Los atributos que son asignables en masa.
     *
     * @var array
     */

    protected $table = 'correcciones';
    protected $fillable = [
        'respuesta_id', // ID de la respuesta relacionada
        'evaluacion',   // Evaluación generada por la IA
        'nota',
    ];

    /**
     * Obtener la respuesta asociada con esta corrección.
     */
    public function respuesta()
    {
        return $this->belongsTo(Respuesta::class);
    }
}
