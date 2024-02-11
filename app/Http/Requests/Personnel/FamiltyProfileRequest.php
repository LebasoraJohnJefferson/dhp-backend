<?php

namespace App\Http\Requests\Personnel;

use Illuminate\Foundation\Http\FormRequest;

class FamiltyProfileRequest extends FormRequest
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
                'brgy_id'=>['required','integer'],
                'contact_number'=>['required','string'],
                'mother' => ['required','string'],
                'father' => ['required','string'],
                'occupation' => ['required','string'],
                'educ_attain' => ['required','string'],
                'food_prod_act' => ['required','string'],
                'toilet_type' => ['required','string'],
                'water_source' => ['required','string'],
                'using_iodized_salt' => ['required','boolean'],
                'using_IFR' => ['required','boolean'],
                'familty_planning' => ['required','boolean'],
                'mother_pregnant' => ['required','boolean']
            ];
    }
}
