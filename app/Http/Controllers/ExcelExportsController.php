<?php

namespace App\Http\Controllers;

use App\Exports\ClaveCursoExport;
use App\Exports\ClaveValidacionExport;
use App\Exports\DocenteCapacitadosExports;
use App\Exports\EstadisticasExport;
use App\Exports\PeriodoExports;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExcelExportsController extends Controller
{
    public function export_Claves_curso()
    {
        return Excel::store(new ClaveCursoExport(), '/public/claves_curso.xlsx');
    }
    public function export_Claves_curso_validacion()
    {
        return Excel::store(new ClaveValidacionExport(), '/public/claves_validacion.xlsx');
    }
    public function export_cursos_periodo()
    {
        return Excel::store(new PeriodoExports(), '/public/periodos.xlsx');
    }
    public function export_total_docentes()
    {
        return Excel::store(new DocenteCapacitadosExports, '/public/capacitado.xlsx');
    }
}
