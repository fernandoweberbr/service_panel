<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Formulário Cadastro</title>
</head>

<body>

<form name="cadastro" method="post" action="cadastrar.php">

Nome
<input name="nome" type="text" id="nome" value="<?php echo $nome; ?>" /><br />

Sobrenome
<input name="sobrenome" type="text" id="sobrenome" value="<?php echo $sobrenome; ?>" /><br />
Email

<input name="email" type="text" id="email" value="<?php echo $email; ?>" /><br />
Nome de Usuário

<input name="usuario" type="text" id="usuario" value="<?php echo $usuario; ?>" /><br />

+ informações sobre você

<textarea name="info" id="info"><?php echo $info; ?></textarea> <br />

<input type="submit" name="Submit" value="Enviar" /> <br />

</form>

</body>
</html>