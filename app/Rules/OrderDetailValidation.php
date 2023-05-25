<?php

namespace App\Rules;

use Closure;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Contracts\Validation\ValidationRule;

class OrderDetailValidation implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($value as $item) {

            $validator = Validator::make($item, [
                'productNumber' => 'required|integer',
                'quantityOrdered' => 'required|integer'
            ]);


            if ($validator->fails()) {
                throw new Exception;
            }
        }
    }
}
