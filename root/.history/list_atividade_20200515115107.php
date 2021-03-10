<?php
include_once("calcula_datas.php"); 
include_once("./mysqlreflection-master/mysqlreflection.config.php");

$WshShell = new COM("WScript.Shell"); 
//$oExec = $WshShell->Run("cmd /C curl http://192.168.1.7:8090/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao > ./root/ordem.xml", 0, false); 
//$oExec = $WshShell->Run("cmd /C curl http://192.168.1.7:8090/API/D/1.0/1ACB8494B500241130775AE530523063/Pedidos/DevolverItensPedidos > ./root/pedidos.xml", 0, false); 

define("XML_FILE_ORDENS","http://192.168.1.7:8090/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao");	// "http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao"
define("XML_FILE_PEDIDOS","http://192.168.1.7:8090/API/D/1.0/1ACB8494B500241130775AE530523063/Pedidos/DevolverItensPedidos"); // "http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao"

//define("XML_FILE_ORDENS" ,'ordem.xml');		// "http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao"
//define("XML_FILE_PEDIDOS",'pedidos.xml'); 	// "http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverItensPedidos"

$Consulta = $_GET['consulta'];
$HtmlTablePedido = '<div class="table-condensed row justify-content-md-center ">
<table class="table-condensed table-bordered" id="dataTable" width="98%" cellspacing="0" padding="0" style="background-color: black;  font-size: 1.4vw">
<thead>
<tr>
<th scope="col">Pedido</th>
<th scope="col">Descrição</th>
<th scope="col" width="350px">Data</th>
</tr>
</thead>
<tbody>
';

$HtmlTableOrdem = '<div class="table-condensed row justify-content-md-center ">
<table class="table-condensed table-bordered" id="dataTable" width="98%" cellspacing="0" padding="0" style="background-color: black;  font-size: 1.4vw">
<thead>
<tr>
<th scope="col">#</th>
<th scope="col">Numero</th>
<th scope="col">Descrição</th>
<th scope="col" width="350px">Data</th>
</tr>
</thead>
<tbody>
';

$HtmlTableAssistencia = '<div class="table-condensed row justify-content-md-center ">
<table class="table-condensed table-bordered" id="dataTable" width="98%" cellspacing="0" padding="0" style="background-color: black;  font-size: 1.4vw">
<thead>
<tr>
<th scope="col">Ordem</th>
<th scope="col">Descrição</th>
<th scope="col" width="400px">Data</th>
</tr>
</thead>
<tbody>
';

$HtmlCloseTable = '</tbody></div></table>';
$HtmlNewRowText = '<tr>';
$HtmlRowText 	= '<td><text class="text-light" style="font-size: 1.0vw">';
$HtmlCloseRowText ='</text></td>';
$HtmlCloseNewRowText = '<tr>';

//check_new_op();
$xml_ordems 	= simplexml_load_file(XML_FILE_ORDENS)   or die("Error: Cannot create objec1t"); 
$xml_pedidos 	= simplexml_load_file(XML_FILE_PEDIDOS) or die("Error: Cannot create objec1t"); 

$xml_local_pedidos = $GLOBALS['xml_pedidos'];
$xml_local_ordem   = $GLOBALS['xml_ordems'];


function if_ordem_exist($number)
{
	$xml_func = $GLOBALS['xml_ordems'];
	for($i=0; $i<(count($xml_func->Conteudo->ListaDeRetorno->Retorno));$i++)
	{
		$trim_number = trim($number);
		//echo $i.'['.$trim_number.']'.'<'.$xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM.'>'.'(';
		//echo strcmp($trim_number,$xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM);
		//echo ')</br>';
		$ConcatOrdemLinha = 'OP'.trim($xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP );
		//echo $ConcatOrdemLinha;
		if(strcmp($ConcatOrdemLinha,$trim_number)==0)return True;

		$ConcatOrdemLinha = 'OPCON'.trim($xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP );
		//echo $ConcatOrdemLinha;
		if(strcmp($ConcatOrdemLinha,$trim_number)==0)return True;

		//	if(strcmp(
		//				intval($xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM),
		//				intval($number)/
		//			))==0){
		//	return True;
		//		}
		//echo $xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM . "</br>";
			//return True;
		//}
	}
	return False;
}



function check_new_op()
{
	$Consulta=$_GET['consulta'];
	$xml_local_ordem   = $GLOBALS['xml_ordems'];
	switch($Consulta)
	{
		case 3:
		case 7:
	break;
		default:
		$conexao = mysql_connect(DBHOST,DBUSER,DBPASSWORD);  
		mysql_select_db(DBNAME); 		

		$squery_users = "SELECT atividade.fk_usuario AS id_users FROM atividade WHERE atividade.fk_setor = ".  $Consulta . " AND atividade.finalizada = 0 	GROUP BY atividade.fk_usuario ";
		$result_user = mysql_query($squery_users) or die(mysql_error()); 

		$count_user = mysql_query($squery_users) or die(mysql_error()); 
		$cnt_u=0;
		while($users = mysql_fetch_array($count_user)){
			$cnt_u++;	
		};

		$GLOBALS["count_users"]=$cnt_u;
		//echo "<pr>".$GLOBALS["count_users"]."<pr>";

		while($users = mysql_fetch_array($result_user))
		{
			//print($users['id_users']);
			if($users['id_users'])
			{
				$user_id = $users['id_users'];
				if($GLOBALS["count_users"]=='1')
				{
					$Limit = "LIMIT 0,20";
				} else {
					$div_usr= round(20/$cnt_u);
					$Limit = "LIMIT 0,".$div_usr;
				}
				//if($Consulta=='5' || $Consulta=='6'){$Limit = "LIMIT 0,20";}					
				$squery = " SELECT 	usuario.usuario_alias AS user_alias, 
				atividade.ordem AS num_ordem, 
				atividade.data_limite AS d_data_limite, 
				atividade.realizada, atividade.finalizada,
				atividade.descricao AS at_descricao,
				atividade.fk_importancia AS prioridade,
				importancia.nome AS alias_prioridade
				FROM atividade 
				INNER JOIN usuario ON usuario.id = atividade.fk_usuario
				INNER JOIN setor ON setor.id = atividade.fk_setor
				INNER JOIN importancia ON importancia.id = atividade.fk_importancia
				WHERE setor.id = ". $Consulta . " AND atividade.fk_usuario = ". $user_id ." AND finalizada = '0'
				ORDER BY usuario.usuario_alias ASC , prioridade ASC, d_data_limite ASC ".$Limit.";";
				$result = mysql_query($squery) or die(mysql_error()); 
				
				while($dados = mysql_fetch_array($result))
				{	
					if(if_ordem_exist($dados['num_ordem'])==True)
					{
						print('<td><text class="text-light" style="font-size: 1.1vw">'.$dados['user_alias'].'</text></td>');
						print('<td><text class="text-light" style="font-size: 1.1vw">'.$dados['num_ordem'].'</text></td>');
						print('<td><text class="text-light" style="font-size: 1.1vw">'.$dados['at_descricao'].'</text></td>');
						if(strtotime($dados['d_data_limite'])>0)
						{
							$date_now	 = strtotime(date("Y-m-d", time()));
							$date_limite = strtotime($dados['d_data_limite']);
							$diferenca =  $date_limite - $date_now ;
							$dias = floor($diferenca / (60 * 60 * 24));
							if($dias>0)
							{
								print('<td><text class="text-white" style="font-size: 1.1vw">'.date('d-m-Y',$date_limite).'<text class="text-primary" style="font-size: 1.1vw"> Faltam '.$dias.' dia(s)</text></td>');
							} 
							else 
							{
								if($dias<0){
									print('<td class="text-dask bg-danger"><text class="text-dask bg-danger" style="font-size: 1.1vw">'.date('d-m-Y',$date_limite).' Atraso '.abs($dias).' dia(s)</text></td>');
								} 
								else 
								{
									if($dias==0)
									{
									print('<td  class="text-dark bg-warning" style="font-size: 1.1vw">Hoje  '.date('d-m-Y',$date_limite).'</td>');
									} 
								}
							}
						} 
						else 
						{
							print('<td><text class="text-light" style="font-size: 1.1vw">SEM DATA</text></td>');
						}
						print('</tr>');
					}
					else 
					{
					// Finalizar Ordem do sistema
						//$sql = "Update atividade set finalizada = " .$_GET["check"]. " WHERE id= ".$_GET["id"].";";
						//$sql_query = "SELECT atividade.id AS id FROM atividade WHERE atividade.fk_setor <> 5 AND atividade.ordem = ". $dados["num_ordem"] .";";
						$sql_query = "SELECT atividade.id AS id FROM atividade WHERE ordem = '". $dados['num_ordem']."';";
						//echo $sql_query;
						$result_sel = mysql_query($sql_query) or die("error select atividade");
						$row = mysql_fetch_array($result_sel);
						//print($row['id']);
						if($row['id']){
							//echo $row['id'];
							$sql = "Update atividade set finalizada = 1  WHERE id= '" . $row['id'] . "';";
							//echo $sql;
							$result = mysql_query($sql) or die("error to update atividade data");
						}
					}
				}
			}
		}
		$squery_atividades = "SELECT atividade.ordem as ordem, atividade.finalizada as finalizada FROM atividade";
		$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
		$row_count	=	mysql_num_rows($result_atividades); // Numero de linhas retornadas de usuarios em cada setor
		$atividades_fetch = array();
		//echo $row_count;
		while($atividades =	mysql_fetch_array($result_atividades)){
			$atividades_fetch[] = $atividades;
			//echo $atividades['ordem'];	
		};
		for($i=0; $i<(count($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno));$i++)
		{
			for($j=0; $j<$row_count;$j++)
			{
				//$ConcatOrdemLinha = 'OP'.trim($xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP );
				$ConcatOrdemLinha = 'OP'.trim($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP);
				//echo $ConcatOrdemLinha;
				if(strcmp($ConcatOrdemLinha,trim($atividades_fetch[$j]['ordem']))==0)
				{
					if($atividades_fetch[$j]['finalizada']==1)
					{
						//$sql = "Update atividade set finalizada = " .$_GET["check"]. " WHERE id= ".$_GET["id"].";";
						//echo  $atividades_fetch[$j]["ordem"];
						$sql_query = "SELECT atividade.id AS id FROM atividade WHERE atividade.ordem ='" . $atividades_fetch[$j]["ordem"] . "';";
						//echo $sql_query;
						$result_sel = mysql_query($sql_query) or die("error select atividade");
						$row = mysql_fetch_array($result_sel);
						//echo $row['id'];
						if($row['id']){
							$sql = "Update atividade set finalizada = 0 , data_limite ='".$xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA."' WHERE id= '" . $row['id'] . "';";
							//echo $sql;
							$result = mysql_query($sql) or die("error to update atividade data");
						}
					}	
					//echo "<". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM .">";
					//echo "[".$atividades_fetch[$j]['ordem']."]</br>";
					break;
				} else {
					//echo "<". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM .">";
					//echo "[".$atividades_fetch[$j]['ordem']."]</br>";
				}
			}
			if($j==$row_count)
			{
	
				//echo "Novos registros!";
				//echo "Nova Ordem <". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM ."></br>";
				$ConcatOrdemLinha = 'OP'.trim($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP);
				//echo $ConcatOrdemLinha;
				if(strcmp($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->TIPODOC,"OP")==0)
				{
					if(strcmp($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->CCUSTO,"20010")==0)
					{
						$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
						"','" . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , '". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA ."' , 2, 16, 3);";
						$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
					} else {
						if(strcmp($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->CCUSTO,"20009")==0) // 
						{
							$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
							"','" . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , '". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA ."' , 6, 16, 3);";
							$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 						
						} else {
							if(strcmp($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->CCUSTO,"20008")==0) // 
							{
								$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
								"','" . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , '". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA ."' , 6, 16, 3);";
								$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
							} else {
								if(strcmp($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->CCUSTO,"20006")==0) // 
								{
									$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
									"','" . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , '". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA ."' , 4, 16, 3);";
									$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
								} else {
									$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
									"','" . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , '". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA ."' , 9, 16, 3);";
									$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
								}
							}
						}
					}
					
				} 
				/*
				if(strcmp($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->TIPODOC,"OPCON")==0)
				{
					$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
					"','" . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , '". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA ."' , 3, 6, 3);";
					$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
					 
				}
				*/
				
				/*
				$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
				"','" . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , 0 , 9, 16, 3);";
				$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
				*/
			}
		}
	break;
	}
}

function check_new_opcon()
{
	$Consulta=$_GET['consulta'];
	$xml_local_ordem   = $GLOBALS['xml_ordems'];
	if($Consulta=='3')
	{
		$conexao = mysql_connect(DBHOST,DBUSER,DBPASSWORD);  
		mysql_select_db(DBNAME); 		
		$squery_users = "SELECT atividade.fk_usuario AS id_users FROM atividade WHERE atividade.fk_setor = ".  $Consulta . " AND atividade.finalizada = 0 	GROUP BY atividade.fk_usuario";
		$result_user = mysql_query($squery_users) or die(mysql_error()); 
		
		while($users = mysql_fetch_array($result_user))
		{
			//print($users['id_users']);
			if($users['id_users'])
			{
				$user_id = $users['id_users'];
				$squerycon = "SELECT usuario.usuario_alias AS user_alias, atividade.ordem AS num_ordem, 
				atividade.data_inicio AS d_data_inicio, 
				atividade.realizada, atividade.finalizada,
				atividade.descricao AS at_descricao,
				atividade.fk_importancia AS prioridade,
				importancia.nome AS alias_prioridade
				FROM atividade 
				INNER JOIN usuario ON usuario.id = atividade.fk_usuario
				INNER JOIN setor ON setor.id = atividade.fk_setor
				INNER JOIN importancia ON importancia.id = atividade.fk_importancia
				WHERE setor.id = ".  $Consulta . " AND finalizada = '0' 
				GROUP BY d_data_inicio, atividade.fk_importancia
				HAVING COUNT(d_data_inicio) < 4
				ORDER BY atividade.fk_importancia ASC, d_data_inicio 
				LIMIT 0,20 ";
				$result_act = mysql_query($squerycon) or die(mysql_error()); 
				
				while($dadosCon = mysql_fetch_array($result_act))
				{	
					if(if_ordem_exist(trim($dadosCon['num_ordem']))==True)
					{
						//print('<th><p class="text-light" style="font-size: 1.2vw">Ordem</th>');
						//print('<th><p class="text-light" style="font-size: 1.2vw">Descrição</th>');
						//print('<th><p class="text-light" style="font-size: 1.2vw">Data</th>');
						//print('<td><text class="text-light" style="font-size: 1.5vw">'.$dadosCon['user_alias'].'</text></td>');
						//print('<td><text class="text-light" style="font-size: 1.5vw">Criar Campo</text></td>');
						print('<td><text class="text-light" style="font-size: 1.1vw">'.$dadosCon['num_ordem'].'</text></td>');
						print('<td><text class="text-light" style="font-size: 1.1vw">'.$dadosCon['at_descricao'].'</td>');
						//print('<td><text class="text-light" style="font-size: 1.5vw">'.$dadosCon['d_data_inicio'].'</text></td>');
						if(strtotime($dadosCon['d_data_inicio'])>0)
						{
							$date_now	 = date("Y-m-d", time());
							$data_inicio = date("d-m-Y",strtotime($dadosCon['d_data_inicio']));
							$data_final  = somar_dias_uteis($data_inicio,5,'');
							$conv_us_data_final = date_format(date_create_from_format('d-m-Y', $data_final),"Y-m-d");
							$diferenca =    strtotime($conv_us_data_final) - strtotime($date_now);
							$dias = floor($diferenca / (60 * 60 * 24));
							if($dias>0)
							{
								if($dias>1 && $dias<3){
									print('<td><text class="text-white bg-warning" style="font-size: 1.1vw">'.$data_inicio.'<text class="text-primary" style="font-size: 1.1vw"> Faltam '.$dias.' dia(s) ['.$data_final.']</text></td>');
								} else {
									print('<td><text class="text-primary " style="font-size: 1.1vw">'.$data_inicio.'<text class="text-primary" style="font-size: 1.1vw"> Faltam '.$dias.' dia(s) ['.$data_final.']</text></td>');
								}
							} else {
									if($dias<0){
										print('<td class="text-dask bg-danger"><text class="text-dask bg-danger" style="font-size: 1.1vw">'.$data_inicio.' Atraso '.abs($dias).' dia(s) ['.$data_final.']</text></td>');
									} else {
										if($dias==0){
											print('<td  class="text-dark bg-warning" style="font-size: 1.1vw">Hoje  '.$data_inicio.', ['.$data_final.']</td>');
										} 
									}
							}
						}
					}
					else 
					{
					// Finalizar Ordem do sistema
						//$sql = "Update atividade set finalizada = " .$_GET["check"]. " WHERE id= ".$_GET["id"].";";
						//$sql_query = "SELECT atividade.id AS id FROM atividade WHERE atividade.fk_setor <> 5 AND atividade.ordem = ". $dados["num_ordem"] .";";
						$sql_query = "SELECT atividade.id AS id FROM atividade WHERE ordem = '". $dadosCon['num_ordem']."';";
						//echo $sql_query;
						$result_sel = mysql_query($sql_query) or die("error select atividade");
						$row = mysql_fetch_array($result_sel);
						//print($row['id']);
						if($row['id']){
							//echo $row['id'];
							$sql = "Update atividade set finalizada = 1  WHERE id= '" . $row['id'] . "';";
							//echo $sql;
							$result = mysql_query($sql) or die("error to update atividade data");
						}
					}
				}
			}
		}
		$squery_atividades = "SELECT atividade.ordem as ordem, atividade.finalizada as finalizada FROM atividade";
		$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
		$row_count	=	mysql_num_rows($result_atividades); // Numero de linhas retornadas de usuarios em cada setor
		$atividades_fetch = array();
		//echo $row_count;
		while($atividades =	mysql_fetch_array($result_atividades)){
			$atividades_fetch[] = $atividades;
			//echo $atividades['ordem'];	
		};
		for($i=0; $i<(count($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno));$i++)
		{
			for($j=0; $j<$row_count;$j++)
			{
				//$ConcatOrdemLinha = 'OP'.trim($xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP );
				$ConcatOrdemLinha = 'OPCON'.trim($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP);
				//echo $ConcatOrdemLinha;
				if(strcmp($ConcatOrdemLinha,trim($atividades_fetch[$j]['ordem']))==0)
				{
					if($atividades_fetch[$j]['finalizada']==1)
					{
						//$sql = "Update atividade set finalizada = " .$_GET["check"]. " WHERE id= ".$_GET["id"].";";
						//echo  $atividades_fetch[$j]["ordem"];
						$sql_query = "SELECT atividade.id AS id FROM atividade WHERE atividade.ordem ='" . $atividades_fetch[$j]["ordem"] . "';";
						//echo $sql_query;
						$result_sel = mysql_query($sql_query) or die("error select atividade");
						$row = mysql_fetch_array($result_sel);
						//echo $row['id'];
						if($row['id'])
						{
							$sql = "Update atividade set finalizada = 0 , data_limite ='".$xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA."' WHERE id= '" . $row['id'] . "';";
							//echo $sql;
							$result = mysql_query($sql) or die("error to update atividade data");
						}
					}	
					//echo "<". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM .">";
					//echo "[".$atividades_fetch[$j]['ordem']."]</br>";
					break;
				} else {
					//echo "<". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM .">";
					//echo "[".$atividades_fetch[$j]['ordem']."]</br>";
				}
			}
			if($j==$row_count)
			{
	
				//echo "Novos registros!";
				//echo "Nova Ordem <". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM ."></br>";
				$ConcatOrdemLinha = 'OPCON'.trim($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP);
				//echo $ConcatOrdemLinha;
				/*
				if(strcmp($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->TIPODOC,"OP")==0)
				{
					$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
					"','" . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , '". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA ."' , 9, 16, 3);";
					$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
				} 
				*/
				if(strcmp($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->TIPODOC,"OPCON")==0)
				{
					$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
					"','" . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ','". $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA ."' , 0 , 3, 6, 3);";
					//echo $squery_atividades;
					$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
				}
				
				/*
				$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
				"','" . $xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , 0 , 9, 16, 3);";
				$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
				*/
			}
		}
	}
}



switch($Consulta)
{
	case 5://ccPedidos
		print($HtmlTablePedido);
		$c_pedidos = count($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno);
		$acc_tela=0;
		//if($c_pedidos>19)$c_pedidos=19;
		for($x=0; $x<($c_pedidos);$x++)
		{
			if( (strcmp($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC,"ORC")==0) ||
				(strcmp($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC,"ORCLIC")==0) ||
				(strcmp($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC,"ORCNIN")==0) ||
				(strcmp($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC,"ORCREV")==0) ||
				(strcmp($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC,"ORCSER")==0) ||
				(strcmp($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC,"ORCZF")==0))
			{
				//if($x>1)$x--;	
				//echo "ORC".$x;
			}	else{
				print($HtmlNewRowText);	
				print($HtmlRowText.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->PEDIDO .'.' .$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->LINHAPE.$HtmlCloseRowText);
				print($HtmlRowText.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DESCRICAO   .$HtmlCloseRowText);
				



				$date_now	    = date('d-m-Y',time());// echo date('d-m-Y',time());
				$data_previsao  = date('d-m-Y',strtotime($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DTENTREGAPREV));
				$diferenca =    strtotime($data_previsao)-strtotime($date_now);
				$dias = floor($diferenca / (60 * 60 * 24));
				//echo $dias.'-';
				if($dias>0)
				{
					if($dias>1 && $dias<3){
						print($HtmlRowText.date('d-m-Y',strtotime($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DTENTREGAPREV)).$HtmlCloseRowText);
					} else {
						print($HtmlRowText.date('d-m-Y',strtotime($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DTENTREGAPREV)).$HtmlCloseRowText);
					}
				} else {
					if($dias<0){
						print("<td class='text-dask bg-danger'><text class='text-dask bg-danger' style='font-size: 1.1vw'>".date('d-m-Y',strtotime($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DTENTREGAPREV)).$HtmlCloseRowText);
					} else {
						if($dias==0){
							print("<td class='text-dask bg-warning'><text class='text-dask bg-warning' style='font-size: 1.1vw'>".date('d-m-Y',strtotime($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DTENTREGAPREV)).$HtmlCloseRowText);
						} 
					}
				}
				print($HtmlCloseNewRowText);
				if($acc_tela<20){
					$acc_tela++;
				} else {
					break;
				}
			}	
			//if($x>=19)break;
		}
		print($HtmlCloseTable);
	break;

	case 2:
	case 4:
	case 5:
	case 6:
		print($HtmlTableOrdem);
		check_new_op();
		/*
		for($x=0; $x<(count($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno));$x++)
		{
			if(strcmp($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC,"OP")==0)
			{
				print($HtmlNewRowText);		
				print($HtmlRowText.$HtmlCloseRowText);
				print($HtmlRowText.$xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->ORDEM.'.'.$xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->LINHAOP.$HtmlCloseRowText);
				print($HtmlRowText.$xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->DESCRICAO   .$HtmlCloseRowText);
				print($HtmlRowText. date('d-m-Y',strtotime($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->DATAPREVISTA)) .$HtmlCloseRowText);
				print($HtmlCloseNewRowText);	
			}
		}	
		*/
		print($HtmlCloseTable);
	break;
	case 3://ccAssistencia
		print($HtmlTableAssistencia);
		check_new_opcon();
		/*
		//print('<tr>');
		for($x=0; $x<(count($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno));$x++)
		{
			if(strcmp($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC,"OPCON")==0)
			{
				print($HtmlNewRowText);		
				print($HtmlRowText.$xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->QTDEORDEM   .$HtmlCloseRowText);
				print($HtmlRowText.$xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->DESCRICAO   .$HtmlCloseRowText);
				print($HtmlRowText. date('d-m-Y',strtotime($xml_local_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->DATAPREVISTA)) .$HtmlCloseRowText);
				print($HtmlCloseNewRowText);	
			}
		}	
		*/
		print($HtmlCloseTable);
	break;
	case 8:
		print('<img src = "parabens.png" />');
	break;
	case 10:
		print('<div class="col-md-0"><canvas id="myChart"></canvas></div>');
		print('<script type="text/javascript">');
		print('var MONTHS = ["Janeiro", "Fevereiro", "March"];
		var color = Chart.helpers.color;
		var barChartData = {
			labels: ["Janeiro", "Fevereiro", "March"],
			datasets: [{
			label: "Meta Atingida",
			backgroundColor: "green",
			borderColor: "rgba(220,220,220,0.5)",
			borderWidth: 1,
			data: [
				10,
				20,
				30,
				40,
				30,
				20,
				10
			]
			}, {
			label: "Resultado Baixo",
			backgroundColor: "red",
			borderColor: "rgba(220,220,220,0.75)",
			borderWidth: 1,
			data: [
				3,
				20,
				7,
				11,
				22,
				112,
				2
				]
			}]
		};');

		print('var ctx = document.getElementById("myChart").getContext("2d");
		window.myBar = new Chart(ctx, {
			type: "bar",
			data: barChartData,
			options: {
				responsive: true,
				legend: {
					position: "top",
				},
				title: {
					display: true,
					text: "Metas 2020"
				}
			}
		});');
		print('</script>');
		/*
			print_r('
			<div class="col-md-0"  >
				<canvas id="myChart"></canvas>
			</div>
			<script type="text/javascript">
			var MONTHS = ['Janeiro', 'Fevereiro', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
			var color = Chart.helpers.color;
			var barChartData = {
				labels: ['Janeiro', 'Fevereiro', 'March', 'April', 'May', 'June', 'July'],
				datasets: [{
				label: 'Meta Atingida',
				backgroundColor: "green",
				borderColor: "rgba(220,220,220,0.5)",
		borderWidth: 1,
		data: [
			10,
			20,
			30,
			40,
			30,
			20,
			10
		]
	}, {
		label: 'Resultado Baixo',
		backgroundColor: "red",
		borderColor: "rgba(220,220,220,0.75)",
		borderWidth: 1,
		data: [
			3,
			20,
			7,
			11,
			22,
			112,
			2
		]
		}]
	};
	var ctx = document.getElementById('myChart').getContext('2d');
	window.myBar = new Chart(ctx, {
		type: 'bar',
		data: barChartData,
		options: {
			responsive: true,
			legend: {
				position: 'top',
			},
			title: {
				display: true,
				text: 'Metas 2020'
			}
		}
	});
	</script>
	');
	*/
	break;
	default: // Ordens
		print("!DESCONHECIDO!");	
	break;
}
?>



