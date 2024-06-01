<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'cooking_time' => 'required|integer|min:1',
            'difficulty_level' => 'required|in:easy,medium,hard',
            'portions' => 'required|integer|min:1',
            'cover_photo' => 'required|file',
            'ingredients' => 'required|array|min:1',
            'ingredients.*.title' => 'required|string|max:255',
            'ingredients.*.measure' => 'required|string|max:100',
            'ingredients.*.count' => 'required|integer|min:1',
            'steps' => 'required|array|min:1',
            'steps.*.description' => 'required|string|max:1000',
            'steps.*.photos' => 'array|nullable',
            'steps.*.photos.*' => 'file|mimes:jpg,jpeg,png',
            'tags.*' => 'nullable|exists:tags,id'
        ];
    }
}
