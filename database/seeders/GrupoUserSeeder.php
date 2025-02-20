<?php

namespace Database\Seeders;

use App\Models\Grupo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GrupoUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $grupos = Grupo::all();
        foreach($grupos as $grupo) {
            $grupo->participantes()->attach($grupo->propietario_id);
        }

    }
}
