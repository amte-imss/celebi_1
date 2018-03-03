<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <link rel="apple-touch-icon" sizes="76x76" href="<?php echo base_url('assets/img/template_sipimss/apple-icon.png'); ?>" />
        <link rel="icon" type="image/png" href="<?php echo base_url('assets/img/template_sipimss/favicon.ico'); ?>" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>
            <?php echo (!is_null($title)) ? "{$title}&nbsp;|" : "" ?>
            <?php echo (!is_null($main_title)) ? $main_title : "Cursos presenciales DIE" ?>
        </title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <meta name="viewport" content="width=device-width" />
        <!-- Google Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <!-- <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'> -->
        <!-- Bootstrap Core Css -->
        <?php echo css('template_cpredie/bootstrap/bootstrap.css'); ?>
        <script type="text/javascript">
            var url = "<?php echo base_url(); ?>";
            var site_url = "<?php echo site_url(); ?>";
            var img_url_loader = "<?php echo base_url('assets/img/loader.gif'); ?>";
        </script>
        <!-- Waves Effect Css -->
        <?php echo css('template_cpredie/node_waves/waves.css'); ?>
        <!-- Animation Css -->
        <?php echo css('template_cpredie/animate/animate.css'); ?>
        <!-- Sweet Alert Css -->
        <?php echo css ('template_cpredie/sweetalert/sweetalert.css'); ?>
        <!-- Bootstrap Material Datetime Picker Css -->
        <?php echo css('template_cpredie/bootstrap-material-datetimepicker/bootstrap-material-datetimepicker.css'); ?>

        <!-- Wait Me Css -->
        <?php echo css('template_cpredie/wait/waitMe.css'); ?>
        <!-- Bootstrap Select Css -->
        <?php echo css('template_cpredie/bootstrap-select/bootstrap-select.css'); ?>
        <!-- Custom Css -->
        <?php echo css('template_cpredie/style.css'); ?>
        <!--Celebi Css´s-->
        <?php echo css('template_cpredie/themes/all-themes.css'); ?>
        <?php echo css('template_cpredie/celebi.css'); ?>

        <!-- Jquery Core Js -->
        <?php echo js("plugins_cpredie/jquery/jquery.js"); ?>

        <?php //echo js("jquery.min.js"); ?>
        <?php //echo js("jquery.ui.min.js"); ?>

        <!--Let browser know website is optimized for mobile-->

        <!-- Google Analytics -->
        <!-- <script>
            (function (i, s, o, g, r, a, m) {
                i['GoogleAnalyticsObject'] = r;
                i[r] = i[r] || function () {
                    (i[r].q = i[r].q || []).push(arguments)
                }, i[r].l = 1 * new Date();
                a = s.createElement(o),
                        m = s.getElementsByTagName(o)[0];
                a.async = 1;
                a.src = g;
                m.parentNode.insertBefore(a, m)
            })(window, document, 'script', 'https://www.google-analytics.com/analytics.js', 'ga');

            ga('create', 'UA-109411950-1', 'auto');
            ga('send', 'pageview');
        </script> -->
        <!-- End Google Analytics -->
    </head>
    <body class="theme-indigo">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-green">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Por favor espere...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->

    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="1" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document" >
            <div class="modal-content" id="myModal_content">

            </div>
        </div>
    </div>

    <div class="modal fade" id="my_modal" tabindex="3" role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog modal-lg" id="my_modal_content" role="document">
            <?php
            if (isset($my_modal))
            {
                ?>
                <?php echo $my_modal; ?>
            <?php } ?>
        </div>
    </div>
    <!-- #Modal -->

    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <!-- <div class="navbar-header">
                <a href=" " class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href=" " class="bars"></a>
                <a class="navbar-brand" href="index.html">CPREDIE</a>
            </div> -->
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <li class="pull-right">
                        <a href=" " class="js-right-sidebar" data-close="true">
                            <img img-responsive src="<?php echo asset_url(); ?>img/template_sipimss/imss.png"
                             height="80px"
                             class="logos"
                             alt="IMSS"
                             title="IMSS"
                             target="_blank"/>
                         </a>
                    </li>
                    <li class="">
                      <a href="http://educacionensalud.imss.gob.mx">
                          <img img-responsive src="<?php echo asset_url(); ?>img/template_sipimss/ces.png"
                               height="80px"
                               class="logos"
                               alt="CES"
                               title="CES"
                               target="_blank"/>
                      </a>
                    </li>

                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <?php $datos_sesion = $this->session->get_userdata()['control_escolar']['usuario']; ?>
            <div class="user-info">
                <div class="info-container">
                  <br>
                  <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Bienvenido</div>
                <div class="email"><?php echo $datos_sesion['nombre'] . ' ' . $datos_sesion['apellido_p'] . ' ' . $datos_sesion['apellido_m']; ?></div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">Menú</li>
                    <li>
                        <a href="principal.html">
                            <i class="fas fa-home fa-2x"></i>
                            <span>Inicio </span>                                                                                                                                                                                                                                                </span>
                        </a>
                    </li>
                    <li>
                        <a class="lista_docentes.html">
                            <i class="fas fa-user fa-2x"></i>
                            <span>Docentes</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="lista_cursos.html" class="">
                            <i class="fas fa-graduation-cap fa-2x"></i>
                            <span>Cursos</span>
                        </a>
                    </li>
                    <li>
                        <a class="lista_implementaciones.html">
                            <i class="fas fa-list-alt fa-2x"></i>
                            <span>Implementaciones</span>
                        </a>
                    </li>
                    <li>
                        <a class="">
                            <i class="fas fa-hand-spock fa-2x"></i>
                            <span>Administración</span>
                        </a>
                        <!-- <ul class="ml-menu">
                            <li>
                                <a href="manual.pdf" class="">
                                    <i class="fas fa-paperclip fa-2x"></i>
                                    <span>Manual</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="">
                                    <i class="fas fa-file-video fa-2x"></i>
                                    <span>Tutorial</span>
                                </a>
                            </li>
                        </ul> -->
                    </li>
                    <li>
                        <a class="menu-toggle">
                            <i class="fas fa-question fa-2x"></i>
                            <span>Ayudas</span>
                        </a>
                        <ul class="ml-menu">
                            <li>
                                <a href="manual.pdf" class="">
                                    <i class="fas fa-paperclip fa-2x"></i>
                                    <span>Manual</span>
                                </a>
                            </li>
                            <li>
                                <a href="" class="">
                                    <i class="fas fa-file-video fa-2x"></i>
                                    <span>Tutorial</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a class="">
                            <i class="fas fa-sign-out-alt fa-2x"></i>
                            <span>Cerrar sesión</span>
                        </a>
                    </li>
                </ul>
            </div>
            <!-- #Menu -->
        </aside>
        <!-- #left side bar -->

    </section>
    <section class="content">
        <div class="container-fluid">
            <!-- Widgets -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <?php
                        if (isset($sub_title) && !empty($sub_title))
                        {
                            ?>
                        <div class="header">
                            <h2><?php echo $sub_title; ?></h2>
                        </div>
                        <div class="body">
                            <?php
                                }
                                if (isset($main_content))
                                {
                            ?>
                            <?php
                                echo $main_content;
                            ?>
                            <?php }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- #END# -->
    <footer class="">

    </footer>

    <div class="modal fade" id="mesa-ayuda-modal" tabindex="-1" role="dialog" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="padding:35px 50px;">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4><span class="glyphicon glyphicon-lock"></span>Mesa de ayuda</h4>
                </div>
                <div class="modal-body" style="padding:40px 50px;">
                    <div class="login-page">
                        <p>¿Tienes alguna duda? Comunícate con nosotros:</p>
                        <p><strong>Teléfono:</strong> 56 27 69 00 Ext. 21146, 21147 y 21148<br><strong>Email:</strong> <a href="mailto:soporte.sipimss@gmail.com">soporte.sipimss@gmail.com</a><br><strong>Horario:</strong>&nbsp;de lunes a&nbsp;viernes, de&nbsp;8h&nbsp;a 16h</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- Bootstrap Core Js este va al final -->
        <?php echo js("plugins_cpredie/bootstrap/js/bootstrap.js"); ?>
        <!-- Select Plugin Js -->
        <?php echo js("plugins_cpredie/bootstrap-select/js/bootstrap-select.js"); ?>
        <!-- Slimscroll Plugin Js -->
        <?php echo js("plugins_cpredie/jquery-slimscroll/jquery.slimscroll.js"); ?>
        <!-- Waves Effect Plugin Js -->
        <?php echo js("plugins_cpredie/node-waves/waves.js"); ?>
        <!-- Custom Js -->
        <?php echo js("template_cpredie/admin.js"); ?>

        <!-- Demo Js -->
        <?php echo js("template_cpredie/demo.js"); ?>
    </body>
</html>
