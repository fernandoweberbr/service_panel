<?php
function session_checker(){
    if (!isset($_SESSION['id'])){
        header ("Location:formulario_login.php");
        exit();
    }
}
?>