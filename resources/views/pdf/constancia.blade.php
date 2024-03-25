<html>
<head>

    <!-- <title></title> -->
    <!-- Styles -->
{{--    <link rel="preconnect" href="https://fonts.googleapis.com">--}}
{{--    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet">--}}
   <style>
        @font-face {
            font-family: 'Montserrat-ExtraBold', sans-serif;
            font-weight: 800;
            /* Asegúrate de que la ruta y el formato coincidan con los archivos descargados */
        }
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            background-image: url({{ public_path('/storage/Membretado/'.$year.'/img_constancia.jpg') }});
            background-size: cover; /* O ajusta según tus necesidades (p. ej., contain) */
            background-position: center; /* Ajusta según tus necesidades */
            background-repeat: no-repeat;
            min-height: 100vh; /* Asegura que el cuerpo tenga al menos la altura de la ventana gráfica (viewport height) */
            display: flex;
            flex-direction: column;
            font-family: 'Montserrat-Black', sans-serif;
        }
        table {
            width: 100%;
        }
    </style>

</head>

<body style="">
    <div style="margin-top: 160px"></div>
    <table width="100%" style="margin-left: 15px">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 18pt; font-weight: bolder">
                EL TECNOLÓGICO NACIONAL DE MÉXICO
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-left: 15px">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 14pt; font-weight: bold">
                A TRAVÉS DEL {{$instituto[0]->name}}
            </td>
        </tr>
    </table>
    <div style="margin-top: 20px"></div>
    <table width="100%" style="margin-left: 15px">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-Black', sans-serif; font-size: 14pt;">
                OTORGA LA PRESENTE
            </td>
        </tr>
    </table>
    <div style="margin-top: 20px"></div>
    <table width="100%" style="margin-left: 15px">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 22pt; font-weight: bold">
                CONSTANCIA
            </td>
        </tr>
    </table>
    <div style="margin-top: 20px"></div>
    <table width="100%" style="margin-left: 15px">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-Black', sans-serif; font-size: 14pt;">
                A
            </td>
        </tr>
    </table>
    <div style="margin-top: 20px"></div>
    <table width="100%" style="margin-left: 15px">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 24pt; font-weight: bold;">
                {{$docente->nombre_completo}}
            </td>
        </tr>
    </table>
    <div style="margin-top: 50px"></div>
    <table width="100%" style="margin-left: 15px">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-Black', sans-serif; font-size: 14pt;">
                Por su destacada participación en el
                @if($curso->tipo_actividad == 1)
                    Taller
                @elseif($curso->tipo_actividad == 2)
                    Curso
                @elseif($curso->tipo_actividad == 3)
                    Curso/taller
                @elseif($curso->tipo_actividad == 4)
                    Foro
                @elseif($curso->tipo_actividad == 5)
                    Seminario
                @elseif($curso->tipo_actividad == 6)
                    Diplomado
                @endif
            </td>
        </tr>
    </table>
    <div style="margin-top: 10px"></div>
    <table width="100%" style="margin-left: 15px">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-Black', sans-serif; font-size: 16pt; font-weight: bold;">
                "{{$curso->nombreCurso}}"
            </td>
        </tr>
    </table>
    <table style="margin-left: 20px">
        <tr>
            <td style="text-align: justify; font-family: 'Montserrat-Black', sans-serif; font-size: 10pt; width: 20%; padding: 20px 90px 20px 90px">
                Que dentro del programa Institucional de Formación Docente y Actualización Profesional @if($curso->periodo === 1)
                    Enero-Junio
                @else
                    Agosto-Diciembre
                @endif
                {{$year}} se llevó a cabo en este instituto, del {{$formatFechasI[2]}} al {{$formatFechasF[2]}} de {{$month[0]}} de {{$formatFechasF[0]}}, con una duración de {{$docente->inscrito[0]->total_horas}} horas.
            </td>
        </tr>
    </table>
    <div style="margin-top: 15px"></div>
    <table>
        <tr>
            <td style="text-align: justify; font-family: 'Montserrat-Black', sans-serif; font-size: 8pt; padding-left: 420px">
                Tuxtla Gutierrez, Chiapas; {{$month[2]}} {{$month[1]}} de {{$formatFechasF[0]}}
            </td>
        </tr>
    </table>
    <div style="margin-top: 120px"></div>
    <table>
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 9pt;  font-weight: bold;padding-left: 50px">
                {{mb_strtoupper($director[0]->nameDirector, 'UTF-8')}}
            </td>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 9pt;  font-weight: bold; padding-right: 70px">
                            @if(count($facilitador) != 0)
                                {{mb_strtoupper($facilitador[0]->nombre_completo, 'UTF-8')}}
                            @else
                                {{mb_strtoupper($curso->facilitador_externo, 'UTF-8')}}
                            @endif
            </td>
            @if (count($facilitador) == 2)
                <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 9pt;  font-weight: bold;padding-right: 70px">
                    {{mb_strtoupper($facilitador[1]->nombre_completo, 'UTF-8')}}
                </td>
            @endif
        </tr>
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 9pt;  font-weight: bold;padding-left: 50px">
                DIRECTOR DEL
            </td>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 9pt;  font-weight: bold;padding-right: 70px" >
                FACILITADOR (A)
            </td>
            @if (count($facilitador) == 2)
                <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 9pt;  font-weight: bold;padding-right: 70px">
                    <!-- Firma del facilitador -->
                    FACILITADOR (A)
                    <!-- Puedes agregar la imagen de la firma u otro contenido aquí -->
                </td>
            @endif
        </tr>
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 9pt;  font-weight: bold;padding-left: 50px">
                {{$instituto[0]->name}}
            </td>
        </tr>
    </table>
</body>

</html>
