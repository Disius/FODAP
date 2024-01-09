<html >
<head>

    <!-- <title></title> -->
    <!-- Styles -->

    <style>
        @page { margin: 1cm 2cm 2cm 2cm;}
        body {
            /*border: 1px solid #000;*/
        }
        .page_break { page-break-after: always; }
        .footer {
            width: 100%;
            position: fixed;
            bottom: 0.5cm;
            /*position: fixed;*/
            /*bottom: -1cm;*/
            /*width: 100%;*/
            /*height: 30px;*/
            /*font-weight: normal;*/
            /*justify-content: center;*/
            /*align-content: center;*/
        }

        .footer p {
            font-size: 9pt;
        }

        .center {
            text-align: center;
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
        }

        .header p {
            margin: 0;
            font-size: 10pt;
            font-family: Calibri, sans-serif;
        }

        .logo {
            position: fixed;
            top: 0;
            left: 0;
        }
        .logo img {
            width: 75px;
            height: 60px;
        }

        #title {
            font-size: 14pt;
            font-weight: bold;
            font-family: Calibri, sans-serif;
        }

        .titles {
            font-size: 10pt;
            font-weight: 500;
            white-space: nowrap;
            font-family: Calibri, sans-serif;
        }

        .content {
            font-size: 10pt;
            font-family: Calibri, sans-serif;
            font-weight: normal;
        }

        .infoTitles {
            width: 100%;
            font-family: Calibri, sans-serif;
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            background-color: lightgrey;

        }
        .justify {
            margin-bottom: 25px;
        }

        .w100 {
            width: 100%;
        }

        .w90 {
            width: 90%;
        }

        .w50 {
            width: 50%;
        }

    </style>

</head>

<body>
    <header class="header">
        <p>SUBSECRETARIA DE EDUCACIÓN SUPERIOR</p>
        <p>TECNOLOGICO NACIONAL DE MÉXICO</p>
        <p>SECRETARIA ACADÉMICA DE INVESTIGACIÓN E INNOVACIÓN</p>
        <p>DIRECCIÓN DE DOCENCIA E INNOVACIÓN EDUCATIVA</p>
    </header>
    <div class="logo">
        <img src="{{public_path('/storage/img/logo.jpg')}}" alt="">
    </div>
    <div class="center">
        <p id="title">CÉDULA DE INSCRIPCIÓN</p>
    </div>
    <div class="justify">
        <table style="float: right">
            <tr>
                <td class="titles">FECHA: </td>
                <td class="uline content" style="width: 100px">{{date('Y-m-d')}} </td>
            </tr>
        </table>
    </div>
    <div class="w100">
        <p class="infoTitles">DATOS DEL EVENTO</p>
    </div>
    <table class="w100">
        <tr>
            <td class="titles">CLAVE DEL CURSO:</td>
            <td class="uline content w100"> {{ $curso->id }} </td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">NOMBRE DEL CURSO:</td>
            <td class="uline content w100"> {{$curso->nombreCurso}} </td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">NOMBRE DE INSTRUCTOR(ES):</td>

            <td class="uline content w100">
                @if(count($curso->deteccion_facilitador) == 1)
                    {{$curso->deteccion_facilitador[0]->nombre_completo}}
                @elseif(count($curso->deteccion_facilitador) == 2)
                    {{$curso->deteccion_facilitador[0]->nombre_completo}}
                    {{$curso->deteccion_facilitador[1]->nombre_completo}}
                @else
                    {{$curso->deteccion_facilitador[0]->nombre_completo}}
                    {{$curso->deteccion_facilitador[1]->nombre_completo}}
                    {{$curso->deteccion_facilitador[2]->nombre_completo}}
                @endif
            </td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">PERIODO DE REALIZACIÓN:</td>
            <td class="uline content w100">
                @if($curso->periodo == 1)
                    enero-junio
                @else
                    agosto-diciembre
                @endif
            </td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">HORARIO:</td>
            <td class="uline content w90"> {{$curso->hora_I}} - {{$curso->hora_F}} </td>
            <td class="titles">DURACIÓN:</td>
            <td class="uline content w100"> {{$curso->total_horas}} Horas </td>
        </tr>
    </table>

    <p class="infoTitles">DATOS PERSONALES</p>

    <table style="float: right;padding-right:1cm;">
        @if($docente->sexo == 1)
            <tr>
                <td class="titles">HOMBRE</td>
                <td class="content" style="width:50px">( X )</td>
                <td class="titles">MUJER</td>
                <td class="content">( )</td>
            </tr>
        @elseif($docente->sexo == 2)
            <tr>
                <td class="titles">HOMBRE</td>
                <td class="content" style="width:50px">( )</td>
                <td class="titles">MUJER</td>
                <td class="content">( X )</td>
            </tr>
        @else
            <tr>
                <td class="titles">HOMBRE</td>
                <td class="content" style="width:50px">( )</td>
                <td class="titles">MUJER</td>
                <td class="content">( )</td>
            </tr>
        @endif
    </table>

    <br><br>

    <table class="w100">
        <tr>
            <td class="titles">NOMBRE:</td>
            <td class="uline content center" style="width:30%"> {{$docente->apellidoPat}} </td>
            <td class="uline content center" style="width:30%"> {{$docente->apellidoMat}} </td>
            <td class="uline content center" style="width:30%"> {{$docente->nombre}} </td>
        </tr>
        <tr>
            <td></td>
            <td class="titles center">APELLIDO PATERNO</td>
            <td class="titles center">APELLIDO MATERNO</td>
            <td class="titles center">NOMBRE(S)</td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">R.F.C.:</td>
            <td class="uline content w50"> {{$docente->rfc}} </td>
            <td class="titles">CURP:</td>
            <td class="uline content w50"> {{$docente->curp}} </td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">CORREO ELECTRÓNICO INSTITUCIONAL:</td>
            <td class="uline content w100"> {{$docente->usuario->email}} </td>
        </tr>
    </table>

    <table class="w100">
        <tr>
            <td class="titles">NOMBRE DEL ÚLTIMO GRADO DE ESTUDIOS:</td>
            <td class="uline content w100">{{$docente->posgrado->nombre}}</td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">LICENCIATURA:</td>
            <td class="uline content w100"> {{$docente->licenciatura}} </td>
        </tr>
    </table>
    <p class="infoTitles">DATOS LABORALES</p>

    <table style="float:right;padding-right:1cm;">
        <tr>
            @if($docente->tipo_plaza == 1)
                <td class="titles">DIRECTIVO</td>
                <td class="content" style="width:50px">( X )</td>
                <td class="titles">DOCENTE / INTERINATO</td>
                <td class="content" style="width:50px">( )</td>
                <td class="titles">HONORARIOS</td>
                <td class="content">( )</td>
            @elseif($docente->tipo_plaza == 2)
                <td class="titles">DIRECTIVO</td>
                <td class="content" style="width:50px">( )</td>
                <td class="titles">DOCENTE / INTERINATO</td>
                <td class="content" style="width:50px">( X )</td>
                <td class="titles">HONORARIOS</td>
                <td class="content">( )</td>
            @elseif($docente->tipo_plaza == 3)
                <td class="titles">DIRECTIVO</td>
                <td class="content" style="width:50px">( )</td>
                <td class="titles">DOCENTE / INTERINATO</td>
                <td class="content" style="width:50px">( )</td>
                <td class="titles">HONORARIOS</td>
                <td class="content">( X )</td>
            @endif
        </tr>
    </table>
    <br><br>
    <table class="w100">
        <tr>
            <td class="titles">INSTITUTO TECNOLÓGICO O CENTRO:</td>
            <td class="uline content w100"> ITTG </td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">ÁREA DE ADSCRIPCIÓN:</td>
            <td class="uline content w100"> {{ $docente->departamento->nameDepartamento }} </td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">PUESTO QUE DESEMPEÑA:</td>
            <td class="uline content w100"> {{$docente->puesto->nombre}} </td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">NOMBRE DEL JEFE INMEDIATO:</td>
            <td class="uline content w100"> {{$docente->departamento->jefe_docente->nombre_completo}} </td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">TELÉFONO DE CONTACTO:</td>
            <td class="uline content w100"> {{$docente->telefono }} </td>
        </tr>
    </table>
    <table class="w100">
        <tr>
            <td class="titles">HORARIO LABORAL:</td>
            <td class="uline content w100">  </td>
        </tr>
    </table>
    <br><br><br><br><br>
    <table style="float:right">
        <tr>
            <td class="tline titles center" style="width:8cm">FIRMA</td>
        </tr>
    </table>
    <div class="footer">
        <p style="float:left">ITTG-AD-PO-006-04</p>
        <p style="display:inline;float:right;">Rev. {{0}}</p>
    </div>
</body>

</html>
