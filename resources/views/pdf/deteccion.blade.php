<!DOCTYPE html>
<html>
<head>

    <!-- <title>Deteccion de Necesidades</title> -->
    <!-- Styles -->

    <style>

        @page { margin: 1cm 2cm 2cm 2cm;}
        body {
            /*border: 1px solid #000;*/
            font-family: "Arial", Helvetica, sans-serif;
        }
        .page_break {
            page-break-after: always;
        }
        .footer {
            position: fixed;
            bottom: -1cm;
            width: 100%;
            height: 30px;
            font-weight: normal;
            justify-content: center;
            align-content: center;
        }

        .footer p {
            display: inline-block;
            font-size: 9pt;
            margin-left: 50px;
            margin-right: 50px;
        }
        .preFooter{
            position: fixed;
            bottom: 0.5cm;
            width: 100%;
            height: 30px;
            font-weight: normal;
            justify-content: center;
            align-content: center;
        }
        .preFooter p {
            font-size: 9pt;
            font-family: "Tahoma", Geneva, sans-serif;
            display: inline-block;
            margin-left: 50px;
            margin-right: 50px;
        }
        .preFooter p a{
            font-weight: bold
        }

        .center {
            text-align: center;
            font-size: 10pt;
        }
        .leftAlinement{
            text-align: left;
            font-size: 10pt;
        }

        .uline {
            border-bottom: 1px solid #000;
        }

        .tline {
            border-top: 1px solid #000;
        }

        .header {
            width: 100%;
            text-align: center;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .header p {
            margin: 0;
            font-size: 12pt;
            margin-bottom: 10px;
        }

        .logo {

            position: fixed;
            top: 0;
            left: 0;
        }
        .logo img{
            width: 52px;
            margin-left: 35px;
            margin-top: 14px;
        }

        #title {
            font-size: 10pt;
            font-weight: bold;
            /* text-justify:inter-word; */
        }
        .titleCentered p{
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            margin: 0;
        }

        .espacio{
            margin-bottom: 20px;
        }
        .titles {
            font-size: 10pt;
            font-weight: 500;
            white-space: nowrap;
        }

        .content {
            font-size: 10pt;
            font-weight: 700;
        }

        .infoTitles {
            width: 100%;
            margin-bottom: 1pt;
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            background-color: lightgrey;
        }

        .titulo{
            width: 95%;
            margin-bottom: 19pt;
            font-size: 10pt;
            font-weight: bold;
            text-align: justify;

        }

        .w100 {
            width: 100%;
        }

        .w90 {
            width: 90%;
            text-align: right;
        }

        .w50 {
            width: 50%;
        }
        .mb-3{
            margin-bottom: 30px;
        }
        .m-0 p{
            margin: 0;
        }

        .mt-5{
            padding-top: 25px;
        }
        .mb-2{
            margin-bottom: 19px;
        }
        .mb-l{
            margin-bottom: 17px;
        }
        table.custom {
            border: 1px solid #000000;
            border-collapse: collapse;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
            font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
        }
        table.custom td, table.custom th {
            border: 1px solid #000000;
            padding: 5px 4px;
        }
        table.custom tbody td {
            font-size: 13px;
            width: 100%;
        }
        table.custom thead {
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.custom thead th {
            font-size: 13px;
            color: #000000;
            text-align: left;
            font-weight: inherit;
        }
        table.custom tfoot {
            font-size: 14px;
            font-weight: bold;
            color: #000000;
            border-top: 3px solid #000000;
        }
        table.custom tfoot td {
            font-size: 14px;
        }

        table.customA  {
            border: 1px solid #000000;
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
            margin-bottom: 20px;
        }
        table.customA td, table.customA th {
            border: 1px solid #000000;
            padding: 5px 4px;
            font-size: 9px;
        }
        table.customA tbody tr th {
            font-size: 10px;
            text-align: center;
            font-weight: inherit;
        }
        table.customA thead {
            text-anchor: middle;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.customA thead th {
            font-size: 10px;
            text-anchor: middle;
            color: #000000;
            text-align: center;
        }

    </style>

</head>

<body>
<!--primera seccion-->
<div class="w100">
    <div class="header">
        <p>
            INSTITUTO TECNOLÓGICO DE TUXTLA GUTIÉRREZ
        </p>
    </div>
    <div class="logo">
        <img src="{{public_path('/storage/img/logo.jpg')}}" alt="">
    </div>
    <div class="titleCentered espacio">
        <p>Subdirección Académica</p>
        <p>Departamento Académico: {{$cursos[0]->departamento->nameDepartamento}}</p>
    </div>
    <div class="titleCentered mb-3">
        <p>DIAGNÓSTICO DE NECESIDADES DE</p>
        <p>FORMACIÓN Y ACTUALIZACIÓN PROFESIONAL DOCENTE </p>
    </div>
    <div class="leftAlinement m-0 mb-2">
        <p  id="title">PARA LOS(AS) PROFESORES(AS) DE LA ACADEMIA DE  {{ $cursos[0]->carrera->nameCarrera }} </p>
        <p>Fecha de realización del diagnóstico: {{ $cursos[0]->created_at->format('Y-m-d') }} </p>
    </div>

    <div class="mb-l">
        <div class="leftAlinement m-0">
            <p>Jefe (a)  del Departamento Académico</p>
        </div>
        <table class="custom">
            <thead>
            <tr>
                <th >Nombre</th>
                <th >Firma</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td> {{ $cursos[0]->jefe->nombre_completo }}</td>
                <td> </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="mb-l">
        <div class="leftAlinement m-8">
            <p>Presidente (s) de Academia</p>
        </div>
        {{--            Aca va el presidente de la academia--}}
        <table class="custom">
            <thead>
            <tr>
                <th >Nombre</th>
                <th >Firma</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>  </td>
                <td>  </td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="titulo">
        <p>a) PRIORIZAR LAS DIMENSIONES DE LA EVALUACIÓN DOCENTE EN LAS QUE
            REQUIERE LA FORMACIÓN DOCENTE DE EL/LA PROFESOR(A), AVALADOS
            POR LA ACADEMIA.
        </p>
    </div>
    <table class="customA">
        <thead>
        <tr>
            <th>Dimensión(es)
                en la(s) que
                se requiere
                Formación
                Docente
            </th>
            <th>
                Competencia(s) en
                la(s) que se requiere
                la Formación
                Docente
            </th>
            <th>
                Número de
                profesores(as)
                que requieren
                Formación
                Docente
            </th>
            <th>
                Periodo en el
                que se requiere
                la Formación
                Docente (enero-junio o agosto-
                diciembre)
            </th>
            <th>
                Facilitador
                (a) que
                impartirá el
                curso/taller
            </th>
            <th>
                Modalidad
            </th>
        </tr>
        </thead>
        @foreach($cursos as $curso)
            @if($curso->tipo_FDoAP == 1)
                @if(count($cursos) == 0)
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                @else
                    <tbody>
                    <tr>
                        <td class="text-sm-h6">{{$curso->asignaturaFA}}</td>
                        <td>{{$curso->contenidosTM}}</td>
                        <td>{{$curso->numeroProfesores}}</td>
                        <td>
                            @if($curso->periodo === 1)
                                ENERO-JUNIO
                            @else
                                AGOSTO-DICIEMBRE
                            @endif
                        </td>
                        <td>
                            @foreach($curso->deteccion_facilitador as $facilitador)
                                {{$facilitador->nombre_completo }}
                            @endforeach
                            @if($curso->facilitador_externo)
                                {{$curso->facilitador_externo}}
                            @endif
                        </td>
                        <td>
                            @if($curso->modalidad == 1)
                                Virtual
                            @elseif($curso->modalidad == 2)
                                Presencial
                            @elseif($curso->modalidad == 3)
                                Híbrido
                            @endif
                        </td>
                    </tr>
                    </tbody>
                @endif
            @endif
        @endforeach
    </table>
    <div class="titulo">
        <p>b) PRIORIZAR LAS ASIGNATURAS EN LAS QUE REQUIERE ACTUALIZACIÓN
            PROFESIONAL DE EL/LA PROFESOR(A), AVALADOS POR LA ACADEMIA.</p>
    </div>
    <div class="w100">
        <table class="customA">
            <thead>
            <tr>
                <th>Asignatura(s)
                    en la(s) que
                    se requiere
                    Actualización
                    profesional
                </th>
                <th>Contenidos
                    temáticos en que se
                    requiere
                    Actualización
                    Profesional</th>
                <th>Número de
                    profesores
                    (as) que
                    requieren
                    Actualización
                    Profesional
                </th>
                <th>Periodo en el
                    que se requiere
                    la Actualización
                    Profesional
                    (enero-junio o
                    agosto
                    diciembre)
                </th>
                <th>Facilitador
                    (a) que
                    impartirá el
                    curso/taller</th>
                <th>
                    Modalidad
                </th>
            </tr>
            </thead>
            @foreach($cursos as $curso)
                @if($curso->tipo_FDoAP == 2)
                    @if(count($cursos) == 0)
                        <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        </tbody>
                    @else
                        <tbody>
                        <tr>
                            <td class="text-sm-h6">{{$curso->asignaturaFA}}</td>
                            <td>{{$curso->contenidosTM}}</td>
                            <td>{{$curso->numeroProfesores}}</td>
                            <td>
                                @if($curso->periodo === 1)
                                    ENERO-JUNIO
                                @else
                                    AGOSTO-DICIEMBRE
                                @endif
                            </td>
                            <td>
                                @foreach($curso->deteccion_facilitador as $facilitador)
                                    {{$facilitador->nombre_completo }}
                                @endforeach
                            </td>
                            <td>
                                @if($curso->modalidad == 1)
                                    Virtual
                                @elseif($curso->modalidad == 2)
                                    Presencial
                                @elseif($curso->modalidad == 3)
                                    Híbrido
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    @endif
                @endif
            @endforeach
        </table>
        <div class="preFooter">
            <p>
                <a>Nota: </a> La formación docente estará atendida prioritariamente con el Programa Nacional de Formación Docente Centrado en el Aprendizaje (Formación DOCA)
            </p>
        </div>
        <div class="footer" style="padding-top:10px">
            <!--  i will make this dinamic for sure -->
            <p style="display:inline;float:left">ITTG-AC-PO-006-01  </p>
            <p style="display:inline;float:right"> Rev.{{0}} </p>
        </div>
    </div>
</div>
<div class="page_break"></div>
<div class="w100">
    <div class="logo">
        <img src="{{public_path('/storage/img/logo.jpg')}}" alt="">
    </div>
    <div class="header">
        <p>INSTITUTO TECNOLÓGICO DE TUXTLA GUTIÉRREZ</p>
    </div>
    <div class="titleCentered mb-3">
        <p>CONCENTRADO DEL DIAGNÓSTICO DE NECESIDADES DE</p>
        <p>FORMACIÓN DOCENTE Y ACTUALIZACIÓN PROFESIONAL</p>
    </div>
    <div class="titulo">
        <p>c) ACTIVIDADES O EVENTOS QUE SE LLEVARÁN A CABO PARA LA FORMACIÓN
            DOCENTE DE EL/LA PROFESOR(A) EN LAS DIMENSIONES DE LA EVALUACIÓN
            DOCENTE</p>
    </div>
    <table class="customA">
        <thead>
        <tr>
            <th>Nombre del curso, taller,
                conferencias, etc.</th>
            <th>
                Fecha en que se
                realizará la actividad
                o evento
            </th>
            <th>
                Horario en que
                se realizará la
                actividad o
                evento
            </th>
            <th>
                Objetivo de la
                actividad o
                evento
            </th>
        </tr>
        </thead>
        @foreach($cursos as $curso)
            @if($curso->tipo_FDoAP == 1)
                @if(count($cursos) == 0)
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                @else
                    <tbody>
                    <tr>
                        <td class="text-sm-h6">{{$curso->nombreCurso}}</td>
                        <td>{{$curso->fecha_I}} al {{$curso->fecha_F}}</td>
                        <td>{{$curso->hora_I}} - {{$curso->hora_F}}</td>
                        <td>
                            {{$curso->objetivoEvento}}
                        </td>
                    </tr>
                    </tbody>
                @endif
            @endif
        @endforeach
    </table>
    <div class="titulo">
        <p>d) ACTIVIDADES O EVENTOS QUE SE LLEVARÁN A CABO PARA LA
            ACTUALIZACIÓN PROFESIONAL DE EL/LA PROFESOR(A) EN ASIGNATURAS
            QUE SE REQUIEREN.</p>
    </div>
    <table class="customA">
        <thead>
        <tr>
            <th>Nombre del curso, taller,
                conferencias, etc.</th>
            <th>
                Fecha en que se
                realizará la actividad
                o evento
            </th>
            <th>
                Horario en que
                se realizará la
                actividad o
                evento
            </th>
            <th>
                Objetivo de la
                actividad o
                evento
            </th>
        </tr>
        </thead>
        @foreach($cursos as $curso)
            @if($curso->tipo_FDoAP == 2)
                @if(count($cursos) == 0)
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                @else
                    <tbody>
                    <tr>
                        <td class="text-sm-h6">{{$curso->nombreCurso}}</td>
                        <td>{{$curso->fecha_I}} al {{$curso->fecha_F}}</td>
                        <td>{{$curso->hora_I}} - {{$curso->hora_F}}</td>
                        <td>
                            {{$curso->objetivoEvento}}
                        </td>
                    </tr>
                    </tbody>
                @endif
            @endif
        @endforeach
    </table>
    <div class="mb-l mt-5">
        <div class="leftAlinement m-0">
            <p>Subdirección Académica</p>
        </div>
        <table class="custom">
            <thead>
            <tr>
                <th>Nombre </th>
                <th>Firma </th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>
                    @if(empty($subdireccion))

                    @else
                        {{$subdireccion[0]->name}}
                    @endif
                </td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="mb-l">
        <div class="leftAlinement m-0">
            <p>
                Jefa(e) de Departamento Académico
            </p>
        </div>
        <table class="custom">
            <thead>
            <tr>
                <th>Nombre</th>
                <th>Departamento</th>
                <th>Firma</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>{{$cursos[0]->jefe->nombre_completo}}</td>
                <td>{{$cursos[0]->departamento->nameDepartamento}}</td>
                <td></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="preFooter">
        <p><a>Nota: </a> La formación docente estará atendida prioritariamente con el Programa Nacional de Formación Docente Centrado en el Aprendizaje (Formación DOCA)</p>
    </div>
    <div class="footer" style="padding-top:10px">
        <!--  i will make this dinamic for sure -->
        <p style="display:inline;float:left"> ITTG-AC-PO-006-01  </p>
        <p style="display:inline;float:right"> Rev.{{0}} </p>
    </div>
</div>
</body>

</html>
