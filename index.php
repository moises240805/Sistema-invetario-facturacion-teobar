<?php
session_start();

$action = isset($_GET['action']) ? $_GET['action'] : '';

if ($action == 'd' && $_SERVER["REQUEST_METHOD"] == "GET") 
{
    require_once "pag_inic.php";
}
elseif ($action == 'c' && $_SERVER["REQUEST_METHOD"] == "GET") 
{
    require_once "public/crud_cliente.php";
}
else{
    require_once 'controllers/AdminController.php';
}
?>