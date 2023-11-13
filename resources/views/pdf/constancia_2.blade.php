<html >
<head>

    <!-- <title></title> -->
    <!-- Styles -->

    <style>
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
    </style>

</head>

<body>
    <div class="header">
        <img src="{{ public_path('/storage/Membretado/'.$year.'/logo_constancia_page_2.png') }}" alt="" class="logo">
    </div>
</body>

</html>
