<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Auth;

//Verifica los permisos de un usuario autenticado para determinar si tiene autorización para realizar ciertas acciones en la aplicación
class RoleHelper
{
    //verifica si el usuario tiene un permiso específico
    public static function isAuthorized(string $permission): bool
    {
        $user = Auth::user();

        if (!$user || !$user->role) {
            return false;
        }

        return $user->role->permissions()->where('code', $permission)->exists();
    }
}
