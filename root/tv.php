<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <meta name="description" content="">
  <meta name="author" content="Fernando Weber">
  <title>TV DASHBOARD</title>
  <!-- Bootstrap core CSS-->
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="../vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="../css/sb-admin.css" rel="stylesheet">
  <script src="../vendor/jquery/jquery.min.js"></script>   
  <script src="../vendor/bootstrap/js/bootstrap.bundle.min.js"></script>   
  <style type="text/css">
  </style>
	<script type="text/javascript">
	</script>
</head>
<html>
  <body>
  <div id="Main" style="height:100px;" class="span12">
  <?php
  error_reporting(0);
  require_once('/debug/PtcDebug.php');
  require_once('/debug/PtcEvent.php');
  $_GET['debug']=true;        // turn on the debug
  $debug_options=array
  (
  'session_start'             =>    true,
  'replace_error_handler'     =>    true,    // replace error handler
  'die_on_error'              =>    false,    // continue if fatal error
  'debug_console'             =>    true,    // send buffer to js console
  'check_referer'             =>    true,    // check if referer has key and pass.
  );
  PtcDebug::load($debug_options);
  include_once("./mysqlreflection-master/beans/BeanAtividade.php");
  $bean = new BeanAtividade();
  $bean->select(1502);


  
 //print_r($ConsultaAtividade->select('1502'));
 //print_r($ConsultaAtividade->$descricao);

 ?>
</div>
</body>
</html>
