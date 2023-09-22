<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoRequest extends FormRequest
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

                'AsignaturasFA' => 'required',
                'ContenidoTFA' => 'required',
                'Numprofesores' => 'required',
                'periodo' => 'required',
                'nombreCT' => 'required',
                'fecha_I' => 'required',
                'fecha_F' => 'required',
                'hora_I' => 'required',
                'hora_F' => 'required',
                'objetivo' => 'required',
                'tipo' => 'required',
                'tipo_act' => 'required',
                'dirigido' => 'required',
                'id_jefe' => 'required',
                'modalidad' => ['required'],
                'id_departamento' => ['required'],
                'id_lugar' => ['required'],

        ];
    }

    public function messages(): array
    {
        return [
            'AsignaturasFA.required' => 'Es requerido',
            'ContenidoTFA.required' => 'Es requerido',
            'Numprofesores.required' => 'Es requerido',
            'periodo.required' => 'Es requerido',
            'nombreCT.required' => 'Es requerido',
            'fecha_I.required' => 'Es requerido',
            'fecha_F.required' => 'Es requerido',
            'hora_I.required' => 'Es requerido',
            'hora_F.required' => 'Es requerido',
            'objetivo.required' => 'Es requerido',
            'tipo_act.required' => 'Es requerido',
            'dirigido.required' => 'Es requerido',
            'id_jefe.required' => 'Es requerido',
            'modalidad.required' => 'Es requerido',
            'tipo.required' => 'Es requerido',
            'id_departamento.required' => 'Es requerido',
            'id_lugar' => 'Es requerido',
        ];
    }
}
