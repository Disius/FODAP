<html >
<head>

    <!-- <title>Deteccion de Necesidades</title> -->
    <!-- Styles -->

    <style>
        @page { margin: 1cm 2cm 2cm 2cm;}
        body {
            /*border: 1px solid #000;*/
            font-family: "Arial", Helvetica, sans-serif;
        }
        .page_break {
            page-break-after: always;
        }
        .footer {
            width: 100%;
            position: fixed;
            bottom: 0.1cm;
        }

        .footer p {
            font-size: 9pt;
        }
        .preFooter{
            width: 100%;
            position: fixed;
            bottom: 1.1cm
        }
        .preFooter p {
            font-size: 9pt;
            font-family: "Tahoma", Geneva, sans-serif
        }
        .preFooter p a{
            font-weight: bold
        }

        .center {
            text-align: center;
            font-size: 10pt;
        }
        .leftAlinement{
            text-align: left;
            font-size: 10pt;
        }

        .uline {
            border-bottom: 1px solid #000;
        }

        .tline {
            border-top: 1px solid #000;
        }

        .header {
            width: 100%;
            text-align: center;
            font-weight: bold;
            margin-top: 25px;
            margin-bottom: 25px;
        }

        .header p {
            margin: 0;
            font-size: 12pt;
            margin-bottom: 10px;
        }

        .logo {

            position: fixed;
            top: 0;
            left: 0;
        }
        .logo img{
            width: 52px;
            margin-left: 35px;
            margin-top: 14px;
        }

        #title {
            font-size: 10pt;
            font-weight: bold;
            /* text-justify:inter-word; */
        }
        .titleCentered p{
            font-size: 10pt;
            font-weight: bold;
            text-align: center;
            margin: 0;
        }

        .espacio{
            margin-bottom: 20px;
        }
        .titles {
            font-size: 10pt;
            font-weight: 500;
            white-space: nowrap;
        }

        .content {
            font-size: 10pt;
            font-weight: 700;
        }

        .infoTitles {
            width: 100%;
            margin-bottom: 1pt;
            font-size: 11pt;
            font-weight: bold;
            text-align: center;
            background-color: lightgrey;
        }

        .titulo{
            width: 95%;
            margin-bottom: 19pt;
            font-size: 10pt;
            font-weight: bold;
            text-align: justify;

        }

        .w100 {
            width: 100%;
        }

        .w90 {
            width: 90%;
            text-align: right;
        }

        .w50 {
            width: 50%;
        }
        .mb-3{
            margin-bottom: 30px;
        }
        .m-0 p{
            margin: 0;
        }

        .mt-5{
            padding-top: 25px;
        }
        .mb-2{
            margin-bottom: 19px;
        }
        .mb-l{
            margin-bottom: 17px;
        }
        table.custom {
            border: 1px solid #000000;
            border-collapse: collapse;
            width: 100%;
            text-align: left;
            border-collapse: collapse;
            font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
        }
        table.custom td, table.custom th {
            border: 1px solid #000000;
            padding: 5px 4px;
        }
        table.custom tbody td {
            font-size: 13px;
            width: 100%;
        }
        table.custom thead {
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.custom thead th {
            font-size: 13px;
            color: #000000;
            text-align: left;
            font-weight: inherit;
        }
        table.custom tfoot {
            font-size: 14px;
            font-weight: bold;
            color: #000000;
            border-top: 3px solid #000000;
        }
        table.custom tfoot td {
            font-size: 14px;
        }

        table.customA  {
            border: 1px solid #000000;
            width: 100%;
            text-align: center;
            border-collapse: collapse;
            font-family: Arial,Helvetica Neue,Helvetica,sans-serif;
        }
        table.customA td, table.customA th {
            border: 1px solid #000000;
            padding: 5px 4px;
        }
        table.customA tbody tr th {
            font-size: 10px;
            text-align: center;
            font-weight: inherit;
        }
        table.customA thead {
            text-anchor: middle;
            background: -moz-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: -webkit-linear-gradient(top, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            background: linear-gradient(to bottom, #dbdbdb 0%, #d3d3d3 66%, #CFCFCF 100%);
            border-bottom: 1px solid #000000;
        }
        table.customA thead th {
            font-size: 10px;
            text-anchor: middle;
            color: #000000;
            text-align: center;
        }

    </style>

</head>

<body>
{{--    Aqui nombre del insituto--}}
@dump($pdf_data)
</body>

</html>
