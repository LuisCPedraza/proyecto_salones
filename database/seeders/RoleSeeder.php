<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name' => 'admin', 'description' => 'Administrador del sistema'],
            ['name' => 'coordinador', 'description' => 'Coordinador académico'],
            ['name' => 'coordinador_infraestructura', 'description' => 'Coordinador de infraestructura'],
            ['name' => 'profesor', 'description' => 'Profesor'],
            ['name' => 'secretaria_administrativa', 'description' => 'Secretaria administrativa'],
            ['name' => 'secretaria_coordinacion', 'description' => 'Secretaria de coordinación'],
            ['name' => 'secretaria_infraestructura', 'description' => 'Secretaria de infraestructura'],
            ['name' => 'profesor_invitado', 'description' => 'Profesor invitado (acceso temporal)'],
        ];

        foreach ($roles as $role) {
            \App\Models\Role::create($role);
        }
    }
}
