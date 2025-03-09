<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Curso::create([
            'profesor' => 2,
            'titulo' => 'Programación de Servicios y Procesos',
            'descripcion' => 'Curso enfocado en la programación concurrente y la gestión de procesos en sistemas informáticos.',
            'codigo' => 'psp-2025',
        ]);

        Curso::create([
            'profesor' => 3,
            'titulo' => 'Sistemas de Gestión Empresarial',
            'descripcion' => 'Estudio de los sistemas ERP y otras herramientas de gestión empresarial para la optimización de procesos.',
            'codigo' => 'sge-2025',
        ]);

        Curso::create([
            'profesor' => 4,
            'titulo' => 'Programación Multimedia y Dispositivos Móviles',
            'descripcion' => 'Desarrollo de aplicaciones multimedia y para dispositivos móviles, incluyendo tecnologías Android e iOS.',
            'codigo' => 'pmdm-2025',
        ]);

        Curso::create([
            'profesor' => 5,
            'titulo' => 'Acceso a Datos',
            'descripcion' => 'Gestión y manipulación de bases de datos relacionales y no relacionales en aplicaciones informáticas.',
            'codigo' => 'ad-2025',
        ]);

        Curso::create([
            'profesor' => 6,
            'titulo' => 'Desarrollo de Interfaces',
            'descripcion' => 'Diseño y desarrollo de interfaces gráficas de usuario (GUI) aplicando principios de usabilidad y accesibilidad.',
            'codigo' => 'di-2025',
        ]);
    }
}
