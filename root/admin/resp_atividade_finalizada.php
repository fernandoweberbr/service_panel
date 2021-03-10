
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
		$data_inicio = date("Y-m-d", strtotime($params["add_inicio"]));
		$data_limite = date("Y-m-d", strtotime($params["add_limite"]));
		if($data_inicio == '1970-01-01')$data_inicio = '';
		if($data_limite == '1970-01-01')$data_limite = '';
		$sql = "INSERT INTO `atividade` (ordem, descricao, realizada, finalizada, aviso,
		data_inicio, data_limite, fk_setor, fk_usuario, fk_importancia ) 
		VALUES ('" . $params["add_ordem"] . "', 
				'" . $params["add_descricao"] . "',
				'" . $params["add_realizada"] . "',
				'" . $params["add_finalizada"] . "',
				'" . $params["add_aviso"] . "',
				'" . $data_inicio . "',
				'" . $data_limite . "',
				'" . $params["add_setor"] . "',
				'" . $params["add_usuario"] . "',
				'" . $params["add_importancia"] . "');  ";
		//echo $sql;
			echo $result = mysqli_query($this->conn, $sql) or die("error to insert atividade data");
		
	}
	
	
	function getRecords($params) {
		$rp = isset($params['rowCount']) ? $params['rowCount'] : 15;
		
		if (isset($params['current'])) { $page  = $params['current']; } else { $page=1; };  
        $start_from = ($page-1) * $rp;
		
		$sql = $sqlRec = $sqlTot = $where = '';
		
		if( !empty($params['searchPhrase']) ) {   
			$where .=" WHERE ";
			$where .=" ( atividade.ordem LIKE '".$params['searchPhrase']."%' ";    
			$where .=" OR setor.nome LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR importancia.nome LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR atividade.descricao LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR DATE_FORMAT(atividade.data_inicio,'%d-%m-%Y') LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR DATE_FORMAT(atividade.data_limite,'%d-%m-%Y') LIKE '".$params['searchPhrase']."%' ";
			$where .=" OR usuario.nome LIKE '".$params['searchPhrase']."%' )";
			$where .=" AND atividade.finalizada = '1' ";
	   } else {
		   $where .=" WHERE atividade.finalizada = '1'";
	   }
	   if( !empty($params['sort']) ) {  
			$where .=" ORDER By ".key($params['sort']) .' '.current($params['sort'])." ";
		}
	   
		/*
				$squery =" SELECT usuario.alias, atividade.ordem
    			FROM atividade
    			INNER JOIN usuario ON usuario.id = atividade.fk_usuario
    			INNER JOIN setor ON setor.id = usuario.fk_setor
    			WHERE setor.id =" $item_value['id'] 
    			LIMIT 0 , 30
		*/
		// getting total number records without any search
		$sql = "SELECT atividade.id AS id,
		atividade.ordem AS ordem,
		atividade.realizada AS realizada,
		atividade.finalizada AS finalizada,
		importancia.nome AS prioridade,
		atividade.descricao AS descricao,
		setor.nome AS setor,
		usuario.nome AS usuario,
		DATE_FORMAT(atividade.data_inicio,'%d-%m-%Y') AS inicio, 
		DATE_FORMAT(atividade.data_limite,'%d-%m-%Y') AS limite,
		atividade.aviso AS aviso 
		FROM  atividade
		INNER JOIN setor ON setor.id=atividade.fk_setor
		INNER JOIN usuario ON usuario.id = atividade.fk_usuario
		INNER JOIN importancia ON importancia.id = atividade.fk_importancia";
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
			"rowCount"          => 15, 			
			"total"             => intval($qtot->num_rows),
			"rows"              => $data   // total data array
			);
		
		return $json_data;
	}
	function updateUsuario($params) {
		$data = array();
		//print_R($_POST);die;
		$data_inicio = date("Y-m-d", strtotime($params["edit_inicio"]));
		$data_limite = date("Y-m-d", strtotime($params["edit_limite"]));
		if($data_inicio == '1970-01-01')$data_inicio = '';
		if($data_limite == '1970-01-01')$data_limite = '';
		$sql = "UPDATE `atividade` SET 
		   ordem = '" . $params["edit_ordem"] . "
		', descricao='" . $params["edit_descricao"]."
		', realizada='" . $params["edit_realizada"] . "
		', finalizada='" . $params["edit_finalizada"] . "
		', aviso='" . $params["edit_aviso"] . "
		', data_inicio='" . $data_inicio . "
		', data_limite='" . $data_limite . "
		', fk_setor='" . $params["edit_setor"] . "
		', fk_usuario='" . $params["edit_usuario"] . "
		', fk_importancia='" . $params["edit_importancia"] . "
		'  WHERE id='".$_POST["edit_id"]."';";
		//echo $sql;
		echo $result = mysqli_query($this->conn, $sql) or die("error to update Atividade data");
	}
	
	function deleteUsuario($params) {
		$data = array();
		//print_R($params);die;
		$sql = "delete from `atividade` WHERE id='".$params["id"]."'";
		//echo $params["id"];
		echo $result = mysqli_query($this->conn, $sql) or die("error to delete Usuario data");
	}
}
?>
	