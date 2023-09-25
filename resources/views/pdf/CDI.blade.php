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
        /*.header2 {*/
        /*    position: absolute;*/
        /*    top: -0.5cm;*/
        /*    width: 100%;*/
        /*    height: 100px;*/
        /*    text-align: center;*/
        /*    font-weight: bold;*/
        /*    margin-left: 50px;*/
        /*}*/

        /*.header2 p {*/
        /*    margin: 0;*/
        /*    font-size: 10pt;*/
        /*    font-family: "Arial", "Helvetica", sans-serif;*/
        /*    font-weight: bold;*/
        /*}*/

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

        /*.custom_table {*/
        /*    table-layout: fixed;*/
        /*    width: 100%;*/
        /*    border-collapse: collapse;*/
        /*    border: 1px solid black;*/
        /*    margin-top: 50px;*/
        /*}*/

        /*.custom_table td,th {*/
        /*    border: 1px solid #000;*/
        /*}*/


        /*.custom_table th {*/
        /*    text-align: center;*/
        /*    font-size: 8pt;*/
        /*    font-weight: bold;*/
        /*    !*white-space: nowrap;*!*/
        /*}*/

        /*.custom_table tbody {*/
        /*    text-align: center;*/
        /*    font-size: 8pt;*/
        /*}*/

        /*#firma {*/
        /*    page-break-inside: avoid;*/
        /*}*/

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
</body>

</html>
