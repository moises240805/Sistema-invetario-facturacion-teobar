<?php
require_once 'models/Manejo.php';
require_once 'models/IngresoEgreso.php';
require_once 'models/Caja.php';
require_once 'models/Bitacora.php';
require_once 'models/Roles.php';
require_once 'views/php/utils.php';

$controller = new Manejo();
$ingresoegreso = new IngresoEgreso();
$cajas = new Caja();
$roles = new Roles();
$bitacora = new Bitacora();


//esta variables es para definir el modulo en la bitacora para cuando se cree el json 
$modulo = 'Caja';
date_default_timezone_set('America/Caracas');//Zona horaria


//Esta variable manejara de forma dinamica las solicitudes http ya sean post o get
$action = isset($_GET['a']) ? $_GET['a'] : '';


//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "agregar":
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            agregarManejo($controller);
        }
        break;
    case "mid_form":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            obtenerManejo($controller);
        }
        break;
    case "":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultarManejo($controller, $ingresoegreso, $cajas, $roles, $modulo);
        }
        break;
    default:
        consultarManejo($controller, $ingresoegreso, $cajas, $roles, $modulo);
        break;
}



    function obtenerManejo($controller) {
    $id = $_GET['ID'];
    if (!filter_var($id, FILTER_VALIDATE_INT)) {
        setError("ID inválido");
        header("Location: index.php?actio=movimiento");
        exit();
    }

    $accion="obtener";
    $movimiento = $controller->manejarAccion($accion,$id);
    header('Content-Type: application/json');
    echo json_encode($movimiento);
}


    function consultarManejo($controller, $ingresoegreso, $cajas, $roles, $modulo){

        //verifica si el usuario logueado tiene permiso de realizar la ccion requerida mendiante 
        //la funcion que esta en el modulo admin donde envia el nombre del modulo luego la 
        //action y el rol de usuario
        if ($roles->verificarPermiso($modulo, "consultar", $_SESSION['s_usuario']['id_rol'])) {

            // Ejecutar acción permitida
            $movimiento = $controller->manejarAccion("consultar",null);
            $ingresosegresos = $ingresoegreso->manejarAccion("consultar",null);
            $caja = $cajas->manejarAccion("consultar",null);
            $status = $cajas->manejarAccion("movimiento",null);


            // Inicializamos arreglo para acumular por mes (formato YYYY-MM)
            $totalesPorMes = [];

            foreach ($movimiento as $mov) {
                $fecha = $mov['fecha']; // o el nombre real del campo fecha
                $mes = date('Y-m', strtotime($fecha)); // extraemos año-mes

                $tipo = strtolower($mov['tipo_movimiento']); // ingreso o egreso (normalizamos a minúsculas)
                $monto = floatval($mov['monto_movimiento']); // monto convertido a float

                if (!isset($totalesPorMes[$mes])) {
                    $totalesPorMes[$mes] = ['ingreso' => 0, 'egreso' => 0];
                }

                if ($tipo === 'ingreso') {
                    $totalesPorMes[$mes]['ingreso'] += $monto;
                } elseif ($tipo === 'egreso') {
                    $totalesPorMes[$mes]['egreso'] += $monto;
                }
            }

            // Ahora $totalesPorMes tiene estructura:
            // [
            //   "2025-03" => ['ingreso' => 500, 'egreso' => 50],
            //   "2025-04" => ['ingreso' => 300, 'egreso' => 0],
            //   ...
            // ]

            // Opcional: preparar arrays para etiquetas y datos para Chart.js
            $labels = array_keys($totalesPorMes);
            $ingresos = array_column($totalesPorMes, 'ingreso');
            $egresos = array_column($totalesPorMes, 'egreso');

            $datosGrafico = [
    'labels' => $labels,
    'datasets' => [
        [
            'label' => 'Ingresos',
            'backgroundColor' => 'rgba(75, 192, 192, 0.6)',
            'borderColor' => 'rgba(75, 192, 192, 1)',
            'borderWidth' => 1,
            'data' => $ingresos,
        ],
        [
            'label' => 'Egresos',
            'backgroundColor' => 'rgba(255, 99, 132, 0.6)',
            'borderColor' => 'rgba(255, 99, 132, 1)',
            'borderWidth' => 1,
            'data' => $egresos,
        ]
    ]
];



            require_once 'views/php/dashboard_manejo.php';
            exit();
            }
        else{

            //muestra un modal de info que dice acceso no permitido
            setError("Error accion no permitida ");
            require_once 'views/php/dashboard_manejo.php';
            exit(); 
        }
    }

?> 