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
            'first_name'=>['required','string'],
            'middle_name'=>['required', 'string'],
            'last_name'=>['required', 'string'],
            'suffix'=>['nullable', 'string'],
            'birthday'=>['required', 'date'],
            'civil_status'=>['required', 'string'],
            'sex'=>['required', 'string'],
            'occupation'=>['required', 'string'],
        ];
    }
}
