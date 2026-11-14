<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Define los permisos disponibles en el sistema
        $permissions = [
            ['code' => 'books.view', 'description' => 'View books', 'module' => 'books'],
            ['code' => 'books.create', 'description' => 'Create books', 'module' => 'books'],
            ['code' => 'books.edit', 'description' => 'Edit books', 'module' => 'books'],
            ['code' => 'books.delete', 'description' => 'Delete books', 'module' => 'books'],

            ['code' => 'authors.view', 'description' => 'View authors', 'module' => 'authors'],
            ['code' => 'authors.create', 'description' => 'Create authors', 'module' => 'authors'],
            ['code' => 'authors.edit', 'description' => 'Edit authors', 'module' => 'authors'],
            ['code' => 'authors.delete', 'description' => 'Delete authors', 'module' => 'authors'],

            ['code' => 'categories.view', 'description' => 'View categories', 'module' => 'categories'],
            ['code' => 'categories.create', 'description' => 'Create categories', 'module' => 'categories'],
            ['code' => 'categories.edit', 'description' => 'Edit categories', 'module' => 'categories'],
            ['code' => 'categories.delete', 'description' => 'Delete categories', 'module' => 'categories'],

            ['code' => 'loans.view', 'description' => 'View loans', 'module' => 'loans'],
            ['code' => 'loans.create', 'description' => 'Create loans', 'module' => 'loans'],
            ['code' => 'loans.edit', 'description' => 'Edit loans', 'module' => 'loans'],
            ['code' => 'loans.return', 'description' => 'Return loans', 'module' => 'loans'],
            ['code' => 'loans.delete', 'description' => 'Delete loans', 'module' => 'loans'],

            ['code' => 'users.view', 'description' => 'View users', 'module' => 'users'],
            ['code' => 'users.create', 'description' => 'Create users', 'module' => 'users'],
            ['code' => 'users.edit', 'description' => 'Edit users', 'module' => 'users'],
            ['code' => 'users.delete', 'description' => 'Delete users', 'module' => 'users'],
        ];

        // Crear los permisos sin duplicar registros existentes
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['code' => $permission['code']],
                [
                    'description' => $permission['description'],
                    'module' => $permission['module'],
                ]
            );
        }

        // Obteien los roles registrados
        $admin = Role::where('name', 'admin')->first();
        $librarian = Role::where('name', 'bibliotecario')->first();
        $reader = Role::where('name', 'lector')->first();

        // Asignar todos los permisos al administrador
        if ($admin) {
            $admin->permissions()->sync(Permission::all()->pluck('id'));
        }

        // Asignar permisos de consulta y gestión de prestamos al bibliotecario
        if ($librarian) {
            $librarian->permissions()->sync(
                Permission::whereIn('code', [
                    'books.view',
                    'books.create',
                    'books.edit',
                    'authors.view',
                    'authors.create',
                    'authors.edit',
                    'categories.view',
                    'categories.create',
                    'categories.edit',
                    'loans.view',
                    'loans.create',
                    'loans.edit',
                    'loans.return',
                ])->pluck('id')
            );
        }

        // Asignar unicamente permisos de consulta al lector
        if ($reader) {
            $reader->permissions()->sync(
                Permission::whereIn('code', [
                    'books.view',
                    'authors.view',
                    'categories.view',
                ])->pluck('id')
            );
        }
    }
}
