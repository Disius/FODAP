<?php

namespace App\Http\Controllers;

use App\Exports\EstadisticasExport;
use App\Models\DeteccionNecesidades;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Maatwebsite\Excel\Facades\Excel;

class EstadisticasController extends Controller
{
    public function index_estadisticas(){
        return Inertia::render('Views/desarrollo/estadisticas/Estadisticas', [
            'cursos_anio' => $this->estadisticas_de_curso_por_anio(),
            'cursos_periodos' => $this->estadistica_cursos_periodo(),
            'cursos_tipo' => $this->estadistica_cursos_tipo(),
            'docente_carrera' => $this->docente_carrera(),
            'total_cursos_ap_fd' => $this->fd_ap_cursos(),
        ]);
    }

    public static function estadisticas_de_curso_por_anio(){
//            Cuantos cursos en general por anio
        $anio = date('Y');
        return DeteccionNecesidades::with('inscritos')
            ->whereYear('fecha_F', '=', $anio)
            ->where('estado', '=', 2)->count();
    }

    public static function estadistica_cursos_periodo(){
        $anio = date('Y');
        $cursos_enero_junio = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('periodo', '=', 1);
            })->count();
        $cursos_agosto_diciembre = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('periodo', '=', 2);
            })->count();

        return array(
            array("periodo" => "Enero-Junio", "total" => $cursos_enero_junio),
            array("periodo" => "Agosto-Diciembre", "total" => $cursos_agosto_diciembre),
        );
    }
    public static function estadistica_cursos_tipo(){
        $anio = date('Y');
        $cursos_taller = DeteccionNecesidades::with('inscritos')->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 1);
            })->count();
        $cursos_curso = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 2);
            })->count();
        $cursos_curso_taller = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 3);
            })->count();
        $cursos_foro = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 4);
            })->count();
        $cursos_seminario = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 5);
            })->count();
        $cursos_diplomado = DeteccionNecesidades::with('inscritos') ->whereYear('fecha_F', '=', $anio)
            ->where(function($query){
                $query->where('estado', '=', 2)
                    ->where('tipo_actividad', '=', 6);
            })->count();

        return array(
            array("tipo" => "Taller", "total" => $cursos_taller),
            array("tipo" => "Curso", "total" => $cursos_curso),
            array("tipo" => "Curso/taller", "total" => $cursos_curso_taller),
            array("tipo" => "Foro", "total" => $cursos_foro),
            array("tipo" => "Seminario", "total" => $cursos_seminario),
            array("tipo" => "Diplomado", "total" => $cursos_diplomado),
        );
    }

    public static function docente_carrera(){
        $mecanica = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 1)->get();
        $sistemas = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 2)->get();
        $industrial = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 3)->get();
        $electronica = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 4)->get();
        $electrica = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 5)->get();
        $bio = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 6)->get();
        $quimica = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 7)->get();
        $gestion = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 8)->get();
        $logistica = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 9)->get();
        $mecatronica = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 10)->get();
        $cb = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 11)->get();
        $ciencias_ea = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 12)->get();
        $todas_carreras = DeteccionNecesidades::with('docente_inscrito')
            ->where('carrera_dirigido', '=', 13)->get();
        $total_mecanica = 0;
        for ($i = 0; $i < count($mecanica) - 1; $i++){
            $total_mecanica = $mecanica[$i]->docente_inscrito->count() + $mecanica[$i+1]->docente_inscrito->count();
        }
        $total_sistemas = 0;
        for ($i = 0; $i < count($sistemas) - 1; $i++){
            $total_sistemas = $sistemas[$i]->docente_inscrito->count() + $sistemas[$i+1]->docente_inscrito->count();
        }
        $total_industrial = 0;
        for ($i = 0; $i < count($industrial) - 1; $i++){
            $total_sistemas = $industrial[$i]->docente_inscrito->count() + $industrial[$i+1]->docente_inscrito->count();
        }
        $total_electronica = 0;
        for ($i = 0; $i < count($electronica) - 1; $i++){
            $total_electronica = $electronica[$i]->docente_inscrito->count() + $electronica[$i+1]->docente_inscrito->count();
        }
        $total_electrica = 0;
        for ($i = 0; $i < count($electrica) - 1; $i++){
            $total_electrica = $electrica[$i]->docente_inscrito->count() + $electrica[$i+1]->docente_inscrito->count();
        }
        $total_bio = 0;
        for ($i = 0; $i < count($bio) - 1; $i++){
            $total_electrica = $bio[$i]->docente_inscrito->count() + $bio[$i+1]->docente_inscrito->count();
        }
        $total_quimica  = 0;
        for ($i = 0; $i < count($quimica ) - 1; $i++){
            $total_electrica = $quimica [$i]->docente_inscrito->count() + $quimica[$i+1]->docente_inscrito->count();
        }
        $total_gestion = 0;
        for ($i = 0; $i < count($gestion) - 1; $i++){
            $total_gestion = $gestion[$i]->docente_inscrito->count() + $gestion[$i+1]->docente_inscrito->count();
        }
        $total_logistica = 0;
        for ($i = 0; $i < count($logistica) - 1; $i++){
            $total_logistica = $logistica[$i]->docente_inscrito->count() + $logistica[$i+1]->docente_inscrito->count();
        }
        $total_mecatronica = 0;
        for ($i = 0; $i < count($mecatronica) - 1; $i++){
            $total_mecatronica = $mecatronica[$i]->docente_inscrito->count() + $mecatronica[$i+1]->docente_inscrito->count();
        }
        $total_cb = 0;
        for ($i = 0; $i < count($cb) - 1; $i++){
            $total_cb = $cb[$i]->docente_inscrito->count() + $cb[$i+1]->docente_inscrito->count();
        }
        $total_ciencias_ea = 0;
        for ($i = 0; $i < count($ciencias_ea) - 1; $i++){
            $total_ciencias_ea= $ciencias_ea[$i]->docente_inscrito->count() + $ciencias_ea[$i+1]->docente_inscrito->count();
        }
        $total_carreras = 0;
        for ($i = 0; $i < count($todas_carreras) - 1; $i++){
            $total_carreras = $todas_carreras[$i]->docente_inscrito->count() + $todas_carreras[$i+1]->docente_inscrito->count();
        }
         return array(
            array("carrera" => "Mecánica", "total" => $total_mecanica),
            array("carrera" => "Sistemas Computacionales", "total" => $total_sistemas),
            array("carrera" => "Industrial", "total" => $total_industrial),
            array("carrera" => "Electrónica", "total" => $total_electronica),
            array("carrera" => "Electrica", "total" => $total_electrica),
            array("carrera" => "Bioquimica", "total" => $total_bio),
            array("carrera" => "Quimica", "total" => $total_quimica),
            array("carrera" => "Gestión Empresarial", "total" => $total_gestion),
            array("carrera" => "Logística", "total" => $total_logistica),
            array("carrera" => "Mecatrónica", "total" => $total_mecatronica),
            array("carrera" => "Ciencias Basicas", "total" => $total_cb),
            array("carrera" => "Ciencias Económico Administrativo", "total" => $total_ciencias_ea),
            array("carrera" => "Todas las carreras", "total" => $total_carreras),
        );
    }

    public static function fd_ap_cursos(){
        $fd = DeteccionNecesidades::where('tipo_FDoAP', 1)->get();
        $ap = DeteccionNecesidades::where('tipo_FDoAP', 2)->get();

        return array(
            array("tipo" => "Formación Docente", "total" => $fd->count()),
            array("tipo" => "Actualización Profesional", "total" => $ap->count()),
        );
    }

    public function export_excel_tipo(){
        return Excel::store(new EstadisticasExport(), '/public/estadisticas_tipo.xlsx');
    }
}
