<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CursoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Obtiene todos los cursos
        $cursos = Curso::all();

        // Obtiene todos los alumnos (usuarios con rol 'alumno')
        $alumnos = User::whereHas('roles', function ($query) {
            $query->where('name', 'alumno');
        })->get();

        // Asigna 8 alumnos aleatorios a cada curso
        foreach ($cursos as $curso) {
            $alumnosRandom = $alumnos->random(min(8, $alumnos->count())); // Si hay menos de 8, toma los disponibles
            $curso->participantes()->attach($alumnosRandom->pluck('id'));
        }
    }
}
