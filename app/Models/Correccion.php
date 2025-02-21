<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Correccion extends Model
{
    use HasFactory;

    protected $fillable = [
        'alumno_id',
        'rubrica_id',
        'puntuacion',
        'comentarios',
        'detalles_correccion',
    ];

    public function alumno()
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }

    public function rubrica()
    {
        return $this->belongsTo(Rubrica::class);
    }
}
