<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTFactory;

class TokenController extends Controller
{
    /**
     *  @OA\Post(
     *      path="/api/login",
     *      tags={"Token"},
     *      summary="Login route",
     *      description="Route pour se login en tant qu'utilisateur",
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                  type="object",
     *                  required={ "login","password" },
     *                  @OA\Property(property="login", type="string", example="JonDoe"),
     *                  @OA\Property(property="password", type="string", example="ExitMusic4AFilm")
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           description="Utilisateur loggedin",
     *      ),
     *      @OA\Response(
     *           response=401,
     *           description="Unauthorized",
     *      )
     *  )
     */
    public function login()
    {
        $credentials = request(['login', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token, $this->generateRefreshToken(), 201);
    }

    /**
     *  @OA\Get(
     *      path="/api/validate/{accessToken}",
     *      tags={"Token"},
     *      summary="Confirme la validité d'un access token",
     *      description="Permet de valider l'access token (est-t-il toujours valable ? existe-il ? Tant de question...)",
     *      @OA\Parameter(
     *          in="path",
     *          name="accessToken",
     *          required=true,
     *          description="L'access token à valider",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                  type="string",
     *                  required={ "accessToken" },
     *                  @OA\Property(property="accessToken", type="string")
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           description="Renvoie l'access token d'un utilisateur",
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="accessToken",
     *                  type="string",
     *                  example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjkwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzE3NTA2Njc4LCJleHAiOjE3MTc1MTAyNzgsIm5iZiI6MTcxNzUwNjY3OCwianRpIjoic1dnblJiUzE5eENvM2UwcyIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.4rynHx58WzK_s0cYH8ExaiyuAwFC2F3xd7jVLeubl2A"
     *              ),
     *              @OA\Property(
     *                  property="accessTokenExpiresAt",
     *                  type="string",
     *                  format="date-time",
     *                  example="2024-06-05T12:34:56.789Z"
     *              )
     *           )
     *      ),
     *      @OA\Response(
     *           response=404,
     *           description="Token absent ou invalide",
     *      )
     *  )
     */
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
                ], 200);
            }

            return response()->json(['error' => 'Invalid token'], 404);
        } catch (JWTException $e) {
            // En cas d'échec de la validation, renvoyer une erreur 404
            return response()->json(['error' => 'Invalid token'], 404);
        }

    }

    /**
     * @OA\Get(
     *      path="/api/refresh-token/{refreshToken}/token",
     *      tags={"Token"},
     *      summary="Création d'un access token à partir d'un refresh token",
     *      description="Permet la génération d'un nouvel access token sans avoir à s'authentifier à nouveau. \n Renvoie un access token et un refresh token.",
     *      @OA\Parameter(
     *          in="path",
     *          name="refreshToken",
     *          required=true,
     *          description="Refresh Token à consommer",
     *          @OA\JsonContent(
     *              @OA\Schema(
     *                  type="string",
     *                  required={ "refreshToken" },
     *                  @OA\Property(property="refreshToken", type="string")
     *              )
     *          ),
     *      ),
     *      @OA\Response(
     *           response=201,
     *           description="Création avec succès des nouveaux tokens",
     *           @OA\JsonContent(
     *              type="object",
     *              @OA\Property(
     *                  property="accessToken",
     *                  type="string",
     *                  example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjkwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzE3NTA2Njc4LCJleHAiOjE3MTc1MTAyNzgsIm5iZiI6MTcxNzUwNjY3OCwianRpIjoic1dnblJiUzE5eENvM2UwcyIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.4rynHx58WzK_s0cYH8ExaiyuAwFC2F3xd7jVLeubl2A"
     *              ),
     *              @OA\Property(
     *                  property="accessTokenExpiresAt",
     *                  type="string",
     *                  format="date-time",
     *                  example="2024-06-05T12:34:56.789Z"
     *              ),
     *              @OA\Property(
     *                  property="refreshToken",
     *                  type="string",
     *                  example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbG9jYWxob3N0OjkwMDAvYXBpL2xvZ2luIiwiaWF0IjoxNzE3NTA2Njc4LCJleHAiOjE3MTc1MTAyNzgsIm5iZiI6MTcxNzUwNjY3OCwianRpIjoic1dnblJiUzE5eENvM2UwcyIsInN1YiI6IjIiLCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.4rynHx58WzK_s0cYH8ExaiyuAwFC2F3xd7jVLeubl2A"
     *              ),
     *              @OA\Property(
     *                  property="refreshTokenExpiresAt",
     *                  type="string",
     *                  format="date-time",
     *                  example="2024-06-05T12:34:56.789Z"
     *              )
     *           )
     *      ),
     *      @OA\Response(
     *           response=404,
     *           description="Token absent ou invalide",
     *      )
     * )
     */
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
