<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Routing\Middleware\ThrottleRequests;

class CustomThrottleRequests extends ThrottleRequests
{
    protected function resolveRequestSignature($request)
    {
        return $request->ip();  // Utiliser l'adresse IP pour identifier l'utilisateur
    }

    protected function buildResponse($key, $maxAttempts)
    {
        $response = parent::buildResponse($key, $maxAttempts);
        // Modifier la durée de blocage à 30 minutes
        $retryAfter = $this->limiter->availableIn($key);
        $response->headers->set('Retry-After', 1800);  // 1800 secondes = 30 minutes
        $response->setContent('Too many attempts, please retry after 30 minutes.');
        return $response;
    }
}
