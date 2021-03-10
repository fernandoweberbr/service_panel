
<?php
	session_start(); // Inicia a session
	include "functions.php"; // arquivo de funções.
	session_checker(); // chama a função que verifica se a session iniciada da acesso à página.
	//include connection file 
	include_once("conn_mysql.php");
	$db = new dbObj();
	$connString =  $db->getConnstring();
	$updateRealiza = new Update($connString);
	class Update {
		protected $conn;
		protected $data = array();
		function __construct($connString) {
			$this->conn = $connString;
			$sql = "Update atividade set realizada = " .$_GET["check"]. " WHERE id= ".$_GET["id"].";";
			echo $sql;
			echo $result = mysqli_query($this->conn, $sql) or die("error to update atividade data");
		}
	}
?>
	