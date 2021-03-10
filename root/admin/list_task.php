<?php
session_start(); // Inicia a session
include "functions.php"; // arquivo de funções.
session_checker(); // chama a função que verifica se a session iniciada da acesso à página.
include_once("../mysqlreflection-master/mysqlreflection.config.php");
$conexao = mysql_connect(DBHOST,DBUSER,DBPASSWORD);  
mysql_select_db(DBNAME); 
$array_of_items_pendentes=array();
$array_of_items_realizados=array();
/*
$servidor = "localhost"; 
$usuario = "root"; 
$senha = "usbw"; 
$banco = "pcp"; 
*/

if(isset($_GET['consulta_user']))
{
    if($_GET['consulta_user'] != NULL)
    {
        $Consulta = $_GET['consulta_user'];
        //$conexao = mysql_connect($servidor,$usuario,$senha);  
        //mysql_select_db($banco); 
        $squery = "SELECT 
        usuario.usuario_alias AS user_alias,  
        atividade.id AS id,  
        atividade.ordem AS num_ordem,  
        atividade.data_limite AS d_data_limite,  
        atividade.realizada, atividade.finalizada, 
        atividade.descricao AS at_descricao, 
        atividade.fk_importancia AS prioridade, 
        setor.setor_alias AS setor_alias, 
        importancia.nome AS alias_prioridade 
        FROM atividade  
        INNER JOIN usuario ON usuario.id = atividade.fk_usuario 
        INNER JOIN setor ON setor.id = atividade.fk_setor 
        INNER JOIN importancia ON importancia.id = atividade.fk_importancia 
        WHERE atividade.fk_usuario = ".  $Consulta . " AND atividade.finalizada = '0' 
        ORDER BY usuario.usuario_alias ASC , prioridade ASC, d_data_limite ASC, atividade.ordem ASC;"; 
        $result = mysql_query($squery) or die(mysql_error()); 

        $dateshow=date("d-m-Y", time());
        print('<html>');
        include_once('head.php');
        print('<body>');
        print('<div class="container-fluid">');
        print('<div class="table-condensed row justify-content-md-center ">');
        print('<table class="table-condensed table-bordered " style="background-color: white" id="user_grid" width="100%" cellspacing="0" padding="5"> ');
        print('<thead>');
        print('<tr>');
            print('<th><p class="text-light" style="font-size: 1.0vw"></th>');
            print('<th><p class="text-light" style="font-size: 1.0vw"></th>');
            print('<th><p class="text-light" style="font-size: 1.0vw">Ordem</th>');
            print('<th><p class="text-light" style="font-size: 1.0vw">Descricao</th>');
            print('<th><p class="text-light" style="font-size: 1.0vw">Data</th>');
        print('</tr>');
        print('</thead>');
        print('<tbody>');
           
                    while($dados = mysql_fetch_array($result))
					{	
                        print('<tr>');
                        if($dados['realizada']=='1')
                        {
                            if ($_SESSION['nivel_usuario'] == 1)
                            {
                            print('<td>
                                <button type="button" class="btn  btn-lg btn-default " id="'.$dados['id'].'" onClick="realizar_desativar(this.id)" value="0"  ><span class="text-success glyphicon glyphicon-ok"></span></button>
                                <button type="button" class="btn  btn-lg btn-default " id="'.$dados['id'].'" onClick="finalizar(this.id)" value="0"  ><span class="text-success glyphicon glyphicon-thumbs-up"></span></button>
                            </td>');
                            } else {
                                print('<td>
                                <button type="button" class="btn  btn-lg btn-default " id="'.$dados['id'].'" onClick="realizar_desativar(this.id)" value="0"  ><span class="text-success glyphicon glyphicon-ok"></span></button>
                            </td>');
                            }
                            print('<td><text class="text-success" style="font-size: 1.5vw">'.$dados['user_alias'].'</text></td>');
                            print('<td><text class="text-success" style="font-size: 1.5vw">'.$dados['num_ordem'].'</text></td>');
                            print('<td><text class="text-success" style="font-size: 1.5vw">'.$dados['at_descricao'].'</text></td>');
                            print('<td><text class="text-success" style="font-size: 1.5vw"> Realizado </text></td>');
			                print('<td><text class="text-light" style="font-size: 1.5vw"></p></h3></td>');    
		                } else {
                            print('<td>
                                <button type="button" class="btn btn-lg btn-default" id="'.$dados['id'].'" onClick="realizar_ativar(this.id)" value="1"   ><span class="text-primary glyphicon glyphicon-repeat"></span></button>
                            </td>');
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
                        }
                        print('</tr>');
                    }
        print('</tbody>');
        print('</table>');
        print('</div>');
        print('</div>');
        ?>
        <script type="text/javascript">
            function update_realiza(id,value) 
            {
                $.ajax({
                        url:'/admin/update_realiza.php?check='+value+'&id='+id,
                        complete: function (response) 
                        {
                            $("#taska",window.parent.document).load("list_task.php",function(e)
		                    {
			                    console.log("task");
		                    });
                            //window.top.location.reload();
                            window.location.reload();
                            //alert("ok");
                            //$('#output').html(response.responseText);
                        },
                        error: function () {
                            alert("Erro!");
                            //$('#output').html('Bummer: there was an error!');
                        }
                });
                return false;
            }
            function update_finaliza(id,value) 
            {
                $.ajax({
                        url:'/admin/update_finaliza.php?check='+value+'&id='+id,
                        complete: function (response) 
                        {
                            $("#taska",window.parent.document).load("list_task.php",function(e)
		                    {
			                    console.log("task");
		                    });
                            //window.top.location.reload();
                            window.location.reload();
                            //alert("ok");
                            //$('#output').html(response.responseText);
                        },
                        error: function () {
                            alert("Erro!");
                            //$('#output').html('Bummer: there was an error!');
                        }
                });
                return false;
            }
            
            function realizar_ativar(id_value) 
            {
                //alert(id_value);
                update_realiza(id_value,1);
            }
            function realizar_desativar(id_value) 
            {
                //alert(id_value);
                update_realiza(id_value,0);
            }
            function finalizar(id_value) 
            {
                //alert(id_value);
                update_finaliza(id_value,1);
            }
        </script> 
        <?php
        print('</body>');
        print('</html>');
    } 
} else {
    //$conexao = mysql_connect($servidor,$usuario,$senha);  
    //mysql_select_db($banco); 
    $squery = "SELECT 
    usuario.id as usuario_id,
    usuario.usuario_alias ,
    atividade.realizada ,
    atividade.finalizada ,
    COUNT(*) AS tarefas
    FROM atividade 
    INNER JOIN usuario ON usuario.id=atividade.fk_usuario 
    INNER JOIN setor ON setor.id=atividade.fk_setor 
    WHERE atividade.fk_setor IN (SELECT atividade.fk_setor FROM atividade ) AND atividade.realizada=0 AND atividade.finalizada=0
    GROUP BY usuario.usuario_alias, atividade.finalizada ,atividade.realizada
    ORDER BY usuario.usuario_alias";
    $result_pendentes = mysql_query($squery) or die(mysql_error()); 
	
	$squery = "SELECT 
    usuario.id as usuario_id,
    usuario.usuario_alias ,
    atividade.realizada ,
    atividade.finalizada ,
    COUNT(*) AS tarefas
    FROM atividade 
    INNER JOIN usuario ON usuario.id=atividade.fk_usuario 
    INNER JOIN setor ON setor.id=atividade.fk_setor 
    WHERE atividade.fk_setor IN (SELECT atividade.fk_setor FROM atividade ) AND atividade.realizada=1 AND atividade.finalizada=0
    GROUP BY usuario.usuario_alias, atividade.finalizada ,atividade.realizada
    ORDER BY usuario.usuario_alias";
    $result_realizados = mysql_query($squery) or die(mysql_error()); 
	
    while($dados_pendentes = mysql_fetch_array($result_pendentes))
    {
        array_push($array_of_items_pendentes,$dados_pendentes);
    }  
    while($dados_realizados = mysql_fetch_array($result_realizados))
    {
        array_push($array_of_items_realizados,$dados_realizados);
    }  
    
        foreach ( $array_of_items_pendentes as $item_value_p )
        {
                print_r('<div class="col-lg-0" ">');
                print_r('<a class="nav-link btn btn-lg btn-outline-dark text-left" style="font-size:16px;" id="'.$item_value_p['usuario_id'].'"onClick="Consulta_User(this.id)" >');
                print_r('<span class="glyphicon glyphicon-repeat"></span>  <span class="label label-primary style="font-size:16px;" ">'.$item_value_p['tarefas'].'</span>');
                foreach ( $array_of_items_realizados as $item_value_r )
                {
                    if($item_value_p['usuario_id']==$item_value_r['usuario_id'])
                    {
                        //print_r('<span class="label label-success" >'.$item_value_r['tarefas'].'</span>');
                    } 
                }
                print_r('   '.$item_value_p['usuario_alias'].'</a></div>');
        }
        foreach ( $array_of_items_realizados as $item_value_r )
        {
                if($item_value_r['tarefas'])
                {
                    print_r('<div class="col-lg-0" >');
                    print_r('<a class="nav-link btn btn-lg btn-outline-dark text-left "style="font-size:16px;" id="'.$item_value_r['usuario_id'].'"onClick="Consulta_User(this.id)" >');
                    print_r('<span class="glyphicon glyphicon-ok text-success"></span>  <span class="label label-success style="font-size:16px;" ">'.$item_value_r['tarefas'].'</span>');
                    print_r('   '.$item_value_r['usuario_alias'].' </span></a></div>');
                }
        }
}
?>