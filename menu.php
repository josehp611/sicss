<?php
session_start();

require_once 'model/cheque/EntityDB.php';
$db = new EntityDB;
$perfil = $db->get_usuario();

function is_ctl_action($ctlaction){
	return stripos("/?".$_SERVER['QUERY_STRING'],$ctlaction);
}
// Si la sesion esta activa debera mostra el menu correspondiente
$is_ufinal_o_uatorizadorcc = false;
$user_categoria = false;
$user_gestion = false;
if (isset($_SESSION['u']) && !empty($_SESSION['u']) && empty($_SESSION['cheque'])) {
	try {
		$usr = Usuario::getInstance ();
		$info = $usr->infoUsuario ( $_SESSION ['u'] );
		$_SESSION['rol_de_usuario']=((int)$info['id_rol']-999999993);
		$cats = $usr->accesosCategorias($info['id_usuario']);
		$user_categoria = $cats;
		$gest = $usr->accesosGestor($info['id_usuario']);
		$user_gestion = $gest;
		$_SESSION['u'] = $info['usr_usuario'];
		$_SESSION['n'] = $info['usr_nombre'];
		$_SESSION['i'] = $info['id_usuario'];
		$_SESSION['idmod'] = $_GET['id'];
		$_SESSION['req'] = $info['usr_req'];
		$_SESSION['sol'] = $info['usr_sol'];
		$_SESSION['oc'] = $info['usr_oc'];
		$_SESSION['rol_admin_sics']=false;
		if(!empty($info)){
			$is_ufinal_o_uatorizadorcc = ((int)$info['id_rol']<=999999995);
			$_SESSION['rol_admin_sics'] = $is_ufinal_o_uatorizadorcc;
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
				/*if($catego[$k][$l][$n]['mod_url'] == '?c=req&a=tracole&id=6'){
					$catego[$k][$l][$n]['mod_url'] = '?c=req&a=tracolex&id=6';
				}*/
				// Trabaja Recoleccion
				if($catego[$k][$l][$n]['mod_url'] == '?c=req&a=oc_sp&id=6' && $info['usr_req'] == 0){
					unset($catego[$k][$l][$n]);
				}
				if($catego[$k][$l][$n]['mod_url'] == '?c=solc&a=oc_sp&id=5' && $info['usr_sol'] == 0){
					unset($catego[$k][$l][$n]);
				}
				
				// Trabaja Solicitudes
				if($catego[$k][$l][$n]['mod_url'] == '?c=solc&a=gestor&id=5' && $info['usr_sol'] == 0){
					unset($catego[$k][$l][$n]);
				}
				if($catego[$k][$l][$n]['mod_url'] == '?c=inv&a=inicios&id=5' && $info['usr_sol'] == 0){
					unset($catego[$k][$l][$n]);
				}
				
				// Trabaja Solicitudes de Consumo
				if($catego[$k][$l][$n]['mod_url'] == '?c=ci&a=gestor&id=12' && $info['usr_sol'] == 0){
					unset($catego[$k][$l][$n]);
				}
				if($catego[$k][$l][$n]['mod_url'] == '?c=ci&a=prod&id=12' && $info['usr_sol'] == 0){
					unset($catego[$k][$l][$n]);
				}
				if($catego[$k][$l][$n]['mod_url'] == '?c=ci&a=xls&id=12&via=1' && $info['usr_sol'] == 0){
					unset($catego[$k][$l][$n]);
				}
				//echo $catego[$k][$l][$n]['mod_url'].'<br>';
			}
		}
	}
	?>
	<?php if(!$is_ufinal_o_uatorizadorcc):?>
	<div class="panel-group" id="accordion">
		<?php $i =1; ?>
		<?php foreach($catego as $c=>$v){ ?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapse<?php echo $i; ?>" class="accordion-toggle" data-parent="#accordion" data-toggle="collapse">
							<?php echo $c; ?>
						</a>
					</h4>
				</div>
				<?php
				$estado = "";
				if($c == 'ADMINISTRACION') {
					if($_GET['a'] == 'anal' || $_GET['id'] == '2' || $_GET['id'] == '3' || $_GET['id'] == '4' || $_GET['id'] == '8' || $_GET['id'] == '11'){
						$estado = "in";
					}
					if($_GET['c'] == 'prov' && $_GET['a'] == 'lista'){
						$estado = "in";
					}
				} elseif($c == 'PROCESOS') {
					if($_GET['id'] == '6' && $_GET['a'] == 'colectar' || $_GET['id'] == '5' && $_GET['a'] == 'colectar' ){
						$estado = "in";
					}
					if($_GET['id'] == '6' && $_GET['a'] == 'crearoc' || $_GET['id'] == '5' && $_GET['a'] == 'crearoc' ){
						$estado = "in";
					}
				} elseif($c == 'REQUISICION DE SUMINISTRO') {
					if($_GET['id'] == '6' && $_GET['a'] <> 'colectar' && $_GET['id'] == '6' && $_GET['a'] <> 'crearoc' && $_GET['a'] <> 'crearnr' && $_GET['a'] <> 'ocpre'){
						$estado = "in";
					}
				} elseif($c == 'SOLICITUD DE COMPRA') {
					if($_GET['id'] == '5' && $_GET['a'] != 'colectar'){
						$estado = "in";
					}
				} elseif ($c == 'REPORTES' && $_GET['id'] == '7') {
					$estado = "in";
				} elseif ($c == 'INVENTARIO' && $_GET['c'] == 'inv' && $_GET[id] == '9' || $c == 'INVENTARIO' && $_GET['a'] == 'ocpre' || $c == 'INVENTARIO' && $_GET['a'] == 'crearnr') {
					$estado = "in";
				} elseif($c == 'CONSUMO INTERNO' && $_GET[id] == '12') {
					$estado = "in";
				} else {
					$estado = "";
				}
				?>
				<div id="collapse<?php echo $i; ?>" class="panel-collapse collapse <?php echo $estado; ?>">
					<div class="panel-body">
						<?php foreach($v as $c1=>$v1 ){ ?>
							<b><?php echo $c1; ?></b>
							<div class="list-group">
							<?php foreach($v1 as $x){ ?>
								<a class="<?php if(is_ctl_action($x['mod_url'])) echo 'list-group-item active'; else echo 'list-group-item'; ?>" href="<?php echo $x['mod_url']; ?>" target="<?php echo $x['mod_target']; ?>">
									<?php echo $x['mod_descripcion']; ?>
								</a>
							<?php }	?>
							</div>
						<?php }	?>
					</div>
				</div>
			<?php $i++; ?>
			</div>
		<?php }	?>
		<?php
		// Debemos verificar si tiene acceso para autorizar ya sea categorias o gestionar
		if(count($cats) > 0){
		?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapseCategorias" class="accordion-toggle" data-parent="#accordion" data-toggle="collapse">
							GEST. CATEGORIA DE COMPRA
						</a>
					</h4>
				</div>
				<div id="collapseCategorias" class="panel-collapse collapse <?php echo (is_ctl_action("c=solc&a=gescat") ? "in" : "")?>">
					<div class="panel-body">	
						<b>Gestionar por Categorias</b>
						<div class="list-group">
							<a class="<?php if(is_ctl_action("c=solc&a=gescat")) echo 'list-group-item active'; else echo 'list-group-item'; ?>" href="?c=solc&a=gescat" target="_self">
								Gestionar
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php 
		}
		?>
		<?php
		// Debemos verificar si tiene acceso para autorizar ya sea categorias o gestionar
		if(count($gest) > 0){
		?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapseCategorias" class="accordion-toggle" data-parent="#accordion" data-toggle="collapse">
							GESTIONAR SOLICITUDES
						</a>
					</h4>
				</div>
				<div id="collapseCategorias" class="panel-collapse collapse <?php echo (is_ctl_action("c=solc&a=gest") ? "in" : "")?>">
					<div class="panel-body">	
						<b>Autorizar Solicitudes</b>
						<div class="list-group">
							<a class="<?php if(is_ctl_action("c=solc&a=gest")) echo 'list-group-item active'; else echo 'list-group-item'; ?>" href="?c=solc&a=gest" target="_self">
								Gestionar
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php 
		}
		?>
		<?php 
                    if(file_exists('view/solcheque/menu_perfil.php')){
                        require_once 'view/solcheque/menu_perfil.php';	
                    }
		?>
	</div>
	<?php endif;?>
<?php } else{ ?>
    <?php 
        if(file_exists('view/solcheque/menu_perfil.php')){
            require_once 'view/solcheque/menu_perfil.php';	
        }
    ?>
<?php } ?>

<?php if($is_ufinal_o_uatorizadorcc):?>
<div id="accordion-sticky-wrapper" class="sticky-wrapper">
		<div class="panel-group" id="accordion">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapse1" class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse">
							GESTIONAR SOLICITUDES
						</a>
					</h4>
				</div>
				<?php
				$isopen = (is_ctl_action('?c=menu&a=index') || is_ctl_action('?c=solcheque&a=crear') || is_ctl_action('?c=menu&a=autorizarcc') || is_ctl_action('?c=menu&a=consulta') || is_ctl_action('?c=solcheque&a=consultarde') || is_ctl_action('?c=solc&a=VerS') || is_ctl_action('?c=solcheque&a=VerS')) && !is_ctl_action('?c=menu&a=consulta_');
				$isopen = ($isopen ? 'in' : '');
				?>
				<div id="collapse1" class="panel-collapse collapse <?php echo $isopen;?>">
					<div class="panel-body">
						<div class="list-group">
							<a class="list-group-item <?php echo (is_ctl_action('?c=menu&a=index') || is_ctl_action('?c=menu&a=autorizarcc') || is_ctl_action('?c=solcheque&a=crear') ? 'active' : '');?>" href="?c=menu&a=index" target="_self">
								Gestionar		
							</a>
							<a class="list-group-item <?php echo (is_ctl_action('?c=menu&a=consulta') ? 'active' : '');?>" href="?c=menu&a=consulta" target="_self">
								Consultar
							</a>
							<?php if(!empty($_SESSION['u'])):
									$usr_sics = strtolower($_SESSION['u']);
									$user_traza = array('controller','gcia.financiera','jefe administracion');
								?>
								<?php if(in_array($usr_sics,$user_traza)):?>
								<a class="list-group-item <?php echo (is_ctl_action('?c=solcheque&a=VerS') || is_ctl_action('?c=solc&a=VerS') ? 'active' : '');?>" href="?c=solc&a=VerS" target="_self">
									Consultar por trazabilidad
								</a>
								<?php endif; ?>
							<?php endif; ?>
							<!--<a class="list-group-item <?php echo (is_ctl_action('?c=req&a=m_r&id=6') ? 'active' : '');?>" href="?c=req&a=m_r&id=6" target="_self">
								Marcar Nota de Remisión (Requisición de Suministros)
							</a>-->
							<?php if(strtoupper($perfil->usuario)=='DIRECCIONEJECUTIVA'):
					                $_SESSION['user_5k']=true;?>
								<a class="list-group-item <?php echo (is_ctl_action('?c=solcheque&a=consultarde') ? 'active' : '');?>" href="?c=solcheque&a=consultarde" target="_self">
									Autorizar Igual o Mayor a $5K
								</a>
							<?php endif;?>
						</div>
					</div>
				</div>
			</div>
		<?php
			// Debemos verificar si tiene acceso para autorizar ya sea categorias o gestionar
		if(count($cats) > 0){
		?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapseCategorias" class="accordion-toggle" data-parent="#accordion" data-toggle="collapse">
							GEST. CATEGORIA DE SOLICITUD
						</a>
					</h4>
				</div>
				<div id="collapseCategorias" class="panel-collapse collapse <?php echo (is_ctl_action('?c=menu&a=consulta_categoria') ? "in" : "")?>">
					<div class="panel-body">	
						<b>Gestionar por Categorias</b>
						<div class="list-group">
							<a class="list-group-item <?php echo (is_ctl_action('?c=menu&a=consulta_categoria') ? 'active' : '');?>" href="?c=menu&a=consulta_categoria" target="_self">
								Gestionar
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php 
		}
		?>
		<?php
		// Debemos verificar si tiene acceso para autorizar ya sea categorias o gestionar
		if(count($gest) > 0){
		?>
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapseCategorias" class="accordion-toggle" data-parent="#accordion" data-toggle="collapse">
							GESTIONAR SOLICITUDES
						</a>
					</h4>
				</div>
				<div id="collapseCategorias" class="panel-collapse collapse <?php echo (is_ctl_action("c=solc&a=gest") ? "in" : "")?>">
					<div class="panel-body">	
						<b>Autorizar Solicitudes</b>
						<div class="list-group">
							<a class="<?php if(is_ctl_action("c=solc&a=gest")) echo 'list-group-item active'; else echo 'list-group-item'; ?>" href="?c=solc&a=gest" target="_self">
								Gestionar
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php 
		}
		?>
			<!--<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a href="#collapse3" class="accordion-toggle collapsed" data-parent="#accordion" data-toggle="collapse">
							NOTA DE REMISIÓN
						</a>
					</h4>
				</div>
				<div id="collapse3" class="panel-collapse collapse <?php echo (is_ctl_action('?c=req&a=m_r&id=6') ? "in" : "")?>">
					<div class="panel-body">
						<b>Marcar</b>
						<div class="list-group">
							<a class="list-group-item <?php echo (is_ctl_action('?c=req&a=m_r&id=6') ? 'active' : '');?>" href="?c=req&a=m_r&id=6" target="_self">
								Nota de Remision								
							</a>
						</div>
					</div>
				</div>
			</div>-->
		<?php

		$arr_menu = array();
		$arr_item = 0;
		$arr_menu_opt = array();
		$is_other = '';

		$is_active_other = false;

		$modulos_extras = $perfil->modulos;
		$arr_omitir = array(39,42,10,15,9,14);
		for($m=0; $m<count($modulos_extras); $m++){
			if(in_array($modulos_extras[$m]->id_acc_modulo_lista,$arr_omitir)){
				$modulos_extras[$m]=null;
			}else{
				if($is_other != $modulos_extras[$m]->categoria){
					if(!empty($arr_menu_opt)){
						$arr_menu[]=(object)array(
							'name'  => $is_other,
							'links' =>	$arr_menu_opt
						);
					}
					$arr_menu_opt=array();
				}
				$arr_menu_opt[]=(object)array(
					'url' => $modulos_extras[$m]->url,
					'text' => $modulos_extras[$m]->descripcion
				);
				if(is_ctl_action($modulos_extras[$m]->url)){
					$is_active_other=true;
				}
				$is_other = $modulos_extras[$m]->categoria;
				if($m==count($modulos_extras)-1){
					$arr_menu[]=(object)array(
						'name'  => $is_other,
						'links' =>	$arr_menu_opt
					);
				}
			}
		}
		if(!empty($arr_menu)):
			$opt_act = ($is_active_other ? "in" : "");
			echo '<div class="panel panel-default">
					<div class="panel-heading">
						<h4 class="panel-title">
							<a href="#collapseOther" class="accordion-toggle" data-parent="#accordion" data-toggle="collapse">
								MAS OPCIONES
							</a>
						</h4>
					</div>
					<div id="collapseOther" class="panel-collapse collapse '.$opt_act.'">
					<div class="panel-body">';
			foreach ($arr_menu as $m) {?>
				<b><?php echo $m->name?></b>
				<div class="list-group">
					<?php foreach($m->links as $op):?>
						<a class="<?php if(is_ctl_action($op->url)) echo 'list-group-item active'; else echo 'list-group-item'; ?>" href="<?php echo $op->url?>" target="_self">
							<?php echo $op->text?>
						</a>
					<?php endforeach;?>
				</div>
			<?php }
			echo '</div></div></div>';
		endif;
		?>
		</div>
</div>
<?php endif;?>

<?php 
    if(file_exists('view/solcheque/menu_perfil.php')){
        require_once 'view/solcheque/menu_perfil.php';	
    }
?>