<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;

class BasicAuthMiddleware
{
    public function handle($request, Closure $next)
    {
        $username = env('API_USERNAME', 'admin');
        $password = env('API_PASSWORD', 'secret123');

        $authHeader = $request->header('Authorization');

        if (!$authHeader) {
            return new JsonResponse([
                'message' => 'Unauthorized - Missing Authorization header'
            ], 401);
        }

        if (strpos($authHeader, 'Basic ') !== 0) {
            return new JsonResponse([
                'message' => 'Unauthorized - Invalid Authorization format'
            ], 401);
        }

        $encodedCredentials = substr($authHeader, 6);
        $decodedCredentials = base64_decode($encodedCredentials, true);

        if ($decodedCredentials === false) {
            return new JsonResponse([
                'message' => 'Unauthorized - Invalid Base64 encoding'
            ], 401);
        }

        list($user, $pass) = explode(':', $decodedCredentials, 2);

        if ($user !== $username || $pass !== $password) {
            return new JsonResponse([
                'message' => 'Unauthorized - Invalid credentials'
            ], 401);
        }

        return $next($request);
    }
}