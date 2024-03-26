<?php

namespace App\Exports;

use App\Http\Controllers\EstadisticasController;
use App\Models\DeteccionNecesidades;
use Maatwebsite\Excel\Concerns\FromCollection;

class PeriodoExports implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(EstadisticasController::estadistica_cursos_periodo());
    }
}
