<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // 1. Verificar que esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Verificar que su rol tenga el permiso exigido por la ruta
        if (!Auth::user()->hasPermission($permission)) {
            abort(403, 'Acceso denegado: No tienes permisos para realizar esta acción.');
        }

        return $next($request);
    }
}
