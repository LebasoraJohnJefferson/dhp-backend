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
            'fp_id'=>['integer','required'],
            'resident_id'=>['integer','required'],
            'nursing_type'=>['string','nullable'],
            'relationship'=>['string'],
            'occupation'=>['string'],
        ];
    }
}
