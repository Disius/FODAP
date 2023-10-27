<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha Técnica</title>

    <style>
        .header {
            position: absolute;
            top: 1cm;
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
        . name_instituto {
            justify-content: start;
            align-content: start;
            width: 100%;
            position: absolute;
            margin-top: 50px;
        }
        .name_instituto p {
            margin: 0;
            font-size: 8pt;
            font-family: "Soberana Sans";
            font-weight: normal;
        }
    </style>
</head>
<body>
    <div class="header">
        <p>FICHA TÉCNICA DEL SERVICIO DE ACTUALIZACION PROFESIONAL Y</p>
        <p>FORMACIÓN DOCENTE</p>
        <p>M00-SC-029-A02</p>
    </div>

    <div class="name_instituto">
        <p>Instituto Tecnológico o Centro o Unidad: {{$name_instituto[0]->name}}</p>
    </div>
</body>
</html>
