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
            font-weight: 700;
            font-family: Calibri, sans-serif;
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
</body>

</html>
