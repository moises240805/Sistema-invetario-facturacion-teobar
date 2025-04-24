<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles</title>
    <?php 
        require_once "link.php";
    ?>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            
        <?php 
            require_once "menu.php";
        ?>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <?php 
            require_once "encabezado.php";
            //require_once "menu.php";
            ?>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Roles</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Roles</h6>
           

        </div>
        <div class="card-body">
        <?php

if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];

    // Pass PHP values to JavaScript variables
    echo "<script>";
    echo "var js_message = '" . htmlspecialchars($message, ENT_QUOTES, 'UTF-8') . "';"; // Sanitize!
    echo "var js_message_type = '" . htmlspecialchars($message_type, ENT_QUOTES, 'UTF-8') . "';"; // Sanitize!
    echo "</script>";

    echo '<script>
        $(document).ready(function() {
            // Set Modal Title and Body
            if (js_message_type === "success") {
                $("#successModal .modal-title").text("Exitoso");
                $("#successModal .modal-body").text(js_message);
            } else {
                $("#successModal .modal-title").text("Error");
                $("#successModal .modal-body").text(js_message);
            }

            // Show the Modal
            $("#successModal").modal("show");
        });
    </script>';

    unset($_SESSION['message']); // Clear the message
    unset($_SESSION['message_type']); // Clear the type
}
require_once "controllers/RolesController.php";
// Simulando $datos que viene de la consulta
$datos = $permiso->Mostrar_Roles();

// Organizar datos
$roles = [];
$permisos = [];
$modulos = [];
$estatusTabla = [];

foreach ($datos as $fila) {
    $roles[$fila['id_rol']] = $fila['nombre_rol'];
    $permisos[$fila['id_permiso']] = $fila['nombre_permiso'];
    $modulos[$fila['id_modulo']] = $fila['nombre_modulo'];
    $estatusTabla[$fila['id_modulo']][$fila['id_rol']][$fila['id_permiso']] = $fila['estatus'];
}
?>

<div class="container">
    <h1 class="mt-5 mb-4">Tabla de Permisos</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th rowspan="2" style="vertical-align: middle;">Módulo / Usuario</th>
                    <?php foreach ($roles as $id_rol => $nombre_rol): ?>
                        <th colspan="<?php echo count($permisos); ?>"><?php echo htmlspecialchars($nombre_rol); ?></th>
                    <?php endforeach; ?>
                </tr>
                <tr>
                    <?php foreach ($roles as $id_rol => $nombre_rol): ?>
                        <?php foreach ($permisos as $id_permiso => $nombre_permiso): ?>
                            <th><?php echo htmlspecialchars($nombre_permiso); ?></th>
                        <?php endforeach; ?>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($modulos as $id_modulo => $nombre_modulo): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($nombre_modulo); ?></td>
                        <?php foreach ($roles as $id_rol => $nombre_rol): ?>
                            <?php foreach ($permisos as $id_permiso => $nombre_permiso): ?>
                                <?php
                                $estatus = $estatusTabla[$id_modulo][$id_rol][$id_permiso] ?? '0';
                                ?>
                                <td class="estatus-cell"
                                    data-id-modulo="<?php echo htmlspecialchars($id_modulo); ?>"
                                    data-id-rol="<?php echo htmlspecialchars($id_rol); ?>"
                                    data-id-permiso="<?php echo htmlspecialchars($id_permiso); ?>">
                                    <?php echo htmlspecialchars($estatus); ?>
                                </td>
                            <?php endforeach; ?>
                        <?php endforeach; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>



    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table th,
        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table thead th {
            background-color: #343a40;
            color: white;
            border-color: #454d55;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }

        .module-name {
            font-weight: bold;
        }

        .form-check-input {
            margin: 0 auto; /* Centrar los checkboxes */
        }
    </style>

    <script src="views/js/ajax_roles.js">
    </script>
    


</body>
</html>