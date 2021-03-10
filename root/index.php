<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <meta name="description" content="">
  <meta name="author" content="Fernando Weber">
  <title>SERVICE EFFECTIVE</title>
  <!-- Bootstrap core CSS-->
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">
  <script src="vendor/jquery/jquery.min.js"></script>   
  <script src="js/chart.js"></script>   
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>   
  <style type="text/css">
    body { background: gray ; } /* Adding !important forces the browser to overwrite the default style applied by Bootstrap */
  </style>
</head>
<?php
//error_reporting(0);
//$GLOBALS['$xml_global']=$xml_filesimple;
//$xml_file=simplexml_load_file("http://192.168.1.7:8091/API/D/1.0/1ACB8494B500241130775AE530523063/Producao/DevolverOrdensProducao/") or die("Error: Cannot create objec1t");
//$GLOBALS['$xml_global']=$xml_file;
include_once("calcula_datas.php");
include_once("./mysqlreflection-master/mysqlreflection.config.php");
//$cnt = 0;
$array_of_items=array();
$conexao = mysql_connect(DBHOST,DBUSER,DBPASSWORD);  
mysql_select_db(DBNAME); 
$squery = "SELECT setor.setor_alias,setor.id FROM setor WHERE setor.habilita = 1 GROUP BY setor.setor_alias ";
$result = mysql_query($squery) or die(mysql_error());
while($dados = mysql_fetch_array($result))
{
    array_push($array_of_items,$dados);
}  
mysql_free_result ( $result );  



//$hourly = EvPeriodic(0, 10, NULL, function () {echo  "<script>alert('10 segundos!);</script>";});


?>

    <body id="page-top">
    <div class="carousel slide carousel-fade" id="CarouselRoll" data-ride="carousel" data-interval="8000" >
		<div class="carousel-inner" id="CarrouselItens" >
        </div>
		    <a class="carousel-control-prev" href="#CarouselRoll" role="button" data-slide="prev" >
	    		<span class="carousel-control-prev-icon" aria-hidden="true"></span>'
    			<span class="sr-only">Previous</span>
		    </a>
		    <a class="carousel-control-next" href="#CarouselRoll" role="button" data-slide="next" >
			    <span class="carousel-control-next-icon" aria-hidden="true"></span>
			    <span class="sr-only">Next</span>
		    </a>
	    <div id="CarrCount">
	    </div>
    </div>
    <script type="text/javascript">
    $( document ).ready(function() 
    {
        var $carrosseldiv = $("#CarrouselItens");
        var BuscaItens = "list_setor.php?";
        $carrosseldiv.load(BuscaItens);
        var ChangeTwice=0;
        var NovoCount=0;
        var $Alias = $("#ItemAlias3");
        var Consulta = "list_atividade.php?consulta=0";
        $Alias.load(Consulta);
        var SetoresCnt = $("#CarrCount");
        var ConsultaSetorCnt = "list_cnt_setor.php";
        SetoresCnt.load(ConsultaSetorCnt);
        $('#CarouselRoll').on('slid.bs.carousel', function (e) 
        {
            var SetoresCnt = $("#CarrCount");
            var ConsultaSetorCnt = "list_cnt_setor.php";
            SetoresCnt.load(ConsultaSetorCnt);
            var Carr_cnt = document.getElementsByClassName("CarroselMaxItens")[0];
            var Count = Carr_cnt.attributes["value"].value;
            var currentIndex = $('div.active').index();
            var x = document.getElementsByClassName("atividades")[currentIndex];
            var v = x.attributes["value"].value;
            var $card = $("#ItemAlias"+v);
            var Consulta = "list_atividade.php?consulta="+v;
            $card.load(Consulta);


            console.log( 'max itens=',Count );   
            console.log( 'idx itens=',currentIndex );   
            if(Count != NovoCount)
            {
                if(ChangeTwice==0)
                {
                    ChangeTwice=1;
                    NovoCount=Count;
                } else {
                    //location.reload();
                }
            }
        });
    });
    </script>
    </body> 
</html>
