<?php

namespace App\Http\Controllers\Traduccion;

use App\Http\Controllers\Controller;
use OpenApi\Annotations as OA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TraduccionController extends Controller
{
    /**
     * @OA\Post(
     *     path="/traduccion",
     *     tags={"Traducción"},
     *     summary="Traducir texto",
     *     description="Traduce un texto desde un idioma origen a un idioma destino usando GoogleTranslate",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"text","to"},
     *             @OA\Property(property="text", type="string", example="Hola mundo"),
     *             @OA\Property(property="to", type="string", minLength=2, maxLength=5, example="en"),
     *             @OA\Property(property="from", type="string", nullable=true, minLength=2, maxLength=5, example="es")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Traducción exitosa",
     *         @OA\JsonContent(
     *             @OA\Property(property="original", type="string", example="Hola mundo"),
     *             @OA\Property(property="translated", type="string", example="Hello world"),
     *             @OA\Property(property="from", type="string", example="es"),
     *             @OA\Property(property="to", type="string", example="en"),
     *             @OA\Property(property="cached", type="boolean", example=false)
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Error de validación"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Error interno"
     *     )
     * )
     */
    public function traducir(Request $request)
    {
        // Validar entrada
        $request->validate([
            'text' => 'required|string',
            'to' => 'required|string|min:2|max:5', // idioma destino
            'from' => 'nullable|string|min:2|max:5', // idioma origen opcional
        ]);

        try {
            $texto = $request->input('text');
            $idiomaDestino = $request->input('to');
            $idiomaOrigen = $request->input('from', null);

            // Clave única para cachear traducciones
            $cacheKey = 'translation:' . md5($texto . ($idiomaOrigen ?? 'auto') . $idiomaDestino);

            $textoTraducido = Cache::remember(
                $cacheKey,
                now()->addDays(1), // Mantener cache 7 días
                function () use ($texto, $idiomaDestino, $idiomaOrigen) {
                    $tr = new GoogleTranslate();
                    $tr->setTarget($idiomaDestino);
                    if ($idiomaOrigen) {
                        $tr->setSource($idiomaOrigen);
                    }
                    return $tr->translate($texto);
                }
            );

            return response()->json([
                'original' => $texto,
                'translated' => $textoTraducido,
                'from' => $idiomaOrigen ?? 'auto',
                'to' => $idiomaDestino,
                'cached' => Cache::has($cacheKey) // Saber si vino de cache
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al traducir',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
