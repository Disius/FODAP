<html>
<head>

    <!-- <title></title> -->
    <!-- Styles -->
{{--    <link rel="preconnect" href="https://fonts.googleapis.com">--}}
{{--    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet">--}}
   <style>
        @font-face {
            font-family: 'Montserrat-Black';
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
        }
        .header {
            display: flex;
            position: relative;
            top: 108px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-weight: normal;
            font-family: 'Montserrat-Black';
            font-weight: bold;
            font-size: 18pt;
            margin-rigth: 1.5px;
        }
        .text-position {
            display: flex;
            position: relative;
            top: 112px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: normal;
            text-align: start;
            margin-left: 80px;
            font-family: 'Montserrat-Black';
            font-size: 14pt;
            font-weight: bold;
        }
        .text-2 {
            display: flex;
            position: relative;
            top: 230px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: normal;
            text-align: center;
            margin-right: 25px;
            font-family: 'Montserrat';
            font-size: 14pt;
        }
        .text-3 {
            display: flex;
            position: relative;
            top: 250px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: normal;
            text-align: center;
            margin-right: 25px;
            font-family: 'Montserrat';
            font-size: 22pt;
            font-weight: bold;
        }
        .text-4 {
            display: flex;
            position: relative;
            top: 270px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: normal;
            text-align: center;
            margin-right: 40px;
            font-family: 'Montserrat';
            font-size: 14pt;
        }
        .text-5 {
            display: flex;
            position: relative;
            top: 290px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            text-align: center;
            margin-right: 40px;
            font-family: 'Montserrat';
            font-size: 22pt;
        }
        .text-6 {
            display: flex;
            position: relative;
            top: 310px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: normal;
            text-align: center;
            margin-right: 50px;
            font-family: 'Montserrat';
            font-size: 14pt;
        }
        .text-7 {
            display: flex;
            position: relative;
            top: 330px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            text-align: center;
            margin-right: 50px;
            font-family: 'Montserrat';
            font-size: 17pt;
            margin-left: 50px;
        }
        .text-8 {
            display: flex;
            position: relative;
            top: 390px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: normal;
            text-align: justify;
            margin-left: 97px;
            font-family: 'Montserrat';
            font-size: 12pt;
            width: 600px;
        }
        .text-9 {
            display: flex;
            position: relative;
            top: 430px;
            flex-direction: column;
            justify-content: end;
            align-items: center;
            font-weight: normal;
            text-align: justify;
            margin-left: 460px;
            font-family: 'Montserrat';
            font-size: 10pt;
        }
        .firmaDirector {
            font-weight: normal;
            text-align: center;
            margin-left: 390px;
            font-family: 'Montserrat';
            font-size: 9pt;
        }
        .nameDirector {
            font-weight: normal;
            text-align: center;
            margin-left: 100px;
            font-family: 'Montserrat';
            font-size: 9pt;
        }
        .footer {
            position: fixed;
            bottom: 250px;
            width: 100%;
            text-align: center;
            padding: 10px;;

        }

        .director-signature {
            float: right;
            margin-right: 160px;
        }

        .teacher-signature {
            float: left;
            margin-left: 80px;
        }
        .custom_table {
            table-layout: fixed;
            width: 75%;
            border-collapse: collapse;
            border: 1px solid black;
            margin-top: 250px;
            margin-left: 100px;
        }
        p {
            font-weight: normal;
            text-align: center;
            font-family: 'Montserrat';
            font-size: 8pt;
        }

        .custom_table td,
        .custom_table th {
            border: 1px solid #000;
            padding: 8px; /* Ajusta según tus necesidades */
        }

        .custom_table th {
            text-align: center;
            font-size: 8pt;
            font-weight: bold;
            background-color: #9ca3af;
        }

        .custom_table tbody {
            text-align: center;
            font-size: 8pt;
            padding: 8px; /* Ajusta según tus necesidades */
        }
        .firmas {
            margin-left: 80px;
        }
        .final_part {
            display: flex;
            justify-content: center;
            align-items: center;
            top: 400px;
            margin-top: 100px;
        }
        .words_strong {
            font-weight: bold;
            font-size: 8pt;
        }
        .margen-derecho {
            margin-right: 200px;
            margin-top: 1px;
        }
        .margen-izquierdo {
            margin-left: 100px;
            margin-top: 1px;
        }
    </style>

</head>

<body>
    <diV class="header">EL TECNOLÓGICO NACIONAL DE MÉXICO</diV>
    <diV class="text-position">A TRAVÉS DEL {{$instituto[0]->name}}</diV>
    <diV class="text-2">OTORGA LA PRESENTE</diV>
    <diV class="text-3">CONSTANCIA</diV>
    <diV class="text-4">A</diV>

    <div class="text-5">
        {{$docente->nombre_completo}}
    </div>
    <div class="text-6">
        Por su destacada participación en el Curso/taller:
    </div>
    <div class="text-7">
        "{{$curso->nombreCurso}}"
    </div>
    <div class="text-8">
        Que dentro del programa Institucional de Formación Docente y Actualización
        Profesional @if($curso->periodo === 1)
                        enero-junio
        @else
                        agosto-diciembre
        @endif
        {{$year}} se llevó a cabo en este instituto, del {{$formatFechasI[2]}} al {{$formatFechasF[2]}} de {{$month[0]}} de {{$formatFechasF[0]}}, con una duración de {{$docente->inscrito[0]->total_horas}} horas.
    </div>
    <div class="text-9">
        Tuxtla Gutierrez, Chiapas; {{$month[2]}} {{$month[1]}} de {{$formatFechasF[0]}}
    </div>

    <div class="footer">
        <div class="director-signature" style="float: right;">
            <!-- Firma del facilitador -->
            @if(count($facilitador) != 0)
            <p>{{$facilitador[0]->nombre_completo}}</p>
            @else
                <p>{{$curso->facilitador_externo}}</p>
            @endif
            <p>FACILITADOR (A)</p>
            <!-- Puedes agregar la imagen de la firma u otro contenido aquí -->
        </div>
        @if (count($facilitador) == 2)
            <div class="director-signature" style="float: right;">
                <!-- Firma del facilitador -->
                <p>{{$facilitador[1]->nombre_completo}}</p>
                <p>FACILITADOR (A)</p>
                <!-- Puedes agregar la imagen de la firma u otro contenido aquí -->
            </div>
        @endif
        <div class="teacher-signature" style="float: left;">
            <!-- Firma del maestro -->
            <p>{{$director[0]->nameDirector}}</p>
            <p>DIRECTOR DEL</p>
            <p>{{$instituto[0]->name}}</p>
            <!-- Puedes agregar la imagen de la firma u otro contenido aquí -->
        </div>
    </div>
</body>

</html>
