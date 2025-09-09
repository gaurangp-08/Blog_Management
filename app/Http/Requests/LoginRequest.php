<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\ResponseService;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string|min:6'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
        ];
    }

     protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        Log::error('Validation failed: ' . $validator->errors()->first());
        $response = new Response(['error' => $validator->errors()], 422);
        $responseService = new ResponseService;
        $response = $responseService->error(__('crud.general.validation_failure'), Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors()->toArray());
        throw new ValidationException($validator, $response);
    }
}