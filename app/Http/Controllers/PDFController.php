<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestPDF;
use App\Models\DeteccionNecesidades;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
class PDFController extends Controller
{
    public function deteccion_pdf(RequestPDF $request){
        $request->validated();
        $cursos = DeteccionNecesidades::with('carrera', 'deteccion_facilitador', 'jefe', 'departamento')
            ->whereYear('fecha_I', '=', $request->anio)
            ->where('periodo', '=', $request->periodo)
            ->where('carrera_dirigido', '=', $request->carrera)
            ->get();
        if (count($cursos) == 0){
            return response()->json([
                'mensaje' => 'No se encontro ningun dato con ese criterio de busqueda'
            ]);
        }else{
            return response()->json([
                'cursos' => $cursos,
                'status' => 'Ok'
            ]);
        }
    }
    public function PIFDAP_pdf(Request $request){
        $pdf_data = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento'])
            ->where('periodo', '=', $request->input('periodo'))
            ->whereYear('fecha_I', '=', $request->input('anio'))->get();

        $pdf = app('dompdf.wrapper');
        $content = $pdf->loadView('pdf.PIFDAP', compact('pdf_data'))
            ->setPaper('letter', 'landscape')
            ->output();
        Storage::disk('local')->put('PIFDAP.pdf', $content);

        return Storage::download('PIFDAP.pdf');
    }
}
