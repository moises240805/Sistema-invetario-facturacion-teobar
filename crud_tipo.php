<?php
session_start();
if($_SESSION["s_usuario"] === null){
    header("Location:index.php");
}
require_once 'controllers/TipoController.php';

?>