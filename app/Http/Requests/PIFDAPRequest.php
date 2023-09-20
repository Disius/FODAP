<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PIFDAPRequest extends FormRequest
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
            'anio' => ['required'],
            'periodo' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'anio.required' => 'El año es requerido!',
            'periodo.required' => 'Debe indicar el periodo'
        ];
    }
}
