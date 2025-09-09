<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    use ApiResponseTrait;

    public function __construct(
        private AuthService $authService
    ) {}

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $result = $this->authService->login($request->validated());
            return $this->successResponse($result, 'Login successful');
        } catch (ValidationException $e) {
            return $this->validationErrorResponse($e->errors(), 'Login failed');
        } catch (\Exception $e) {
            return $this->errorResponse('Login failed', 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $this->authService->logout(auth()->user());
            return $this->successResponse(null, 'Logged out successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Logout failed', 500);
        }
    }

    public function logoutFromAllDevices(): JsonResponse
    {
        try {
            $this->authService->logoutFromAllDevices(auth()->user());
            return $this->successResponse(null, 'Logged out from all devices successfully');
        } catch (\Exception $e) {
            return $this->errorResponse('Logout failed', 500);
        }
    }
}