<?php
include_once("./mysqlreflection-master/mysqlreflection.config.php");
$cnt = 0; 
$array_of_items=array();
$conexao = mysql_connect(DBHOST,DBUSER,DBPASSWORD);  
mysql_select_db(DBNAME); 

$squery = "SELECT setor.setor_alias,setor.id FROM setor 
WHERE habilita = 1 
GROUP BY setor.setor_alias";
$result = mysql_query($squery) or die(mysql_error()); 
while($dados = mysql_fetch_array($result))
{
    array_push($array_of_items,$dados);
}  
foreach ( $array_of_items as $item_value )
{
    $cnt++;
}
print('<div class="CarroselMaxItens" id="CarrouselCount" Value="'.$cnt.'" ></div>');
mysql_free_result ( $result );  
?>