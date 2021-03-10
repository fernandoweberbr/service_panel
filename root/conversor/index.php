<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <meta name="description" content="">
  <meta name="author" content="Fernando Weber">
  <title>LIBCONV</title>
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
	$("#grid-basic1").bootgrid();
	$("#grid-basic2").bootgrid();
	</script>
</head>
<html>
<body>
<div id="Main" style="height:100px;" class="span12">
<h4>Conversor Arquivo Pick and Place Altium to TRI AOI</h4>
Os campos sma_code correspondem ao nome usado internamente na maquina AOI da TRI"<br>
Esse aplicativo busca na lista o campo code que é o codigo do sistema ERP do componente <br>
e converte para uma lista que pode ser facilmente usada na maquina de inspeção visual.<br>
Certifique-se de que na primeira linha exista os campos abaixo:
<h4>
Copie  e cole o conteudo do arquivo CAD pick and place logo apos clique em  "Converter"<p>
Logo abaixo estarao os link para download da coversão,A lista dos itens estara nos campos abaixo<p>
obs, para a maquina aoi não existe layer bottom <br>
então serão gerados arquivos com o layer em TOP porem separadados por nome.<br>
<br>
<table class="alert alert-warning">
<tr><th>code     </th><th>,Designator</th><th>,Center-X(mm)</th><th>,Center-Y(mm)</th><th>,Rotation</th><th>,Layer</th><th>,sma_code</th></tr>
<tr><th>414472002</th><th>,ALIVE1</th><th>,123.543</th><th>,33.232</th><th>,90</th><th>,TopLayer</th><th>,LED-0805-SUYG0805-VD</th></tr>
<tr><th>410461001</th><th>,C9</th><th>,42.1388</th><th>,8.3056</th><th>,180</th><th>,TopLayer</th><th>,CAP-MAB-10UF16V</th></tr>
<tr><th>410462001</th><th>,C10</th><th>,41.7068</th><th>,14.0208</th><th>,0</th><th>,TopLayer</th><th>,CAP-0805-100NFX50V</th></tr>
</h4>
</table>
    <form method="post">
    <br>
        <p><textarea name="xls" style="width: 1200px; height: 250px"></textarea></p>
        <p><input type="submit" value="Converter" > Clique aqui para converter </input> </p>
    </form> 
<?php
error_reporting(0);
require_once('textarea2csv.php');
if (isset($_POST['xls']) && trim($_POST['xls']) != '')
  {
    $csv  = new textarea_2_csv($_POST);
    // possibility to set the divider to another format
    //$csv->set_divider(chr(9));
    // $xls->set_divider(chr(9));
    // process data and save it with filename output
    $data = $csv->save_data('aoi/output');
    
  }

require_once('/DEBUG/PtcDebug.php');
$_GET['debug']=true;        // turn on the debug
$debug_options=array
(
'session_start'            =>    true,
'replace_error_handler'    =>    true,    // replace error handler
'die_on_error'            =>    false,    // continue if fatal error
'debug_console'        =>    true,    // send buffer to js console
'check_referer'            =>    true,    // check if referer has key and pass.
);
PtcDebug::load($debug_options);

$aoi_files = array("proj_top.aoi", "proj_bot.aoi");
foreach($aoi_files as $aoi){
   //$file_path = $aoi;
		//$file_date = filemtime ($file_path);
      echo '<div class="img-box">';
      echo '<file src="aoi/' . $aoi . '" width="200" alt="' .  pathinfo($aoi, PATHINFO_FILENAME) .'">';
      echo '<p><a href="download.php?file=' . urlencode($aoi) . '"><img src=aoi/mac.png>' . urlencode($aoi).'</a></p>';
      echo '</div>';
}


$P_code        = 255;
$P_Designator  = 255;
$P_CenterX     = 255;
$P_CenterY     = 255;
$P_Rotation    = 255;
$P_Layer       = 255;
$P_sma_code    = 255;
$Arr_Pos_Code  = 255;
$Arr_Pos_Des   = 255;
$Arr_Pos_Cntx  = 255;
$Arr_Pos_Cnty  = 255;
$Arr_Pos_Rot   = 255;
$Arr_Pos_Layer = 255;
$Arr_Pos_Sma   = 255;

$cnt            = 0;
$array_of_items = array();
$csvarray       = array();
$proc_array     = array();


$servidor = "localhost";
$usuario  = "root";
$senha    = "usbw";
$banco    = "conversor_tri";
$conexao  = mysql_connect($servidor, $usuario, $senha);
mysql_select_db($banco);
$squery = "SELECT * FROM aoi_conv";
$result = mysql_query($squery) or die(mysql_error());
while ($dados = mysql_fetch_array($result))
  {
    array_push($array_of_items, $dados);
  }
mysql_free_result($result);
function ffputcsv($hFile, $aRow, $sSeparator = ',', $sEnclosure = '"')
  {
    foreach ($aRow as $iIdx => $sCell)
        $aRow[$iIdx] = str_replace($sEnclosure, $sEnclosure . $sEnclosure, $sCell);
        fwrite($hFile, join($aRow, $sSeparator) . "\n");
  }
# Capturar posicao dos elementos dos campos para organizar o arquivo de saida AOI
# Open the File.
if (($handle = fopen("aoi/output.csv", "r")) !== FALSE)
  {
    # Set the parent multidimensional array key to 0.
    $nn = 0;
    while (($data_cmp = fgetcsv($handle, 1000, ",")) !== FALSE)
      {
        # Count the total keys in the row.
        $c = count($data_cmp);
        #Populate the multidimensional array.
        for ($x = 0; $x < $c; $x++)
          {
            
            if (strcmp($data_cmp[$x], "code") == 0)
              {
                $P_code       = $x;
                //$var='something';
                //log_msg($var,'testing a variable');
                //console("$P_code"+$P_code,1,$debug);
                $Arr_Pos_Code = $nn;
              }
            if (strcmp($data_cmp[$x], "Designator") == 0)
              {
                $P_Designator = $x;
                //print_r(',Designator='.$P_Designator.',');
                //console("$P_Designator"+$P_Designator,1,$debug);
                $Arr_Pos_Des  = $nn;
              }
            if (strcmp($data_cmp[$x], "Center-X(mm)") == 0)
              {
                $P_CenterX    = $x;
                //print_r(',P_CenterX='.$P_CenterX.'');
                $Arr_Pos_Cntx = $nn;
              }
            if (strcmp($data_cmp[$x], "Center-Y(mm)") == 0)
              {
                $P_CenterY    = $x;
                //print_r(',P_CenterY='.$P_CenterY.'');
                $Arr_Pos_Cnty = $nn;
              }
            if (strcmp($data_cmp[$x], "Rotation") == 0)
              {
                $P_Rotation  = $x;
                //print_r(',Rotation='.$P_Rotation.'');
                $Arr_Pos_Rot = $nn;
              }
            if (strcmp($data_cmp[$x], "Layer") == 0)
              {
                $P_Layer       = $x;
                //print_r(',Layer='.$P_Layer.'');
                $Arr_Pos_Layer = $nn;
              }
            if (strcmp($data_cmp[$x], "sma_code") == 0)
              {
                $P_sma_code  = $x;
                //print_r(',sma_code='.$P_sma_code.'');
                $Arr_Pos_Sma = $nn;
              }
          }
        $nn++;
      }
      if (($P_code != 255) && ($P_Designator != 255) && ($P_CenterX != 255) && ($P_CenterY != 255) && ($P_Rotation != 255) && ($P_Layer != 255) && ($P_sma_code != 255))
      {
        
        if ($Arr_Pos_Code == $Arr_Pos_Des && $Arr_Pos_Code == $Arr_Pos_Cntx && $Arr_Pos_Code == $Arr_Pos_Cnty && $Arr_Pos_Code == $Arr_Pos_Rot && $Arr_Pos_Code == $Arr_Pos_Layer && $Arr_Pos_Code == $Arr_Pos_Sma)
          {
            //print_r("</p>Campos Encontradados na posicao .$Arr_Pos_Code.");	
            if (($handle1 = fopen("aoi/output.csv", "r")) !== FALSE)
            # Set the parent multidimensional array key to 0.
              {
                $nn = 0;
                while (($data = fgetcsv($handle1, 1000, ",")) !== FALSE)
                {
                    # Count the total keys in the row.
                    $c = count($data);
                    #Populate the multidimensional array.
                    for ($x = 0; $x < $c; $x++)
                    {
                        //print_r($c);
                      $csvarray[$nn][$x] = $data[$x];
                    }
                    $nn++;
                }
                $cnt = 0;
                for ($y = ($Arr_Pos_Code + 1); $y < $nn; $y++)
                  {
                    $proc_array[$cnt] = $csvarray[($Arr_Pos_Code + 1) + $cnt];
                    $cnt++;
                  }
                $aoi_array        = array();
                $aoi_array_top    = (array) null;
                $aoi_array_bottom = (array) null;
                $top_c            = 0;
                $top_b            = 0;
                $z                = 0;
				        if (count($proc_array) == 0)
                {
                    die;
                }
				        foreach ($proc_array as $item_array)
                {
                  $found =0;
                  foreach ($array_of_items as $item_value)
                  {
                    if (!empty($item_array[$P_code]))
                    {
							          if (strcmp($item_array[$P_code], $item_value['code']) == 0)
                        {
								                $aoi_array[$z][0] = $item_array[$P_Designator];
								                $aoi_array[$z][1] = $item_array[$P_CenterX];
								                $aoi_array[$z][2] = $item_array[$P_CenterY];
								                $aoi_array[$z][3] = $item_array[$P_Rotation];
								                $aoi_array[$z][4] = $item_array[$P_Layer];
								                $aoi_array[$z][5] =  $item_value['sma_code'];
                                $z++;
                                $found=1;
            						  		  break;
						            }
                    } 
                  }
                  if($found==0){
                      $aoi_array[$z][0] = $item_array[$P_Designator];
                      $aoi_array[$z][1] = $item_array[$P_CenterX];
                      $aoi_array[$z][2] = $item_array[$P_CenterY];
                      $aoi_array[$z][3] = $item_array[$P_Rotation];
                      $aoi_array[$z][4] = $item_array[$P_Layer];
                      $aoi_array[$z][5] =  "CODIGO_ERRO";
                      $z++;
                  }
				        }
				        foreach ($aoi_array as $item_aoi)
                  {				  
                   
                    if (strcmp($item_aoi[4], "TopLayer") == 0)
                      {
                        $aoi_array_top[$top_c][0] = $item_aoi[0];
                        $aoi_array_top[$top_c][1] = $item_aoi[1];
                        $aoi_array_top[$top_c][2] = $item_aoi[2];
                        $aoi_array_top[$top_c][3] = $item_aoi[3];
                        $aoi_array_top[$top_c][4] = 'T'; //$proc_array[$z][$P_Layer];
                        $aoi_array_top[$top_c][5] = $item_aoi[5];
                        $top_c++;
                      }
                    else
                      {
                        if (strcmp($item_aoi[4], "BottomLayer") == 0)
                          {
                            $aoi_array_bottom[$top_b][0] = $item_aoi[0];
                            $aoi_array_bottom[$top_b][1] = $item_aoi[1];
                            $aoi_array_bottom[$top_b][2] = $item_aoi[2];
                            $aoi_array_bottom[$top_b][3] = $item_aoi[3];
                            $aoi_array_bottom[$top_b][4] = 'T'; //$proc_array[$z][$P_Layer];
                            $aoi_array_bottom[$top_b][5] = $item_aoi[5];
                            $top_b++;
                          }
                      }
                    
                  }
                echo '<div class="container-fluid small">';
                if (count($aoi_array_top > 0))
                  {
                    echo '<table id="grid-basic1" class="table table-condensed" width="25%" cellspacing="0" data-toggle="bootgrid"> ';
                    echo '<thead>';
                    echo '<tr>';
					          print_r('<th data-column-id="id" data-type="numeric" data-identifier="true">pos</th>');
				        	  print_r('<th data-column-id="Designator">Designator</th>');
                    print_r('<th data-column-id="Center-X(mm)">Center-X(mm)</th>');
                    print_r('<th data-column-id="Center-Y(mm)">Center-Y(mm)</th>');
                    print_r('<th data-column-id="Rotation">Rotation</th>');
                    print_r('<th data-column-id="Layer">proj_top</th>');
                    print_r('<th data-column-id="sma_code">sma_code</th>');
                    echo '</tr>';
					          $pos_top=1;
				            	foreach ($aoi_array_top as $aoi_value)
                      {
                        if( $aoi_value[5]=="CODIGO_ERRO"){
                          echo '<tr class="alert alert-danger">';
                          print_r('<th >' . $pos_top . '</th>');
                          print_r('<th >' . $aoi_value[0] . '</th>');
                          print_r('<th >' . $aoi_value[1] . '</th>');
                          print_r('<th >' . $aoi_value[2] . '</th>');
                          print_r('<th >' . $aoi_value[3] . '</th>');
                          print_r('<th >' . $aoi_value[4] . '</th>');
                          print_r('<th >' . $aoi_value[5] . '</th>');
                          echo '</tr>';
                        } else {
                          echo '<tr class="alert alert-success">';
                          print_r('<th >' . $pos_top . '</th>');
                          print_r('<th >' . $aoi_value[0] . '</th>');
                          print_r('<th >' . $aoi_value[1] . '</th>');
                          print_r('<th >' . $aoi_value[2] . '</th>');
                          print_r('<th >' . $aoi_value[3] . '</th>');
                          print_r('<th >' . $aoi_value[4] . '</th>');
                          print_r('<th >' . $aoi_value[5] . '</th>');
                          echo '</tr>';
                        }
						            $pos_top++;
                      }
                    echo '</thead>';
                    echo '</table>';
                  }
                if (count($aoi_array_bottom) > 0)
                  {
                    echo '<table id="grid-basic2" class="table table-condensed" width="25%" cellspacing="0" data-toggle="bootgrid"> ';
                    echo '<thead>';
                    echo '<tr>';
					          print_r('<th data-column-id="id" data-type="numeric" data-identifier="true">pos</th>');
				          	print_r('<th data-column-id="Designator">Designator</th>');
                    print_r('<th data-column-id="Center-X(mm)">Center-X(mm)</th>');
                    print_r('<th data-column-id="Center-Y(mm)">Center-Y(mm)</th>');
                    print_r('<th data-column-id="Rotation">Rotation</th>');
                    print_r('<th data-column-id="Layer">proj_bot</th>');
                    print_r('<th data-column-id="sma_code">sma_code</th>');
                    echo '</tr>';
					$pos_bot=1;
					foreach ($aoi_array_bottom as $aoi_value)
                      {
                        echo '<tr>';
						print_r('<th >' . $pos_bot . '</th>');
						print_r('<th >' . $aoi_value[0] . '</th>');
                        print_r('<th >' . $aoi_value[1] . '</th>');
                        print_r('<th >' . $aoi_value[2] . '</th>');
                        print_r('<th >' . $aoi_value[3] . '</th>');
                        print_r('<th >' . $aoi_value[4] . '</th>');
                        print_r('<th >' . $aoi_value[5] . '</th>');
						echo '</tr>';
						$pos_bot++;
                      }
                    echo '</thead>';
                    echo '</table>';
                  }
			  }
            fclose($handle1);
          }
		  echo '</div>';
		}
    else
      {
        print_r("<h1>Formato Incompativel, campos nao encontrados</h1>");
        if ($P_code != 255)
            print_r("</p>falta campo code");
        if ($P_Designator != 255)
            print_r("</p>falta campo Designator");
        if ($P_CenterX != 255)
            print_r("</p>falta campo Center-X(mm)");
        if ($P_CenterY != 255)
            print_r("</p>falta campo Center-Y(mm)");
        if ($P_Rotation != 255)
            print_r("</p>falta campo Rotation");
        if ($P_Layer != 255)
            print_r("</p>falta campo Layer");
        if ($P_sma_code != 255)
            print_r("</p>falta campo sma_code");
      }
    if (count($aoi_array_top))
      {
        $fp = fopen('aoi/proj_top.aoi', 'w');
        foreach ($aoi_array_top as $fields)
          {
            ffputcsv($fp, $fields, "\t", "\"");
          }
		fclose($fp);
		
      }
    if (count($aoi_array_bottom))
      {
        $fp1 = fopen('aoi/proj_bot.aoi', 'w');
        foreach ($aoi_array_bottom as $fields)
          {
            ffputcsv($fp1, $fields, "\t", "\"");
          }
        fclose($fp1);
      }
    fclose($handle);
  }
?>

</div>
</body>
</html>
