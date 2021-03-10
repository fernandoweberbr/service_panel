<!DOCTYPE html>
<html lang="pt">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
  <meta name="description" content="">
  <meta name="author" content="Fernando Weber">
  <title>LAYOUT</title>
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
<div class="container-12">
  <div class="row">
    <div class="col-12">
		<div class="alert alert-dark" role="alert">
			<h4 class="alert-heading">Conversor Arquivo Pick and Place Altium to TRI AOI</h4>
			<p>Copie  e cole o conteudo do arquivo CAD pick and place logo apos clique em  "Converter"</p>
			<hr>
			<p class="mb-0">Os campos sma_code correspondem ao nome usado internamente na maquina AOI da TRI,
				esse aplicativo busca na lista o campo code que é o codigo do sistema ERP do componente	e converte para uma lista que pode ser facilmente usada na maquina de inspeção visual.<br>
				Logo abaixo estarao os link para download da coversão,A lista dos itens estara nos campos abaixo
				para a maquina não existe layer bottom então serão gerados arquivos com o layer em TOP porem separadados por nome.
			</p>
		<div class="alert alert-danger" role="alert">
		Certifique-se de que na primeira linha exista os campos abaixo:
		</div>
		<table>
			<tr><th>"code"</th><th>,"Designator"</th><th>,"Center-X(mm)"</th><th>,"Center-Y(mm)"</th><th>,"Rotation"</th><th>,"Layer"</th><th>,"sma_code"</th></tr>
			<tr><th>"410654001"</th><th>,"C1"</th><th>,"123.543"</th><th>","33.232"</th><th>,"90"</th><th>,"TopLayer"</th><th>,""</th></tr>
		</table>
		</div>
		<form method="post">
			<textarea name="xls" style="width: 100%; height: 240px"></textarea>
			<input type="submit" value="Converter" />
		</form>     
	</div>
  </div>
  <div class="row">
    <div class="col-6">
		<div class="alert alert-dark" role="alert">TOP SIDE
		<a href="download.php?file=proj_top.aoi"><img src=aoi/mac.png></a>
		</div>
		<div class="alert alert-dark" role="alert">
		<table id="grid-basic2" class="table table-condensed" width="100%" cellspacing="0" data-toggle="bootgrid"> 
		<thead>
		<tr>
		<th data-column-id="id" data-type="numeric" data-identifier="true">pos</th>
		<th data-column-id="Designator">Designator</th>
        <th data-column-id="Center-X(mm)">Center-X(mm)</th>
        <th data-column-id="Center-Y(mm)">Center-Y(mm)</th>
        <th data-column-id="Rotation">Rotation</th>
        <th data-column-id="Layer">proj_top</th>
        <th data-column-id="sma_code">sma_code</th>
		</tr>		</thead>
		</table>
		</div>
    </div>
    <div class="col-6">
	  <div class="alert alert-dark" role="alert">BOTTOM SIDE
	  <a href="download.php?file=proj_bot.aoi"><img src=aoi/mac.png></a>
	  </div>
		<div class="alert alert-dark" role="alert">
		<table id="grid-basic2" class="table table-condensed" width="100%" cellspacing="0" data-toggle="bootgrid"> 
		<thead>
		<tr>
		<th data-column-id="id" data-type="numeric" data-identifier="true">pos</th>
		<th data-column-id="Designator">Designator</th>
        <th data-column-id="Center-X(mm)">Center-X(mm)</th>
        <th data-column-id="Center-Y(mm)">Center-Y(mm)</th>
        <th data-column-id="Rotation">Rotation</th>
        <th data-column-id="Layer">proj_bot</th>
        <th data-column-id="sma_code">sma_code</th>
		</tr>		</thead>
		</table>
		</div>
    </div>
  </div>
</div>
</body>
</html>
