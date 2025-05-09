<?php

// Incluye el archivo del modelo 
require_once 'models/Roles.php';

$permiso = new Roles();

//Esta variable manejara de forma dinamica las solicitudes http ya sean post o get
$action = isset($_GET['a']) ? $_GET['a'] : '';

if ($action == "" && $_SERVER["REQUEST_METHOD"] == "GET")
{
    $datos=$permiso->manejarAccion('consultar',null);
    $roles = [];
    $permisos = [];
    $modulos = [];
    $estatusTabla = [];
    require_once "views/php/dashboard_roles.php";
}
if ($action == "actualizar" && $_SERVER["REQUEST_METHOD"] == "POST")
{


// actualizar_estatus.php
header('Content-Type: application/json');

// Leer JSON enviado por fetch
$data = json_decode(file_get_contents('php://input'), true);

if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}


$roles=$permiso->manejarAccion('actualizar',$data);


}

?>