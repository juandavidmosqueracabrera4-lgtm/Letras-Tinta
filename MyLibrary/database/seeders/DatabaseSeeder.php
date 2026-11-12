<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use App\Models\Book;
use App\Models\Author;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles predeterminados
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $librarianRole = Role::firstOrCreate(['name' => 'bibliotecario']);
        $readerRole = Role::firstOrCreate(['name' => 'lector']);

        // Crear usuario de prueba con los nuevos campos 'document' y 'role_id'
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'document' => '1000000000',
                'name' => 'Test Admin',
                'password' => bcrypt('password'),
                'role_id' => $adminRole->id,
            ]
        );

        // CREAR AUTORES PREDETERMINADOS 
        $autores = [
            ['name' => 'Gabriel García Márquez'],
            ['name' => 'Miguel de Cervantes'],
            ['name' => 'Isabel Allende'],
            ['name' => 'Jorge Luis Borges'],
            ['name' => 'Julio Cortázar']
        ];

        foreach ($autores as $autor) {
            Author::firstOrCreate(['name' => $autor['name']]);
        }


    }
}

