<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // En lugar de usar factory->create(), busca si ya existe o lo crea sin romperse
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        // 2. CREAR AUTORES PREDETERMINADOS 
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

