<?php

namespace App\Rules;

use App\Models\Inscripcion;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class IfDocenteInscrito implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

    public function __construct($curso_id, $docente_id){
        $this->curso_id = $curso_id;
        $this->docente_id = $docente_id;
    }



    public function validate(string $attribute, mixed $value, Closure $fail): mixed
    {
        return $value;
    }
}
