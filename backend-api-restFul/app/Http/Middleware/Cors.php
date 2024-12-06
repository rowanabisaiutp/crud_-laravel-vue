<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si la solicitud es de tipo OPTIONS (preflight), directamente retornamos una respuesta vacía
        if ($request->getMethod() == "OPTIONS") {
            return response()->json([], 200);
        }

        // Agregar encabezados CORS a la respuesta
        $response = $next($request);
        
        // Los encabezados para permitir el acceso desde cualquier origen
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS');
        $response->headers->set('Access-Control-Allow-Headers', 'Content-Type, Authorization');
        $response->headers->set('Access-Control-Allow-Credentials', 'true'); // Si se necesita enviar cookies
        
        return $response;
    }
}
