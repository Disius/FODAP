<?php

namespace App\Http\Controllers;

use App\Http\Requests\PIFDAPRequest;
use App\Http\Requests\RequestPDFDeteccion;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Docente;
use App\Models\Subdireccion;
use http\Env\Response;
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
    public static function pdf_request_deteccion($data): \Illuminate\Database\Eloquent\Collection|array
    {
        return DeteccionNecesidades::with('carrera', 'deteccion_facilitador', 'jefe', 'departamento')
            ->whereYear('fecha_I', '=', $data->anio)
            ->where('periodo', '=', $data->periodo)
            ->where('carrera_dirigido', '=', $data->carrera)
            ->get();
    }

    public static function FD_request($data)
    {
        return DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento'])
            ->where('periodo', '=', $data->input('periodo'))
            ->where('tipo_FDoAP', '=', 1)
            ->whereYear('fecha_I', '=', $data->input('anio'))->get();

    }
    public static function AP_request($data){
        return DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento'])
            ->where('periodo', '=', $data->input('periodo'))
            ->where('tipo_FDoAP', '=', 2)
            ->whereYear('fecha_I', '=', $data->input('anio'))->get();
    }
    public static function save_file($file, $path): bool
    {
        return Storage::disk('public')->put($path, $file);
    }
    public static function download_file($file): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        return Storage::download($file);
    }

    public function deteccion_pdf(RequestPDFDeteccion $request): \Symfony\Component\HttpFoundation\StreamedResponse|\Illuminate\Http\JsonResponse
    {
        $request->validated();
        $cursos = $this->pdf_request_deteccion($request);
        $subdireccion = Subdireccion::all();
        if (count($cursos) == 0){
            return response()->json([
                'mensaje' => 'No se encontro ningun dato con ese criterio de busqueda'
            ]);
        }else {
            $pdf = Pdf::loadView('pdf.deteccion', compact('cursos', 'subdireccion'))->output();
            $path = "Deteccion.pdf";
            $this->save_file($pdf, $path);
//            return $this->download_file($path);
            return response()->json([
               'status' => 'Ok'
            ]);
        }

    }
    public function PIFDAP_pdf(PIFDAPRequest $request)
    {
        $request->validated();
        $FD = $this->FD_request($request);
        $AP = $this->AP_request($request);
        $subdireccion = Subdireccion::all();
        $departamento = Departamento::with('jefe_docente')
            ->where('nameDepartamento', '=', 'Departamento de Desarrollo Académico')
            ->first();
        $anio = $request->anio;
        $periodo = $request->periodo;
        if (count($FD) == 0 && count($AP) == 0){
            return response()->json([
                'mensaje' => 'No se encontro ningun dato con ese criterio de busqueda',
            ]);
        }else {
            $pdf = Pdf::loadView('pdf.PIFDAP', compact('FD', 'AP', 'anio', 'periodo', 'subdireccion', 'departamento'))
                ->setPaper('letter', 'landscape')
                ->output();
            $path = 'PIFDAP.pdf';
            $this->save_file($pdf, $path);
//            return $this->download_file($path);
            return response()->json([
               'status' => 'OK'
            ]);
        }
    }

    public function cdi_pdf(Request $request){
        $curso = DeteccionNecesidades::with('deteccion_facilitador', 'carrera')->find($request->id_curso);
        $docente = Docente::with('usuario', 'posgrado', 'plaza', 'departamento', 'puesto')->find($request->docente);
        $pdf = Pdf::loadView('pdf.CDI', compact('curso', 'docente'))
            ->output();

        $path = 'CDI.pdf';
        $this->save_file($pdf, $path);
        return response()->json([
            'docente' => $docente
        ]);
    }
}
