<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

//la clase representa un permiso en el sistema
class Permission extends Model
{
    protected $fillable = [
        'code',
        'description',
        'module',
    ];

    // Obtener los roles que tienen asignado este permiso
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions');
    }
}
