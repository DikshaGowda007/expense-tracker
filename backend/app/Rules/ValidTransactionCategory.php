<?php

namespace App\Rules;

use App\Constants\CommonConstant;
use App\Models\Category;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ValidTransactionCategory implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  Closure(string, ?string=): PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isValid = Category::where('id', $value)
            ->where('status', CommonConstant::STATUS_ACTIVE)
            ->where('is_deleted', CommonConstant::IS_DELETED_NO)
            ->exists();

        if (! $isValid) {
            $fail('The selected category is invalid or inactive.');
        }
    }
}
