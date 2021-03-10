<!DOCTYPE html>
<html>
<?php
    include_once('head.php');
    include_once("../mysqlreflection-master/mysqlreflection.config.php");
    session_start(); // Inicia a session
    include "functions.php"; // arquivo de funções.
    session_checker(); // chama a função que verifica se a session iniciada da acesso à página.
    $cnt = 0;
    $array_of_items=array();
    $conexao = mysql_connect(DBHOST,DBUSER,DBPASSWORD);  
    mysql_select_db(DBNAME); 

    function admin_load_op_from_url()
    {


    }

    function admin_load_op_from_file()
    {
        //$xml_local = simplexml_load_file("../ordem.xml") or die("Error: Cannot create objec1t"); 
        $squery_atividades = "SELECT atividade.ordem as ordem, atividade.finalizada as finalizada FROM atividade";
        
    }

   /*
    function admin_check_new_ordem()
    {
        //session_checker(); // chama a função que verifica se a session iniciada da acesso à página.
        
        global  $xml_local;
        $xml_stringfile= file_get_contents("http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao/");
        //$xml_removexmlns = preg_replace('/xmlns[^=]*="[^"]*"/i', '', $xml_stringfile);
        $xml_local = simplexml_load_string($xml_stringfile) or die("Error: Cannot create objec1t"); 
        //$xml_pedidos = simplexml_load_file("http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Pedidos/DevolverItensPedidos/") or die("Error: Cannot create objec1t"); 
        //$xml_local = simplexml_load_file("http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao/") or die("Error: Cannot create objec1t"); 
        //echo count($xml_local->Conteudo->ListaDeRetorno->Retorno);
        //$xml_local = simplexml_load_file("../ordem.xml") or die("Error: Cannot create objec1t"); 
        //$cnt_xml_reg=count($xml_local->Conteudo->ListaDeRetorno->Retorno);
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
                if(strcmp($ConcatOrdemLinha,trim($atividades_fetch[$j]['ordem']))==0)
                {
                    if($atividades_fetch[$j]['finalizada']==1)
                    {
                        //$sql = "Update atividade set finalizada = " .$_GET["check"]. " WHERE id= ".$_GET["id"].";";
                        $sql_query = "SELECT atividade.id AS id FROM atividade WHERE atividade.ordem = ". $atividades_fetch[$j]["ordem"] . ";";
                        //echo $sql_query;
                        $result_sel = mysql_query($sql_query) or die("error select atividade");
                        $row = mysql_fetch_array($result_sel);
                        //echo $row['id'];
                        $sql = "Update atividade set finalizada = 0  WHERE  id= '" . $row['id'] . "';";
                        //echo $sql;
                        $result = mysql_query($sql) or die("error to update atividade data");
                    } else {
    
                    }	
                    //echo "<". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM .">";
                    //echo "[".$atividades_fetch[$j]['ordem']."]</br>";
                    break;
                } else {
                    
                        $sql_query = "select atividade.id as id from atividade where ordem = '". $atividades_fetch[$j]["ordem"] . "';";
                        $result_sel = mysql_query($sql_query) or die("error select atividade");
                        $row = mysql_fetch_array($result_sel);
                        $sql = "Update atividade set finalizada = 1  WHERE id= '" . $row['id'] . "';";
                        $result = mysql_query($sql) or die("error to update atividade data");
                       
                        
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
                //echo $squery_atividades .'</br>';
                //print_r ($xml_func2);
                
    
               
                $sql_query = "select atividade.id as id from atividade where ordem = '". $atividades_fetch[$j]["ordem"] . "';";
                $result_sel = mysql_query($sql_query) or die("error select atividade");
                $row = mysql_fetch_array($result_sel);
                echo $row;
                
                if($row)
                {
                    //echo $row['id'];
                    $sql = "Update atividade set finalizada = 1  WHERE id= '" . $row['id'] . "';";
                    echo "Registro Encontrado!";
                    $result = mysql_query($sql) or die("error to update atividade data");
                } else {
                    echo "Novo registro!";
                    //echo "Nova Ordem <". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM ."></br>";
                    $squery_atividades = "INSERT INTO atividade (ordem,descricao,realizada,finalizada,aviso,data_inicio,data_limite,fk_setor,fk_usuario,fk_importancia) VALUES (" . "'" . $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM . 
                    "','" . $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_PRODDESC . "'" . ", 0 , 0 , '   ', 0 , 0 , 9, 16, 3);";
                    $result_atividades = mysql_query($squery_atividades) or die(mysql_error()); 
                }
               
                // VALUES (\"". $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_ORDEM . "\",\"" . $xml_func2->Conteudo->ListaDeRetorno->Retorno[$i]->OPB001_PRODDESC . "\",0,0,"  ",0,0);";
                //echo $squery_atividades."</br>";
            } else {
                //echo " Dentro  ". $atividades_fetch[$j]["ordem"].",";
            }
        }
    }
    admin_check_new_ordem();
    */
?>

<body>
    <div>
		<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="mi-modal">
		<div class="modal-dialog modal-sm">
		<div class="modal-content">
		<div class="modal-header">
		    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title" id="myModalLabel">Confirma Sair</h4>
		</div>
		<div class="modal-footer">
			<button type="button" class="btn btn-default" id="modal-btn-si">Sim</button>
			<button type="button" class="btn btn-primary" id="modal-btn-no">Nao</button>
		</div>
		</div>        
    	</div>        
    	</div>        
   	</div>        

    <div class="row">
        <div class="container-fluid">
            <div class="col-sm-0">
            <div class="well clearfix">
            <p class="nav-link btn btn-lg btn-outline-dark text-left" style="font-size:20px;"> <span class="glyphicon glyphicon-user"> <?php echo $_SESSION['nome'];  ?>         
            <button class="btn btn-default" id="btn-confirm">Sair</button></span></p>
            <?php if ($_SESSION['nivel_usuario'] == 1){ ?>
                    <!-- Button for booking -->
                    <!-- <p class="nav-link btn btn-lg btn-outline-dark text-left" style="font-size:20px;" id="myButton5"> <span class="glyphicon glyphicon-th-list"> Ordens Effective </span></p> -->
                    <p class="nav-link btn btn-lg btn-outline-dark text-left" style="font-size:20px;" id="myButton6"> <span class="glyphicon glyphicon-th-list"> Geral Assistencia </span></p>
                    <p class="nav-link btn btn-lg btn-outline-dark text-left" style="font-size:20px;" id="myButton2"> <span class="glyphicon glyphicon-th-list"> Todas Atividades </span></p>
                    <p class="nav-link btn btn-lg btn-outline-dark text-left" style="font-size:20px;" id="myButton3"> <span class="glyphicon glyphicon-th-list"> Todas Finalizadas </span></p>
                    <p class="nav-link btn btn-lg btn-outline-dark text-left" style="font-size:20px;" id="myButton1"> <span class="glyphicon glyphicon-th-list"> Todos Usuarios </span></p>
                    <p class="nav-link btn btn-lg btn-outline-dark text-left" style="font-size:20px;" id="myButton4"> <span class="glyphicon glyphicon-th-list"> Todos Setores </span></p>
            <?php }?>
        </div>
        </div>
        </div>
        <div class="col-sm-2">
            <div class="card" id="taska">
			</div>
        </div>
        <div class="container-fluid">
            <!-- Button for direktaction -->
            <div class="embed-responsive embed-responsive-4by3" allowfullscreen>
                <iframe class="embed-responsive-item" src="atividade_sql.php" id="nav_frame"></iframe>
            </div>
        </div>
    </div>

<script type="text/javascript">
   
    $(document).ready(function (e) 
    {
        $("#myButton1").on('click', function (e) {
            $('#nav_frame').attr( "src","usuario_sql.php");
            $("#taska",window.parent.document).load("list_task.php",function(e){});
        })
        $("#myButton2").on('click', function (e) {
            $('#nav_frame').attr( "src","atividade_sql.php");
            $("#taska",window.parent.document).load("list_task.php",function(e){});
        })
        $("#myButton3").on('click', function (e) {
            $('#nav_frame').attr( "src","atividade_finalizada_sql.php");
            $("#taska",window.parent.document).load("list_task.php",function(e){});
        })
        $("#myButton4").on('click', function (e) {
            $('#nav_frame').attr( "src","setor_sql.php");
            $("#taska",window.parent.document).load("list_task.php",function(e){});
        })
        $("#myButton5").on('click', function (e) {
            $('#nav_frame').attr( "src","effective_sql.php");
            $("#taska",window.parent.document).load("list_task.php",function(e){});
        })
        $("#myButton6").on('click', function (e) {
            $('#nav_frame').attr( "src","assistencia_sql.php");
            $("#taska",window.parent.document).load("list_task.php",function(e){});
        })
        $("#taska",window.parent.document).load("list_task.php",function(e){});
    });
    function Consulta_User(clicked_value) 
    {
        $('#nav_frame').attr( "src","list_task.php?consulta_user="+clicked_value);
        $("#taska",window.parent.document).load("list_task.php",function(e){});
        //alert(clicked_value);
    }

    var modalConfirm = function(callback){
		$("#btn-confirm").on("click", function()
		{
			$("#mi-modal").modal('show');
		});
		$("#modal-btn-si").on("click", function(){
			callback(true);
			$("#mi-modal").modal('hide');
		});
		$("#modal-btn-no").on("click", function(){
			callback(false);
			$("#mi-modal").modal('hide');
		});
    };


    modalConfirm(function(confirm)
    {
        if(!confirm){
            $(document).load('logout.php?logmeout');
        }else{
	        javascript:history.go(-1);
        }
    });

</script>
</body>
</html>