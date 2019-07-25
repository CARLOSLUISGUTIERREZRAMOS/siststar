<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <body>
        <table border="0" cellpadding="0" cellspacing="0" width=100%>	
            <tr>
                <td style="padding: 10px 0 30px 0;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse;">
                        <tr>
                            <td align="center" bgcolor="#70bbd9" style="padding: 20px 0 10px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                                <img src="https://www.starperu.com/siststar/img/logo_starperu.png" alt="Email Sistema Tickets" />
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                <table border="0" cellpadding="0" cellspacing="0" width="700">
                                    <tr>
                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                            <b>SISTEMA DE REEMBOLSOS - </b>STARPERU
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                            Num Refund: <?=$numero_refund?><br>
                                            Origen de Venta : <?=$origen_vta?>   <br>
                                                <?php 
                                                switch ($forma_pago){
                                                    case 'TJ':
                                                        $texto_cod_metpago = 'Tarjeta';
                                                        break;
                                                    case 'PP':
                                                        $texto_cod_metpago = 'PayPal';
                                                        break;
                                                    case 'SF':
                                                        $texto_cod_metpago = 'SafetyPay';
                                                        break;
                                                }
                                                ?>
                                            Metodo de Pago :   <?=$texto_cod_metpago?>  <br>
                                            Nombre de Pasajero : <?=$nombre_titular?>    <br>
                                            N° Ticket : <?=$num_ticket?>    <br>
                                            Monto a pagar :  USD <?=$monto_refund?>  
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <td>
                                            <table border="0" cellpadding="0" cellspacing="0" width="700">
                                                <tr>
                                                    <td width="260" valign="top">
                                                        <table border="0" cellpadding="0" cellspacing="0" width="300">
                                                            <tr>
                                                                <td>

                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
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
                                                                <td style="padding: 25px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                                    <ul>
                                                                           
                                                                    </ul>
                                                                </td>
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