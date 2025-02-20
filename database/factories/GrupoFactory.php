<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grupo>
 */
class GrupoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            //
            'name' => fake()->slug(2),
            'importe' => fake()->randomFloat(2,1,15),
            'fechasorteo' => fake()->dateTimeBetween("2 day", "1 week"),
            'fechaentregaregalos' => fake()->dateTimeBetween("2 week", "2 month"),
            'fechasorteoreal' => null,
            'comentario' => fake()->paragraph(1),
            'codigoacceso' => fake()->bothify('????????'),
            'propietario_id' => $this->faker->randomElement(DB::table('users')->pluck('id')),
            'estado' => 0,

        ];
    }
}
