<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PreschoolWithNutritionalStatusRequest extends FormRequest
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
            'height'=>['required','numeric'],
            'weight'=>['required','numeric'],
            'member_id'=>['required', 'string'],
            'date_opt'=>['required', 'date'],
        ];
    }
}
