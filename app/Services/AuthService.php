<?php

namespace App\Services;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthService
{
    public function login(array $credentials): array
    {
        $user = User::where('email', $credentials['email'])->first();

        if (!$user || !Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }
        $user->tokens()->delete();
        $token = $user->createToken('blog-token')->plainTextToken;

        return [
            'bearer_token' => $token,
            'user' => new UserResource($user),
            // 'token_type' => 'Bearer'
        ];
    }

    public function logout(User $user): bool
    {
        return $user->currentAccessToken()->delete();
    }

    public function logoutFromAllDevices(User $user): bool
    {
        return $user->tokens()->delete();
    }
}