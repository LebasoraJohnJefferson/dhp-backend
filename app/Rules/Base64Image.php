<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class Base64Image implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!preg_match('/^data:image\/(\w+);base64,/', $value)) {
            $fail("The $attribute must be a valid Base64-encoded image.");
            return;
        }

        // Check if the Base64 string can be decoded
        $data = base64_decode(preg_replace('/^data:image\/(\w+);base64,/', '', $value), true);

        // Check if the decoding was successful and the result is an image
        if ($data === false || @getimagesizefromstring($data) === false) {
            $fail("The $attribute must be a valid Base64-encoded image.");
        }
    }
}
