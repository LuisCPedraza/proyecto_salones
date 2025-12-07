<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario admin
        \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'admin@salones.local',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'status' => 'active',
        ]);

        // Usuario coordinador
        \App\Models\User::create([
            'name' => 'Juan Coordinador',
            'email' => 'coordinador@salones.local',
            'password' => bcrypt('coordinador123'),
            'role' => 'coordinador',
            'status' => 'active',
        ]);

        // Usuario profesor
        \App\Models\User::create([
            'name' => 'María Profesor',
            'email' => 'profesor@salones.local',
            'password' => bcrypt('profesor123'),
            'role' => 'profesor',
            'status' => 'active',
        ]);
    }
}
