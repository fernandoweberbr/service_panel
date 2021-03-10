<?php

function dataPascoa($ano=false, $form="d/m/Y") {
	$ano=$ano?$ano:date("Y");
	if ($ano<1583) { 
		$A = ($ano % 4);
		$B = ($ano % 7);
		$C = ($ano % 19);
		$D = ((19 * $C + 15) % 30);
		$E = ((2 * $A + 4 * $B - $D + 34) % 7);
		$F = (int)(($D + $E + 114) / 31);
		$G = (($D + $E + 114) % 31) + 1;
		return date($form, mktime(0,0,0,$F,$G,$ano));
	}
	else {
		$A = ($ano % 19);
		$B = (int)($ano / 100);
		$C = ($ano % 100);
		$D = (int)($B / 4);
		$E = ($B % 4);
		$F = (int)(($B + 8) / 25);
		$G = (int)(($B - $F + 1) / 3);
		$H = ((19 * $A + $B - $D - $G + 15) % 30);
		$I = (int)($C / 4);
		$K = ($C % 4);
		$L = ((32 + 2 * $E + 2 * $I - $H - $K) % 7);
		$M = (int)(($A + 11 * $H + 22 * $L) / 451);
		$P = (int)(($H + $L - 7 * $M + 114) / 31);
		$Q = (($H + $L - 7 * $M + 114) % 31) + 1;
		return date($form, mktime(0,0,0,$P,$Q,$ano));
	}
}
// dataCarnaval(ano, formato);
// Autor: Yuri Vecchi
//
// Funcao para o calculo do Carnaval
// Retorna o dia do Carnaval no formato desejado ou false.
//
// ######################ATENCAO###########################
// Esta funcao sofre das limitacoes de data de mktime()!!!
// ########################################################
//
// Possui dois parametros, ambos opcionais
// ano = ano com quatro digitos
//	 Padrao: ano atual
// formato = formatacao da funcao date() http://br.php.net/date
//	 Padrao: d/m/Y

function dataCarnaval($ano=false, $form="d/m/Y") {
	$ano=$ano?$ano:date("Y");
	$a=explode("/", dataPascoa($ano));
	return date($form, mktime(0,0,0,$a[1],$a[0]-47,$a[2]));
}




// dataCorpusChristi(ano, formato);
// Autor: Yuri Vecchi
//
// Funcao para o calculo do Corpus Christi
// Retorna o dia do Corpus Christi no formato desejado ou false.
//
// ######################ATENCAO###########################
// Esta funcao sofre das limitacoes de data de mktime()!!!
// ########################################################
//
// Possui dois parametros, ambos opcionais
// ano = ano com quatro digitos
//	 Padrao: ano atual
// formato = formatacao da funcao date() http://br.php.net/date
//	 Padrao: d/m/Y

function dataCorpusChristi($ano=false, $form="d/m/Y") {
	$ano=$ano?$ano:date("Y");
	$a=explode("/", dataPascoa($ano));
	return date($form, mktime(0,0,0,$a[1],$a[0]+60,$a[2]));
}


// dataSextaSanta(ano, formato);
// Autor: Yuri Vecchi
//
// Funcao para o calculo da Sexta-feira santa ou da Paixao.
// Retorna o dia da Sexta-feira santa ou da Paixao no formato desejado ou false.
//
// ######################ATENCAO###########################
// Esta funcao sofre das limitacoes de data de mktime()!!!
// ########################################################
//
// Possui dois parametros, ambos opcionais
// ano = ano com quatro digitos
// Padrao: ano atual
// formato = formatacao da funcao date() http://br.php.net/date
// Padrao: d/m/Y

function dataSextaSanta($ano=false, $form="d/m/Y") {
	$ano=$ano?$ano:date("Y");
	$a=explode("/", dataPascoa($ano));
	return date($form, mktime(0,0,0,$a[1],$a[0]-2,$a[2]));
} 




/*
formas diferentes de usar a funcao

1- qdt de dias uteis a contar apartir de uma data especifica ou fixa você pode passar a data direto nos paremetros da funcao
   function somar_dias_uteis($str_data,$int_qtd_dias_somar = 7,$feriados) 
   
   chamando a funcao   
   somar_dias_uteis('09/04/2009','','');
   ou 
   $data = date('Y-m-d'); 
   somar_dias_uteis('$data','','');
   
2- nao precisa passar os dias como parametro da funcao tipo function somar_dias_uteis($str_data,$int_qtd_dias_somar,$feriados) 
   para chamar a funcao fica
   somar_dias_uteis('09/04/2009','4','');
   ou
   $data = date('Y-m-d'); 
   somar_dias_uteis('$data','4','');
*/

function somar_dias_uteis($str_data,$int_qtd_dias_somar,$feriados) {
	// Caso seja informado uma data do MySQL do tipo DATETIME - aaaa-mm-dd 00:00:00
	// Transforma para DATE - aaaa-mm-dd
	$str_data = substr($str_data,0,10);
	// Se a data estiver no formato brasileiro: dd/mm/aaaa
	// Converte-a para o padrão americano: aaaa-mm-dd
	if ( preg_match("@/@",$str_data) == 1 ) {
		$str_data = implode("-", array_reverse(explode("/",$str_data)));
	}
	// chama a funcao que calcula a pascoa	
	$pascoa_dt = dataPascoa(date('Y'));
	$aux_p = explode("/", $pascoa_dt);
	$aux_dia_pas = $aux_p[0];
	$aux_mes_pas = $aux_p[1];
	$pascoa = "$aux_mes_pas"."-"."$aux_dia_pas"; // crio uma data somente como mes e dia
	// chama a funcao que calcula o carnaval	
	$carnaval_dt = dataCarnaval(date('Y'));
	$aux_carna = explode("/", $carnaval_dt);
	$aux_dia_carna = $aux_carna[0];
	$aux_mes_carna = $aux_carna[1];
	$carnaval = "$aux_mes_carna"."-"."$aux_dia_carna"; 
	// chama a funcao que calcula corpus christi	
	$CorpusChristi_dt = dataCorpusChristi(date('Y'));
	$aux_cc = explode("/", $CorpusChristi_dt);
	$aux_cc_dia = $aux_cc[0];
	$aux_cc_mes = $aux_cc[1];
	$Corpus_Christi = "$aux_cc_mes"."-"."$aux_cc_dia"; 
	// chama a funcao que calcula a sexta feira santa	
	$sexta_santa_dt = dataSextaSanta(date('Y'));
	$aux = explode("/", $sexta_santa_dt);
	$aux_dia = $aux[0];
	$aux_mes = $aux[1];
	$sexta_santa = "$aux_mes"."-"."$aux_dia"; 
    $feriados = array("01-01", $carnaval, $sexta_santa, $pascoa, $Corpus_Christi, "04-21", "05-01", "06-12" ,"07-09", "07-16", "09-07", "10-12", "11-02", "11-15", "12-24", "12-25", "12-31" );
	$array_data = explode('-', $str_data);
	$count_days = 0;
	$int_qtd_dias_uteis = 0;
	while ( $int_qtd_dias_uteis < $int_qtd_dias_somar ) {
		$count_days++;
		$day = date('m-d',strtotime('+'.$count_days.'day',strtotime($str_data))); 
		if(($dias_da_semana = gmdate('w', strtotime('+'.$count_days.' day', gmmktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6' && !in_array($day,$feriados)) 
		{
			$int_qtd_dias_uteis++;
		}
	}
	return gmdate('d-m-Y',strtotime('+'.$count_days.' day',strtotime($str_data)));

}
function int_divide($x, $y) {
    return ($x - ($x % $y)) / $y;
}


//include_once("./mysqlreflection-master/beans/BeanAtividade.php");
//$array_of_items=array();
//$conexao = mysql_connect(DBHOST,DBUSER,DBPASSWORD);  
//mysql_select_db(DBNAME); 

//error_reporting(0);

//global  $xml_local;
//$xml_stringfile= file_get_contents("http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao");
//$xml_removexmlns = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $xml_stringfile);
//print_r($xml_removexmlns);
//$xml_local 			= simplexml_load_file("./ordem.xml") or die("Error: Cannot create objec1t"); 
//$xml_local_pedidos 	= simplexml_load_file("./Pedidos.xml") or die("Error: Cannot create objec1t"); 

//$xml_local = simplexml_load_string($xml_stringfile) or die("Error: Cannot create objec1t"); 
//$xml_local = simplexml_load_file("http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao/") or die("Error: Cannot create objec1t"); 

//$xml_stringfilepedidos= file_get_contents("http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao");
//$xml_removexmlnspedidos = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $xml_stringfilepedidos);
//print_r($xml_removexmlns);
//$xml_local_pedidos = simplexml_load_string($xml_stringfilepedidos) or die("Error: Cannot create objec1t"); 


/*
if($xml_local==NULL) {
	$xml_local = simplexml_load_file("ordem.xml") or die("Error: Cannot create objec1t");
	if($xml_local==NULL)
	{
		echo "Sem Systema";
		return;
	}
}
*/
//echo count($xml_local->Conteudo->ListaDeRetorno->Retorno);
//$xml_local = simplexml_load_file("ordem.xml") or die("Error: Cannot create objec1t"); 
//$cnt_xml_reg=count($xml_local->Conteudo->ListaDeRetorno->Retorno);

/*
function if_ordem_exist($number)
{
	//$count=$GLOBALS['cnt_xml_reg'];
	$xml_func = $GLOBALS['xml_local'];
	//echo count($xml_func->Conteudo->ListaDeRetorno->Retorno) . '</br>';
	for($i=0; $i<(count($xml_func->Conteudo->ListaDeRetorno->Retorno));$i++)
	{
		$trim_number = trim($number);
		//echo $i.'['.$trim_number.']'.'<'.$xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM.'>'.'(';
		//echo strcmp($trim_number,$xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM);
		//echo ')</br>';
		$ConcatOrdemLinha = trim($xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP);
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


function check_new_ordem()
{
	// Compara se existe novas ordens em xml e se elas devem ser adicionadas nos registros
	$xml_func2 = $GLOBALS['xml_local'];
	$squery_atividades = "SELECT atividade.ordem as ordem, atividade.finalizada as finalizada FROM atividade";
	$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
	$row_count	=	mysql_num_rows($result_atividades); // Numero de linhas retornadas de usuarios em cada setor
	$atividades_fetch = array();
	//echo $row_count;
	while($atividades =	mysql_fetch_array($result_atividades)){
		$atividades_fetch[] = $atividades;
		//echo $atividades['ordem'];	
	};
	//print_r($atividades_fetch) ;
	for($i=0; $i<(count($xml_func2->Conteudo->ListaDeRetorno->Retorno));$i++)
	{
		for($j=0; $j<$row_count;$j++)
		{
			$ConcatOrdemLinha = trim($xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP);
			//echo $ConcatOrdemLinha;
			if(strcmp($ConcatOrdemLinha,trim($atividades_fetch[$j]['ordem']))==0)
			{
				if($atividades_fetch[$j]['finalizada']==1)
				{
					//$sql = "Update atividade set finalizada = " .$_GET["check"]. " WHERE id= ".$_GET["id"].";";
					$sql_query = "SELECT atividade.id AS id FROM atividade AND ordem = ". $atividades_fetch[$j]["ordem"] . ";";
					//echo $sql_query;
					$result_sel = mysql_query($sql_query) or die("error select atividade");
					$row = mysql_fetch_array($result_sel);
					//echo $row['id'];
					$sql = "Update atividade set finalizada = 0  WHERE id= '" . $row['id'] . "';";
					//echo $sql;
					$result = mysql_query($sql) or die("error to update atividade data");
				}	
				//echo "<". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM .">";
				//echo "[".$atividades_fetch[$j]['ordem']."]</br>";
				break;
			} else {
				//echo "<". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM .">";
				//echo "[".$atividades_fetch[$j]['ordem']."]</br>";
			}
		}
		if($j==$row_count)
		{

            //echo "Novos registros!";
            //echo "Nova Ordem <". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM ."></br>";
            $ConcatOrdemLinha = trim($xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "." . $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP);
            //echo $ConcatOrdemLinha;
            if(strcmp($xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->TIPODOC,"OP")==0)
            {
                $squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
                "','" . $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , '". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA ."' , 9, 16, 3);";
            }
            if(strcmp($xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->TIPODOC,"OPCON")==0)
            {
                $squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
                "','" . $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , '". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->DATAPREVISTA ."' , 3, 6, 3);";
            }
            $result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 

			//echo "Nova Ordem <". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM ."></br>";
			//$ConcatOrdemLinha = $xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->ORDEM . "-" . $xml_func->Conteudo->ListaDeRetorno->Retorno[$i]->LINHAOP;
	
			$squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $ConcatOrdemLinha . 
			"','" . $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->DESCRICAO . "'" . ", 0 , 0 , '   ', 0 , 0 , 9, 16, 3);";
			$result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
			// VALUES (\"". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM . "\",\"" . $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_PRODDESC . "\",0,0,"  ",0,0);";
			//echo $squery_atividades."</br>";
		
		}
	}
}


abstract class Centros_de_Custo extends BasicEnum 
{
	const ccNenhum = 0;
	const ccControle_producao = 1;
	const ccProducao_eletronica = 2;
	const ccAssistencia = 3;
	const ccMarcenaria = 4;
	const ccPedidos = 5;
	const ccProd_mont_placas = 6;
	const ccPermutas = 7;
	const ccAniversario = 8;
}
*/


//check_new_ordem();
$Consulta = $_GET['consulta'];

//print_r($Consulta);
$HtmlTablePedido = '<div class="table-condensed row justify-content-md-center ">
<table class="table-condensed table-bordered" id="dataTable" width="97%" cellspacing="0" padding="0" style="background-color: black;  font-size: 1.0vw">
<thead>
<tr>
<th scope="col">Pedido</th>
<th scope="col">Descrição</th>
<th scope="col">Data</th>
</tr>
</thead>
<tbody>
';

$HtmlTableOrdem = '<div class="table-condensed row justify-content-md-center ">
<table class="table-condensed table-bordered" id="dataTable" width="97%" cellspacing="0" padding="0" style="background-color: black;  font-size: 1.0vw">
<thead>
<tr>
<th scope="col">Ordem</th>
<th scope="col">Descrição</th>
<th scope="col">Data</th>
</tr>
</thead>
<tbody>
';

$HtmlTableAssistencia = '<div class="table-condensed row justify-content-md-center ">
<table class="table-condensed table-bordered" id="dataTable" width="97%" cellspacing="0" padding="0" style="background-color: black;  font-size: 1.0vw">
<thead>
<tr>
<th scope="col">Quantidade</th>
<th scope="col">Descrição</th>
<th scope="col">Data</th>
</tr>
</thead>
<tbody>
';

$HtmlCloseTable = '</tbody></div></table>';
$HtmlNewRowText = '<tr>';
$HtmlRowText 	= '<td><text class="text-light" style="background-color: black;  font-size: 1.0vw">';
$HtmlCloseNewRowText = '<tr>';
$HtmlCloseRowText ='</text></td>';

$xml_ordem 	= simplexml_load_file("./ordem.xml") or die("Error: Cannot create objec1t"); 
$xml_local_pedidos 	= simplexml_load_file("./Pedidos.xml") or die("Error: Cannot create objec1t"); 

switch($Consulta)
{
	case 5://ccPedidos
		print($HtmlTablePedido);
		for($x=0; $x<(count($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno));$x++)
		{
			print($HtmlNewRowText);	
			print($HtmlRowText.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->PEDIDO .'.' .$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->LINHAPE.$HtmlCloseRowText);
			print($HtmlRowText.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DESCRICAO   .$HtmlCloseRowText);
			print($HtmlRowText.date('d-m-Y',strtotime($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DTENTREGAPREV)).$HtmlCloseRowText);
			print($HtmlCloseNewRowText);	
		}	
		print($HtmlCloseTable);
	break;
	case 3://ccAssistencia
		print($HtmlTableAssistencia);
		//print('<tr>');
		for($x=0; $x<(count($xml_ordem->Conteudo->ListaDeRetorno->Retorno));$x++)
		{
			if(strcmp($xml_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC,"OPCON")==0)
			{
				print($HtmlNewRowText);		
				print($HtmlRowText.$xml_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->QTDEORDEM   .$HtmlCloseRowText);
				print($HtmlRowText.$xml_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->DESCRICAO   .$HtmlCloseRowText);
				print($HtmlRowText. date('d-m-Y',strtotime($xml_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->DATAPREVISTA)) .$HtmlCloseRowText);
				print($HtmlCloseNewRowText);	
			}
		}	
		print($HtmlCloseTable);
	break;
	case 2:
	case 4:
	case 5:
	case 6:
		print($HtmlTableOrdem);
		for($x=0; $x<(count($xml_ordem->Conteudo->ListaDeRetorno->Retorno));$x++)
		{
			if(strcmp($xml_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->TIPODOC,"OP")==0)
			{
				print($HtmlNewRowText);		
				print($HtmlRowText.$xml_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->ORDEM.'.'.$xml_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->LINHAOP.$HtmlCloseRowText);
				print($HtmlRowText.$xml_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->DESCRICAO   .$HtmlCloseRowText);
				print($HtmlRowText. date('d-m-Y',strtotime($xml_ordem->Conteudo->ListaDeRetorno->Retorno[$x]->DATAPREVISTA)) .$HtmlCloseRowText);
				print($HtmlCloseNewRowText);	
			}
		}	
		print($HtmlCloseTable);
	break;
		default: // Ordens
		print("!DESCONHECIDO!");	

	break;
}
/*
switch($Consulta)
{
		case 3:
			print('<div class="table-condensed row justify-content-md-center ">');
			print('<table class="table-condensed table-bordered "  style="background-color: black" id="dataTable" width="100%" cellspacing="0" padding="0"> ');
			print('<thead>');
			print('<tr>');
			print('<th><p class="text-light" style="font-size: 1.2vw">Ordem</th>');
			print('<th><p class="text-light" style="font-size: 1.2vw">Descrição</th>');
			print('<th><p class="text-light" style="font-size: 1.2vw">Data</th>');
			print('</tr>');
			print('</thead>');
			print('<tbody>');
			print('</tbody>');
			for($x=0; $x<(count($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno));$x++)
			{
				print('<tr>');	
				print('<td><text class="text-light" style="background-color: black;  font-size: 1.5vw">'.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->QTDEORDEM .'</text></td>');
				print('<td><text class="text-light" ">'.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DESCRICAO.'</text></td>');
				print('<td><text class="text-light" ">'.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DATAPREVISTA.'</text></td>');
				print('</tr>');	
			}	
		break;
	
		case ccControle_producao:
		case ccProducao_eletronica:
		case ccMarcenaria:
		case ccProd_mont_placas:
		break;
		case ccPedidos:	
			print('<div class="table-condensed row justify-content-md-center ">');
			print('<table class="table-condensed table-bordered "  style="background-color: black" id="dataTable" width="100%" cellspacing="0" padding="0"> ');
			print('<thead>');
			print('<tr>');
			print('<th><p class="text-light" style="font-size: 1.2vw">Ordem</th>');
			print('<th><p class="text-light" style="font-size: 1.2vw">Descrição</th>');
			print('<th><p class="text-light" style="font-size: 1.2vw">Data</th>');
			print('</tr>');
			print('</thead>');
			print('<tbody>');
			print('</tbody>');
			//for()	
			for($x=0; $x<(count($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno));$x++)
			{
				print('<tr>');	
				print('<td><text class="text-light" style="background-color: black;  font-size: 1.5vw">'.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->QTDEORDEM .'</text></td>');
				print('<td><text class="text-light" ">'.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DESCRICAO.'</text></td>');
				print('<td><text class="text-light" ">'.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DATAPREVISTA.'</text></td>');
				print('</tr>');	
			}		
		break;
		case ccPermutas:			
		break;
		case ccAniversario:			
		break;
}
*/	
/*

if($Consulta=='3' || $Consulta=='7')
{
		$squery_users = " SELECT atividade.fk_usuario AS id_users
			FROM atividade
			WHERE atividade.fk_setor = ".  $Consulta . " AND atividade.finalizada = 0
		    GROUP BY atividade.fk_usuario ";
		$result_user = mysql_query($squery_users) or die(mysql_error()); 
		$row_count=mysql_num_rows($result_user); // Numero de linhas retornadas de usuarios em cada setor
		$Divisor = 21 / $row_count; // divide numero de linhas por quantos usuarios existem
		$Limit = "LIMIT 0,".floor($Divisor).";";
		//echo $Limit;
		$squery = " SELECT usuario.usuario_alias AS user_alias, atividade.ordem AS num_ordem, 
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
					GROUP BY d_data_inicio, atividade.fk_importancia, atividade.ordem
					HAVING COUNT(d_data_inicio) < 4
					ORDER BY atividade.fk_importancia ASC, d_data_inicio, atividade.ordem ".$Limit.";";
} 
else 
{
	if($Consulta=='5')
	{
		print('<div class="table-condensed row justify-content-md-center ">');
		print('<table class="table-condensed table-bordered "  style="background-color: black" id="dataTable" width="100%" cellspacing="0" padding="0"> ');
		print('<thead>');
		print('<tr>');
		print('<th><p class="text-light" style="font-size: 1.2vw">Ordem</th>');
		print('<th><p class="text-light" style="font-size: 1.2vw">Descrição</th>');
		print('<th><p class="text-light" style="font-size: 1.2vw">Data</th>');
		print('</tr>');
		print('</thead>');
		print('<tbody>');
		print('</tbody>');
		//for()	
		for($x=0; $x<(count($xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno));$x++)
		{
			print('<tr>');	
			print('<td><text class="text-light" style="background-color: black;  font-size: 1.5vw">'.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->QTDEORDEM .'</text></td>');
			print('<td><text class="text-light" ">'.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DESCRICAO.'</text></td>');
			print('<td><text class="text-light" ">'.$xml_local_pedidos->Conteudo->ListaDeRetorno->Retorno[$x]->DATAPREVISTA.'</text></td>');
			print('</tr>');	
		}
	} 
	else 
	{
		$squery_users = " SELECT atividade.fk_usuario AS id_users
						FROM atividade
						WHERE atividade.fk_setor = ".  $Consulta . " AND atividade.finalizada = 0
						GROUP BY atividade.fk_usuario ";
				//$dateshow=date("d-m-Y", time());
				//echo '<h4>';
				//print($dateshow);
				//echo '</h4>';
		print('<div class="table-condensed row justify-content-md-center ">');
		print('<table class="table-condensed table-bordered "  style="background-color: black" id="dataTable" width="100%" cellspacing="0" padding="0"> ');
		print('<thead>');
		print('<tr>');
		print('<th></th>');
		print('<th><p class="text-light" style="font-size: 1.2vw">Ordem</th>');
		print('<th><p class="text-light" style="font-size: 1.2vw">Descrição</th>');
		print('<th><p class="text-light" style="font-size: 1.2vw">Data</th>');
		print('</tr>');
		print('</thead>');
		print('<tbody>');
		print('<tr>');
		//check_new_ordem();
		$result_user = mysql_query($squery_users) or die(mysql_error()); 
		$row_count=mysql_num_rows($result_user); // Numero de linhas retornadas de usuarios em cada setor
		while($users = mysql_fetch_array($result_user))
		{
			if($users['id_users'])
			{
				$user_id = $users['id_users'];
				//print('id='.$users['id_users'].',');
				$Divisor = 21 / $row_count; // divide numero de linhas por quantos usuarios existem
				$Limit = "LIMIT 0,".floor($Divisor).";";
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
						//echo $Limit;
				$result = mysql_query($squery) or die(mysql_error()); 
				while($dados = mysql_fetch_array($result))
				{	
					if(if_ordem_exist($dados['num_ordem'])==True)
					{
						if($dados['realizada']=='1')
						{
							print('<td><text class="text-success" ">'.$dados['user_alias'].'</text></td>');
							print('<td><text class="text-success" ">'.$dados['num_ordem'].'</text></td>');
							print('<td><text class="text-success" ">'.$dados['at_descricao'].'</text></td>');
							print('<td><text class="text-success" "> Realizado </text></td>');
							//print('<td><h5><p class="text-success font-weight-bold">'.$dados['alias_prioridade'].'</p><h5></td>');
							print('<td><text class="text-light" "></p></h3></td>');    
						} 
						else 
						{
							print('<td><text class="text-light" style="background-color: black;  font-size: 1.5vw">'.$dados['user_alias'].'</text></td>');
							print('<td><text class="text-light" ">'.$dados['num_ordem'].'</text></td>');
							print('<td><text class="text-light" ">'.$dados['at_descricao'].'</text></td>');
							if(strtotime($dados['d_data_limite'])>0)
							{
								$date_now	 = strtotime(date("Y-m-d", time()));
								$date_limite = strtotime($dados['d_data_limite']);
								$diferenca =  $date_limite - $date_now ;
								$dias = floor($diferenca / (60 * 60 * 24));
								if($dias>0)
								{
									print('<td><text class="text-white" ">'.date('d-m-Y',$date_limite).'<text class="text-primary" "> Faltam '.$dias.' dia(s)</text></td>');
								} 
								else 
								{
									if($dias<0)
									{
										print('<td class="text-dask bg-danger"><text class="text-dask bg-danger" ">'.date('d-m-Y',$date_limite).' Atraso '.abs($dias).' dia(s)</text></td>');
									} 
									else 
									{
										if($dias==0)
										{
											print('<td  class="text-dark bg-warning" ">Hoje  '.date('d-m-Y',$date_limite).'</td>');
										} 
									}
								}
							} 
							else 
							{
								print('<td><text class="text-light" style="font-size: 1.2vw">SEM DATA</text></td>');
							}
							
						}
						print('</tr>');
					} 
					else 
					{
						//$sql = "Update atividade set finalizada = " .$_GET["check"]. " WHERE id= ".$_GET["id"].";";
						//$sql_query = "SELECT atividade.id AS id FROM atividade WHERE atividade.fk_setor <> 5 AND atividade.ordem = ". $dados["num_ordem"] .";";
						$sql_query = "SELECT atividade.id AS id FROM atividade WHERE ordem = ". $dados["num_ordem"] .";";
						//echo $sql_query;
						$result_sel = mysql_query($sql_query) or die("error select atividade");
						$row = mysql_fetch_array($result_sel);
						//echo $row['id'];
						$sql = "Update atividade set finalizada = 1  WHERE id= '" . $row['id'] . "';";
						//echo $sql;
						$result = mysql_query($sql) or die("error to update atividade data");
					}
				}
			}		
		}
		return;
	}
} 	
//$dateshow=date("d-m-Y", time());
//echo '<h5>';
//print($dateshow);
//echo '</h5>';
print('<div class="table-condensed row justify-content-md-center ">');
print('<table class="table-condensed table-bordered " style="background-color: black" id="dataTable" width="100%" cellspacing="0" padding="0"> ');
print('<thead>');
print('<tr>');
print('<th></th>');
print('<th><p class="text-light" style="font-size: 1.2vw">Ordem</th>');
print('<th><p class="text-light" style="font-size: 1.2vw">Descrição</th>');
print('<th><p class="text-light" style="font-size: 1.2vw">Data</th>');
print('</tr>');
print('</thead>');
print('<tbody>');
print('<tr>');

$result = mysql_query($squery) or die(mysql_error()); 
while($dados = mysql_fetch_array($result))
{
	if(if_ordem_exist($dados['num_ordem'])==True)
	{
		print('<tr>');
		if($dados['finalizada']=='0')
    	{
        	if($dados['realizada']=='1')
        	{
            	print('<td><text class="text-success" ">'.$dados['user_alias'].'</text></td>');
            	print('<td><text class="text-success" ">'.$dados['num_ordem'].'</text></td>');
            	print('<td><text class="text-success" ">'.$dados['at_descricao'].'</text></td>');
            	print('<td><text class="text-success" "> Realizado </text></td>');
				//print('<td><h5><p class="text-success font-weight-bold">'.$dados['alias_prioridade'].'</p><h5></td>');
				print('<td><text class="text-light" "></p></h3></td>');    
			} 
			else 
			{
				print('<tr>');
				print('<td><text class="text-light" ">'.$dados['user_alias'].'</text></td>');
            	print('<td><text class="text-light" ">'.$dados['num_ordem'].'</text></td>');
				print('<td><text class="text-light" ">'.$dados['at_descricao'].'</text></td>');
				//print('<td><h0><p class="text-white">'.$dados['alias_prioridade'].'</p></h0></td>');
				if($Consulta=='3')
				{
					if(strtotime($dados['d_data_inicio'])>0)
					{
						$date_now	 = date("Y-m-d", time());
						$data_inicio = date("d-m-Y",strtotime($dados['d_data_inicio']));
						$data_final  = somar_dias_uteis($data_inicio,5,"");
						$diasemana_numero = date('w', strtotime($data_final));
						if($diasemana_numero==0)
						{
							$data_final=date('d-m-Y',strtotime($data_final. ' + 1 days'));
						}
						if($diasemana_numero==6)
						{
							$data_final=date('d-m-Y',strtotime($data_final. ' + 2 days'));
						}
						$conv_us_data_final = date_format(date_create_from_format('d-m-Y', $data_final),"Y-m-d");
						$diferenca =    strtotime($conv_us_data_final) - strtotime($date_now);
						$dias = floor($diferenca / (60 * 60 * 24));
						if($dias>0)
						{
							if($dias>1 && $dias<3)
							{
								print('<td><text class="text-white bg-warning" ">'.$data_inicio.'<text class="text-primary" "> Faltam '.$dias.' dia(s) ['.$data_final.']</text></td>');
							}	 
							else 
							{
								$soma_dias = $data_final;
								print('<td><text class="text-primary " ">'.$data_inicio.'<text class="text-primary" "> Faltam '.$dias.' dia(s) ['.$soma_dias.']</text></td>');						
							}
						}
					}
				}
				else 
				{
					if($dias<0)
					{
						print('<td class="text-dask bg-danger"><text class="text-dask bg-danger" ">'.$data_inicio.' Atraso '.abs($dias).' dia(s) ['.$data_final.']</text></td>');
					} 
					else 
					{
						if($dias==0)
						{
							print('<td  class="text-dark bg-warning" ">Hoje  '.$data_inicio.', ['.$data_final.']</td>');
						} 
					}
				}
			}
		} 
		else 
		{
			if($Consulta=='7')
			{
				if(strtotime($dados['d_data_inicio'])>0)
				{
					$date_now	 = date("Y-m-d", time());
					$data_inicio = date("d-m-Y",strtotime($dados['d_data_inicio']));
					$data_final  = somar_dias_uteis($data_inicio,5,'');
					$diasemana_numero = date('w', strtotime($data_final));
					if($diasemana_numero==0)
					{
						$data_final=date('d-m-Y',strtotime($data_final. ' + 1 days'));
					}
					if($diasemana_numero==6)
					{
						$data_final=date('d-m-Y',strtotime($data_final. ' + 2 days'));
					}
					$conv_us_data_final = date_format(date_create_from_format('d-m-Y', $data_final),"Y-m-d");
					$diferenca =    strtotime($conv_us_data_final) - strtotime($date_now);
					$dias = floor($diferenca / (60 * 60 * 24));
					if($dias>0)
					{
						if($dias>1 && $dias<3)
						{
							print('<td><text class="text-white bg-warning" ">'.$data_inicio.'<text class="text-primary" "> Faltam '.$dias.' dia(s) ['.$data_final.']</text></td>');
						} 
						else 
						{
							$soma_dias = $dias;
							print('<td><text class="text-primary " ">'.$data_inicio.'<text class="text-primary" "> Faltam '.$dias.' dia(s) ['.$soma_dias.']</text></td>');
						}
					} 
					else 
					{
						if($dias<0)
						{
							print('<td class="text-dask bg-primary"><text class="text-dask bg-primary" ">'.$data_inicio.' Atraso '.abs($dias).' dia(s) ['.$data_final.']</text></td>');
						} 
						else 
						{
							if($dias==0)
							{
								print('<td  class="text-dark bg-primary" ">Hoje  '.$data_inicio.', ['.$data_final.']</td>');
							} 
						}
					}
				}
			} 
			else 
			{
				if(strtotime($dados['d_data_limite'])>0)
				{
					$date_now	 = strtotime(date("Y-m-d", time()));
					$date_limite = strtotime($dados['d_data_limite']);
					$diferenca =  $date_limite - $date_now ;
					$dias = floor($diferenca / (60 * 60 * 24));
					if($dias>0)
					{
						print('<td><text class="text-white" ">'.date('d-m-Y',$date_limite).'<text class="text-primary" "> Faltam '.$dias.' dia(s)</text></td>');
					} 
					else 
					{
						if($dias<0)
						{
							print('<td class="text-dask bg-danger"><text class="text-dask bg-danger" ">'.date('d-m-Y',$date_limite).' Atraso '.abs($dias).' dia(s)</text></td>');
						} 
						else 
						{
							if($dias==0)
							{
								print('<td  class="text-dark bg-warning" ">Hoje  '.date('d-m-Y',$date_limite).'</td>');
							} 
						}
					}
				} 
				else 
				{
					print('<td><text class="text-light" style="font-size: 1.2vw">SEM DATA</text></td>');
				}
			}
		}
		print('</tr>');
	}
	else 
	{
						//$sql = "Update atividade set finalizada = " .$_GET["check"]. " WHERE id= ".$_GET["id"].";";
						$sql_query = "SELECT atividade.id AS id FROM atividade WHERE  atividade.ordem = ". $dados["num_ordem"] .";";
						//echo $sql_query;
						$result_sel = mysql_query($sql_query) or die("error select atividade");
						$row = mysql_fetch_array($result_sel);
						//echo $row['id'];
						$sql = "Update atividade set finalizada = 1  WHERE id= '" . $row['id'] . "';";
						//echo $sql;
						$result = mysql_query($sql) or die("error to update atividade data");
	}
}
*/

//mysql_free_result ( $result );
?>



