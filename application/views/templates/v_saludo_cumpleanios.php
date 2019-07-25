<?php
date_default_timezone_set('Europe/Madrid');
setlocale(LC_TIME, 'spanish');
$date = (new DateTime())->format('Y-m-d');
$DiaLetrasNumero = ucwords(utf8_encode(strftime("%A, %d ", strtotime($date))));
$MesLetra = ucwords(utf8_encode(strftime(" %B %Y", strtotime($date))));
$fecha_formada = $DiaLetrasNumero . " de " . $MesLetra;
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
    </head>
    <style>
        h1 { font-family: Calibri, Candara, Segoe, "Segoe UI", Optima, Arial, sans-serif; 
             font-size: 38px;
             font-weight: bold; 
             color: rgb(243, 168, 1);
        }


        .calibri { 
            font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; 
            color: rgb(89, 89, 89);

        }
        .CeldaNombres { 
            border-spacing: 0;
            border-collapse: collapse;
            padding:0; margin:0;
            text-align: center;
            margin : 0 0 0 0;
        }
        table{
            border-collapse: collapse;
            border: 0px;
            border-spacing: 0px;
        }
    </style>
</head>
<body>
    <table cellpadding="0" border="0">
        <tr>
            <td colspan="2"><img src="https://www.starperu.com/siststar/img/birthday/header_mensaje.png"></td>
        </tr>
        <tr>
            <td colspan="2" class="CeldaNombres" style="border-bottom: 0">
                <h1><?= ucwords(explode(" ", $nombres)[0]) ?> <?= ucwords(explode(" ", $apellidos)[0]) ?></h1>
                <p class="calibri"><?= ucwords($nombre_cargo) ?></p>
            </td>
        </tr>
        <tr>
            <td colspan="2"><img src="https://www.starperu.com/siststar/img/birthday/footer_mensaje.png"></td>
        </tr>
        <tr>
            <td><img src="https://www.starperu.com/siststar/img/birthday/logostarperu.png"></td>
            <td class="calibri"><?= utf8_decode($fecha_formada) ?></td>
        </tr>
    </table>
</body>
</html>
