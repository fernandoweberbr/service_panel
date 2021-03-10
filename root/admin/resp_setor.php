
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
	$empCls = new Setor($connString);

	switch($action) {
	 case 'add':
		$empCls->insertSetor($params);
	 break;
	 case 'edit':
		$empCls->updateSetor($params);
	 break;
	 case 'delete':
		$empCls->deleteSetor($params);
	 break;
	 default:
	 $empCls->getSetors($params);
	 return;
	}
	
	class Setor {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
	}
	
	public function getSetors($params) {
		
		$this->data = $this->getRecords($params);
		
		echo json_encode($this->data);
	}
	function insertSetor($params) {
		$data = array();
	    $sql = "INSERT INTO `setor` (nome, setor_alias, habilita) VALUES ('" . $params["nome"] . "', '" . $params["alias"] . "','" . $params["habilita"] . "');  ";
		echo $result = mysqli_query($this->conn, $sql) or die("error to insert Setor data");
		
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 10;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {   
			$where .=" WHERE ";
			$where .=" ( nome LIKE '".$params['searchPhrase']."%' ";    
			$where .=" OR setor_alias LIKE '".$params['searchPhrase']."%' ";

			$where .=" OR habilita LIKE '".$params['searchPhrase']."%' )";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   // getting total number records without any search
		$sql = "SELECT * FROM `setor` ";
		$sqlTot .= $sql;
		$sqlRec .= $sql;
		
		//concatenate search sql if value exist
		if(isset($where) && $where != '') {

			$sqlTot .= $where;
			$sqlRec .= $where;
		}
		if ($rp!=-1)
		$sqlRec .= " LIMIT ". $start_from .",".$rp;
		
		
		$qtot = mysqli_query($this->conn, $sqlTot) or die("error to fetch tot Setors data");
		$queryRecords = mysqli_query($this->conn, $sqlRec) or die("error to fetch Setors data");
		
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
	function updateSetor($params) {
		$data = array();
		//print_R($_POST);die;
		$sql = "Update `setor` set nome = '" . $params["edit_nome"] . "', setor_alias='" . $params["edit_alias"]."', habilita='" . $params["edit_habilita"] . "' WHERE id='".$_POST["edit_id"]."'";
		echo $result = mysqli_query($this->conn, $sql) or die("error to update Setor data");
	}
	
	function deleteSetor($params) {
		$data = array();
		//print_R($params);die;
		$sql = "delete from `setor` WHERE id='".$params["id"]."'";
		//echo $params["id"];
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete Setor data");
	}
}
?>
	