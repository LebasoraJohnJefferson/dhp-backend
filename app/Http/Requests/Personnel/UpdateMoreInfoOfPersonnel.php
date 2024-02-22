<?php

namespace App\Http\Requests\Personnel;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMoreInfoOfPersonnel extends FormRequest
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
            'address'=>['required', 'string'],
            'birthday'=>['required', 'date'],
            'gender'=>['required', 'string'],
            'contact_number'=>['required', 'string'],
            'emergency_contact_relationship'=>['required', 'string'],
            'emergency_contact_number'=>['required', 'string'],
            'image' => ['nullable', 'string']
        ];
    }
}
