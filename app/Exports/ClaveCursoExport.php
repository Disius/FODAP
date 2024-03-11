<?php

namespace App\Exports;

use App\Models\ClaveCurso;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClaveCursoExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $clave =  ClaveCurso::select('clave')->get();
        return collect($clave);
    }
}
