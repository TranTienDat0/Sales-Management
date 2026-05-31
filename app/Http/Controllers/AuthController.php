<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;

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
}
