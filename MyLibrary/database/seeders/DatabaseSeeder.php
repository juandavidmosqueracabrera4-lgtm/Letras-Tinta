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

        // 4 usuarios administradores
        $admins = [
            [
                'name'     => 'Profe',
                'email'    => 'manueldominguez8481@correo.itm.edu.co',
                'document' => '1000000001',
                'password' => '123456',
            ],
            [
                'name'     => 'juan david',
                'email'    => 'juandavid@admin.com',
                'document' => '1000000002',
                'password' => '123456',
            ],
            [
                'name'     => 'sary',
                'email'    => 'sary@admin.com',
                'document' => '1000000003',
                'password' => '123456',
            ],
            [
                'name'     => 'katty',
                'email'    => 'katty@admin.com',
                'document' => '1000000004',
                'password' => '123456',
            ],
        ];

        foreach ($admins as $admin) {
            User::firstOrCreate(
                ['email' => $admin['email']],
                [
                    'name'              => $admin['name'],
                    'document'          => $admin['document'],
                    'password'          => bcrypt($admin['password']),
                    'role_id'           => $adminRole->id,
                    'email_verified_at' => now(),
                ]
            );
        }

        // Crear usuario de prueba con los nuevos campos 'document' y 'role_id'
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'document' => '1000000005',
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
