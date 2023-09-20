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
    public static function pdf_request($data){
        return DeteccionNecesidades::with('carrera', 'deteccion_facilitador', 'jefe', 'departamento')
            ->whereYear('fecha_I', '=', $data->anio)
            ->where('periodo', '=', $data->periodo)
            ->where('carrera_dirigido', '=', $data->carrera)
            ->get();
    }

    public static function save_file($file){
        return Storage::disk('public')->put('Deteccion.pdf', $file);
    }
    public static function download_file_deteccion($file){
        return Storage::download($file);
    }
    public function deteccion_pdf(RequestPDF $request){
        $request->validated();
        $cursos = $this->pdf_request($request);
        $pdf = Pdf::loadView('pdf.deteccion', compact('cursos'))->output();
        $this->save_file($pdf);
        if (count($cursos) == 0){
            return response()->json([
                'mensaje' => 'No se encontro ningun dato con ese criterio de busqueda'
            ]);
        }else{
            return $this->download_file_deteccion('Deteccion.pdf');
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
