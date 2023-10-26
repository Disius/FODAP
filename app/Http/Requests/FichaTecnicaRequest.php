<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FichaTecnicaRequest extends FormRequest
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
            'id_curso' => 'required',
            'introduccion' => 'required',
            'justificacion' => 'required',
            'objetivo_general' => 'required',
            'descripcion_servicio' => 'required',
            'elementos_didacticos' => 'required',
            'competencias_desarrollar' => 'required',
            'fuentes_informacion' => 'required',
        ];
    }
}
