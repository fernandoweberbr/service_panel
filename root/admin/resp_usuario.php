
<?php
	session_start(); // Inicia a session
	include "functions.php"; // arquivo de funções.
	session_checker(); // chama a função que verifica se a session iniciada da acesso à página.

	//include connection file 
	include_once("conn_mysql.php");
	
	$db = new dbObj();
	$connString =  $db->getConnstring();

	$params = $_REQUEST;
	
	$action = isset($params['action']) != '' ? $params['action'] : '';
	$empCls = new Usuario($connString);

	switch($action) {
	 case 'add':
		$empCls->insertUsuario($params);
	 break;
	 case 'edit':
		$empCls->updateUsuario($params);
	 break;
	 case 'delete':
		$empCls->deleteUsuario($params);
	 break;
	 default:
	 $empCls->getUsuarios($params);
	 return;
	}
	
	class Usuario {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getUsuarios($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertUsuario($params) {
		$data = array();
	    $sql = "INSERT INTO `usuario` (nome, usuario_alias, nivel_usuario) VALUES ('" . $params["nome"] . "', '" . $params["alias"] . "','" . $params["nivel"] . "');  ";
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert Usuario data");
		
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {   
			$where .=" WHERE ";
			$where .=" ( nome LIKE '".$params['searchPhrase']."%' ";    
			$where .=" OR usuario_alias LIKE '".$params['searchPhrase']."%' ";

			$where .=" OR nivel_usuario LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT * FROM `usuario` ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot Usuarios data");
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch Usuarios data");
		
		while( $row = mysqli_fetch_assoc($queryRecords) ) { 
			$data[] = $row;
		}

		$json_data = array(
			"current"           => intval($params['current']), 
			"rowCount"          => 10, 			
			"total"             => intval($qtot->num_rows),
			"rows"              => $data   // total data array
			);
		
		return $json_data;
	}
	function updateUsuario($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "Update `usuario` set nome = '" . $params["edit_nome"] . "',
								 usuario_alias='" . $params["edit_alias"]."',
								 nivel_usuario='" . $params["edit_nivel"] . "',
								 senha='" . md5($params["edit_senha"]) . "'
								  WHERE id='".$_POST["edit_id"]."'";
		echo $result = mysqli_query($this->conn, $sql) or die("error to update Usuario data");
	}
	
	function deleteUsuario($params) {
		$data = array();
		//print_R($params);die;
		$sql = "delete from `usuario` WHERE id='".$params["id"]."'";
		//echo $params["id"];
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete Usuario data");
	}
}
?>
	