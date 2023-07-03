<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MovieRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required'],
            'image' => ['required', 'image', 'mimes:jpeg,png,webp', 'max:2048'],
            'category_id' => ['required'],
        ];
    }

    public function messages() {
        return [
            'title.required'  => 'Please write Your address',
            'image.required'     => 'Please write Your city',
            'category_id.required' => 'Please write Your zip_code',
            
        ];
    }
}
