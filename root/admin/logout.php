<?php

session_start();

if (!isset($_REQUEST['logmeout']))
{
/*
echo "Realmente quer sair?<br />";
echo "<a href=\"logout.php?logmeout\">Sim</a> | ";
echo "<a href=\"javascript:history.go(-1)\">Não</a>";
*/
//echo "<div class="popup" onclick="myFunction()">Click me!";
//echo " <span class="popuptext" id="myPopup">Popup text...</span>";
//echo "</div> ";


session_destroy();

//include "index.php";

}else{

if (!session_is_registered('nome'))
{
    include "index.php";
}

}
?>