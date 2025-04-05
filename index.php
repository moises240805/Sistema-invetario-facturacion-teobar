<?php
session_start();
$controlador = isset($_GET['action']) ? $_GET['action'] : '';
$action = isset($_GET['a']) ? $_GET['a'] : '';
require_once 'config/Route.php';
if (!isset($_SESSION["s_usuario"]) && $controlador != 'usuario' && $action != 'ingresar' && $controlador != '') {
    // Si no está iniciada y no es la acción de inicio de sesión, redirige a la página de inicio de sesión
    require_once "views/php/login.php";
    exit(); // Asegúrate de que el script termine aquí
}
if ($controlador == '') {
    require_once "views/php/pagina.php";
} else {
    if (isset($rutas[$controlador])) {
        require_once $rutas[$controlador];
        
        // Manejo especial para reportes
        if ($controlador == 'reportes') {
            $controller = new ReporteController();
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                $option = htmlspecialchars($_POST['option']);
                        { if ($option == "tipo_producto") {
                                $controller->generarPDF8();
                            }
                            elseif($option == "fecha"){
                                $controller->generarPDF9();
                            }
                            elseif($option == "stock"){
                                $controller->generarPDF10();
                            }
                            elseif($option == "cliente_v"){
                                $controller->generarPDF11();
                            }
                            elseif($option == "proveedor_c"){
                                $controller->generarPDF12();
                            }
                            elseif($option == "trans"){
                                $controller->generarPDF13();
                            }
                            elseif($option == "movil"){
                                $controller->generarPDF14();
                            }
                            elseif($option == "divisa"){
                                $controller->generarPDF15();
                            }
                            elseif($option == "trans_c"){
                                $controller->generarPDF16();
                            }
                            elseif($option == "movil_c"){
                                $controller->generarPDF17();
                            }
                            elseif($option == "divisa_c"){
                                $controller->generarPDF18();
                            }
                            elseif($option == ""){
                            }
                        }
                            if (isset($_POST['generar_pdf'])) {
                                $controller->generarPDF();
                            } elseif (isset($_POST['generar_pdf2'])) {
                                $controller->generarPDF2();
                            } elseif (isset($_POST['generar_pdf4'])) {
                                $controller->generarPDF4();
                            } elseif (isset($_POST['generar_pdf5'])) {
                                $controller->generarPDF5();
                            } elseif (isset($_POST['generar_pdf3'])) {
                                $controller->generarPDF3();
                            }  elseif (isset($_POST['generar_pdf6'])) {
                                $controller->generarpdf6();
                            } elseif (isset($_POST['generar_pdf7'])) {
                                $controller->generarpdf7();
                            }
                        }
                        require_once "views/php/dashboard_reporte.php";
                
                } else {
                    require_once 'controllers/AdminController.php';
                }
            }
}

?>