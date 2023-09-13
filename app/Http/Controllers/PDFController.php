<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestPDF;
use App\Models\DeteccionNecesidades;
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


        $pdf_data = DB::table('deteccion_necesidades')
            ->whereYear('fecha_I', '=', $request->anio)
            ->where('periodo', '=', $request->periodo)
            ->where('carrera_dirigido', '=', $request->carrera)
            ->join('carreras' , 'carreras.id', '=', 'deteccion_necesidades.carrera_dirigido')
            ->join('departamento' , 'departamento.id', '=', 'deteccion_necesidades.id_departamento')
            ->join('docente' , 'docente.id', '=', 'deteccion_necesidades.id_jefe')
            ->select('deteccion_necesidades.*', 'carreras.nameCarrera', 'departamento.nameDepartamento', 'docente.nombre_completo')
            ->get();
            $relation = DB::table('');
//        $deteccion_1 = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento'])
//            ->where('periodo', '=', $request->input('periodo'))
//            ->where('carrera_dirigido', '=', $request->input('carrera'))
//            ->where('tipo_FDoAP', '=', 1)
//            ->whereYear('fecha_I', '=', $request->input('anio'))->get();
//        $deteccion_2 = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento'])
//            ->where('periodo', '=', $request->input('periodo'))
//            ->where('carrera_dirigido', '=', $request->input('carrera'))
//            ->where('tipo_FDoAP', '=', 2)
//            ->whereYear('fecha_I', '=', $request->input('anio'))->get();
//

        $contenido = 1;
        $pdf = app('dompdf.wrapper');
//        $content = Pdf::loadView('pdf.deteccion', compact('pdf_data'))->output();
           $content =  $pdf->loadView('pdf.deteccion', compact('pdf_data'))->output();
//        $pdf = Pdf::loadView('pdf.PIFDAP');
        Storage::disk('local')->put('deteccion.pdf', $content);
//
//        return Storage::download('deteccion.pdf');
        return response()->json([
            'res' => 1,
            'request' => $request->all(),
            'pdf_data' => $pdf_data,

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
