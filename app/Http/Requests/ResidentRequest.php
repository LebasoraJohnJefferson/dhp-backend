<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResidentRequest extends FormRequest
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
            'brgy_id'=>['required','numeric'],
            'mother_first_name'=>['required','string'],
            'mother_middle_name'=>['required', 'string'],
            'mother_last_name'=>['required', 'string'],
            'father_first_name'=>['required','string'],
            'father_middle_name'=>['required', 'string'],
            'father_last_name'=>['required', 'string'],
            'father_suffix'=>['nullable', 'string'],
            'father_birthday'=>['required', 'date'],
            'mother_birthday'=>['required', 'date'],
        ];
    }
}
