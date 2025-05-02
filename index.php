<?php ob_start(); ?>
<!DOCTYPE html>
	<html>
	<head>
	<meta charset="utf-8">
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
  	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>Sistema Integrado de Compras y Suministros</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
    
    <!-- Material Design fonts -->
  <!--<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:300,400,500,700">
  <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/icon?family=Material+Icons">-->

    <!-- ESTILOS -->
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css" />
	<link rel="stylesheet" type="text/css" href="css/redmond/jquery-ui-1.9.2.custom.css" />
	<link rel="stylesheet" type="text/css" href="css/msgGrowl.css" />
	<link rel="stylesheet" type="text/css" href="css/jquery.pnotify.default.css" />
	<link rel="stylesheet" type="text/css" href="css/datepicker.css" />
	<link rel="stylesheet" type="text/css" href="css/bootstrap-wysihtml5.css"></link>
	<link rel="stylesheet" type="text/css" href="css/DT_bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome-social.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome-corp.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome-ext.css">
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="css/font-awesome-ie7.min.css">
	<link rel="stylesheet" type="text/css" href="css/font-awesome-more-ie7.min.css">
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="css/custom.css" />
	<link rel="stylesheet" type="text/css" href="css/dataTables.bootstrap.min.css" />

	<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv-printshiv.js"></script>
    <![endif]-->

	<!-- jQuery -->

	<script type="text/javascript" src="js/jquery-1.8.3.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.9.2.custom.js"></script>
	<script type="text/javascript" src="js/jquery.validate.js"></script>
	<script type="text/javascript" src="js/jquery.metadata.js"></script>
	<script type="text/javascript" src="js/msgGrowl.js"></script>
	<script type="text/javascript" src="js/jquery.pnotify.js"></script>
	<script type="text/javascript" src="js/jquery.sticky.js"></script>
	<script type="text/javascript" src="js/ajaxq.js"></script>
	<script type="text/javascript" src="js/moment.js"></script>
	<script type="text/javascript" src="js/daterangepicker.js"></script>

	<!-- <script type="text/javascript" src="js/modernizr-2.5.3.min.js"></script>
	<script type="text/javascript" src="js/respond.min.js"></script>-->

    <?php
	// xajax
	require_once 'xajax/xajax_core/xajax.inc.php';
	$xj = new xajax ();
	$xj->printJavascript ( 'xajax/' );
	?>
	<script type="text/javascript" charset="utf-8">

		/***********************************************
		* Disable Text Selection script- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
		* This notice MUST stay intact for legal use
		* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
		***********************************************/
		function disableSelection(target){
			if (typeof target.onselectstart!="undefined") { //For IE
				target.onselectstart=function(){
					return false;
					};
			} else if (typeof target.style.MozUserSelect!="undefined") { //For Firefox
				target.style.MozUserSelect="none";
			} else { //All other route (For Opera)
				target.onmousedown=function(){
					return false;
					};
			}
			target.style.cursor = "default";
		}
		/*
		* EVITAMOS EL CLICK DERECHO
		*/
		$(function () {

			/*Preloader*/
			  $(window).load(function() {
			    setTimeout(function() {
			      $('body').addClass('loaded');      
			    }, 0);
			  });
			  
			$(this).bind("contextmenu", function (e) {
				return;
				e.preventDefault();
				$.msgGrowl ({
					type: 'error',
					title: 'IMPRESSA, S.A. de C.V.',
					text: 'Accion NO autorizada.'
				});
			});
		});
		/*
		*VEAMOS EL CTRL+C
		*/
		var ctlPressed = false; //Flag to check if pressed the CTL key
		var ctl = 17; //Key code for Ctl Key
		var c = 67; //Key code for "c" key
		var timeSlide = 5000;
		$(document).keydown(function(e) {
			if (e.keyCode == ctl) ctlPressed = true;
		}).keyup(function(e) {
			if (e.keyCode == ctl) ctlPressed = true;
		});
		$(".container").keydown(function(e)     {
			if (ctlPressed && e.keyCode == 'c')
				$('#alerta-copy').show('slow');
				$('#alerta-copy').slideUp(timeSlide);
				return false;
		});
		var stack_topleft = {"dir1": "down", "dir2": "right", "push": "top"};
		var stack_bottomleft = {"dir1": "right", "dir2": "up", "push": "top"};
		var stack_custom = {"dir1": "right", "dir2": "down"};
		var stack_custom2 = {"dir1": "left", "dir2": "up", "push": "top"};
		var stack_bar_top = {"dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0};
		var stack_bar_bottom = {"dir1": "up", "dir2": "right", "spacing1": 0, "spacing2": 0};
		var stack_bottomright = {"dir1": "up", "dir2": "left", "firstpos1": 25, "firstpos2": 25};
	</script>
	<style type="text/css">
		select#primera, select#segunda {
			overflow: auto;
		    overflow-y: auto;
			overflow-x: auto;
			-ms-overflow-y: auto;
			-ms-overflow-x: auto;
			font-size: 11px;
		}
		option:not(:enabled) { 
		    color:red;
			font-weight: bold;
		}
		.modal-dialog {
		    min-width: 90%;
		}
		.dropdown-menu{
		    min-width: 300px;
		}
		.material-switch > input[type="checkbox"] {
		    display: none;   
		}
		
		.material-switch > label {
		    cursor: pointer;
		    height: 0px;
		    position: relative; 
		    width: 40px;  
		}
		
		.material-switch > label::before {
		    background: rgb(0, 0, 0);
		    box-shadow: inset 0px 0px 10px rgba(0, 0, 0, 0.5);
		    border-radius: 8px;
		    content: '';
		    height: 16px;
		    margin-top: -8px;
		    position:absolute;
		    opacity: 0.3;
		    transition: all 0.4s ease-in-out;
		    width: 40px;
		}
		.material-switch > label::after {
		    background: rgb(255, 255, 255);
		    border-radius: 16px;
		    box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.3);
		    content: '';
		    height: 24px;
		    left: -4px;
		    margin-top: -8px;
		    position: absolute;
		    top: -4px;
		    transition: all 0.3s ease-in-out;
		    width: 24px;
		}
		.material-switch > input[type="checkbox"]:checked + label::before {
		    background: inherit;
		    opacity: 0.5;
		}
		.material-switch > input[type="checkbox"]:checked + label::after {
		    background: inherit;
		    left: 20px;
		}
		
		table#tblColectar > tbody > tr > td, 
		table#tblColectar > tbody > tr > td > ul,
		table#tblColectar > thead > tr > th,
		table#tblColectar > thead > tr > th > ul {
			vertical-align: middle;
			margin-bottom: 0px;
		}
		.red-tooltip + .tooltip > .tooltip-inner {background-color: #f00;}
		.red-tooltip + .tooltip > .tooltip-arrow { 
			border-bottom-color:#f00; 
			top: 50%;
		  	right: 0;
		  	margin-top: -5px;
		  	border-left-color: #f00;
		  	border-width: 5px 0 5px 5px;
		}
	.form-inline > .form-group > .form-control {
	    font-size: 9px;
	}
	.table-condensed > tbody > tr > td {
		vertical-align: middle;
	}
.bs-calltoaction{
    position: relative;
    width:auto;
    padding: 15px 25px;
    border: 1px solid black;
    margin-top: 10px;
    margin-bottom: 10px;
    border-radius: 5px;
}

    .bs-calltoaction > .row{
        display:table;
        width: calc(100% + 30px);
    }
     
        .bs-calltoaction > .row > [class^="col-"],
        .bs-calltoaction > .row > [class*=" col-"]{
            float:none;
            display:table-cell;
            vertical-align:middle;
        }

            .cta-contents{
                padding-top: 10px;
                padding-bottom: 10px;
            }

                .cta-title{
                    margin: 0 auto 15px;
                    padding: 0;
                }

                .cta-desc{
                    padding: 0;
                }

                .cta-desc p:last-child{
                    margin-bottom: 0;
                }

            .cta-button{
                padding-top: 10px;
                padding-bottom: 10px;
            }

@media (max-width: 991px){
    .bs-calltoaction > .row{
        display:block;
        width: auto;
    }

        .bs-calltoaction > .row > [class^="col-"],
        .bs-calltoaction > .row > [class*=" col-"]{
            float:none;
            display:block;
            vertical-align:middle;
            position: relative;
        }

        .cta-contents{
            text-align: center;
        }
}



.bs-calltoaction.bs-calltoaction-default{
    color: #333;
    background-color: #fff;
    border-color: #ccc;
}

.bs-calltoaction.bs-calltoaction-primary{
    color: #fff;
    background-color: #337ab7;
    border-color: #2e6da4;
}

.bs-calltoaction.bs-calltoaction-info{
    color: #fff;
    background-color: #5bc0de;
    border-color: #46b8da;
}

.bs-calltoaction.bs-calltoaction-success{
    color: #fff;
    background-color: #5cb85c;
    border-color: #4cae4c;
}

.bs-calltoaction.bs-calltoaction-warning{
    color: #fff;
    background-color: #f0ad4e;
    border-color: #eea236;
}

.bs-calltoaction.bs-calltoaction-danger{
    color: #fff;
    background-color: #d9534f;
    border-color: #d43f3a;
}

.bs-calltoaction.bs-calltoaction-primary .cta-button .btn,
.bs-calltoaction.bs-calltoaction-info .cta-button .btn,
.bs-calltoaction.bs-calltoaction-success .cta-button .btn,
.bs-calltoaction.bs-calltoaction-warning .cta-button .btn,
.bs-calltoaction.bs-calltoaction-danger .cta-button .btn{
    border-color:#fff;
}
        
        #loader-wrapper{
            z-index: 10000;
        }
	</style>
	
    <!-- Custom styles for this template -->
    <link href="css/sticky-footer-navbar.css" rel="stylesheet">
    <link href="css/daterangepicker.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->
    
    <!-- Bootstrap Material Design -->
  <!-- <link rel="stylesheet" type="text/css" href="css/bootstrap-material-design.css">
  <link rel="stylesheet" type="text/css" href="css/ripples.min.css"> -->
  
  <link rel="stylesheet" type="text/css" href="css/notie.css" />
</head>
<?php
global $idmod;
// Primero algunas variables de configuracion
require_once 'Configuracion.php';
// Manejo de Base de Datos
require_once 'DB.php';
// Clase de Usuarios
require_once 'class/Usuario.php';
// La carpeta donde buscaremos los controladores
$carpetaControladores = "controller/";
// Si no se indica un controlador, este es el controlador que se usará
$controladorPredefinido = "index";
// Si no se indica una accion, esta accion es la que se usará
$accionPredefinida = "inicio";
if (! empty ( $_GET ['c'] )) {
	$controlador = $_GET ['c'];
} else {
	$controlador = $controladorPredefinido;
}
if (! empty ( $_GET ['a'] )) {
	$accion = $_GET ['a'];
} else {
	$accion = $accionPredefinida;
}
// SESSION
session_start ();
?>
<body>
<!-- CONTENIDO -->
<div class="container-fluid">
	<div class="row panal">
		<img src="images/header.png" class="img-responsive hidden-xs hidden-sm">
		<h3 class="pull-right visible-xs visible-sm">SICS<sup class="text-danger"></sup></h3>
		<img src="images/logo.PNG" class="img-responsive visible-xs visible-sm">
		<!--<h3 class="pull-right hidden-xs hidden-sm">Sistema Integrado de Compras y Suministros <sup class="text-danger">beta</sup></h3>-->
		<?php require_once 'header.php'; ?>
		<div class="row">
		<?php if($_SESSION){ ?>
			<div class="col-md-3">
				<?php require_once('menu.php'); ?>
			</div>
			<div class="col-md-9" style="padding: 0;margin-left: -8px;">
		<?php } else { ?>
			<div class="col-md-12" style="border-top: 1px solid #000;">
		<?php } ?>
			<?php
			// Ya tenemos el controlador y la accion
			// Formamos el nombre del fichero que contiene
			// nuestro controlador
			$controlador = $carpetaControladores . $controlador . 'Controller.php';
			/*
			 * CONTENIDO AQUI
			 */
			// Si la sesion ya esta activa
			if (! empty ( $_SESSION ['n'] ) && ! empty ( $_SESSION ['u'] )) {
				// Incluimos el controlador o
				// detenemos todo si no existe
				if (is_file ( $controlador )) {
					require_once $controlador;
					// Invocamos la accion
					if (is_callable ( $accion )) {
						$accion ();
					} else {
					?>

					<div class="container">
					    <div class="row">
					        <div class="col-md-12">
					            <div class="error-template">
					                <h1>
					                    Oops!</h1>
					                <h2>
					                    404 No Encontrado</h2>
					                <div class="error-details">
					                    Parece que el link que buscas no ha sido encontrado!
					                </div>
					                <div class="error-actions">
					                    <a href="." class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
					                        Ir al Inicio </a>
					                    <!-- <a href="?c=login&a=ingreso" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a> -->
					                </div>
					            </div>
					        </div>
					    </div>
					</div>
					<?php
					}
				} else {
				?>
					<div class="container">
					    <div class="row">
					        <div class="col-md-12">
					            <div class="error-template">
					                <h1>
					                    Oops!</h1>
					                <h2>
					                    404 No Encontrado</h2>
					                <div class="error-details">
					                    Parece que el link que buscas no ha sido encontrado!
					                </div>
					                <div class="error-actions">
					                    <a href="." class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
					                        Ir al Inicio </a>
					                    <!-- <a href="?c=login&a=ingreso" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a> -->
					                </div>
					            </div>
					        </div>
					    </div>
					</div>
					<?php
					}
				} else {
					if ($controlador === 'controller/indexController.php') {
						// Incluimos el controlador o detenemos
						// todo si no existe
						if (is_file ( $controlador )) {
							require_once $controlador;
						}
						// Llamamos la accion o detenemos
						// todo si no existe
						if (is_callable ( $accion )) {
							$accion ();
						} else {
						?>
							<!-- La accion no ha sido definida para este controlador -->
							<div class="container">
							    <div class="row">
							        <div class="col-md-12">
							            <div class="error-template">
							                <h1>
							                    Oops!</h1>
							                <h2>
							                    404 No Encontrado</h2>
							                <div class="error-details">
							                    Parece que el link que buscas no ha sido encontrado!
							                </div>
							                <div class="error-actions">
							                    <a href="." class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
							                        Ir al Inicio </a>
							                    <!-- <a href="?c=login&a=ingreso" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a> -->
							                </div>
							            </div>
							        </div>
							    </div>
							</div>
						<?php
						}
					} else {
					?>
						<div class="container">
						    <div class="row">
						        <div class="col-md-12">
						            <div class="error-template">
						                <h1>
						                    Oops!</h1>
						                <h2>
						                    404 No Encontrado</h2>
						                <div class="error-details">
						                    Parece que tus credenciales de sesion han expirado!
						                </div>
						                <div class="error-actions">
						                    <a href="." class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-home"></span>
						                        Iniciar Sesion </a>
						                    <!-- <a href="?c=login&a=ingreso" class="btn btn-default btn-lg"><span class="glyphicon glyphicon-envelope"></span> Contact Support </a> -->
						                </div>
						            </div>
						        </div>
						    </div>
						</div>
					<?php
					}
				}
				?>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- PIES -->
<div class="footer">
	<div class="container-fluid">
		<?php require_once 'footer.php'; ?>
	</div>
</div>

<div id="alerta-copy" style="margin-left: 65px; top: 35px; position: absolute; z-index: 9999999; display: none;" class="alert alert-danger">
	<p>Lo sentimos no esta autorizado, para esta accion.</p>
</div>
<div id="overlay" class="modal-open modal-backdrop hide"><img class="centering" src="images/preloader-w8-cycle-black.gif" id="img-load" style="position: fixed;" /></div>

</body>
<script>
$('a').mouseover(function(){
	window.status = "SISTEMA INTEGRADO DE COMPRAS Y SUMINISTROS.";
});
$('a').mouseenter(function(){
	window.status = "SISTEMA INTEGRADO DE COMPRAS Y SUMINISTROS.";
});
$('a').mouseleave(function(){
	window.status = "SISTEMA INTEGRADO DE COMPRAS Y SUMINISTROS.";
});
$('a').hover(function(){
	window.status = "SISTEMA INTEGRADO DE COMPRAS Y SUMINISTROS.";
});
disableSelection(document.body);
</script>
<script type="text/javascript" src="js/bootstrap.js"></script>
<!-- Material Design for Bootstrap -->
<!-- <script src="js/material.js"></script>
<script src="js/ripples.min.js"></script>-->
<script>
  //$.material.init();
</script>
<!-- x-editable (bootstrap) -->
<link href="css/bootstrap-editable.css" rel="stylesheet">
<script src="js/bootstrap-editable.js"></script>
<script>
var f = 'bootstrap';
</script>
<!-- address input -->
<link href="css/address.css" rel="stylesheet">
<script src="js/address.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/wysihtml5-0.3.0.js"></script>
<script type="text/javascript" src="js/bootstrap-wysihtml5.js"></script>
<link href="css/jquery.alerts.css" rel="stylesheet">
<script type="text/javascript" src="js/jquery.alerts.js"></script>
<script type="text/javascript" src="js/bootstrap-datepicker.js"></script>
<script type="text/javascript" src="js/jquery.price_format.min.js"></script>
<script type="text/javascript" src="js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
    $(function(){
		$("#accordion").sticky({topSpacing: 10});
		if($.browser.msie && parseInt($.browser.version, 10) <= 7) {
		//if(!$.browser.msie) {
			jAlert('Lo sentimos, el navegador no ha sido soportado', 'Alert Dialog', function(r){
				$(location).attr('href', 'http://intranet.impressa.com');
			});
		}
		//$('body').bootstrapMaterialDesign();   
	});
</script>
<script type="text/javascript" src="js/notie.min.js"></script>
</html>
<?php
ob_end_flush();
?>