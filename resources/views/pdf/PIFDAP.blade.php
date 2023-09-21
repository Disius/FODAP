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
            position: fixed;
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
            /*page-break-inside: auto;*/
            /*padding-top: 100px;*/
            /*margin-top: 100px;*/
            border: 1px solid #000;
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
        @php
            $anio = explode('-', $cursos[0]->fecha_F)
        @endphp
        @if($cursos[0]->periodo == 1)
            <p>PERIODO ENERO - JUNIO {{$anio[0]}}</p>
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

</body>

</html>
