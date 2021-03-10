<?php

session_start(); // Inicia a session

include "config.php";
error_reporting(E_ERROR | E_WARNING | E_PARSE);
$usuario = $_POST['usuario'];
$senha   = $_POST['senha'];

if ((!$usuario) || (!$senha)){

echo "<h1>Por favor, todos campos devem ser preenchidos!</h1> <br /><br />";

include "formulario_login.php";

}else{

include_once("../mysqlreflection-master/mysqlreflection.config.php");
$conexao = mysql_connect(DBHOST,DBUSER,DBPASSWORD);  
mysql_select_db(DBNAME); 

$senha = md5($senha);
echo $senha;
$sql = mysql_query(

"SELECT * FROM usuario
WHERE nome='{$usuario}'
AND senha='{$senha}'
AND ativado='1'"

);

$login_check = mysql_num_rows($sql);

if ($login_check > 0){

while ($row = mysql_fetch_array($sql)){

foreach ($row AS $key => $val){

$$key = stripslashes( $val );

}

$_SESSION['id'] = $usuario_id;
$_SESSION['nome'] = $nome;
$_SESSION['alias'] = $sobrenome;
$_SESSION['email'] = $email;
$_SESSION['nivel_usuario'] = $nivel_usuario;

mysql_query(

"UPDATE usuario SET data_ultimo_login = now() WHERE id ='{$usuario_id}'"

);

header("Location: index.php");

}

}else{

echo "Usuario ou Senha Invalidos!<br />";

include "formulario_login.php";

}

}

?>