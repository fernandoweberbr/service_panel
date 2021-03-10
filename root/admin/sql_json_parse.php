<?php
include_once("../mysqlreflection-master/beans/BeanAtividade.php");
$cnt = 0;
$array_of_items=array();
$conexao = mysql_connect(DBHOST,DBUSER,DBPASSWORD);  
mysql_select_db(DBNAME); 

$params = $_REQUEST;
$action = isset($params['table']) != '' ? $params['table'] : '';

$squery = "SELECT id , nome FROM  ".$action." GROUP BY nome";
$result = mysql_query($squery) or die(mysql_error()); 
while($dados = mysql_fetch_array($result))
{
    array_push($array_of_items,$dados);
}  
header('Access-Control-Allow-Origin: *');
header('Content-type: application/json');
echo json_encode($array_of_items);
?>