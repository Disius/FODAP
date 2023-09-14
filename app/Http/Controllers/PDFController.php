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
    public static function consultPDFDeteccion($request){
        $request->validated();
        return DeteccionNecesidades::with('carrera', 'deteccion_facilitador', 'jefe', 'departamento')
            ->whereYear('fecha_I', '=', $request->anio)
            ->where('periodo', '=', $request->periodo)
            ->where('carrera_dirigido', '=', $request->carrera)
            ->get();
    }
    public function deteccion_pdf(RequestPDF $request){
    $cursos = $this->consultPDFDeteccion($request);
//        $pdf = App::make('dompdf.wrapper');
//        $contenido = $pdf->loadView('pdf.deteccion', compact('cursos'))->output();
//        Storage::disk('local')->put('deteccion.pdf', $contenido);
//        $file = storage_path('app/deteccion.pdf');
//        $headers = [
//          'Content-TYpe' => 'application/pdf'
//        ];
//        return response()->download($file, 'deteccion.pdf', $headers);
        return response()->json([
            'cursos' => $cursos,
            'status' => 'Ok'
        ]);
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
