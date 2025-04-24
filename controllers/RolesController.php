<?php

// Incluye el archivo del modelo 
require_once 'models/Roles.php';

$permiso = new Roles();
require_once "views/php/dashboard_roles.php";

//Esta variable manejara de forma dinamica las solicitudes http ya sean post o get
$action = isset($_GET['a']) ? $_GET['a'] : '';

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

$id_modulo = intval($data['id_modulo']);
$id_rol = intval($data['id_rol']);
$id_permiso = intval($data['id_permiso']);
$estatus = intval($data['estatus']);
$roles=$permiso->Actualizar_Roles($id_modulo,$id_rol,$id_permiso,$estatus);


}

?>