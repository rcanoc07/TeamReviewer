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
        $roleAdmin = Role::create(['name' => 'admin']);
        $roleProfesor = Role::create(['name' => 'profesor']);
        $roleAlumno = Role::create(['name' => 'alumno']);

        User::create([
            'name' => 'Administrador',
            'email' => "admin@a.a",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ])->assignRole($roleAdmin);

        User::create([
            'name' => 'Jesús',
            'email' => "jesus@p.p",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ])->assignRole($roleProfesor);

        User::create([
            'name' => 'Ángel',
            'email' => "angel@p.p",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ])->assignRole($roleProfesor);

        User::create([
            'name' => 'Antonio',
            'email' => "antonio@p.p",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ])->assignRole($roleProfesor);

        User::create([
            'name' => 'Nacho',
            'email' => "nacho@p.p",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ])->assignRole($roleProfesor);

        User::create([
            'name' => 'Chema',
            'email' => "chema@p.p",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ])->assignRole($roleProfesor);

        $usuariosAlumnos = User::factory(15)->create();

        foreach($usuariosAlumnos as $alumno) {
            $alumno->assignRole($roleAlumno);
        }
    }
}
