<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="Las Mejores tarifas aéreas para peruanos y extranjeros. Vuela por el Perú: Cusco, Tarapoto, Iquitos, Pucallpa, Lima; promociones especiales">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Aerolíneas StarPerú</title>
        <link rel="stylesheet" href="css/bootstrap.css">
        <link rel="stylesheet" href="css/font-awesome.css">
        <link rel="stylesheet" href="css/main.css">
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet">
    </head>
    <body class="internas nohero">
        <div class="interfaz">
            <header class="cabecera">
                <div class="container-fluid">
                    <div class="row no-gutters fondo">
                        <div class="col">
                            <div class="container">
                                <div class="row no-gutters">
                                    <div class="col-12">
                                        <div class="row no-gutters">
                                            <div class="col-sm-12 col-md-4 logotipo">
                                                <h1><img src="img/Logotipo.png" alt=""></h1>
                                            </div>

                                            <div class="col-sm-12 col-md-8">
                                                <nav class="navbar navbar-expand sec-nav">
                                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample02" aria-controls="navbarsExample02" aria-expanded="false" aria-label="Toggle navigation">
                                                        <span class="navbar-toggler-icon"></span>
                                                    </button>
                                                    <div class="collapse navbar-collapse" id="navbarsExample02">
                                                        <ul class="navbar-nav ml-auto">
                                                            <li class="nav-item telefono">
                                                                <strong>(511) 2138813</strong>
                                                            </li>
                                                            <li class="nav-item idiomas">
                                                                <div class="dropdown">
                                                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                        ES
                                                                    </button>
                                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                        <a class="dropdown-item" href="#">ES</a>
                                                                        <!--<a class="dropdown-item" href="#">ENG</a>-->
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="nav-item facebook">
                                                                <a href="">facebook</a>
                                                            </li>
                                                            <li class="nav-item blog">
                                                                <a href="http://blog.starperu.com/es/" class="nav-link">
                                                                    <img src="img/icon-blog.png" class="off" alt="">
                                                                    <img src="img/icon-blog-on.png" class="on" alt="">
                                                                    <span>Blog</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </nav>
                                                <nav class="navbar navbar-expand-md navbar-dark bg-dark main-nav">
                                                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample03" aria-controls="navbarsExample03" aria-expanded="false" aria-label="Toggle navigation">
                                                        <span class="navbar-toggler-icon"></span>
                                                    </button>
                                                    <div class="collapse navbar-collapse" id="navbarsExample03">
                                                        <ul class="navbar-nav ml-auto">
                                                            <li class="nav-item active">
                                                                <a class="nav-link" href="index.html">Inicio</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="destinos.html">Destinos</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="promociones.html">Promociones</a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a class="nav-link" href="servicios-especiales.html">Servicios Especiales</a>
                                                            </li>
                                                            <li class="nav-item dropdown">
                                                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                                    Volar en StarPerú
                                                                </a>
                                                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                                                    <a class="dropdown-item" href="servicio-al-cliente.html">Servicios al cliente</a>
                                                                    <a class="dropdown-item" href="servicios-especiales.html">Servicios especiales</a>
                                                                    <a class="dropdown-item" href="viajes-grupales.html">Viajes grupales</a>
                                                                    <a class="dropdown-item" href="oficinas.html">Oficinas</a>
                                                                    <a class="dropdown-item" href="sobre-mi-equipaje.html">Sobre mi equipaje</a>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </nav>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <main class="contenidos">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12 col-md-8">
                            <div class="accordion destinos--2" id="accordionStar">
                                <div class="card">
                                    <div class="card-header" id="headingOne">
                                        <a class = "accordion-toggle" data-toggle="collapse" data-parent="#collapseOne" href="#collapseOne"  aria-controls="collapseOne">
                                            <h3>Información del Vuelo:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionStar">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-11">
                                                    <table class="table resumen">
                                                        <?php foreach ($res_model->Result() as $item) { ?>



                                                            <thead>
                                                                <tr>
                                                                    <th>Día</th>
                                                                    <th>Salida / Llegada</th>
                                                                    <th>Origen</th>
                                                                    <th>Destino</th>
                                                                    <th>Vuelo</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td> <?php $fecha_hora_salida_ida = Fecha_dia_mes($item->fechahora_salida_tramo_ida);
                                                                     echo $fecha_hora_salida_ida ?> </td>
                                                                    <td>
                                                                        <?php
                                                                        $hora_salida_ida = new DateTime($item->fechahora_salida_tramo_ida);
                                                                        $hora_salida_vuelta = new DateTime($item->fechahora_llegada_tramo_ida);
                                                                        echo $hora_salida_ida->format('H:i') . "  /  " . $hora_salida_vuelta->format('H:i');
                                                                        ?></td>
                                                                    <td><?php echo $item->origen; ?></td>
                                                                    <td><?php echo $item->destino; ?></td>
                                                                    <td><?php  
                                                                    if ($item->cod_compartido_vuelo_ida==="P9") {                                                                        
                                                                    
                                                                        echo $item->cod_compartido_vuelo_ida."(operado por Peruvian)"; }
                                                                    else
                                                                        { echo $item->cod_compartido_vuelo_ida;}?>
                                                                    </td>                                                              
                                                                </tr>
                                                                
                                                                <tr>
                                                                  <td> 
                                                                 <?php $fechahora_salida_tramo_retorno = Fecha_dia_mes($item->fechahora_salida_tramo_retorno);
                                                                     echo $fechahora_salida_tramo_retorno ?>
                                                                 </td>
                                                                 
                                                                <td>
                                                                        <?php
                                                                        $hora_salida_ida = new DateTime($item->fechahora_salida_tramo_retorno);
                                                                        $hora_salida_vuelta = new DateTime($item->fechahora_llegada_tramo_retorno);
                                                                        echo $hora_salida_ida->format('H:i') . "  /  " . $hora_salida_vuelta->format('H:i');
                                                                        ?>
                                                                </td>
                                                                    <td><?php echo $item->destino; ?></td>
                                                                    <td><?php echo $item->origen; ?></td>
                                                                    <td><?php if ($item->cod_compartido_vuelo_retorno==="P9") { 
                                                                    
                                                                    echo $item->cod_compartido_vuelo_retorno."(operado por Peruvian)"; }
                                                                    else
                                                                        { echo $item->cod_compartido_vuelo_retorno;}?></td>
                                                                </tr>
                                                            </tbody>
                                                       
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card" id="accordionStar">
                                    <div class="card-header" id="headingTwo">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseTwo" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                            <h3>Datos de Pasajeros:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseTwo" class="collapse show" aria-labelledby="headingTwo" data-parent="#accordionStar">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-11">
                                                    <table class="table resumen">
                                                        <thead>
                                                            <tr>
                                                                <th>&nbsp;</th>
                                                                <th>Tipo</th>
                                                                <th>Apellidos / Nombres</th>
                                                                <th>Documento</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td><?php $i=0;$i=$i+1; echo "Pasajero"." ".$i;?> </td>
                                                                <td><?php                                                                     
                                                                    switch ($item->tipo_pasajero) {
                                                                        case "ADT": echo 'ADULTO';break;
                                                                        case "INF":echo 'INFANTE';break;
                                                                        case "CNN":echo 'NIÑO';break;
                                                                   }?></td>
                                                                <td><?php echo $item->apellidos." ".$item->nombres   ?></td>
                                                                <td><?php echo $item->tipo_documento." :  ".$item->num_documento ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                                <div class="card" id="accordionStar">
                            <div class="card-header" id="headingThree">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseThree" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <h3>Información de Contacto:</h3>
                                </a>
                            </div>
                            <div id="collapseThree" class="collapse show" aria-labelledby="headingThree" data-parent="#accordionStar">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-11">
                                            <table class="table resumen">
                                                <tbody>
                                                    <tr>
                                                        <th>
                                                            <div class="form-group">
                                                                <label for="contact">Contacto:</label>
                                                                <input type="text" class="form-control" aria-describedby="contact" id="contact">
                                                            </div>
                                                        </th>
                                                        <th>
                                                            <div class="form-group">
                                                                <label for="correo-e">Correo electrónico:</label>
                                                                <input type="text" class="form-control" aria-describedby="correo-e" id="correo-e">
                                                            </div>
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label>Teléfono Fijo</label>
                                                            <table>
                                                                <tbody><tr>
                                                                    <td>
                                                                        <label>País:</label>
                                                                        <div class="select">
                                                                            <select>
                                                                                <option>PE - 0 51</option>
                                                                                <option>PE - 0 51</option>
                                                                                <option>PE - 0 51</option>
                                                                            </select>
                                                                            <div class="select__arrow"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label for="regionfijo">Región:</label>
                                                                            <input type="text" class="form-control" aria-describedby="regionfijo" id="regionfijo">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label for="numerofijo">Número:</label>
                                                                            <input type="text" class="form-control" aria-describedby="numerofijo" id="numerofijo">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">
                                                            <label>Celular</label>
                                                            <table>
                                                                <tbody><tr>
                                                                    <td>
                                                                        <label>País:</label>
                                                                        <div class="select">
                                                                            <select>
                                                                                <option>PE - 0 51</option>
                                                                                <option>PE - 0 51</option>
                                                                                <option>PE - 0 51</option>
                                                                            </select>
                                                                            <div class="select__arrow"></div>
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label for="regioncel">Región:</label>
                                                                            <input type="text" class="form-control" aria-describedby="regioncel" id="regioncel">
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div class="form-group">
                                                                            <label for="numerocel">Número:</label>
                                                                            <input type="text" class="form-control" aria-describedby="numerocel" id="numerocel">
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody></table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr>
                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                                
                                
                                
                                
                                
                                 
                                <div class="card" id="accordionStar">
                                    <div class="card-header" id="headingFour">
                                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#collapseFour" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                            <h3>Forma de pago:</h3>
                                        </a>
                                    </div>
                                    <div id="collapseFour" class="collapse show" aria-labelledby="headingFour" data-parent="#accordionStar">
                                        <div class="card-body">

                                            <div class="row">
    <div class="col-sm-12 col-md-6">
        <label for="pre-loc">Forma de pago:</label>
        <div class="select">
            <select id="select_cards" name="cc_code">
                <option value="VI">Visa</option>
                <option value="MC">Mastercard</option>
                <option value="AX">American Express</option>
                <option value="DC">Diners Club</option>
                <option value="PP">PayPal</option>
                <option value="SP">SafetyPay</option>
            </select>
            <div class="select__arrow"></div>
        </div>
    </div>
    
    
 
    <div class="col-sm-12 col-md-6">
        <div class="logo-medio-pago">
            <!--<img id="img_cards" class="d-block w-90" src="img/metodos_pagos/logo_visa.jpg" alt="First slide">-->
<!--                    <form action='http://127.0.0.1/new_web_2019/PasarelaPagos' method='post'>
                <script src='http://127.0.0.1/new_web_2019/js/visa/checkout.js'
                        data-sessiontoken='fe62a5206863d30ef4cc6a19c67879e18e835892b3e52bbb1cbc9314ac585bb4'
                        data-channel='web'
                        data-merchantid='342062522'
                        data-merchantlogo= 'img/comercio.png'
                        data-formbuttoncolor='#D80000'
                        data-purchasenumber='123'
                        data-amount='20.98'
                        data-expirationminutes='5'
                        data-timeouturl = 'timeout.html'></script>
            </form>-->
        </div>
    </div>
</div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <br><p># Web Check-in No aplica para vuelos operados por Peruvian, acercarse 2 hrs antes al counter para hacer su check-in gracias. </p>
                                                </div>
                                                <div class="col-sm-12 col-md-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input vacios_radio" type="checkbox" value="" id="defaultCheck1">
                                                        <label class="form-check-label" for="defaultCheck1">
                                                            Acepto las condiciones de compra
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <button type="button" class="btn btn-secondary btn-sm">ver condiciones</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12"><br></div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-8">
                                                    <div class="form-check">
                                                        <input class="form-check-input vacios_radio" type="checkbox" value="" id="defaultCheck2">
                                                        <label class="form-check-label" for="defaultCheck2">
                                                            Acepto las condiciones de Transporte.
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-sm-12 col-md-4">
                                                    <button type="button" class="btn btn-secondary btn-sm">ver condiciones</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                
                                
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="card resumen destinos-2">
                                <table>
                                    <tr>
                                        <th>
                                            <div class="form-group">
                                                <label for="nomest">Nombre del establecimiento:</label>
                                                <input type="text" class="form-control" aria-describedby="nomest" id="nomest" value="STAR PERU" disabled>
                                             </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <div class="form-group">
                                                <label for="codres">Código de Reserva:</label>
                                                <input type="text" class="form-control" aria-describedby="codres" id="codres"  value=" <?php echo $item->pnr ?>" disabled>
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <th>
                                            <div class="form-group">
                                                <label for="montotrans">Monto de la transacción:</label>
                                                <input type="text" class="form-control" aria-describedby="montotrans" id="montotrans" value=" USD <?php echo $item->total ?>" disabled>
                                               
                                            </div>
                                        </th>
                                        
                                    </tr>
                                    
                                </table><br>
                                <button type="submit" id="validacion_v" class="btn btn-primary btn-lg">Continuar</button>
                            </div>
                            
                        </div>
                    </div>  
                </div>
            </main>
                                                                     <?php } ?>

            <footer class="pie">
                <div class="container-fluid">
                    <div class="row no-gutters">
                        <div class="col-sm-12 col-md-5 menu-inf">
                            <div class="row no-gutters justify-content-end">
                                <div class="col-sm-12 col-md-11">
                                    <img src="img/Logotipo.png" alt="">
                                    <ul class="list-inline">
                                        <li class="list-inline-item"><a href="libro-de-reclamaciones.html">Libro de reclamaciones</a></li>
                                        <li class="list-inline-item"><a href="la-empresa.html">La Empresa</a></li>
                                        <li class="list-inline-item"><a href="contacto.html">Contacto</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-7 redes">
                            <div class="row no-gutters align-items-end">
                                <div class="col-sm-12 col-md-9">
                                    <p>CALL CENTER (511) 705-9000 <br>
                                        Atención diaria – 08:00 a 20:00Hrs.</p>
                                </div>
                                <div class="col-sm-12 col-md-3">
                                    <ul class="list-inline">
                                        <li class="list-inline-item facebook">
                                            <a href="https://www.facebook.com/aerolineas.starperu?fref=ts" class="nav-link">
                                                facebook
                                            </a>
                                        </li>
                                        <li class="list-inline-item twitter">
                                            <a href="https://twitter.com/starperu_" class="nav-link">
                                                twitter
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row no-gutters">
                        <div class="col-12 text-center disclaimer">
                            <p><small>2018 Star up S.A - <a href="contrato-de-transporte.html">Contrato de transporte</a> - <a href="condiciones-de-venta.html">Condiciones de venta</a> - <a href="condiciones-clases-tarifarias.html">Condiciones de clases tarifarias</a> - <a href="endosos-y-postergaciones.html">Endosos y postergaciones</a> - <a href="preguntas-frecuentes.html">FAQ</a> - <a href="privacidad.html">Privacidad</a><!-- - <a href="prensa-e-imagen.html">Prensa e imagen</a>--> - <a href="flota.html">Flota</a> - <a href="mapa-del-sitio.html">Mapa del sitio</a></small></p>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        <script src="js/jquery.min.js" charset="utf-8"></script>
        <script src="js/popper.min.js" charset="utf-8"></script>
        <script src="js/bootstrap.min.js" charset="utf-8"></script>
    </body>
</html>