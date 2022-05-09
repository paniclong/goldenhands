<?php

declare(strict_types=1);

namespace App\Modules\Auth\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Modules\Auth\Http\Request\RegisterRequest;
use App\Modules\Auth\Services\JwtGuard;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

final class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     *
     * @return JsonResponse
     * 
     * @throws \Illuminate\Auth\AuthenticationException
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::query()
            ->where('email', '=', $request->getEmail())
            ->first();

        if ($user !== null) {
            return response()
                ->json(['error' => __('User already exist')], Response::HTTP_BAD_REQUEST);
        }

        $user = User::create([
            'name' => $request->getName(),
            'email' => $request->getEmail(),
            'password' => Hash::make($request->getUserPassword()),
        ]);

        /** @var JwtGuard $apiGuard */
        $apiGuard = Auth::guard('api');

        $apiGuard->setUser($user);
        $apiGuard->authenticate();

        return response()->json([], Response::HTTP_OK);
    }
}
