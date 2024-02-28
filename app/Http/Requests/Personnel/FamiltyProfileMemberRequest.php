<?php

namespace App\Http\Requests\Personnel;

use Illuminate\Foundation\Http\FormRequest;

class FamiltyProfileMemberRequest extends FormRequest
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
            'first_name'=>['required','string'],
            'middle_name'=>['required','string'],
            'last_name'=>['required','string'],
            'suffix'=>['string','nullable'],
            'birthDay'=>['required','date'],
            'nursing_type'=>['string','nullable'],
            'relationship'=>['string'],
            'occupation'=>['string'],
            'gender'=>['string'],
        ];
    }
}
