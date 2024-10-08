<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;


class StoreUserRequest extends FormRequest
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
            'first_name'=>['required','string','max:255'],
            'middle_name'=>['required','string','max:255'],
            'last_name'=>['required','string','max:255'],
            'suffix'=>['string','nullable'],
            'email'=>['required','string','max:255','unique:users'],
            'password'=>['required','confirmed',Rules\Password::defaults()],
            'is_active'=>['boolean'],
        ];
    }
}
