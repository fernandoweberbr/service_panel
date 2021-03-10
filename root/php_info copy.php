<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <meta name="description" content="">
  <meta name="author" content="Fernando Weber">
  <title>SERVICOS</title>
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
?>

<body id="page-top">
<div class="col-xl-0 col-sm-0 mb-0">
    <div class="card bg-dark text-white text-center display-5  w-0 h-0  p-0" >setor</div>
</div>

<script type="text/javascript">
    $( document ).ready(function() {
        loadxml = "http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao/";
        if (window.DOMParser) { // Demais Navegadores
            parser = new DOMParser();
            xmlDoc = parser.parseFromString(loadxml, "text/xml")
        } else { // Internet Explorer
            xmlDoc = new ActiveXObject("Microsoft.XMLDOM")
            xmlDoc.async = false;
            xmlDoc.loadXML(loadxml);
        }
    });
    </script>
    </body> 
</html>
