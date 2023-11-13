<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OverrideMimeType
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next): Response
    {
        $response = $next($request);
        // dd($response->headers->get('Content-Type'));
        if ($response instanceof Response && $response->headers->get('Content-Type') === 'video/mp2t') {
            $response->headers->set('Content-Type', 'application/typescript');
        }
        // dd($response->headers->get('Content-Type'));

        return $response;
    }
}
