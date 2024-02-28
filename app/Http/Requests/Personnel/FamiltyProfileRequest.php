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
                'brgy_id' => ['required', 'integer'],
                'contact_number' => ['required', 'string'],

                'mother_first_name' => ['string', 'required'],
                'mother_middle_name' => ['string', 'required'],
                'mother_last_name' => ['string', 'required'],
                'mother_suffix' => ['string','nullable'],

                'father_first_name' => ['string', 'required'],
                'father_middle_name' => ['string', 'required'],
                'father_last_name' => ['string', 'required'],
                'father_suffix' => ['string','nullable'],

                'food_prod_act' => ['required', 'string'],
                'toilet_type' => ['required', 'string'],
                'water_source' => ['required', 'string'],

                'using_iodized_salt' => [ 'boolean'],
                'using_IFR' => [ 'boolean'],
                'familty_planning' => [ 'boolean'],
                'mother_pregnant' => [ 'boolean'],

                'mother_occupation' => ['required', 'string'],
                'father_occupation' => ['required', 'string'],
                'mother_educ_attain' => ['required', 'string'],
                'father_educ_attain' => ['required', 'string'],
                'mother_birthday' => ['required', 'date'],
                'father_birthday' => ['required', 'date'],
            ];
    }
}
