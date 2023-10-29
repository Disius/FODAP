<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Ficha Técnica</title>

    <style>
        .header {
            display: flex;
            /* top: -0.5cm; */
            margin-top: 50px;
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
        . text_init {
            justify-content: start;
            align-content: start;
            width: 100%;
            position: absolute;
        }
        .text_init p {
            margin: 0;
            font-size: 1pt;
            font-family: "Soberana Sans";
            font-weight: normal;
        }
        .text-middle {
            display: flex;
            width: 100px;
            height: 100px;
            margin-left: 60px;
            margin-top: 50px;
        }
        .viñeta {
            list-style-type: disc;
        }
        .text-middle p {
            margin: 0;
            font-size: 12pt;
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

    <div class="text-init">
        <p><b>Instituto Tecnológico o Centro o Unidad:</b> {{$name_instituto[0]->name}}</p>
        <p><b>Nombre del Curso:</b> {{$ficha->curso_ficha->nombreCurso}}</p>
        <p><b>Instructor(a):</b> {{$ficha->curso_ficha->deteccion_facilitador[0]->nombre_completo}}</p>
    </div>
    <div class="text-middle">
        <p>• Introducción</p>
    </div>
    <div class="tex-middle">
        <p>{{$ficha->introduccion}}</p>
    </div>

</body>
</html>
