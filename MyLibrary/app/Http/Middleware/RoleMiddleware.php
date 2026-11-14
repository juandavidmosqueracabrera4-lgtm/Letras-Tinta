<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    // Verificar que el usuario tenga uno de los roles permitidos
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Comprobar que el usuario haya iniciado sesión
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Comprobar que el usuario tenga un rol permitido
        if (!$user->role || !in_array($user->role->name, $roles)) {
            abort(403, 'Access denied: You do not have permission to access this section.');
        }

        return $next($request);
    }
}
