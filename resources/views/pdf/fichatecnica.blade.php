<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha Técnica</title>

    <style>
        .header {
            display: flex;
            /* top: -0.5cm; */
            margin-top: 50px;
            width: 100%;
            height: 100px;
            text-align: center;
            font-weight: bold;
        }

        .header p {
            margin: 0;
            font-size: 10pt;
            font-family: "Arial", "Helvetica", sans-serif;
            font-weight: bold;
        }
        . text_init {
            justify-content: start;
            align-content: start;
            width: 100%;
            position: absolute;
        }
        .text_init p {
            margin: 0;
            font-size: 1pt;
            font-family: "Soberana Sans";
            font-weight: normal;
        }
        .text-middle {
            display: flex;

        }
        . title {
            display: flex;
            width: 100px;
            height: 100px;
            margin-left: 60px;
            margin-top: 50px;
        }
        . title  p {
            margin: 0;
            font-size: 12pt;
            font-family: "Soberana Sans";
            font-weight: normal;
            width: 100%;
        }
        . words_minus {
            display: flex;
        }
        . words_minus p {
            display: flex;
            margin-left: 100px;
        }
        .custom_table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
        }

        .custom_table td,th {
            border: 1px solid #000;
        }


        .custom_table th {
            text-align: center;
            font-size: 8pt;
            font-weight: bold;
            /*white-space: nowrap;*/
        }

        .custom_table tbody {
            text-align: center;
            font-size: 8pt;
        }

        .firmas {
            margin-left: 80px;
        }
        .uline {
            border-bottom: 1px solid #000;
        }
        .final_part {
            display: flex;
        }
        .words_strong {
            font-weight: bold;
            font-size: 8pt;
        }
        .margen-izquierdo {
            margin-right: 100px;
            margin-top: 1px;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>FICHA TÉCNICA DEL SERVICIO DE ACTUALIZACION PROFESIONAL Y</p>
        <p>FORMACIÓN DOCENTE</p>
        <p>M00-SC-029-A02</p>
    </div>

    <div class="text-init">
        <p><b>Instituto Tecnológico o Centro o Unidad:</b> {{$name_instituto[0]->name}}</p>
        <p><b>Nombre del Curso:</b> {{$ficha->curso_ficha->nombreCurso}}</p>
        @if(count($ficha->curso_ficha->deteccion_facilitador) > 0)
            <p><b>Instructor(a):</b> {{$ficha->curso_ficha->deteccion_facilitador[0]->nombre_completo}}</p>
        @elseif($ficha->curso_ficha->facilitador_externo != null)
            <p><b>Instructor(a):</b> {{$ficha->curso_ficha->facilitador_externo}}</p>
        @endif
    </div>
    <div class="text-middle">
        <p class="title">• Introducción</p>
        <p class="text-middle">{{$ficha->introduccion}}</p>
    </div>
    <div class="text-middle">
        <p class="title">• Justificación</p>
        <p class="text-middle">{{$ficha->justificacion}}</p>
    </div>
    <div class="text-middle">
        <p class="title">• 	Objetivo General</p>
        <p class="text-middle">{{$ficha->objetivo_general}}</p>
    </div>
    <div class="text-middle">
        <p class="title">• 	Descripción del curso</p>
    </div>
    <div class="words_minus">
        <p>
            <b>a.</b>	Especificar tipo de curso:
            @if($ficha->tipo_servicio == 1)
                TALLER
            @elseif($ficha->tipo_servicio == 2)
                CURSO
            @elseif($ficha->tipo_servicio == 3)
                CURSO-TALLER
            @elseif($ficha->tipo_servicio == 4)
                FORO
            @elseif($ficha->tipo_servicio == 5)
                SEMINARIO
            @elseif($ficha->tipo_servicio == 6)
                DIPLOMADO
            @endif
        </p>
        <p>
            <b>b.</b>	Duración en horas del curso: {{$ficha->duracion}} hrs
        </p>
        <p>
            <b>c.</b>	Contenido temático del curso
        </p>
    </div>
    <div>
        <table class="custom_table">
            <thead>
            <tr>
                <th>Temas</th>
                <th>Tiempo Programado (HRS)</th>
                <th>Actividades de aprendizaje</th>
            </tr>
            </thead>

            @foreach($ficha->temas as $tema)
                <tbody>
                <tr>
                    <td>{{$tema->name_tema}}</td>
                    <td>{{$tema->tiempo_programado}} hrs</td>
                    <td>{{$tema->act_aprendizaje}}</td>
                </tr>
                </tbody>
            @endforeach
        </table>
    </div>
    <div style="page-break-after: always;"></div>
    <div class="words_minus">
        <p>
            <b>d.</b>	Elementos didácticos para el desarrollo del curso:  {{$ficha->elementos_didacticos}}
        </p>
        <p>
            <b>e.</b>	Criterio de evaluación:
        </p>
    </div>
    <div>
        <table class="custom_table">
            <thead>
            <tr>
                <th>No.</th>
                <th>Criterio</th>
                <th>Valor</th>
                <th>Instrumento de evaluación</th>
            </tr>
            </thead>
            @php
                $count = 1;
            @endphp
            @foreach($ficha->evaluacion_criterio as $eval)
                <tbody>
                <tr>
                    <td>{{$count++}}</td>
                    <td>{{$eval->criterio}}</td>
                    <td>{{$eval->valor}} %</td>
                    <td>{{$eval->instrumento_evaluacion}}</td>
                </tr>
                </tbody>
            @endforeach
        </table>
    </div>
    <div class="text-middle">
        <p class="title">•	Competencias a desarrollar: </p>
        <p class="text-middle">
            {{$ficha->competencias_desarrollar}}
        </p>
    </div>
    <div class="text-middle">
        <p class="title">•	Fuentes de Información:  </p>
        <p class="text-middle">{{$ficha->fuentes_informacion}}</p>
    </div>

    <div class="final_part">
        <div style="float: left;">
            @if(count($ficha->curso_ficha->deteccion_facilitador) > 0)
                <p class="uline firmas">{{$ficha->curso_ficha->deteccion_facilitador[0]->nombre_completo}}</p>
            @elseif($ficha->curso_ficha->facilitador_externo != null)
                <p class="uline firmas">{{$ficha->curso_ficha->facilitador_externo}}</p>
            @endif
            <p class="firmas words_strong">Nombre y Firma del Facilitador(a)</p>
        </div>
        <div style="float: right;" class="margen-izquierdo">
            <p class="uline firmas">{{$departamento->jefe_docente->nombre_completo}}</p>
            <p class="firmas words_strong">Nombre y Firma del Jefe(a) de Desarrollo Académico.</p>
        </div>
    </div>
</body>
</html>
