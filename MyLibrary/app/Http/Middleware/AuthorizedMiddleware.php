<?php

namespace App\Http\Middleware;

use App\Helpers\RoleHelper;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorizedMiddleware
{
    // Verificar si el usuario tiene autorización para acceder a la ruta
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Comprobar si el usuario tiene el permiso solicitado
        if (!RoleHelper::isAuthorized($permission)) {
            abort(403, 'Access denied: You do not have permission to perform this action.');
        }

        return $next($request);
    }
}
