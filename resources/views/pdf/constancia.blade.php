<html>
<head>

    <!-- <title></title> -->
    <!-- Styles -->
{{--    <link rel="preconnect" href="https://fonts.googleapis.com">--}}
{{--    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>--}}
{{--    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@800&display=swap" rel="stylesheet">--}}
   <style>
        @font-face {
            font-family: 'Montserrat-Black', sans-serif;
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
        /*.header {*/
        /*    display: flex;*/
        /*    position: relative;*/
        /*    top: 168px;*/
        /*    flex-direction: column;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*    text-align: center;*/
        /*    font-family: 'Montserrat-ExtraBold', sans-serif;*/
        /*    font-weight: bold;*/
        /*    font-size: 18pt;*/
        /*    margin-left: 42px;*/
        /*}*/
        /*.text-position {*/
        /*    display: flex;*/
        /*    position: relative;*/
        /*    top: 175px;*/
        /*    flex-direction: column;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*    text-align: start;*/
        /*    margin-left: 90px;*/
        /*    font-family: 'Montserrat-ExtraBold', sans-serif;*/
        /*    font-size: 14pt;*/
        /*    font-weight: bold;*/
        /*}*/
        /*.text-2 {*/
        /*    display: flex;*/
        /*    position: relative;*/
        /*    top: 230px;*/
        /*    flex-direction: column;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*    font-weight: normal;*/
        /*    text-align: center;*/
        /*    margin-right: 25px;*/
        /*    font-family: 'Montserrat-Black', sans-serif;*/
        /*    font-size: 14pt;*/
        /*}*/
        /*.text-3 {*/
        /*    display: flex;*/
        /*    position: relative;*/
        /*    top: 250px;*/
        /*    flex-direction: column;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*    text-align: center;*/
        /*    margin-right: 25px;*/
        /*    font-family: 'Montserrat-ExtraBold', sans-serif;*/
        /*    font-size: 22pt;*/
        /*    font-weight: bold;*/
        /*}*/
        /*.text-4 {*/
        /*    display: flex;*/
        /*    position: relative;*/
        /*    top: 270px;*/
        /*    flex-direction: column;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*    font-weight: normal;*/
        /*    text-align: center;*/
        /*    margin-right: 40px;*/
        /*    font-family: 'Montserrat-Black', sans-serif;*/
        /*    font-size: 14pt;*/
        /*}*/
        /*.text-5 {*/
        /*    display: flex;*/
        /*    position: relative;*/
        /*    top: 290px;*/
        /*    flex-direction: column;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*    font-weight: bold;*/
        /*    text-align: center;*/
        /*    margin-right: 40px;*/
        /*    font-family: 'Montserrat-ExtraBold', sans-serif;*/
        /*    font-size: 22pt;*/
        /*}*/
        /*.text-6 {*/
        /*    display: flex;*/
        /*    position: relative;*/
        /*    top: 310px;*/
        /*    flex-direction: column;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*    font-weight: normal;*/
        /*    text-align: center;*/
        /*    margin-right: 50px;*/
        /*    font-family: 'Montserrat-Black', sans-serif;*/
        /*    font-size: 14pt;*/
        /*}*/
        /*.text-7 {*/
        /*    display: flex;*/
        /*    position: relative;*/
        /*    top: 330px;*/
        /*    flex-direction: column;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*    font-weight: bold;*/
        /*    text-align: center;*/
        /*    margin-right: 50px;*/
        /*    font-family: 'Montserrat-ExtraBold', sans-serif;*/
        /*    font-size: 17pt;*/
        /*    margin-left: 50px;*/
        /*}*/
        /*.text-8 {*/
        /*    display: flex;*/
        /*    position: relative;*/
        /*    top: 390px;*/
        /*    flex-direction: column;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*    font-weight: normal;*/
        /*    text-align: justify;*/
        /*    margin-left: 97px;*/
        /*    font-family: 'Montserrat-Black', sans-serif;*/
        /*    font-size: 12pt;*/
        /*    width: 600px;*/
        /*}*/
        /*.text-9 {*/
        /*    display: flex;*/
        /*    position: relative;*/
        /*    top: 430px;*/
        /*    flex-direction: column;*/
        /*    justify-content: end;*/
        /*    align-items: center;*/
        /*    font-weight: normal;*/
        /*    text-align: justify;*/
        /*    margin-left: 460px;*/
        /*    font-family: 'Montserrat-Black', sans-serif;*/
        /*    font-size: 10pt;*/
        /*}*/
        /*.firmaDirector {*/
        /*    font-weight: normal;*/
        /*    text-align: center;*/
        /*    margin-left: 390px;*/
        /*    font-family: 'Montserrat-Black', sans-serif;*/
        /*    font-size: 9pt;*/
        /*}*/
        /*.nameDirector {*/
        /*    font-weight: normal;*/
        /*    text-align: center;*/
        /*    margin-left: 100px;*/
        /*    font-family: 'Montserrat-Black', sans-serif;*/
        /*    font-size: 9pt;*/
        /*}*/
        /*.footer {*/
        /*    position: fixed;*/
        /*    bottom: 250px;*/
        /*    display: flex;*/
        /*    justify-content: space-between;*/
        /*    align-items: center;*/
        /*}*/
        /*!*position: fixed;*!*/
        /*!*bottom: 250px;*!*/
        /*!*width: 100%;*!*/
        /*!*text-align: center;*!*/
        /*!*padding: 10px;*!*/
        /*!*flex-wrap: wrap; !* Permite que los elementos se envuelvan a una nueva línea *!*!*/
        /*!*align-items: center; !* Alinea los elementos al principio del contenedor *!*!*/
        /*!*justify-content: center;*!*/
        /*.director-signature {*/
        /*    margin-left: 40px;*/
        /*}*/

        /*.teacher-signature {*/
        /*    margin-left: 50px;*/
        /*}*/
        /*.teacher-signature2 {*/
        /*    !*float: left;*!*/
        /*    margin-left: 400px;*/
        /*}*/
        /*.footer {*/
        /*    !*position: fixed;*!*/
        /*    !*bottom: 250px; !* Ajusta esta posición según sea necesario *!*!*/
        /*    !*width: calc(100% - 20px); !* Ajusta el ancho según sea necesario *!*!*/
        /*    !*left: 20px; !* Ajusta esta posición según sea necesario *!*!*/
        /*    !*display: flex;*!*/
        /*    !*justify-content: space-between; !* Distribuye los elementos en la línea *!*!*/
        /*    !*align-items: center; !* Alinea los elementos verticalmente *!*!*/
        /*    !*position: fixed;*!*/
        /*    !*bottom: 250px; !* Ajusta esta posición según sea necesario *!*!*/
        /*    !*width: calc(100% - 100px); !* Ajusta el ancho según sea necesario *!*!*/
        /*    !*left: 50px; !* Ajusta esta posición según sea necesario *!*!*/
        /*    !*display: flex;*!*/
        /*    !*justify-content: space-between; !* Distribuye los elementos en la línea *!*!*/
        /*    !*align-items: center; !* Alinea los elementos verticalmente *!*!*/
        /*}*/

        /*!*.director-signature{*!*/
        /*!*    text-align: center;*!*/
        /*!*    margin-left: 10px; !* Ajusta este margen según sea necesario *!*!*/
        /*!*    width: 90%; !* Ajusta el ancho según sea necesario *!*!*/

        /*!*}*!*/
        /*!*.teacher-signature{*!*/
        /*!*    text-align: center;*!*/
        /*!*    margin-left: 400px; !* Ajusta este margen según sea necesario *!*!*/
        /*!*    width: 40%; !* Ajusta el ancho según sea necesario *!*!*/
        /*!*    float: left;*!*/

        /*!*}*!*/
        /*!*.teacher-signature2 {*!*/
        /*!*    text-align: center;*!*/
        /*!*    margin: 0 100px; !* Ajusta este margen según sea necesario *!*!*/
        /*!*    width: 20%; !* Ajusta el ancho según sea necesario *!*!*/

        /*!*}*!*/
        /*!*.footer {*!*/
        /*!*    display: flex; !* Utiliza flexbox *!*!*/
        /*!*    justify-content: space-between; !* Distribuye el espacio entre los elementos *!*!*/
        /*!*    align-items: center; !* Alinea los elementos verticalmente *!*!*/
        /*!*    padding: 20px; !* Añade espacio interior al footer (ajusta según sea necesario) *!*!*/
        /*!*}*!*/

        /*!*.box {*!*/
        /*!*    width: 100px; !* Ancho de cada caja (ajusta según sea necesario) *!*!*/
        /*!*    height: 100px; !* Altura de cada caja (ajusta según sea necesario) *!*!*/
        /*!*}*!*/
        /*.textP {*/
        /*    font-family: 'Montserrat-ExtraBold', sans-serif;*/
        /*    font-weight: bold;*/
        /*    font-size: 8pt;*/
        /*}*/
        /*!*.footer {*!*/
        /*!*    position: fixed;*!*/
        /*!*    bottom: 250px;*!*/
        /*!*    width: 100%;*!*/
        /*!*    text-align: center;*!*/
        /*!*    padding: 10px;*!*/
        /*!*    display: flex; !* Activa el modelo de caja flexible *!*!*/
        /*!*    justify-content: center; !* Centra los elementos horizontalmente *!*!*/
        /*!*    align-items: center; !* Centra los elementos verticalmente *!*!*/
        /*!*}*!*/

        /*!*.director-signature,*!*/
        /*!*.teacher-signature {*!*/
        /*!*    text-align: center; !* Centra el contenido dentro de los elementos *!*!*/
        /*!*    margin: 0 40px; !* Ajusta este valor según sea necesario *!*!*/
        /*!*}*!*/

        /*!*!* Ajustes para cuando hay tres firmas *!*!*/
        /*!*.footer > div {*!*/
        /*!*    flex: 1; !* Distribuye el espacio disponible entre los elementos *!*!*/
        /*!*    text-align: center; !* Centra el contenido dentro de los elementos *!*!*/
        /*!*    margin: 0 20px; !* Ajusta este valor según sea necesario *!*!*/
        /*!*}*!*/
        /*.custom_table {*/
        /*    table-layout: fixed;*/
        /*    width: 75%;*/
        /*    border-collapse: collapse;*/
        /*    border: 1px solid black;*/
        /*    margin-top: 250px;*/
        /*    margin-left: 100px;*/
        /*}*/
        /*p {*/
        /*    font-weight: normal;*/
        /*    text-align: center;*/
        /*    font-family: 'Montserrat-Black', sans-serif;*/
        /*    font-size: 8pt;*/
        /*}*/

        /*.custom_table td,*/
        /*.custom_table th {*/
        /*    border: 1px solid #000;*/
        /*    padding: 8px; !* Ajusta según tus necesidades *!*/
        /*}*/

        /*.custom_table th {*/
        /*    text-align: center;*/
        /*    font-size: 8pt;*/
        /*    font-weight: bold;*/
        /*    background-color: #9ca3af;*/
        /*}*/

        /*.custom_table tbody {*/
        /*    text-align: center;*/
        /*    font-size: 8pt;*/
        /*    padding: 8px; !* Ajusta según tus necesidades *!*/
        /*}*/
        /*.firmas {*/
        /*    margin-left: 80px;*/
        /*}*/
        /*.final_part {*/
        /*    display: flex;*/
        /*    justify-content: center;*/
        /*    align-items: center;*/
        /*    top: 400px;*/
        /*    margin-top: 100px;*/
        /*}*/
        /*.words_strong {*/
        /*    font-weight: bold;*/
        /*    font-size: 8pt;*/
        /*}*/
        /*.margen-derecho {*/
        /*    margin-right: 200px;*/
        /*    margin-top: 1px;*/
        /*}*/
        /*.margen-izquierdo {*/
        /*    margin-left: 100px;*/
        /*    margin-top: 1px;*/
        /*}*/

    </style>

</head>

<body style="font-family: 'Montserrat-Black', sans-serif;">
    <div style="margin-top: 133px"></div>
    <table width="100%">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 18pt; font-weight: bold">
                EL TECNOLÓGICO NACIONAL DE MÉXICO
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 14pt; font-weight: bold">
                A TRAVÉS DEL {{$instituto[0]->name}}
            </td>
        </tr>
    </table>
    <div style="margin-top: 20px"></div>
    <table width="100%">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-Black', sans-serif; font-size: 14pt;">
                OTORGA LA PRESENTE
            </td>
        </tr>
    </table>
    <div style="margin-top: 20px"></div>
    <table width="100%">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 22pt; font-weight: bold">
                CONSTANCIA
            </td>
        </tr>
    </table>
    <div style="margin-top: 20px"></div>
    <table width="100%">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-Black', sans-serif; font-size: 14pt;">
                A
            </td>
        </tr>
    </table>
    <div style="margin-top: 20px"></div>
    <table width="100%">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 24pt; font-weight: bold;">
                {{$docente->nombre_completo}}
            </td>
        </tr>
    </table>
    <div style="margin-top: 50px"></div>
    <table width="100%">
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
    <table width="100%">
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-Black', sans-serif; font-size: 16pt; font-weight: bold;">
                "{{$curso->nombreCurso}}"
            </td>
        </tr>
    </table>
    <table>
        <tr>
            <td style="text-align: justify; font-family: 'Montserrat-Black', sans-serif; font-size: 12pt; width: 20%; padding: 20px 90px 20px 90px">
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
            <td style="text-align: justify; font-family: 'Montserrat-Black', sans-serif; font-size: 8pt; padding-left: 450px">
                Tuxtla Gutierrez, Chiapas; {{$month[2]}} {{$month[1]}} de {{$formatFechasF[0]}}
            </td>
        </tr>
    </table>
    <div style="margin-top: 200px"></div>
    <table>
        <tr>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 9pt;  font-weight: bold;padding-left: 50px">
                {{strtoupper($director[0]->nameDirector)}}
            </td>
            <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 9pt;  font-weight: bold; padding-right: 70px">
                            @if(count($facilitador) != 0)
                                {{$facilitador[0]->nombre_completo}}
                            @else
                                {{$curso->facilitador_externo}}
                            @endif
            </td>
            @if (count($facilitador) == 2)
                <td style="text-align: center; vertical-align: middle; font-family: 'Montserrat-ExtraBold', sans-serif; font-size: 9pt;  font-weight: bold;padding-right: 70px">
                    <!-- Firma del facilitador -->
                    {{$facilitador[1]->nombre_completo}}
                    <!-- Puedes agregar la imagen de la firma u otro contenido aquí -->
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
{{--    <diV class="header">EL TECNOLÓGICO NACIONAL DE MÉXICO</diV>--}}
{{--    <diV class="text-position">A TRAVÉS DEL {{$instituto[0]->name}}</diV>--}}
{{--    <diV class="text-2">OTORGA LA PRESENTE</diV>--}}
{{--    <diV class="text-3">CONSTANCIA</diV>--}}
{{--    <diV class="text-4">A</diV>--}}

{{--    <div class="text-5">--}}
{{--        {{$docente->nombre_completo}}--}}
{{--    </div>--}}
{{--    <div class="text-6">--}}
{{--        Por su destacada participación en el Curso/taller:--}}
{{--    </div>--}}
{{--    <div class="text-7">--}}
{{--        "{{$curso->nombreCurso}}"--}}
{{--    </div>--}}
{{--    <div class="text-8">--}}
{{--        Que dentro del programa Institucional de Formación Docente y Actualización--}}
{{--        Profesional @if($curso->periodo === 1)--}}
{{--                        enero-junio--}}
{{--        @else--}}
{{--                        agosto-diciembre--}}
{{--        @endif--}}
{{--        {{$year}} se llevó a cabo en este instituto, del {{$formatFechasI[2]}} al {{$formatFechasF[2]}} de {{$month[0]}} de {{$formatFechasF[0]}}, con una duración de {{$docente->inscrito[0]->total_horas}} horas.--}}
{{--    </div>--}}
{{--    <div class="text-9">--}}
{{--        Tuxtla Gutierrez, Chiapas; {{$month[2]}} {{$month[1]}} de {{$formatFechasF[0]}}--}}
{{--    </div>--}}

{{--    <div class="footer">--}}
{{--        <div class="teacher-signature" style="float: right;">--}}
{{--            <!-- Firma del facilitador -->--}}
{{--            @if(count($facilitador) != 0)--}}
{{--            <p  class="textP">{{$facilitador[0]->nombre_completo}}</p>--}}
{{--            @else--}}
{{--                <p  class="textP">{{$curso->facilitador_externo}}</p>--}}
{{--            @endif--}}
{{--            <p  class="textP">FACILITADOR (A)</p>--}}
{{--            <!-- Puedes agregar la imagen de la firma u otro contenido aquí -->--}}
{{--        </div>--}}
{{--        @if (count($facilitador) == 2)--}}
{{--            <div class="teacher-signature2">--}}
{{--                <!-- Firma del facilitador -->--}}
{{--                <p  class="textP">{{$facilitador[1]->nombre_completo}}</p>--}}
{{--                <p  class="textP">FACILITADOR (A)</p>--}}
{{--                <!-- Puedes agregar la imagen de la firma u otro contenido aquí -->--}}
{{--            </div>--}}
{{--        @endif--}}
{{--        <div class="director-signature" style="float: left;">--}}
{{--            <!-- Firma del maestro -->--}}
{{--            <p class="textP">{{$director[0]->nameDirector}}</p>--}}
{{--            <p  class="textP">DIRECTOR DEL</p>--}}
{{--            <p  class="textP">{{$instituto[0]->name}}</p>--}}
{{--            <!-- Puedes agregar la imagen de la firma u otro contenido aquí -->--}}
{{--        </div>--}}
{{--    </div>--}}
</body>

</html>
