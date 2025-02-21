<?php
session_start();
if (!isset($_SESSION["s_usuario"])) {
    // Si no está autenticado, redirige a la página de inicio
    header("Location: index.php");
    exit(); // Termina el script después de redirigir
}

// Verifica si el usuario no es administrador
if ($_SESSION["s_usuario"]["rol"] !== "Administrador") {
    // Si no es administrador, redirige a otra página
    header("Location: pag_inic.php");
    exit(); // Termina el script después de redirigir
}

require_once "controllers/AdminController.php";
?>