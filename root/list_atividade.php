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
		
		if(($dias_da_semana = gmdate('w', strtotime('+'.$count_days.' day', gmmktime(0, 0, 0, $array_data[1], $array_data[2], $array_data[0]))) ) != '0' && $dias_da_semana != '6' && !in_array($day,$feriados)) {

			$int_qtd_dias_uteis++;
		}

	}
	return gmdate('d-m-Y',strtotime('+'.$count_days.' day',strtotime($str_data)));

}

$servidor = "localhost"; 
$usuario = "root"; 
$senha = "usbw"; 
$banco = "effective"; 
$conexao = mysql_connect($servidor,$usuario,$senha);  
mysql_select_db($banco); 
        $Consulta = $_GET['consulta'];
        if($Consulta=='3' || $Consulta=='7'){
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
					GROUP BY d_data_inicio, atividade.fk_importancia
					HAVING COUNT(d_data_inicio) < 4
					ORDER BY atividade.fk_importancia ASC, d_data_inicio 
					LIMIT 0,20 ";
		} else {
        	$squery_users = " SELECT atividade.fk_usuario AS id_users
							  FROM atividade
							  WHERE atividade.fk_setor = ".  $Consulta . " AND atividade.finalizada = 0
				  	 		  GROUP BY atividade.fk_usuario ";
			
			$dateshow=date("d-m-Y", time());
			echo '<h4>';
			print($dateshow);
			echo '</h4><span class=\"glyphicon glyphicon-edit\"></span>';
			print('<div class="table-condensed row justify-content-md-center ">');
			print('<table class="table-condensed table-bordered " id="dataTable" width="100%" cellspacing="0" padding="0"> ');
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
			$result_user = mysql_query($squery_users) or die(mysql_error()); 
			while($users = mysql_fetch_array($result_user))
			{
				if($users['id_users'])
				{
					$user_id = $users['id_users'];
					//print('id='.$users['id_users'].',');
					$Limit = "LIMIT 0,5";
					if($Consulta=='5' || $Consulta=='6'){
						$Limit = "LIMIT 0,20";
					}					

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
						print('<td><text class="text-light" style="font-size: 1.5vw">'.$dados['user_alias'].'</text></td>');
            			print('<td><text class="text-light" style="font-size: 1.5vw">'.$dados['num_ordem'].'</text></td>');
						print('<td><text class="text-light" style="font-size: 1.5vw">'.$dados['at_descricao'].'</text></td>');
						if(strtotime($dados['d_data_limite'])>0)
						{
						$date_now	 = strtotime(date("Y-m-d", time()));
						$date_limite = strtotime($dados['d_data_limite']);
						$diferenca =  $date_limite - $date_now ;
						$dias = floor($diferenca / (60 * 60 * 24));
						if($dias>0){
								print('<td><text class="text-white" style="font-size: 1.5vw">'.date('d-m-Y',$date_limite).'<text class="text-primary" style="font-size: 1.5vw"> Faltam '.$dias.' dia(s)</text></td>');
							} else {
								if($dias<0){
									print('<td class="text-dask bg-danger"><text class="text-dask bg-danger" style="font-size: 1.5vw">'.date('d-m-Y',$date_limite).' Atraso '.abs($dias).' dia(s)</text></td>');
								} else {
									if($dias==0){
										print('<td  class="text-dark bg-warning" style="font-size: 1.5vw">Hoje  '.date('d-m-Y',$date_limite).'</td>');
									} 
								}
							}
						} else {
							print('<td><text class="text-light" style="font-size: 1.2vw">SEM DATA</text></td>');
						}
						print('</tr>');
					}
				}		
			}
			return;
		}
		$dateshow=date("d-m-Y", time());
		echo '<h4>';
		print($dateshow);
		echo '</h4><span class=\"glyphicon glyphicon-edit\"></span>';
		print('<div class="table-condensed row justify-content-md-center ">');
		print('<table class="table-condensed table-bordered " id="dataTable" width="100%" cellspacing="0" padding="0"> ');
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
    print('<tr>');
	if($dados['finalizada']=='0')
    {
        if($dados['realizada']=='1')
        {
            print('<td><text class="text-success" style="font-size: 1.5vw">'.$dados['user_alias'].'</text></td>');
            print('<td><text class="text-success" style="font-size: 1.5vw">'.$dados['num_ordem'].'</text></td>');
            print('<td><text class="text-success" style="font-size: 1.5vw">'.$dados['at_descricao'].'</text></td>');
            print('<td><text class="text-success" style="font-size: 1.5vw"> Realizado </text></td>');
			//print('<td><h5><p class="text-success font-weight-bold">'.$dados['alias_prioridade'].'</p><h5></td>');
			print('<td><text class="text-light" style="font-size: 1.5vw"></p></h3></td>');    
		} else {
			print('<tr>');
			print('<td><text class="text-light" style="font-size: 1.5vw">'.$dados['user_alias'].'</text></td>');
            print('<td><text class="text-light" style="font-size: 1.5vw">'.$dados['num_ordem'].'</text></td>');
			print('<td><text class="text-light" style="font-size: 1.5vw">'.$dados['at_descricao'].'</text></td>');
			//print('<td><h0><p class="text-white">'.$dados['alias_prioridade'].'</p></h0></td>');
			if($Consulta=='3')
			{
				if(strtotime($dados['d_data_inicio'])>0)
				{
					$date_now	 = date("Y-m-d", time());
					$data_inicio = date("d-m-Y",strtotime($dados['d_data_inicio']));
					$data_final  = somar_dias_uteis($data_inicio,5,'');
					$conv_us_data_final = date_format(date_create_from_format('d-m-Y', $data_final),"Y-m-d");
					$diferenca =    strtotime($conv_us_data_final) - strtotime($date_now);
					$dias = floor($diferenca / (60 * 60 * 24));
					if($dias>0)
					{
						if($dias>1 && $dias<3){
							print('<td><text class="text-white bg-warning" style="font-size: 1.5vw">'.$data_inicio.'<text class="text-primary" style="font-size: 1.5vw"> Faltam '.$dias.' dia(s) ['.$data_final.']</text></td>');
						} else {
							print('<td><text class="text-primary " style="font-size: 1.5vw">'.$data_inicio.'<text class="text-primary" style="font-size: 1.5vw"> Faltam '.$dias.' dia(s) ['.$data_final.']</text></td>');
						}
					} else {
							if($dias<0){
								print('<td class="text-dask bg-danger"><text class="text-dask bg-danger" style="font-size: 1.5vw">'.$data_inicio.' Atraso '.abs($dias).' dia(s) ['.$data_final.']</text></td>');
							} else {
								if($dias==0){
									print('<td  class="text-dark bg-warning" style="font-size: 1.5vw">Hoje  '.$data_inicio.', ['.$data_final.']</td>');
								} 
							}
					}
				}
			} else {
				if($Consulta=='7')
				{
					if(strtotime($dados['d_data_inicio'])>0)
					{
						$date_now	 = date("Y-m-d", time());
						$data_inicio = date("d-m-Y",strtotime($dados['d_data_inicio']));
						$data_final  = somar_dias_uteis($data_inicio,5,'');
						$conv_us_data_final = date_format(date_create_from_format('d-m-Y', $data_final),"Y-m-d");
						$diferenca =    strtotime($conv_us_data_final) - strtotime($date_now);
						$dias = floor($diferenca / (60 * 60 * 24));
						if($dias>0)
						{
							if($dias>1 && $dias<3){
								print('<td><text class="text-white bg-warning" style="font-size: 1.5vw">'.$data_inicio.'<text class="text-primary" style="font-size: 1.5vw"> Faltam '.$dias.' dia(s) ['.$data_final.']</text></td>');
							} else {
								print('<td><text class="text-primary " style="font-size: 1.5vw">'.$data_inicio.'<text class="text-primary" style="font-size: 1.5vw"> Faltam '.$dias.' dia(s) ['.$data_final.']</text></td>');
							}
						} else {
								if($dias<0){
									print('<td class="text-dask bg-primary"><text class="text-dask bg-primary" style="font-size: 1.5vw">'.$data_inicio.' Atraso '.abs($dias).' dia(s) ['.$data_final.']</text></td>');
								} else {
									if($dias==0){
										print('<td  class="text-dark bg-primary" style="font-size: 1.5vw">Hoje  '.$data_inicio.', ['.$data_final.']</td>');
									} 
								}
						}
						//print('<td class="text-dask bg-danger"><text class="text-dask bg-danger" style="font-size: 1.5vw">'.$conv_us_data_final.' ,'.$date_now.' ,'.$dias.'</text></td>');
					}
				} else {
					if(strtotime($dados['d_data_limite'])>0)
					{
					$date_now	 = strtotime(date("Y-m-d", time()));
					$date_limite = strtotime($dados['d_data_limite']);
					$diferenca =  $date_limite - $date_now ;
					$dias = floor($diferenca / (60 * 60 * 24));
					if($dias>0){
							print('<td><text class="text-white" style="font-size: 1.5vw">'.date('d-m-Y',$date_limite).'<text class="text-primary" style="font-size: 1.5vw"> Faltam '.$dias.' dia(s)</text></td>');
						} else {
							if($dias<0){
								print('<td class="text-dask bg-danger"><text class="text-dask bg-danger" style="font-size: 1.5vw">'.date('d-m-Y',$date_limite).' Atraso '.abs($dias).' dia(s)</text></td>');
							} else {
								if($dias==0){
									print('<td  class="text-dark bg-warning" style="font-size: 1.5vw">Hoje  '.date('d-m-Y',$date_limite).'</td>');
								} 
							}
						}
					} else {
						print('<td><text class="text-light" style="font-size: 1.2vw">SEM DATA</text></td>');
					}
				}
			}
		}	
	}
	print('</tr>');
}
print('</tbody>');
print('</div>');
print('</table>');
mysql_free_result ( $result );
?>



