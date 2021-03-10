<?php
include_once("./mysqlreflection-master/mysqlreflection.config.php");
$cnt = 0; 
$array_of_items=array();
$conexao = mysql_connect(DBHOST,DBUSER,DBPASSWORD);  
mysql_select_db(DBNAME); 

$squery = "SELECT setor.setor_alias,setor.id FROM setor 
WHERE habilita = 1 OR habilita = 2 OR habilita = 3
GROUP BY setor.setor_alias";

$result = mysql_query($squery) or die(mysql_error()); 
while($dados = mysql_fetch_array($result))
{
    array_push($array_of_items,$dados);
}  
$dateshow=date("d-m-Y", time());

foreach ( $array_of_items as $item_value )
{
	if($cnt==0){
        print_r('<div class="carousel-item active">');
    } else {
        print_r('<div class="carousel-item ">');
    }
        print_r('<div class="col-xl-0 col-sm-0 mb-0">');    
        print_r('<div class="card bg-dark text-white text-center display-5  w-0 h-0  p-0" >');
        print_r('<div class="atividades"  value="'.$item_value['id'].'">');
       // print_r('<span class="text-white .bg-dark  align="left" style="font-size: 1.5vw" >'.$dateshow.'</span>');
		print_r('<h2><span class="text-warning  .bg-dark font-weight-bold" >'.$item_value['setor_alias'].'                 <span class="text-white .bg-dark  align="right" style="font-size: 1.5vw" >'.$dateshow.'</span></span></h2>  ');
		//$dateshow=date("d-m-Y", time());
			//echo '<h4>';
			//print($dateshow);
			//echo '</h4>';
		//print_r('<h4><p class="text-warning .bg-dark font-weight-bold" >'.$dateshow.'</p></h4>');
        print_r('<div class="card text-white bg-dark w-0 h-0 p-0" id="ItemAlias'. $item_value['id'] .'"></div>');         
        print_r('</div>'); // <div class="atividades        
        print_r('</div>'); // <div class="card 
        print_r('</div>'); //  <div class="col-xl-0 
        print_r('</div>'); //  class="carousel-item 
    $cnt++;
}
mysql_free_result ( $result );  
?>