<?php
class DB {
	private $servidor;
	private $usuario;
	private $password;
	private $base_datos;
	private $link;
	private $stmt;
	private $array;
	private $tbl_tagasto;
	private $tbl_cecosto;
	private $tbl_categoria;
	private $tbl_sublinea;
	private $_numero;
	private $_mensaje;
	private $_sql;
	public $_last_insert_id;
	private static $_instance;
	private $_link;
	private $_link2;
	private $db_prov;
	private $db_prov2;
	private $tbl_restric;
	// La conexion es privada para evitar que el objeto pueda ser creado
	// mediante new
	private function __construct() {
		$this->setConexion ();
		$this->conectar ();
	}
	// Metodo para establecer los parametros de la conexion
	private function setConexion() {
		$conf = Configuracion::getInstance ();
		$this->servidor = $conf->getHostDB ();
		$this->base_datos = $conf->getBD ();
		$this->usuario = $conf->getUserDB ();
		$this->password = $conf->getPassDB ();
		$this->tbl_tagasto = $conf->getTbl_tagasto ();
		$this->tbl_cecosto = $conf->getTbl_cecosto ();
		$this->tbl_categoria = $conf->getTbl_categoria ();
		$this->tbl_sublinea = $conf->getTbl_sublinea ();
		$this->db_prov = $conf->getDbprov();
		$this->db_prov2 = $conf->getDbprov2();
		$this->tbl_restric = $conf->getTbl_restric();
	}
	// Evitamos el clonaje del objeto
	private function __clone() {
	}
	private function __wakeup() {
	}
	// Funcion encargada de crear si es necesario, el objeto. Esta es la funcion
	// que debemos
	// llamar desde fuera de la clase para instanciar el objeto, y asi, poder
	// reutilizar sus metodos
	public static function getInstance() {
		if (! (self::$_instance instanceof self)) {
			self::$_instance = new self ();
		}
		return self::$_instance;
	}
	// Realiza la conexion
	private function conectar() {
		$link = mysql_connect ( $this->servidor, $this->usuario, $this->password );
		if ($link) {
			mysql_query("SET NAMES 'utf8'");
			$selec_db = mysql_select_db ( $this->base_datos, $link );
			if (!$selec_db) {
				throw new Exception ( $this->Error () );
			}
		}
		if (! $link) {
			throw new Exception ( $this->Error () );
		} else {
			$this->link = $link;
		}
	}
	// Conecta usando la base de datos de O.C.
	public function conecta_OC(){
		$linkp = mysql_connect($this->servidor, $this->usuario, $this->password, true);
		if ($linkp) {
			mysql_query("SET NAMES 'latin1'");
			$selec_dbp = mysql_select_db ( $this->db_prov, $linkp );
			if (!$selec_dbp) {
				throw new Exception ( $this->Error () );
			}
		}
		if (! $linkp) {
			throw new Exception ( $this->Error () );
		} else {
			$this->_link = $linkp;
		}
	}
	// ejecutamos en base de O.C.
	public function ejecuta_OC($sqlp){
		$this->_sql = $sqlp;
		$stmtp = mysql_query($this->_sql, $this->_link);
		if (! $stmtp) {
			throw new Exception ( $this->Error () );
		}
		return $stmtp;
	}
	// Desconecta base O.C.
	public function desconecta_OC() {
		mysql_close($this->_link);
	}
	// Metodo para ejecutar una sentencia sql
	public function ejecutar($sql) {
		// Pongamos en una variable lo que queremos ejecutar
		$this->_sql = $sql;
		$this->stmt = mysql_query ( $sql, $this->link );
		if (! $this->stmt) {
			throw new Exception ( $this->Error () );
		}
		if($this->stmt){
			$this->_last_insert_id = mysql_insert_id($this->link);
		}
		return $this->stmt;
	}
	// Metodo para obtener una fila de resultados de la sentencia sql
	public function obtener($stmt, $fila = 0) {
		if ($fila == 0) {
			$this->array = mysql_fetch_array ( $stmt );
		} else {
			mysql_data_seek ( $stmt, $fila );
			$this->array = mysql_fetch_array ( $stmt );
		}
		if (! $this->array) {
			$this->array = array();
			//throw new Exception ( $this->Error () );
		}
		return $this->array;
	}
	// Retorna nombre de tabla de gasto
	public function getTabGas($emp, $tit, $det) {
		$sql = "Select * From " . $this->tbl_tagasto . " Where gas_tit_codigo = '" . $tit . "'" . " And gas_det_codigo = '" . $det . "'";
		$run = $this->ejecutar ( $sql );
		$fila = $this->obtener ( $run, 0 );
		return $fila [4];
	}
	// Retorna nombre Centro de Costo
	public function getCC($emp, $cc) {
		$sql = "Select * From " . $this->tbl_cecosto . " Where id_empresa = '" . $emp . "'" . " And cc_codigo = '" . $cc . "'";
		$run = $this->ejecutar ( $sql );
		$fila = $this->obtener ( $run, 0 );
		return $fila [3];
	}
	// Retorna nombre de Categoria
	public function getCat($idcat) {
		$sql = "Select * From " . $this->tbl_categoria . " Where id_categoria = '" . $idcat . "'";
		$run = $this->ejecutar ( $sql );
		$fila = $this->obtener ( $run, 0 );
		return $fila [1];
	}
	// Retorna nombre de Sublinea
	public function getSublinea($l, $sl) {
		$sql = "Select * From " . $this->tbl_sublinea . " Where sl_linea = '" . $l . "' And sl_sublinea = '" . $sl . "'";
		$run = $this->ejecutar ( $sql );
		$fila = $this->obtener ( $run, 0 );
		return $fila [3];
	}
	/* 
	 * PRUEVAS
	 */
	// Conecta usando la base de datos de O.C.
	public function conecta_OC2(){
		$linkp = mysql_connect($this->servidor, $this->usuario, $this->password, true);
		if ($linkp) {
			mysql_query("SET NAMES 'latin1'");
			$selec_dbp = mysql_select_db ( $this->db_prov2, $linkp );
			if (!$selec_dbp) {
				throw new Exception ( $this->Error () );
			}
		}
		if (! $linkp) {
			throw new Exception ( $this->Error () );
		} else {
			$this->_link2 = $linkp;
		}
	}
	// ejecutamos en base de O.C.
	public function ejecuta_OC2($sqlp){
		$this->_sql = $sqlp;
		$stmtp = mysql_query($this->_sql, $this->_link2);
		if (! $stmtp) {
			throw new Exception ( $this->Error () );
		}
		return $stmtp;
	}
	// Desconecta base O.C.
	public function desconecta_OC2() {
		mysql_close($this->_link2);
	}
	/*
	 * Manejo de Errores
	 */
	private function Error() {
		$this->_numero = mysql_errno ();
		$msg = mysql_error ();
		$msg = str_replace ( "'", " ", $msg );
		$this->_mensaje = '<b>HA OCURRIDO EL SIGUIENTE ERROR!</b>';
		$this->_mensaje .= '<br><b>Error No : </b> ' . $this->_numero;
		switch ($this->_numero) {
			case 1062 :
				$this->_mensaje .= '<br><b>Descripcion : </b>Ya existe ese registro.';
				break;
			case 1146 :
				$this->_mensaje .= '<br><b>Descripcion : </b>No Existe la Tabla.';
				break;
			case 1265 :
				$this->_mensaje .= '<br><b>Descripcion : </b>Datos Truncados en Columna.';
				break;
			case 1054 :
				$this->_mensaje .= '<br><b>Descripcion : </b>Nombre de Columna Erroneo.';
				break;
			case 1364 :
				$this->_mensaje .= '<br><b>Descripcion : </b>No se ha Definido Valor para el Campo.';
				break;
			case 1064 :
				$this->_mensaje .= '<br><b>Descripcion : </b>Error de Sintaxis.';
				break;
			case 1406 :
				$this->_mensaje .= '<br><b>Descripcion : </b>Informacion Mayor al Tamaño del Campo.';
				break;
			case 1136 :
				$this->_mensaje .= '<br><b>Descripcion : </b>Tablas No Poseen el Mismo Numero de Columnas.';
				break;
			case 1044 :
				$this->_mensaje .= '<br><b>Descripcion : </b>Acceos Denegado.';
				break;
			case 1045 :
				$this->_mensaje .= '<br><b>Descripcion : </b>Credenciales no validas.';
				break;
			case 1046 :
				$this->_mensaje .= '<br><b>Descripcion : </b>No se ha seleccionado base de datos.';
				break;
			case 2002 :
				$this->_mensaje .= '<br><b>Descripcion : </b>El sevidor ha rechazado la conexion.';
				break;
			default :
				$this->_mensaje .= '<br><b>Descripcion : </b>No ha podido identificarse el error, informe a sistemas.';
				break;
		}
		$this->_mensaje .= '<hr>';
		$this->_mensaje .= '<br><h4>habilitado modo <sup class="fg-color-red text-warning">beta</sup></h4>';
		$this->_mensaje .= '<br><b>Informacion Tecnica : </b>'.$msg;
		$this->_mensaje .= '<br><b>Sentencia : </b>'.$this->_sql;
		return $this->_mensaje;
	}
}
?>