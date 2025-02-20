<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleProfesor = Role::create(['name' => 'profesor']);
        $roleAlumno = Role::create(['name' => 'alumno']);

        User::create([
            'name' => 'profe',
            'email' => "admin@a.a",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
            ]
        )->assignRole($roleProfesor);

        $usuariosProfesores = User::factory(4)->create();
        $usuariosAlumnos = User::factory(50)->create();


        foreach($usuariosProfesores as $profesor) {
            $profesor->assignRole($roleProfesor);
        }
        foreach($usuariosAlumnos as $alumno) {
            $alumno->assignRole($roleAlumno);
        }



    }
}
