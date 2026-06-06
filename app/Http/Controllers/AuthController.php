<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login (LoginRequest $request) : JsonResponse
    {
        return response()->json(
            $this->authService->login($request->validated())
        );
    }

    public function refresh(): JsonResponse
    {
        $token = JWTAuth::getToken();

        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Token not provided',
            ], 401);
        }

        return response()->json([
            'status' => 'success',
            'access_token' => JWTAuth::refresh($token),
        ]);
    }
}
