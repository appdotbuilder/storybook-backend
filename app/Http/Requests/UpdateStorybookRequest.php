<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStorybookRequest extends FormRequest
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
            'author' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'languages' => 'required|array|min:1',
            'languages.*' => 'required|string|in:en,hi',
            'description' => 'nullable|string',
            'status' => 'required|string|in:draft,published,archived',
            'age_group' => 'nullable|string|max:50',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:100',
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Storybook title is required.',
            'author.required' => 'Author name is required.',
            'languages.required' => 'At least one language must be selected.',
            'languages.*.in' => 'Only English (en) and Hindi (hi) languages are supported.',
            'cover_image.image' => 'Cover image must be a valid image file.',
            'cover_image.max' => 'Cover image size cannot exceed 2MB.',
            'status.in' => 'Status must be draft, published, or archived.',
        ];
    }
}