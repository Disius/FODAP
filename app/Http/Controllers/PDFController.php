<?php

namespace App\Http\Controllers;

use App\Models\DeteccionNecesidades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PDFController extends Controller
{
    public function deteccion_pdf(Request $request){

        $pdf_data = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento'])
            ->where('periodo', '=', $request->input('periodo'))
            ->where('carrera_dirigido', '=', $request->input('carrera'))
            ->whereYear('created_at', '=', $request->input('anio'))->get();

        $deteccion_1 = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento'])
            ->where('periodo', '=', $request->input('periodo'))
            ->where('carrera_dirigido', '=', $request->input('carrera'))
            ->where('tipo_FDoAP', '=', 1)
            ->whereYear('created_at', '=', $request->input('anio'))->get();
        $deteccion_2 = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento'])
            ->where('periodo', '=', $request->input('periodo'))
            ->where('carrera_dirigido', '=', $request->input('carrera'))
            ->where('tipo_FDoAP', '=', 2)
            ->whereYear('created_at', '=', $request->input('anio'))->get();

        $pdf = app('dompdf.wrapper');
        $content = $pdf->loadView('pdf.deteccion', compact('pdf_data', 'deteccion_1', 'deteccion_2'))
            ->setPaper('a4', 'portrait')
            ->output();
        Storage::disk('local')->put('deteccion.pdf', $content);

        return Storage::download('deteccion.pdf');
    }
    public function PIFDAP_pdf(Request $request){
        $pdf_data = DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento'])
            ->where('periodo', '=', $request->input('periodo'))
            ->whereYear('created_at', '=', $request->input('anio'))->get();

        $pdf = app('dompdf.wrapper');
        $content = $pdf->loadView('pdf.PIFDAP', compact('pdf_data'))
            ->setPaper('letter', 'landscape')
            ->output();
        Storage::disk('local')->put('PIFDAP.pdf', $content);

        return Storage::download('PIFDAP.pdf');
    }
}
