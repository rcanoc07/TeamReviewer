<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model {
    use HasFactory;

    protected $fillable = ['nombre', 'profesor_id'];

    public function profesor() {
        return $this->belongsTo(User::class, 'profesor_id')->where('role', 'profesor');
    }

     public function alumnos()
    {
        return $this->belongsToMany(User::class, 'clase_user', 'clase_id', 'user_id');
    }

    public function rubricas() {
        return $this->hasMany(Rubrica::class);
    }
}

