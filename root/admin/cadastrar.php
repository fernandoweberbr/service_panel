<?php

include "config.php";

$nome = trim($_POST['nome']);
$sobrenome = trim($_POST['sobrenome']);
$email = trim($_POST['email']);
$usuario = trim($_POST['usuario']);
$info = trim($_POST['info']);

/* Vamos checar algum erro nos campos */

if ((!$nome) || (!$sobrenome) || (!$email) || (!$usuario)){

echo "ERRO: <br /><br />";

if (!$nome){

echo "Nome é requerido.<br />";

}

if (!$sobrenome){

echo "Sobrenome é requerido.<br /> <br />";

}

if (!$email){

echo "Email é um campo requerido.<br /><br />";

}

if (!$usuario){

echo "Nome de Usuário é requerido.<br /><br />";

}

echo "Preencha os campos abaixo: <br /><br />";

include "formulario_cadastro.php";

}else{

/* Vamos checar se o nome de Usuário escolhido e/ou Email já existem no banco de dados */

$sql_email_check = mysql_query(

"SELECT COUNT(usuario_id) FROM usuarios WHERE email='{$email}'"

);

$sql_usuario_check = mysql_query(

"SELECT COUNT(usuario_id) FROM usuarios WHERE usuario='{$usuario}'"

);

$eReg = mysql_fetch_array($sql_email_check);
$uReg = mysql_fetch_array($sql_usuario_check);

$email_check = $eReg[0];
$usuario_check = $uReg[0];

if (($email_check > 0) || ($usuario_check > 0)){

echo "<strong>ERRO</strong>: <br /><br />";

if ($email_check > 0){

echo "Este email já está sendo utilizado.<br /><br />";

unset($email);

}

if ($usuario_check > 0){

echo "Este nome de usuário já está sendo
utilizado.<br /><br />";

unset($usuario);

}

include "formulario_cadastro.php";

}else{

/* Se passarmos por esta verificação ilesos é hora de
finalmente cadastrar os dados. Vamos utilizar uma função para gerar a senha de
forma randômica*/

function makeRandomPassword(){

$salt = "abchefghjkmnpqrstuvwxyz0123456789";
srand((double)microtime()*1000000);
$i = 0;

while ($i <= 7){

$num = rand() % 33;
$tmp = substr($salt, $num, 1);
$pass = $pass . $tmp;
$i++;

}

return $pass;

}

$senha_randomica = makeRandomPassword();
$senha = md5($senha_randomica);

// Inserindo os dados no banco de dados

$info = htmlspecialchars($info);

$sql = mysql_query(

"INSERT INTO usuarios
(nome, sobrenome, email, usuario, senha, info, data_cadastro)

VALUES
('$nome', '$sobrenome', '$email', '$usuario', '$senha', '$info', now())")

or die( mysql_error()

);

if (!$sql){

echo "Ocorreu um erro ao criar sua conta, entre em contato.";

}else{

$usuario_id = mysql_insert_id();

// Enviar um email ao usuário para confirmação e ativar o cadastro!

$headers = "MIME-Version: 1.0\n";
$headers .= "Content-type: text/html; charset=iso-8859-1\n";
$headers .= "From: Teu Domínio - Webmaster<email@teusite.com.br>";

$subject = "Confirmação de cadastro - teusite.com.br";
$mensagem = "Prezado {$nome} {$sobrenome},<br />
Obrigado pelo seu cadastro em nosso site, <a href='http://www.teusite.com.br'>
http://www.teusite.com.br</a>!<br /> <br />

Para confirmar seu cadastro e ativar sua conta em nosso site, podendo acessar à
áreas exclusivas, por favor clique no link abaixo ou copie e cole na barra de
endereço do seu navegador.<br /> <br />

<a href='http://www.teusite.com.br/ativar.php?id={$usuario_id}&code={$senha}'>

http://www.teusite.com.br/ativar.php?id={$usuario_id}&code={$senha}

</a>

<br /> <br />
Após a ativação de sua conta, você poderá ter acesso ao conteúdo exclusivo
efetuado o login com os seguintes dados abaixo:<br > <br />

<strong>Usuario</strong>: {$usuario}<br />
<strong>Senha</strong>: {$senha_randomica}<br /> <br />

Obrigado!<br /> <br />

Webmaster<br /> <br /> <br />
Esta é uma mensagem automática, por favor não responda!";

mail($email, $subject, $mensagem, $headers);

echo "Foi enviado para seu email - ( ".$email." ) um pedido de
confirmação de cadastro, por favor verifique e sigas as instruções!";

}

}

}

?>