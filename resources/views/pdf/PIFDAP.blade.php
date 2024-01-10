<html >
<head>

    <!-- <title></title> -->
    <!-- Styles -->

    <style>
        @page { margin: 3cm 1cm 2cm;}
        body {
            /*border: 1px solid #000;*/
        }

        .header {
            position: absolute;
            top: -0.5cm;
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
        .header2 {
            position: absolute;
            top: -0.5cm;
            width: 100%;
            height: 100px;
            text-align: center;
            font-weight: bold;
            margin-left: 50px;
        }

        .header2 p {
            margin: 0;
            font-size: 10pt;
            font-family: "Arial", "Helvetica", sans-serif;
            font-weight: bold;
        }

        .logo {
            position: fixed;
            top: -2.0cm;
            left: 1.8cm;
        }

        .logo img {
            width: 75px;
            height: 60px;
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

        .custom_table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            border: 1px solid black;
            margin-top: 50px;
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

        #firma {
            page-break-inside: avoid;
        }

    </style>

</head>

<body>
    <div class="header">
        <p>PROGRAMA INSTITUCIONAL DE FORMACIÓN DOCENTE</p>
        <p>INSTITUTO TECNOLÓGICO DE TUXTLA GUTIERREZ</p>
        @if($periodo == 1)
            <p>PERIODO ENERO-JUNIO {{$anio}}</p>
        @else
            <p>PERIODO AGOSTO-DICIEMBRE {{$anio}}</p>
        @endif
    </div>
    <div class="logo">
        <img src="{{public_path('/storage/img/logo.jpg')}}" alt="">
    </div>
    <div class="footer">
        <p>ITTG-AC-PO-006-02</p>
        <p style="float:right;margin-top: 23px">Rev.{{0}}</p>
    </div>
{{--    Tabla de formacion docente--}}
    @if(count($FD) == 0)
        <table class="custom_table">
            <thead>
            <tr>
                <th>No.</th>
                <th>Nombre de los Cursos</th>
                <th>Objetivo</th>
                <th>Fecha de realización</th>
                <th>Lugar donde se realizara el curso</th>
                <th>Modalidad (presencial o virtual)</th>
                <th>Horario</th>
                <th>No. de horas x curso</th>
                <th>Facilitador (a)</th>
                <th>Dirigido a:</th>
                <th>Observaciones</th>
            </tr>
            </thead>

                <tbody>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
        </table>
    @else
        <table class="custom_table">
            <thead>
            <tr>
                <th>No.</th>
                <th>Nombre de los Cursos</th>
                <th>Objetivo</th>
                <th>Fecha de realización</th>
                <th>Lugar donde se realizara el curso</th>
                <th>Modalidad (presencial o virtual)</th>
                <th>Horario</th>
                <th>No. de horas x curso</th>
                <th>Facilitador (a)</th>
                <th>Dirigido a:</th>
                <th>Observaciones</th>
            </tr>
            </thead>
            @php
                $count = 1;
            @endphp
            @foreach($FD as $curso)
                <tbody>
                <tr>
                    <td>
                        {{$count++}}
                    </td>
                    <td>{{$curso->nombreCurso}}</td>
                    <td>{{$curso->objetivoEvento}}</td>
                    <td>{{$curso->fecha_I}} A {{$curso->fecha_F}}</td>
                    <td>
                        @if($curso->lugar !== null)
                            {{$curso->lugar->nombreAula}}
                        @else
                            SIN ASIGNAR
                        @endif
                    </td>
                    <td>
                        @if($curso->modalidad == 1)
                            Virtual
                        @elseif($curso->modalidad == 2)
                            Presencial
                        @else
                            Híbrido
                        @endif
                    </td>
                    <td>{{$curso->hora_I}} A {{$curso->hora_F}}</td>
                    <td>{{$curso->total_horas}}</td>
                    <td>
                        @if(count($curso->deteccion_facilitador) == 0)
                            {{$curso->facilitador_externo}}
                        @else
                            @foreach($curso->deteccion_facilitador as $facilitador)
                                {{$facilitador->nombre_completo}}.
                            @endforeach
                        @endif
                    </td>
                    <td>{{$curso->carrera->nameCarrera}}</td>
                    <td>{{$curso->observaciones}}</td>
                </tr>
                </tbody>
            @endforeach
        </table>
    @endif

    <table class="custom_table" id="firma" cellspacing="0" width="50%" style="text-align:center;margin-left:auto;margin-right:auto">
        <tr>
            <td style="font-weight: bold;">Elaboró</td>
            <td style="font-weight: bold;">Aprobó</td>
        </tr>
        <tr>
            <td style="height:60px; position: relative"> {{ $departamento->jefe_docente->nombre_completo }}
                {{--                <div style="position: absolute; left: 0; margin-top: 8px; font-size: 13px;font-weight: bold;"> Jefe de Desarrollo Académico </div>--}}
            </td>
            <td style="position: relative;"> {{ $subdireccion[0]->name }}
                {{--                <div style="position: absolute; left: 0; margin-top: 8px; font-size: 13px;font-weight: bold;"> Subdirector Académico</div>--}}
            </td>
        </tr>
        <tr>
            <td>
                {{--                <div style="position: absolute; left: 0; margin-top: 8px; font-size: 13px;font-weight: bold;">--}}
                <div style="font-weight: bold;">
                    Nombre y Firma
                </div>
                {{--                </div>--}}
                <div style="font-weight: bold;">
                    Jefa(e) de Departamento de Desarrollo
                    Académico
                </div>
            </td>
            <td>
                <div style="font-weight: bold">
                    Nombre y Firma
                </div>
                <div style="font-weight: bold">
                    Subdirector(a) Académico(a)
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:left">Fecha de elaboración: {{ $AP[0]->created_at->format('Y-m-d') }}</td>
            <td style="text-align:left">Fecha de aprobación: {{ $AP[0]->updated_at->format('Y-m-d')}}</td>
        </tr>
    </table>
    <div style="page-break-before: always"></div>

    <div class="header2">
        <p>PROGRAMA INSTITUCIONAL DE ACTUALIZACIÓN PROFESIONAL</p>
        <p>INSTITUTO TECNOLÓGICO DE TUXTLA GUTIERREZ</p>
        @if($periodo == 1)
            <p>PERIODO ENERO-JUNIO {{$anio}}</p>
        @else
            <p>PERIODO AGOSTO-DICIEMBRE {{$anio}}</p>
        @endif
    </div>
    @if(sizeof($AP) == 0)
        <table class="custom_table">
            <thead>
            <tr>
                <th>No.</th>
                <th>Nombre de los Cursos</th>
                <th>Objetivo</th>
                <th>Fecha de realización</th>
                <th>Lugar donde se realizara el curso</th>
                <th>Modalidad (presencial o virtual)</th>
                <th>Horario</th>
                <th>No. de horas x curso</th>
                <th>Facilitador (a)</th>
                <th>Dirigido a:</th>
                <th>Observaciones</th>
            </tr>
            </thead>

            <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
    @else
        <table class="custom_table">
            <thead>
            <tr>
                <th>No.</th>
                <th>Nombre de los Cursos</th>
                <th>Objetivo</th>
                <th>Fecha de realización</th>
                <th>Lugar donde se realizara el curso</th>
                <th>Modalidad (presencial o virtual)</th>
                <th>Horario</th>
                <th>No. de horas x curso</th>
                <th>Facilitador (a)</th>
                <th>Dirigido a:</th>
                <th>Observaciones</th>
            </tr>
            </thead>
            @php
                $count = 1;
            @endphp
            @foreach($AP as $curso)
                <tbody>
                <tr>
                    <td>
                        {{$count++}}
                    </td>
                    <td>{{$curso->nombreCurso}}</td>
                    <td>{{$curso->objetivoEvento}}</td>
                    <td>{{$curso->fecha_I}} A {{$curso->fecha_F}}</td>
                    <td>
                        @if($curso->lugar !== null)
                            {{$curso->lugar->nombreAula}}
                        @else
                            SIN ASIGNAR
                        @endif
                    </td>
                    <td>
                        @if($curso->modalidad == 1)
                            Virtual
                        @elseif($curso->modalidad == 2)
                            Presencial
                        @else
                            Híbrido
                        @endif
                    </td>
                    <td>{{$curso->hora_I}} A {{$curso->hora_F}}</td>
                    <td>{{$curso->total_horas}}</td>
                    <td>
                        @if(count($curso->deteccion_facilitador) == 0)
                            {{$curso->facilitador_externo}}
                        @else
                             @foreach($curso->deteccion_facilitador as $facilitador)
                                {{$facilitador->nombre_completo}}.
                             @endforeach
                        @endif
                    </td>
                    <td>{{$curso->carrera->nameCarrera}}</td>
                    <td>{{$curso->observaciones}}</td>
                </tr>
                </tbody>
            @endforeach
        </table>
    @endif

    <br>
{{--    <div style="page-break-before: always;"></div>--}}
    <table class="custom_table" id="firma" cellspacing="0" width="50%" style="text-align:center;margin-left:auto;margin-right:auto">
        <tr>
            <td style="font-weight: bold;">Elaboró</td>
            <td style="font-weight: bold;">Aprobó</td>
        </tr>
        <tr>
            <td style="height:60px; position: relative"> {{ $departamento->jefe_docente->nombre_completo }}
{{--                <div style="position: absolute; left: 0; margin-top: 8px; font-size: 13px;font-weight: bold;"> Jefe de Desarrollo Académico </div>--}}
            </td>
            <td style="position: relative;"> {{ $subdireccion[0]->name }}
{{--                <div style="position: absolute; left: 0; margin-top: 8px; font-size: 13px;font-weight: bold;"> Subdirector Académico</div>--}}
            </td>
        </tr>
        <tr>
            <td>
{{--                <div style="position: absolute; left: 0; margin-top: 8px; font-size: 13px;font-weight: bold;">--}}
                    <div style="font-weight: bold;">
                        Nombre y Firma
                    </div>
{{--                </div>--}}
                <div style="font-weight: bold;">
                    Jefa(e) de Departamento de Desarrollo
                    Académico
                </div>
            </td>
            <td>
                <div style="font-weight: bold">
                    Nombre y Firma
                </div>
                <div style="font-weight: bold">
                    Subdirector(a) Académico(a)
                </div>
            </td>
        </tr>
        <tr>
            <td style="text-align:left">Fecha de elaboración: {{ $AP[0]->created_at->format('Y-m-d') }}</td>
            <td style="text-align:left">Fecha de aprobación: {{ $AP[0]->updated_at->format('Y-m-d')}}</td>
        </tr>
    </table>
</body>

</html>
