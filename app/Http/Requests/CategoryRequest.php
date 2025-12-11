<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => ['nullable', 'exists:product_categories,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg'],
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:product_categories,slug'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:255'],
        ];
    }
}
