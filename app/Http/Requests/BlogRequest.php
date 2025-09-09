<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use App\Services\ResponseService;

class BlogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

        ];

        if ($this->isMethod('post')) {
            $rules['image'] = 'required|image|mimes:jpeg,png,jpg,gif|max:2048';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['image'] = 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048';
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Title is required.',
            'title.max' => 'Title cannot exceed 255 characters.',
            'description.required' => 'Description is required.',
            'image.required' => 'Image is required.',
            'image.image' => 'The file must be an image.',
            'image.mimes' => 'Image must be of type: jpeg, png, jpg, gif.',
            'image.max' => 'Image size cannot exceed 2MB.',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        // Log::error('Validation failed: ' . $validator->errors()->first());
        $response = new Response(['error' => $validator->errors()], 422);
        $responseService = new ResponseService;
        $response = $responseService->error(__('crud.general.validation_failure'), Response::HTTP_UNPROCESSABLE_ENTITY, $validator->errors()->toArray());
        throw new ValidationException($validator, $response);
    }
}