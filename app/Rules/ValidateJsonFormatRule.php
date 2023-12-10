<?php

namespace App\Rules;

use App\Helper\Util;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateJsonFormatRule implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (! $this->isValidJson($value)) {
            $fail('The :attribute content must be a valid Json');
        }
    }
    public function isValidJson($content): bool
    {
        $json = Util::getJsonFileContent($content);

        return json_last_error() === JSON_ERROR_NONE;
    }
}
