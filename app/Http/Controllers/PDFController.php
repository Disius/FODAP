<?php

namespace App\Http\Controllers;

use App\Http\Requests\PIFDAPRequest;
use App\Http\Requests\RequestPDFDeteccion;
use App\Models\Departamento;
use App\Models\DeteccionNecesidades;
use App\Models\Director;
use App\Models\Docente;
use App\Models\FichaTecnica;
use App\Models\NombreInstituto;
use App\Models\Subdireccion;
use App\Models\User;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;
use Webklex\PDFMerger\Facades\PDFMergerFacade as PDFMerger;
use setasign\Fpdi\Fpdi;
use setasign\Fpdi\PdfReader;
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
        return DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento', 'lugar'])
            ->where('periodo', '=', $data->input('periodo'))
            ->where('tipo_FDoAP', '=', 1)
            ->whereYear('fecha_I', '=', $data->input('anio'))->get();

    }
    public static function AP_request($data){
        return DeteccionNecesidades::with(['carrera', 'deteccion_facilitador', 'jefe', 'departamento', 'lugar'])
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
        return $this->save_file($pdf, $path);
//        return response()->json([
//            'docente' => $docente,
//            'curso' => $curso,
//        ]);
    }

    public function ficha_tecnica_pdf(Request $request){
        $ficha = FichaTecnica::find($request->id_ficha);
        $name_instituto = NombreInstituto::all();
        $departamento = Departamento::with( 'jefe_docente')->where('nameDepartamento', '=','Departamento de Desarrollo Académico')->first();
        $pdf = Pdf::loadView('pdf.fichatecnica', compact('ficha', 'name_instituto', 'departamento'))
            ->output();
//
        $path = 'ficha.pdf';

        return $this->save_file($pdf, $path);

//        return response()->json([
//            'chinga tu puta madre' => $ficha,
//            'ya me tienes hasta la verga' => $name_instituto,
//            'hijo de tu puta madre' => $departamento,
////            'pdf' => $pdf
//        ]);
    }
    public function acta_calificaciones_pdf(Request $request){
        $year = date('Y');
        $curso = DeteccionNecesidades::with('calificaciones_curso', 'carrera')->find($request->id);
        $pdf = Pdf::loadView('pdf.actacalificaciones', compact('year', 'curso'))
            ->output();

        $path = 'acta_de_calificaciones.pdf';

        return $this->save_file($pdf, $path);
    }
    public function constancia_pdf(Request $request){
        $year = date('Y');
        $instituto = DB::table('nombre_instituto')->get();
        $docente = Docente::with('inscrito', 'posgrado', 'carrera', 'puesto')->find($request->id_docente);
        $curso = DeteccionNecesidades::with('deteccion_facilitador',  'clave_curso', 'clave_validacion')->find($request->id);
        $coordinacion = User::with('docente')->where('email', 'cformacion@tuxtla.tecnm.mx')->first();
        $ficha = FichaTecnica::where('id_curso', $curso->id)->first();


        $facilitador = $curso->deteccion_facilitador;

        $actual_date = date('Y-m-d');
        $day = date('d');
        $anio = date('Y');
        $month_get = $this->parse_date($actual_date);

        $fecha = $docente->inscrito[0]->fecha_I;
        $fecha2 = $docente->inscrito[0]->fecha_F;
        $formatFechasI = explode("-", $fecha);
        $formatFechasF = explode("-", $fecha2);
        $director = Director::all();
        $month = $this->parse_date($fecha);

        $pdf_1 = Pdf::loadView('pdf.constancia', compact('year', 'instituto', 'docente', 'formatFechasI', 'formatFechasF', 'month', 'facilitador', 'director', 'curso'))
            ->setOptions([
                'fontDir' => storage_path('app/public/fonts/'),
            ])
            ->output();

        $path = 'constancia1.pdf';

        $pdf_2 = Pdf::loadView('pdf.constancia_2', compact('year', 'curso', 'docente', 'day', 'anio', 'month_get', 'coordinacion', 'ficha'))
            ->setPaper('a4','landscape')
            ->output();

        $path_2 = 'constancia2.pdf';

        $this->save_file($pdf_1, $path);
        $this->save_file($pdf_2, $path_2);

        $this->merge_pdf('constancia1', 'constancia2');

        return response()->json([
            'docente' => $docente,
            'year' => $year,
            'facilitador' => $facilitador,
            'coordinacion' => $coordinacion,
        ]);
    }

    public static function merge_pdf($pdf1, $pdf2){
        $name = "constancia.pdf";
        $ruta = storage_path('app/public/'.$name);
        $pdf_1 = storage_path('app/public/'.$pdf1.'.pdf');
        $pdf_2 = storage_path('app/public/'.$pdf2.'.pdf');

        if (!file_exists($pdf_1) || !file_exists($pdf_2)) {
            // Manejar la falta de archivos, lanzar excepción o generar los PDFs previamente si es necesario
            return null;
        }else {
            $pdf = new Fpdi();

            $pageCount1 = $pdf->setSourceFile($pdf_1);
            $template1 = $pdf->importPage(1);
            $pdf->addPage();
            $pdf->useTemplate($template1);

            // Añade la primera página del segundo PDF
            $pageCount2 = $pdf->setSourceFile($pdf_2);


            // Añade la primera página del segundo PDF con la misma orientación del papel del primer PDF
            $template2 = $pdf->importPage(1);
            $pdf->addPage('landscape');
            $pdf->useTemplate($template2);

            $pdf->Output($ruta, 'F');
            return $ruta;
        }
    }

    public static function parse_date($fecha1){
        $fechaActual = date("Y-m-d");
        $componentes2 = date_parse($fechaActual);
        $componentes = date_parse($fecha1);

        $anio = $componentes['year'];
        $anio_2 = $componentes2['year'];

        $mesesEnEspanol = [
            1 => 'enero',
            2 => 'febrero',
            3 => 'marzo',
            4 => 'abril',
            5 => 'mayo',
            6 => 'junio',
            7 => 'julio',
            8 => 'agosto',
            9 => 'septiembre',
            10 => 'octubre',
            11 => 'noviembre',
            12 => 'diciembre'
        ];

        $mesNumero = $componentes['month'];

        $month_number = $componentes2['month'];
        $day = $componentes2['day'];
        return [$mesesEnEspanol[$mesNumero], $mesesEnEspanol[$month_number], $day];
    }

}
