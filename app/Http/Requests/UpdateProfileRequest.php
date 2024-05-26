<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstName' => 'nullable|string|min:3',
            'lastName' => 'nullable|string|min:3',
            'email' => 'nullable|email',
            'password' => ['nullable', Password::min(8)->letters()->numbers()],
            'birthDate' => 'nullable|date|before_or_equal:today',
            'profileImage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gender' => 'nullable|in:male,female',
            'language' => 'nullable',
            'timezone' => 'nullable'
        ];
    }
}
