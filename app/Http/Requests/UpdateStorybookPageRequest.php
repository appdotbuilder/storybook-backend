<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateStorybookPageRequest extends FormRequest
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
            'page_number' => 'required|integer|min:1',
            'text_content' => 'required|array',
            'text_content.en' => 'nullable|string',
            'text_content.hi' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'audio_en' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'audio_hi' => 'nullable|file|mimes:mp3,wav,ogg|max:10240',
            'animation_data' => 'nullable|array',
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
            'page_number.required' => 'Page number is required.',
            'page_number.min' => 'Page number must be at least 1.',
            'text_content.required' => 'Text content is required.',
            'image.image' => 'Image must be a valid image file.',
            'image.max' => 'Image size cannot exceed 5MB.',
            'audio_en.mimes' => 'English audio must be mp3, wav, or ogg format.',
            'audio_en.max' => 'English audio file cannot exceed 10MB.',
            'audio_hi.mimes' => 'Hindi audio must be mp3, wav, or ogg format.',
            'audio_hi.max' => 'Hindi audio file cannot exceed 10MB.',
        ];
    }
}