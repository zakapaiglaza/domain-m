<?php

namespace Api\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Api\Http\Requests\Auth\LoginRequest;
use Api\Http\Requests\Auth\RegisterRequest;
use Api\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());

        return response()->json([
            'message' => 'Пользователь успешно зарегистрирован',
            'user'    => new UserResource($user),
        ], Response::HTTP_CREATED);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $user = $this->authService->login($request->validated());

        if (!$user) {
            return response()->json([
                'message' => 'Неверный email или пароль'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user->tokens()->delete();

        $token = $user->createToken('api-token')->plainTextToken;

        return response()->json([
            'message' => 'Вы успешно авторизованы',
            'user'    => new UserResource($user),
            'token'   => $token,
        ]);
    }

    public function logout(): JsonResponse
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Вы вышли из системы'
        ]);
    }

    public function user(): JsonResponse
    {
        return response()->json([
            'user' => new UserResource(auth()->user())
        ]);
    }
}
