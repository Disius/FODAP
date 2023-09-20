<?php

namespace App\Http\Controllers;

use App\Http\Requests\PIFDAPRequest;
use App\Http\Requests\RequestPDFDeteccion;
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
    public static function pdf_request_deteccion($data){
        return DeteccionNecesidades::with('carrera', 'deteccion_facilitador', 'jefe', 'departamento')
            ->whereYear('fecha_I', '=', $data->anio)
            ->where('periodo', '=', $data->periodo)
            ->where('carrera_dirigido', '=', $data->carrera)
            ->get();
    }

    public static function pdf_request_PIFDAP($data){
        return DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento'])
            ->where('periodo', '=', $data->input('periodo'))
            ->whereYear('fecha_I', '=', $data->input('anio'))->get();
    }
    public static function save_file($file, $path){
        return Storage::disk('public')->put($path, $file);
    }
    public static function download_file_deteccion($file){
        return Storage::download($file);
    }
    public function deteccion_pdf(RequestPDFDeteccion $request){
        $request->validated();
        $cursos = $this->pdf_request_deteccion($request);
        $pdf = Pdf::loadView('pdf.deteccion', compact('cursos'))->output();
        $path = "Deteccion.pdf";
        $this->save_file($pdf, $path);
        if (count($cursos) == 0){
            return response()->json([
                'mensaje' => 'No se encontro ningun dato con ese criterio de busqueda'
            ]);
        }else{
            return $this->download_file_deteccion($path);
        }
    }
    public function PIFDAP_pdf(PIFDAPRequest $request){
        $request->validated();
        $cursos = $this->pdf_request_PIFDAP($request);
        $pdf = Pdf::loadView('pdf.PIFDAP', compact('cursos'))
            ->setPaper('letter', 'landscape')
            ->output();
        $path = 'PIFDAP.pdf';
        $this->save_file($pdf, $path);
        if (count($cursos) == 0){
            return response()->json([
                'mensaje' => 'No se encontro ningun dato con ese criterio de busqueda'
            ]);
        }else{
            return $this->download_file_deteccion($path);
        }
    }
}
