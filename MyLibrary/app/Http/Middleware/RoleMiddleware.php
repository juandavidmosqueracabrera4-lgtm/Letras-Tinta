<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // 1. Verificar que el usuario haya iniciado sesión
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // 2. Verificar que tenga un rol asignado y que coincida con los permitidos en la ruta
        if (!$user->role || !in_array($user->role->name, $roles)) {
            abort(403, 'Acceso denegado: No tienes permisos para acceder a esta sección.');
        }

        return $next($request);
    }
}