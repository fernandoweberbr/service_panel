<?php
$servidor = "localhost"; 
$usuario = "root"; 
$senha = "usbw"; 
$banco = "pcp"; 
$conexao = mysql_connect($servidor,$usuario,$senha);  
        mysql_select_db($banco); 
        //$Consulta = $_GET['consulta'];
        $squery = "SELECT setor.setor_alias, usuario.usuario_alias, atividade.ordem , atividade.data_inicio, atividade.data_limite, atividade.realizada, atividade.finalizada
                   FROM atividade
                   INNER JOIN usuario ON usuario.id = atividade.fk_usuario
                   INNER JOIN setor ON setor.id = atividade.fk_setor
                   ORDER BY setor.setor_alias";
                                            //print('<div class="table-responsive">');
                                            print('<div class="card mb-3">');
                                            print('<div class="card-header">');
                                            print('<i class="fas fa-table"></i>');
                                            print('Data Table Example</div>');
                                            print('<div class="card-body">');
                                            print('<div class="table-responsive">');
                                            print('<table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">');
                                            //print('<table class="row-border" id="dataTable" style="width:100%">');
                                            print('<thead>');
                                            print('<tr>');
                                            print('<th><h2>Setor</h2></th>');
                                            print('<th><h2>Ordem</h2></th>');
                                            print('<th><h2>Usuario</h2></th>');
                                            print('<th><h2>Data Inicio</h2></th>');
                                            print('<th><h2>Data Limite</h2></th>');
                                            print('<th><h2>Realizada</h2></th>');
                                            print('<th><h2>Finalizada</h2></th>');
                                            print('</tr>');
                                            print('</thead>');
                                            print('<tbody>');
                                            $result = mysql_query($squery) or die(mysql_error()); 
                                            while($dados = mysql_fetch_array($result))
                                            {
                                                print('<tr>');
                                                print('<td><h2>'.$dados['setor_alias'].'</h2></td>');
                                                print('<td><h2>'.$dados['ordem'].'</h2></td>');
                                                print('<td><h2>'.$dados['usuario_alias'].'</h2></td>');
                                                print('<td><h2>'.$dados['data_inicio'].'</h2></td>');
                                                print('<td><h2>'.$dados['data_limite'].'</h2></td>');
                                                print('<td><h2>'.$dados['realizada'].'</h2></td>');
                                                print('<td><h2>'.$dados['finalizada'].'</h2></td>');
                                                print('</tr>');
                                            }
                                            print('</tbody>');
                                           // print('</div>');
                                            print('</table>');
                                            print('</div>');
                                            print('</div>');
                                            print('<div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>');
                                            print('</div>');
                                            mysql_free_result ( $result );
?>