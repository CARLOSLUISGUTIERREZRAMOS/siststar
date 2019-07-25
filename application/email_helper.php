
<?php

function mensajeEmail($apellido, $nombre, $humanDate) {
	$dirUrlImg = 'http://10.100.1.17:8081/siststar/img/cumple_opt2_header.png';
        $msjDeseo = utf8_decode('Que este día sea el comienzo de otro año de felicidad.');
        $msgDeseoFelicidades = utf8_decode('Muchas felicidades y Feliz Cumpleaños.');
    $message = "
<html>
<head>
	<meta http-equiv='Content-Type' content='text/html; charset=UTF-8' />
</head>

<body style='text-align:center;margin:0px auto 0px auto;'>
<table>
    <thead style='text-align:center;margin:0px auto 0px auto;'>
        <tr>
            <td><img src='" . $dirUrlImg . "' /></td>
        </tr>
    </thead>
    <tbody style='text-align:center;margin:0px auto 0px auto;'>
        <tr style='height:30px;'>
            <td><p style='text-align:right;font-family: Arial, Helvetica, sans-serif;color:#5f5f5f;  font-style: italic;'>$humanDate</p></td>
        </tr>
        <tr>
            <td><p class='lead' style='font-family:Impact, Charcoal, sans-serif;text-align:center;font-size:25px; font-weight: bold; color:#5f5f5f'>$apellido $nombre</p></td>
        </tr>
    </tbody>
    <tfoot style='text-align:left;'>
        <tr style='height:50px;'>
            <td></td>
        </tr>
        
        <tr>
            <td  style='font-family: Arial, Helvetica, sans-serif;color:#5f5f5f''>$msjDeseo</td>
        </tr>
        <tr>
            <td style='font-family: Arial, Helvetica, sans-serif;color:#5f5f5f''>$msgDeseoFelicidades</td>
        </tr>
        <tr>
            <td><hr></td>
        </tr>
        <tr>
        <td style='font-family: Arial, Helvetica, sans-serif;font-weight: bold; color:#5f5f5f''>Roman Kasianov</td>
        </tr>
            
    </tfoot>
 
</table>
</body>
</html>
";
    return $message;
}
