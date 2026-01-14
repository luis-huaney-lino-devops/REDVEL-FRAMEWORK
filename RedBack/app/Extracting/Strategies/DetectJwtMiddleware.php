<?php

namespace App\Extracting\Strategies;

use Knuckles\Camel\Extraction\ExtractedEndpointData;
use Knuckles\Scribe\Extracting\Strategies\Strategy;
use Knuckles\Scribe\Tools\DocumentationConfig;

/**
 * Estrategia personalizada para detectar automáticamente si una ruta requiere autenticación JWT
 * basándose en el middleware aplicado a la ruta.
 */
class DetectJwtMiddleware extends Strategy
{
    public function __invoke(ExtractedEndpointData $endpointData, array $settings = []): ?array
    {
        $metadata = [];

        // Obtener la ruta
        $route = $endpointData->route;

        // Obtener todos los middlewares aplicados a la ruta
        // Esto incluye middlewares de grupo y middlewares individuales
        $middleware = $route->middleware();

        // También verificar middlewares de grupo
        $gatheredMiddleware = $route->gatherMiddleware();

        // Verificar si tiene el middleware check.jwt o ValidateJWT
        $hasJwtMiddleware = in_array('check.jwt', $middleware) ||
            in_array('check.jwt', $gatheredMiddleware) ||
            in_array('App\Http\Middleware\ValidateJWT', $middleware) ||
            in_array('App\Http\Middleware\ValidateJWT', $gatheredMiddleware) ||
            in_array(\App\Http\Middleware\ValidateJWT::class, $middleware) ||
            in_array(\App\Http\Middleware\ValidateJWT::class, $gatheredMiddleware);

        if ($hasJwtMiddleware) {
            $metadata['authenticated'] = true;
        }

        return !empty($metadata) ? $metadata : null;
    }
}
