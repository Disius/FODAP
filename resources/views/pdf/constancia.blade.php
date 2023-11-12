<html >
<head>

    <!-- <title></title> -->
    <!-- Styles -->

    <style>
        @page {
            size: A4 portrait;
            margin: 0;
        }
        body {
            background-image: url({{ public_path('/storage/Membretado/'.$year.'/img_constancia.png') }});
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
            top: 200px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            font-weight: bold;
            font-family: "Arial", "Helvetica", sans-serif;
            font-size: 10pt;
        }
        .text-position {
            display: flex;
            position: relative;
            top: 220px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            font-weight: bold;
            text-align: start;
            margin-left: 100px;
            font-family: "Arial", "Helvetica", sans-serif;
            font-size: 10pt;
        }
        .custom_table {
            table-layout: fixed;
            width: 75%;
            border-collapse: collapse;
            border: 1px solid black;
            margin-top: 250px;
            margin-left: 100px;
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

</body>

</html>
