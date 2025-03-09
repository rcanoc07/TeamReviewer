<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Curso extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Profesor que crea el curso
        'titulo',
        'descripcion',
        'codigo',
    ];

    // Relación con el profesor
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relación con las rúbricas (un curso puede tener muchas rúbricas)
    public function rubricas()
    {
        return $this->hasMany(Rubrica::class);
    }

    // Relación con los alumnos (muchos a muchos)
    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'curso_user');
    }
}
