<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidFileExtension implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected $allowedExtensions;

    public function __construct($allowedExtensions)
    {
        $this->allowedExtensions = $allowedExtensions;
    }

//    public function passes($attribute, $value)
//    {
//        $extension = strtolower($value->getClientOriginalExtension());
//        return in_array($extension, $this->allowedExtensions);
//    }

    public function message()
    {
        return 'El archivo no tiene una extensión válida.';
    }

    public function validate(string $attribute, mixed $value, Closure $fail): bool
    {
        $extension = strtolower($value->getClientOriginalExtension());
        return in_array($extension, $this->allowedExtensions);
    }
}
