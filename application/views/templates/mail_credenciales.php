<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <body>
        <table border="0" cellpadding="0" cellspacing="0" width=100%>	
            <tr>
                <td style="padding: 10px 0 30px 0;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                        <tr>
                            <td align="center" bgcolor="#70bbd9" style="padding: 20px 0 10px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                                <img src="<?= base_url() ?>img/logo_starperu.png" alt="Email Sistema Tickets" />
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="700">
                                    <tr>
                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px; text-align: center">
                                            <b>CREDENCIALES DE ACCESO - </b>STARPERU
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px 0px 10px 0px;color: #153643; font-family: Arial, sans-serif; font-size: 14px;" colspan='2'><p>Estimado Sr(a). <b><?= (isset($nombre)) ? $nombre : 'Nombre Test' ?></b><b> <?= (isset($apellido)) ? $apellido : 'Apellido de Prueba' ?></b><br>Se han creado las siguientes credenciales para que usted pueda acceder al <a href='<?= base_url() ?>'>SISTSTAR</a></p></td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <table border="0" cellpadding="0" cellspacing="0" width="700">
                                                <tr>
                                                    <td width="260" valign="top">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="300">

                                                            <tr>
                                                                <td style="padding: 15px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 26px; line-height: 20px;">
                                                                    
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                    <td style="font-size: 0; line-height: 0;" width="20">
                                                        &nbsp;
                                                    </td>
                                                    <td width="260" valign="top">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="400">
                                                            <tr>
                                                                <td>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>
                                                                </td>
                                                            </tr>
                                                            <tr border='0' >
                                                                <td style="color: #153643; font-family: Arial, sans-serif; font-size: 20px;" ><b>&nbsp;&nbsp;Usuario</b> :</td><td border='0'><?= (isset($codigo)) ? $codigo : 'Codigo de Prueba' ?></td>
                                                            </tr>
                                                            <tr border='0' ><td style="color: #153643; font-family: Arial, sans-serif; font-size: 20px;"><b>&nbsp;&nbsp;Password</b>:</td><td border='0'><?= (isset($password)) ? $password : 'Contraseña_Prueba' ?></td></tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ee4c50" style="padding: 25px 25px 25px 25px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="700">
                                    <tr>
                                        <td align="right">
                                            <table border="0" cellpadding="0" cellspacing="0">
                                                <tr>
                                                    <td style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                        <a href="<?= base_url() ?>" style="color: #ffffff;" title="click para llevarte">
                                                            <i class="fa fa-link"></i> Ir al sistema
                                                        </a>
                                                    </td>
                                                    <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>








