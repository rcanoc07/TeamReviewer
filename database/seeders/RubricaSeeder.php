<?php

namespace Database\Seeders;

use App\Models\Rubrica;
use App\Models\Curso;
use Illuminate\Database\Seeder;

class RubricaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Obtener todos los cursos
        $cursos = Curso::all();

        // Crear una rúbrica sencilla para cada curso
        foreach ($cursos as $curso) {
            Rubrica::create([
                'codigo' => 'RUB-' . $curso->id,
                'curso_id' => $curso->id,
                'titulo' => 'Rúbrica de Evaluación para ' . $curso->titulo,
                'descripcion' => 'Rúbrica básica para evaluar el curso ' . $curso->titulo,
                'claridad' => true,
                'comentario' => true,
                'num_preguntas' => 3,
                'preguntas' => json_encode([
                    [
                        'pregunta' => '¿El contenido del curso fue claro?',
                        'puntuacion' => 5,
                    ],
                    [
                        'pregunta' => '¿Los ejercicios fueron útiles?',
                        'puntuacion' => 5,
                    ],
                    [
                        'pregunta' => '¿Recomendarías este curso?',
                        'puntuacion' => 5,
                    ],
                ]),
            ]);
        }
    }
}
