<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FichaRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'id_curso' => 'required',
            'introduccion' => 'required',
            'justificacion' => 'required',
            'objetivo_general' => 'required',
            'temas' => 'required',
            'actividades_aprendizaje' => 'required',
            'elementos_didacticos' => 'required',
            'criterio_evaluacion' => 'required',
            'competencias' => 'required',
            'bibliografia' => 'required'
        ];
    }
}
