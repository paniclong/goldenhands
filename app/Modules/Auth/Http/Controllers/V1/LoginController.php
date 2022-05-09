<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers\V1;

use App\Models\User;
use App\Modules\Auth\Http\Request\LoginRequest;
use App\Modules\Auth\Http\Request\RefreshTokenRequest;
use App\Modules\Auth\Services\ErrorCodes;
use App\Modules\Auth\ValueObject\JwtToken;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

final class LoginController extends Controller
{
    /**
     * @return JsonResponse
     */
    public function me(): JsonResponse
    {
        /** @var User|null $user */
        $user = Auth::guard('api')->user();

        $data = [];
        $statusCode = Response::HTTP_NOT_FOUND;
        if ($user !== null) {
            $data = [
                'status' => 'success',
                'user' => [
                    'name' => $user->getAttribute('name'),
                    'email' => $user->getAttribute('email'),
                ]

            ];

            $statusCode = Response::HTTP_OK;
        }

        return response()->json($data, $statusCode);
    }

    /**
     * @param LoginRequest $request
     *
     * @return JsonResponse
     */
    public function loginByEmailAndPassword(LoginRequest $request): JsonResponse
    {
        /** @var JwtToken $tokenObject */
        $tokenObject = Auth::guard('api')->attempt($request->validated());

        if (!$tokenObject instanceof JwtToken) {
            return response()->json(
                [
                    'status' => 'error',
                    'code' => ErrorCodes::USER_NOT_FOUND
                ],
                Response::HTTP_NOT_FOUND
            );
        }

        $data = [
            'status' => 'success',
            'auth' => [
                'token' => $tokenObject->getToken(),
                'refresh_token' => $tokenObject->getRefreshToken(),
                'expired_in' => $tokenObject->getExpiresIn(),
            ],
        ];
        
        return response()
            ->json($data, Response::HTTP_OK)
            ->cookie(Cookie::create('refresh_token', $tokenObject->getRefreshToken()));
    }

    /**
     * @param RefreshTokenRequest $request
     *
     * @return JsonResponse
     */
    public function refreshToken(RefreshTokenRequest $request): JsonResponse
    {
        $refreshToken = $request->getRefreshToken();

        $tokenObject = Auth::guard('api')->refreshToken($refreshToken);

        if (!$tokenObject instanceof JwtToken) {
            return response()->json([], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'status' => 'success',
            'auth' => [
                'token' => $tokenObject->getToken(),
                'refresh_token' => $tokenObject->getRefreshToken(),
                'expired_in' => $tokenObject->getExpiresIn(),
            ],
        ];
        
        return response()
            ->json($data, Response::HTTP_OK)
            ->cookie(Cookie::create('refresh_token', $tokenObject->getRefreshToken()));
    }
}
