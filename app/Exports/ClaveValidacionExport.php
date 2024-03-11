<?php

namespace App\Exports;

use App\Models\ClaveValidacion;
use Maatwebsite\Excel\Concerns\FromCollection;

class ClaveValidacionExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $clave = ClaveValidacion::select('clave')->get();
        return collect($clave);
    }
}
