<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Iqbalatma\LaravelServiceRepo\BaseService;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

//#[ServiceRepository()]
class AuthService extends BaseService
{
    public function login(array $data): array
    {
        $user = User::where('email', $data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password)) {
            return [
                'status' => 'error',
                'message' => 'Email or password không đúng',
                'data' => null
            ];
        }

        // JWT check
        $token = JWTAuth::fromUser($user);

        return [
            'status' => 'success',
            'message' => 'Login thanh cong',
            'data' => [
                'user' => $user,
                'access' => $token,
                'token_type' => 'Bearer'
            ]
        ];
    }
}
