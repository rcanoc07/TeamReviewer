<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrica extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'curso_id', // Relación con el curso
        'titulo',
        'descripcion',
        'claridad',
        'comentario',
        'num_preguntas',
        'preguntas',
    ];

    protected $casts = [
        'preguntas' => 'array',
    ];

    // Relación con el curso
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }
}
