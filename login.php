<?php
$user = strtoupper ( $_POST ['User'] );
$pass = strtoupper ( $_POST ['Passwd'] );
//$user = strtoupper("wserpas");
//$pass = strtoupper("wserpas");
require_once "Configuracion.php";
require_once "DB.php";
global $db;
$rtn = "error";
try {
	$db = DB::getInstance ();
	$sql = "Select * From usuario Where usr_usuario = '" . $user . "' And usr_password = '" . $pass . "'";
	$consulta = $db->ejecutar ( $sql );
	if (mysql_num_rows ( $consulta ) > 0) {
		try {
			$row = mysql_fetch_array($consulta);
			if ($row ['usr_estado'] == 'A') {
				$rtn = 'success';
				session_start ();
				$_SESSION['u'] = $row['usr_usuario'];
				$_SESSION['n'] = $row['usr_nombre'];
				$_SESSION['i'] = $row['id_usuario'];
				$_SESSION['req'] = $row['usr_req'];
				$_SESSION['sol'] = $row['usr_sol'];
				$_SESSION['oc'] = $row['usr_oc'];
			} else {
				$rtn = 'Usuario Deshabilitado.';
			}
		} catch ( Exception $e ) {
			$rtn = $e->getMessage ();
		}
	}else{
            require_once 'model/cheque/Entity.php';
            $db=new Entity;
            $user = strtolower($_POST['User']);
            $pass = strtolower($_POST['Passwd']);
            $login=$db->LoginUser($user,$pass);
            if(!empty($login)){
                session_start();
                $_SESSION['i']=$login->id_usuario;
                $_SESSION['u'] = $login->usuario;
                $_SESSION['n'] = $login->nombre;
                $_SESSION['req'] = 0;
                $_SESSION['sol'] = 0;
                $_SESSION['oc'] = 0;
                $_SESSION['cheque'] = true;
                $rtn = 'success';
            }
	}
} catch ( Exception $e ) {
	$rtn = $e->getMessage ();
}
//echo $rtn;
echo json_encode ( $rtn );
?>