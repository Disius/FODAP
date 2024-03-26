<?php

namespace App\Exports;

use App\Http\Controllers\EstadisticasController;
use App\Models\DeteccionNecesidades;
use Maatwebsite\Excel\Concerns\FromCollection;

class DocenteCapacitadosExports implements FromCollection
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return collect(EstadisticasController::docente_carrera());
    }
}
