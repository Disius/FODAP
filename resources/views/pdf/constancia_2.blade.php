<html >
<head>

    <!-- <title></title> -->
    <!-- Styles -->

    <style>
        @font-face {
            font-family: 'Montserrat-Black', sans-serif;
            font-weight: 800;
            /* Asegúrate de que la ruta y el formato coincidan con los archivos descargados */
        }
        @page {
            size: A4 landscape;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .logo {
            max-width: 400px; /* Ajusta el tamaño de la imagen según tus necesidades */
            height: auto;
            margin-right: 50px; /* Ajusta la cantidad de desplazamiento hacia la derecha según tus necesidades */
        }
        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-wrap: wrap; /* Permite que los elementos se envuelvan a una nueva línea */
            align-items: center; /* Alinea los elementos al principio del contenedor */
            justify-content: center;
            margin-top: 50px;
        }
        .square {
            width: 250px;
            height: 120px;
            border: 2px solid #000; /* Cambia esto para el color deseado */
            display: inline-block;
            margin: 0 2%; /* Agrega margen entre los elementos */
            text-align: center;
            padding: 20px;
        }
        .uline {
            border-bottom: 1px solid #000;
        }
        .titles {
            font-size: 7pt;
            white-space: nowrap;
            font-family: 'Montserrat-Black', sans-serif;
            text-align: center;
        }
        .center {
            text-align: center;
        }
        .content {
            font-size: 7pt;
            font-family: 'Montserrat-Black', sans-serif;
            font-weight: normal;
        }

        .w100 {
            width: 100%;
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
            font-family: 'Montserrat-Black', sans-serif;
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

        .title-row {
            font-weight: bold;
        }
    </style>

</head>

<body>
    <div class="header">
        {{-- <img src="{{ public_path('/storage/Membretado/'.$year.'/logo_constancia_page_2.png') }}" alt="" class="logo"> --}}
    </div>

    <div class="container">
        <div class="square">
            <table class="w100">
                <tr>
                    <td class="titles" style="font-family: 'Montserrat-Black', sans-serif;">Nivel Educativo del Curso</td>
                    <td class="uline content center w100"> Superior </td>
                </tr>
            </table>
            <table class="w100">
                <tr>
                    <td class="titles">Forma de impartición del Curso</td>
                    @if($curso->modalidad == 1)
                        <td class="uline content center w100"> Virtual </td>
                    @elseif($curso->modalidad == 2)
                        <td class="uline content center w100"> Presencial </td>
                    @elseif($curso->modalidad == 3)
                        <td class="uline content center w100"> Híbrido </td>
                    @endif
                </tr>
            </table>
            <table class="w100">
                <tr>
                    <td class="titles">Forma de impartición del Curso</td>
                    <td class="uline content center w100"> {{$curso->total_horas}} </td>
                </tr>
            </table>
            <table class="w100">
                <tr>
                    <td class="titles">Escolaridad del Participante</td>
                    <td class="uline content center w100"> {{$docente->posgrado->nombre}} </td>
                </tr>
            </table>
            <table class="w100">
                <tr>
                    <td class="titles">Área de Adscripción</td>
                    <td class="uline content center w100"> {{$docente->carrera->nameCarrera}} </td>
                </tr>
            </table>
            <table class="w100">
                <tr>
                    <td class="titles">Puesto</td>
                    <td class="uline content center w100"> {{$docente->puesto->nombre}} </td>
                </tr>
            </table>
        </div>
        <div class="square">
            @if($docente->tipo_plaza == 1 || $docente->tipo_plaza == 2)
                <table class="w100">
                    <tr>
                        <td class="titles content center">Este evento quedó registrado con la clave: </td>
                    </tr>
                </table>
                <table class="w100">
                        <tr>
                            <td class="titles content center">{{$curso->clave_curso->clave}}</td>
                        </tr>
                </table>
            @else
                <table class="w100">

                    <tr>
{{--                        <td class="titles content center">{{$curso->clave_curso->clave}}</td>--}}
                    </tr>

                </table>
            @endif
            <table class="w100">
                <tr>
                    <td class="titles content center">Tuxtla Gutiérrez, Chis. {{$day}} de {{$month_get[0]}} de {{$anio}}</td>
                </tr>
            </table>
            <table class="w100">
                <tr>
                    <td class="titles content center">Registró</td>
                </tr>
            </table>
            <table class="w100" style="margin-top: 35px;">
                <tr>
                    <td class="titles content center">Lic. {{$coordinacion->docente->nombre_completo}}</td>
                </tr>
            </table>
            <table class="w100">
                <tr>
                    <td class="titles content center">Coordinadora de Actualización Docente</td>
                </tr>
            </table>
        </div>
        <div class="square">
            <table class="w100" style="margin-top: 120px;">
                <tr>
                    <td class="titles content center">Registro No. {{$curso->clave_validacion->clave}}</td>
                </tr>
            </table>
        </div>
    </div>


    <table class="custom_table">
        <tr class="title-row">
            <th colspan="4">Temario</th>
        </tr>
        <tr>
            <th>No.</th>
            <th>Temas</th>
            <th>No.</th>
            <th>Temas</th>
        </tr>
        @php
            $maxTemas = 14;
            $mitadTemas = ceil($maxTemas / 2);
        @endphp
        @for($i = 0; $i < $mitadTemas; $i++)
            <tr>
                <td>{{ ($i < count($ficha->temas)) ? $i + 1 : '' }}</td>
                <td>{{ ($i < count($ficha->temas)) ? $ficha->temas[$i]->name_tema : '' }}</td>
                <td>{{ ($i + $mitadTemas < count($ficha->temas)) ? $i + $mitadTemas + 1 : '' }}</td>
                <td>{{ ($i + $mitadTemas < count($ficha->temas)) ? $ficha->temas[$i + $mitadTemas]->name_tema : '' }}</td>
            </tr>
        @endfor
    </table>
</body>

</html>
