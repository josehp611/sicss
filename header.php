<nav class="navbar navbar-inverse" role="navigation" id="stickyribbon">
  <!-- Brand and toggle get grouped for better mobile display -->
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
      <span class="sr-only">Toggle navigation</span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
  </div>
  <!-- Collect the nav links, forms, and other content for toggling -->
  <div class="collapse navbar-collapse navbar-ex1-collapse">
	<ul class="nav navbar-nav">
            <li class="active"><a href="./"><img src="images/home.png"></img></a></li>
<?php
// Si la sesion esta activa debera mostra el menu correspondiente
if (isset($_SESSION['u']) && !empty($_SESSION['u'])) {
	try {
		$usr = Usuario::getInstance ();
		$info = $usr->infoUsuario ( $_SESSION ['u'] );
		if(!empty($info)){
			$_SESSION['u'] = $info['usr_usuario'];
			$_SESSION['n'] = $info['usr_nombre'];
			$_SESSION['i'] = $info['id_usuario'];
			$_SESSION['idmod'] = $_GET['id'];
			$_SESSION['req'] = $info['usr_req'];
			$_SESSION['sol'] = $info['usr_sol'];
			$_SESSION['oc'] = $info['usr_oc'];
			$_SESSION['menu_cheque_users']=((int)$info['id_rol']>=999999996 ? true : false);
		}else if(!empty($_SESSION['cheque'])){
            $info=array(
                'id_usuario'=>0
            );
        }
		//print_r($info);
		if (empty ( $_GET ['c'] )) {
			$controlador = 'login';
		}
		if (empty ( $_GET ['a'] )) {
			$accion = 'ingreso';
		}
	} catch ( Exception $e ) {
	?>
		<div class="alert alert-error">
			<p><?php echo $e->getMessage(); ?></p>
		</div>
	<?php
		die ();
	}
	// ACCESO A MODULOS
	$res = $usr->modulosUsuario ( $_SESSION ['i'] );
	$categoria = "";
	$catego = array();
	// Llenamos la primera categoria
	while ( $mods = mysql_fetch_array ( $res ) ) {
		if($categoria != $mods['mod_categoria']){
				$catego[$mods['mod_categoria']] = '' ;
		}
		$categoria = $mods['mod_categoria'];
	}
	// Llenamos la segunda categoria y el contenido de la misma
	$res = $usr->modulosUsuario ( $_SESSION ['i'] );
	$x = 0;
	while ( $mods = mysql_fetch_array ( $res ) ) {
		foreach($catego as $c=>$v){
			if($c == $mods['mod_categoria']){
				if($mods['id_modulo'] == 3) {
					if($x == 0){
						$catego[$c][$mods['mod_categoria2']][]=$mods;
						$x = 1;
					}
				} else {
					$catego[$c][$mods['mod_categoria2']][]=$mods;
				}
			}
		}
	}
	/*
	 * Quitamos las opciones a las que no tiene acceso
	 */
	foreach($catego as $k => $v){
		foreach($v as $l => $m){
			foreach($m as $n => $o){
				// Consultar Emisor
				/*
				if($catego[$k][$l][$n]['mod_url'] == '?c=req&a=emisor&id=6' && $info['usr_req'] == 0){
					unset($catego[$k][$l][$n]);
				}
				if($catego[$k][$l][$n]['mod_url'] == '?c=solc&a=emisor&id=5' && $info['usr_sol'] == 0){
					unset($catego[$k][$l][$n]);
				}*/
				// Recoleccion
				if($catego[$k][$l][$n]['mod_url'] == '?c=req&a=colectar&id=6' && $info['usr_req'] == 0){
					unset($catego[$k][$l][$n]);
				}
				if($catego[$k][$l][$n]['mod_url'] == '?c=solc&a=colectar&id=5' && $info['usr_sol'] == 0){
					unset($catego[$k][$l][$n]);
				}
				// Trabaja Recoleccion
				if($catego[$k][$l][$n]['mod_url'] == '?c=req&a=tracole&id=6' && $info['usr_req'] == 0){
					unset($catego[$k][$l][$n]);
				}
				if($catego[$k][$l][$n]['mod_url'] == '?c=solc&a=tracole&id=5' && $info['usr_sol'] == 0){
					unset($catego[$k][$l][$n]);
				}
				//echo $catego[$k][$l][$n]['mod_url'].'<br>';
			}
		}
	}
	?>
			<?php //foreach($catego as $c=>$v){ ?>
			<!--
				<li class="dropdown">
					<a id="drop1" href="#" role="button" class="dropdown-toggle" data-hover="dropdown" data-toggle="dropdown">
						<?php //echo $c; ?><b class="caret"></b>
					</a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="drop1">
					<?php //foreach($v as $c1=>$v1 ){ ?>
							<li class="dropdown-submenu">
								<a><?php //echo $c1; ?></a>
								<ul class="dropdown-menu">
							<?php //foreach($v1 as $x){ ?>
									<li>
										<a href="<?php //echo $x['mod_url']; ?>" target="<?php //echo $x['mod_target']; ?>"><?php //echo $x['mod_descripcion']; ?></a>
									</li>
							<?php //}	?>
								</ul>
							</li>
					<?php //}	?>
					</ul>
					</li>
					-->
			<?php //}	?>
			</ul>
			<div class="navbar-right">
			<ul class="nav pull-right">
				<li class="dropdown clearfix">
					<a id="dropdownMenu1" href="#" role="button" class="dropdown-toggle" data-toggle="dropdown"><i class="glyphicon glyphicon-user"></i><?php echo $_SESSION['u']; ?><b class="caret"></b></a>
					<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
						<li>
							<div class="col-sm-4 col-md-4">
            					<img src="images/users-grey.png" alt="" class="img-rounded img-responsive" />
        					</div>
					        <div class="col-sm-8 col-md-8">
					            <blockquote>
					                <p><?php echo $_SESSION['u']; ?></p> <small><cite title="Ubicacion"><?php echo $_SESSION['n']; ?>  <i class="glyphicon glyphicon-map-marker"></i></cite></small>
					            </blockquote>
					            <p>
					            	<i class="glyphicon glyphicon-calendar"></i> <?php echo date("d/m/Y"); ?>
					                <br />
					                <i class="glyphicon glyphicon-time"></i> <?php echo date("H:i:s"); ?>
					            </p>
					        </div>
						</li>
						<li role="presentation"><a role="menuitem" href="?c=usua&a=pwd"><i class="icon-cog"></i> Preferencias</a></li>
						<li role="presentation"><a role="menuitem" href="#"><i class="icon-envelope"></i> Ayuda</a></li>
						<li role="presentation" class="divider"></li>
						<li role="presentation">
							<a role="menuitem" href="LogOut.php"><i class="icon-off"></i> Salir</a>
						</li>
					</ul>
				</li>
			</ul>
			</div>
<?php } ?>
</div>
</nav>