<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rubrica extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'user_id',
        'clase_id', // Nueva columna
        'titulo',
        'descripcion',
        'claridad',
        'comentario',
        'num_preguntas',
        'preguntas'
    ];

    protected $casts = [
        'preguntas' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function clase()
    {
        return $this->belongsTo(Clase::class);
    }
}
