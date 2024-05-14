<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class TokenController extends Controller
{
    public function login()
    {
        $credentials = request(['login', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 404);
        }

        return $this->respondWithToken($token, $this->generateRefreshToken(), 201);
    }

    public function validate(Request $request, string $accessToken)
    {
        try {
            // Tenter de vérifier le token et extraire les données
            $payload = JWTAuth::setToken($accessToken)->getPayload();
            $expiration = $payload->get('exp');
            $expirationDate = \Carbon\Carbon::createFromTimestamp($expiration);

            if($payload->get('kind') === null) {
                return response()->json([
                    'accessToken' => $accessToken,
                    'accessTokenExpiresAt' => $expirationDate->toIso8601String(),
                ]);
            }

            return response()->json(['error' => 'Invalid token'], 404);
        } catch (JWTException $e) {
            // En cas d'échec de la validation, renvoyer une erreur 404
            return response()->json(['error' => 'Invalid token'], 404);
        }

    }

    public function refreshToken(Request $request, string $refreshToken)
    {
        try {
            // Valider le refresh token
            JWTAuth::setToken($refreshToken);
            $payload = JWTAuth::getPayload();
            if ($payload['kind'] != 'refresh_token') {
                return response()->json(['error' => 'Invalid token kind'], 404);
            }

            $userId = $payload['sub'];
            $newToken = auth('api')->tokenById($userId);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Invalid token'], 404);
        }

        return $this->respondWithToken($newToken, $this->generateRefreshToken(), 201);
    }

    private function generateRefreshToken() {
        $customClaims = ['kind' => 'refresh_token'];
        $factory = JWTFactory::customClaims($customClaims);
        $payload = $factory->make();
        $refreshToken = JWTAuth::encode($payload);

        return $refreshToken->get();
    }

    protected function respondWithToken($token, $refresh_token = null, $status = 200)
    {
        return response()->json([
            'accessToken' => $token,
            'refreshToken' => $refresh_token,
            'accessTokenExpiresAt' => Carbon::now()->addMinutes(auth()->factory()->getTTL() * 60)->toIso8601String(),
            'refreshTokenExpiresAt' => Carbon::now()->addMinutes(config('jwt.refresh_ttl') * 60)->toIso8601String()
        ], $status);
    }
}
