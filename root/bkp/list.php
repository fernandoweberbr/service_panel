<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>DETRONIX</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

  <script src="vendor/jquery/jquery.min.js"></script>   
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>   
  <style type="text/css">
   body { background: black ; } /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
   </style>

</head>

<?php

print('<body id="page-top">');
    print('<div id="wrapper">');
        print('<div id="content-wrapper" >');
            print('<div class="container-fluid">');
            print('<div class="" id="list_atividade" >');
            print('</div>'); //  class="container-fluid
            print('</div>'); //  class="container-fluid
        print('</div>'); //  id="content-wrapper"
    print('</div>'); //  div id="wrapper"
?>
    <script>
    $(document).ready(function() {
        var $card = $("#list_atividade");
            var Consulta = "list_atividade.php?"
            console.log(Consulta);
            $card.load(Consulta);      
    } );
    </script>
</html>
