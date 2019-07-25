<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <meta http-equiv="cache-control" content="max-age=0" />
<meta http-equiv="cache-control" content="no-cache" />
<meta http-equiv="expires" content="0" />
<meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
<meta http-equiv="pragma" content="no-cache" />
        <link rel="icon" type="image/png" href="<?= base_url() . 'img/icostar.jpg' ?>">
        <title>
            INTRANET STARPERU
        </title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <!--     Fonts and icons     -->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <!-- CSS Files -->
        <?php echo link_tag('assets/css/bootstrap.min.css'); ?>
        <!--<link href="<?= base_url() ?>assets/css/bootstrap.min.css" rel="stylesheet" />-->
        <?php echo link_tag('assets/css/now-ui-kit.css?v=1.3.0'); ?>
        <!--<link href="../assets/css/now-ui-kit.css?v=1.3.0" rel="stylesheet" />-->
        <!-- CSS Just for demo purpose, don't include it in your project -->
        <?php echo link_tag('assets/demo/demo.css'); ?>
        
    </head>

    <body class="login-page sidebar-collapse">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg bg-primary fixed-top navbar-transparent " color-on-scroll="400">
            <div class="container">
                <div class="dropdown button-dropdown">
                    <a href="#pablo" class="dropdown-toggle" id="navbarDropdown" data-toggle="dropdown">
                        <span class="button-bar"></span>
                        <span class="button-bar"></span>
                        <span class="button-bar"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-header">Listado de opciones</a>
                        <a class="dropdown-item" target="_blank" href="https://www.starperu.com/es">Llévame a la web</a>
                        <!--<a class="dropdown-item" href="#">Another action</a>-->
                        <!--<a class="dropdown-item" href="#">Something else here</a>-->
                        <!--<div class="dropdown-divider"></div>-->
                        <!--<a class="dropdown-item" href="#">Separated link</a>-->
                        <!--<div class="dropdown-divider"></div>-->
                        <!--<a class="dropdown-item" href="#">One more separated link</a>-->
                    </div>
                </div>
                <div class="navbar-translate">
                    <a class="navbar-brand" href="https://www.starperu.com/es" rel="tooltip" title="Herramientas de ayuda" data-placement="bottom" target="_blank">
                        Herramientas
                    </a>
                    <button class="navbar-toggler navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-bar top-bar"></span>
                        <span class="navbar-toggler-bar middle-bar"></span>
                        <span class="navbar-toggler-bar bottom-bar"></span>
                    </button>
                </div>
                <div class="collapse navbar-collapse justify-content-end" id="navigation" data-nav-image="<?= base_url() ?>assets/img/blurred-image-1.jpg">
                    <ul class="navbar-nav">
                        <!--          <li class="nav-item">
                                    <a class="nav-link" href="../index.html">Back to Kit</a>
                                  </li>-->
                        <li class="nav-item">
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" rel="tooltip" title="Ir a Twitter de StarPeru" data-placement="bottom" href="https://twitter.com/starperu_" target="_blank">
                                <i class="fab fa-twitter"></i>
                                <p class="d-lg-none d-xl-none">Twitter</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" rel="tooltip" title="Ir a Facebook de StarPeru" data-placement="bottom" href="https://www.facebook.com/aerolineas.starperu?fref=ts" target="_blank">
                                <i class="fab fa-facebook-square"></i>
                                <p class="d-lg-none d-xl-none">Facebook</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- End Navbar -->
        <div class="page-header clear-filter" filter-color="orange">
            <div class="page-header-image" style="background-image:url(<?= base_url() ?>assets/img/login.jpg)"></div>
            <div class="content">
                <div class="container">
                    <div class="col-md-4 ml-auto mr-auto">
                        <div class="card card-login card-plain">
                            <?= validation_errors(); ?>
                            <?= form_open('Login'); ?>
                            <div class="card-header text-center">
                                <div class="logo-container">
                                    <img src="<?= base_url() ?>assets/img/now-logo.png" alt="">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group no-border input-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="now-ui-icons users_circle-08"></i>
                                        </span>
                                    </div>
                                    <input type="text" class="form-control" name="codigoUsuario" placeholder="CODIGO USUARIO" id="cod_user">
                                </div>
                                <div class="input-group no-border input-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="now-ui-icons text_caps-small"></i>
                                        </span>
                                    </div>
                                    <input type="text" placeholder="CONTRASEÑA" class="form-control" id="pass" name="password"/>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary btn-round btn-lg btn-block">INGRESAR</button>
                                
                                <?= form_hidden(array('validar' => '1')); ?>
                                
                            </div>
                               <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class=" container ">
                    <nav>
                        <ul>
                            <li>
                                <a href="http://blog.starperu.com/es/">
                                    Blog
                                </a>
                            </li>
                        </ul>
                    </nav>
                    <div class="copyright" id="copyright">
                        &copy;
                        <script>
                            document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))
                        </script>
                        <a href="https://www.starperu.com" target="_blank">Star up S.A</a>.
                        Developed by Carlos Luis Gutiérrez Ramos
                    </div>
                </div>
            </footer>
        </div>
        <!--   Core JS Files   -->
        <?php echo script_tag('assets/js/core/jquery.min.js'); ?>
        <?php echo script_tag('assets/js/core/popper.min.js'); ?>
        <?php echo script_tag('assets/js/core/bootstrap.min.js'); ?>
        <?php echo script_tag('assets/js/plugins/bootstrap-switch.js'); ?>
        <?php echo script_tag('assets/js/plugins/nouislider.min.js'); ?>
        <?php echo script_tag('assets/js/plugins/bootstrap-datepicker.js'); ?>
        <?php echo script_tag('assets/js/now-ui-kit.js?v=1.3.0'); ?>
        <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    </body>
    <script>
                            $("#pass").on('click', function () {
                                $(this).attr('type', 'password');
                            });
                            $("#cod_user").on('blur', function () {
                                $("#pass").attr('type', 'password');
                            });
    </script>
</html>