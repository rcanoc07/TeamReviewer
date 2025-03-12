<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respuesta extends Model
{
    use HasFactory;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'rubrica_id',
        'alumno_id',
        'respuestas',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'respuestas' => 'json',
    ];

    /**
     * Obtener la rúbrica asociada a la respuesta.
     */
    public function rubrica()
    {
        return $this->belongsTo(Rubrica::class);
    }

    /**
     * Obtener el alumno que realizó la respuesta.
     */
    public function alumno()
    {
        return $this->belongsTo(User::class, 'alumno_id');
    }

    public function correcciones()
    {
        return $this->hasMany(Correccion::class);
    }
}
