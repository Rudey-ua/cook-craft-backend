<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'firstName' => 'required|string|min:3',
            'lastName' => 'required|string|min:3',
            'email' => 'required|email|unique:users',
            'password' => ['required', Password::min(8)->letters()->numbers()],
            'birthDate' => 'required|date|before_or_equal:today',
            'gender' => 'required|in:male,female',
            'language' => 'nullable',
            'time_zone' => 'nullable'
        ];
    }

    public function messages() : array
    {
        return [
            'firstName.required' => 'The firstName field is required',
            'lastName.required' => 'The lastName field is required',
            'password.required' => 'The password field is required',
            'birthDate.required_if' => 'The birthDate field is required',
        ];
    }
}
