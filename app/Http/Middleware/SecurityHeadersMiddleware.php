<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeadersMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // D-01: Anti-clickjacking
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // D-02: Content Security Policy (Allow self, standard CDNs, and maps/assets)
        $response->headers->set('Content-Security-Policy', "default-src 'self' 'unsafe-inline' 'unsafe-eval' https: http:; img-src 'self' data: https: http:; font-src 'self' https: data:; frame-ancestors 'self';");

        // X-Content-Type-Options: nosniff
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // Hapus informasi X-Powered-By
        $response->headers->remove('X-Powered-By');

        return $response;
    }
}
