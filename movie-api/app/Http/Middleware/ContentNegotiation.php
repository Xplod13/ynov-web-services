<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContentNegotiation
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Vérifiez l'en-tête Accept pour le type de réponse souhaité
        $acceptHeader = $request->header('Accept');

        if (strpos($acceptHeader, 'application/xml') !== false) {
            // Convertir la réponse en XML
            $content = $response->getContent();
            $xml = new \SimpleXMLElement('<root/>');
            $this->toXml(json_decode($content, true), $xml);
            $response->setContent($xml->asXML());
            $response->header('Content-Type', 'application/xml');
        } elseif (strpos($acceptHeader, 'application/json') !== false) {
            // S'assurer que la réponse est en JSON
            $response->header('Content-Type', 'application/json');
        }

        return $response;
    }

    private function toXml($data, &$xml)
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (is_numeric($key)) {
                    $key = 'item' . $key; // traiter les clés numériques dans les données
                }
                $subnode = $xml->addChild($key);
                $this->toXml($value, $subnode);
            } else {
                $xml->addChild("$key", htmlspecialchars("$value"));
            }
        }
    }
}

