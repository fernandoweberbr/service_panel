
<?php
include "/admin/functions.php"; // arquivo de funções.
include_once("/admin/conn_pcp.php");
$db = new dbObj();
$connString =  $db->getConnstring();
$updateRealiza = new Update($connString);
class Update {
	protected $conn;
	protected $data = array();
	function __construct($connString) {
		$this->conn = $connString;
		//$sql = "Update atividade set finalizada = " .$_GET["check"]. " WHERE id= ".$_GET["id"].";";
		$sql = "select atividade.id from atividade where ordem = ".$_GET["id"].";";
		$result = mysqli_query($this->conn,$sql) or die("error to update atividade data");
		$row = mysqli_fetch_array($result);
		//echo $row['id'];
		$sql = "Update atividade set finalizada = " .$_GET["check"]. " WHERE id= ".$row['id'].";";
		echo $result = mysqli_query($this->conn,$sql) or die("error to update atividade data");
		//mysqli_close($result);
	}
}
mysql_free_result ( $result );  
?>
	