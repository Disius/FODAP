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

            'asignaturaFA' => 'required',
            'contenidosTM' => 'required',
            'numeroProfesores' => 'required',
            'periodo' => 'required',
            'nombreCurso' => 'required',
            'fecha_I' => 'required',
            'fecha_F' => 'required',
            'hora_I' => 'required',
            'hora_F' => 'required',
            'objetivoEvento' => 'required',
            'tipo_actividad' => 'required',
            'carrera_dirigido' => 'required',
            'modalidad' => 'required',
            'tipo_FDoAP' => 'required',
        ];
    }

//    public function messages(): array
//    {
//        return [
//            'AsignaturasFA.required' => 'Es requerido',
//            'ContenidoTFA.required' => 'Es requerido',
//            'Numprofesores.required' => 'Es requerido',
//            'periodo.required' => 'Es requerido',
//            'nombreCT.required' => 'Es requerido',
//            'fecha_I.required' => 'Es requerido',
//            'fecha_F.required' => 'Es requerido',
//            'hora_I.required' => 'Es requerido',
//            'hora_F.required' => 'Es requerido',
//            'objetivo.required' => 'Es requerido',
//            'tipo_act.required' => 'Es requerido',
//            'dirigido.required' => 'Es requerido',
//            'modalidad.required' => 'Es requerido',
//            'tipo.required' => 'Es requerido',
//            'id_lugar.required' => 'Es requerido',
//        ];
//    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'asignaturaFA' => $this->AsignaturasFA,
            'contenidosTM' => $this->ContenidoTFA,
            'numeroProfesores' => $this->Numprofesores,
            'nombreCurso' => $this->nombreCT,
            'objetivoEvento' => $this->objetivo,
            'tipo_actividad' => $this->tipo_act,
            'carrera_dirigido' => $this->dirigido,
            'tipo_FDoAP' => $this->tipo,
        ]);
    }
}
