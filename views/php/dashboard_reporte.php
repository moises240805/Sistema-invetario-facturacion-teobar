<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard/ Reportes</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">


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
?>
    <main class="main">
    <section class="full-width text-center" style="padding: 0;">
        <h2 style="margin-top: .2rem;" class="titulo">Generar Reportes</h2>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="text-center">Productos</h4>
                            <form method="POST" action="index.php?action=reportes">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit" name="generar_pdf"><b>PDF</b></button>
                                </div>
                                <div class="form-group">
                                    <label for="opciones">Filtrar por:</label>
                                    <select name="option" id="opciones" class="form-control">
                                        <option value="">...</option>
                                        <option value="tipo_producto">Tipo de Producto</option>
                                        <option value="fecha">Fecha de Vencimiento</option>
                                        <option value="stock">Stock</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-secondary btn-block" type="submit" name="enviar_opcion"><b>Filtrar</b></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="text-center">Clientes</h4>
                            <form method="POST" action="index.php?action=reportes">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit" name="generar_pdf2"><b>PDF</b></button>
                                </div>
                                <div class="form-group">
                                    <label for="opciones">Filtrar por:</label>
                                    <select name="option" id="opciones" class="form-control">
                                        <option value="">...</option>
                                        <option value="cliente_v">Ventas</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-secondary btn-block" type="submit" name="enviar_opcion"><b>Filtrar</b></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="text-center">Proveedor</h4>
                            <form method="POST" action="index.php?action=reportes">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit" name="generar_pdf3"><b>PDF</b></button>
                                </div>
                                <div class="form-group">
                                    <label for="opciones">Filtrar por:</label>
                                    <select name="option" id="opciones" class="form-control">
                                        <option value="">...</option>
                                        <option value="proveedor_c">Compras</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-secondary btn-block" type="submit" name="enviar_opcion"><b>Filtrar</b></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="text-center">Ventas</h4>
                            <form method="POST" action="index.php?action=reportes">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit" name="generar_pdf4"><b>PDF</b></button>
                                </div>
                                <div class="form-group">
                                    <label for="opciones">Filtrar por:</label>
                                    <select name="option" id="opciones" class="form-control">
                                        <option value="">...</option>
                                        <option value="trans">Transferencias</option>
                                        <option value="movil">Pago móvil</option>
                                        <option value="divisa">Divisa y efectivo</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-secondary btn-block" type="submit" name="enviar_opcion"><b>Filtrar</b></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="text-center">Cuentas por Cobrar</h4>
                            <form method="POST" action="index.php?action=reportes">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit" name="generar_pdf5"><b>PDF</b></button>
                                </div>
                                <div class="form-group">
                                    <label for="opciones">Filtrar por:</label>
                                    <select name="option" id="opciones" class="form-control">
                                        <option value="">...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-secondary btn-block" type="submit" name="enviar_opcion"><b>Filtrar</b></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="text-center">Compras</h4>
                            <form method="POST" action="index.php?action=reportes">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit" name="generar_pdf6"><b>PDF</b></button>
                                </div>
                                <div class="form-group">
                                    <label for="opciones">Filtrar por:</label>
                                    <select name="option" id="opciones" class="form-control">
                                        <option value="">...</option>
                                        <option value="trans_c">Transferencias</option>
                                        <option value="movil_c">Pago móvil</option>
                                        <option value="divisa_c">Divisa y efectivo</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-secondary btn-block" type="submit" name="enviar_opcion"><b>Filtrar</b></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center">
                <div class="col-md-4 mb-4">
                    <div class="card shadow">
                        <div class="card-body">
                            <h4 class="text-center">Cuentas por Pagar</h4>
                            <form method="POST" action="index.php?action=reportes">
                                <div class="form-group">
                                    <button class="btn btn-primary btn-block" type="submit" name="generar_pdf7"><b>PDF</b></button>
                                </div>
                                <div class="form-group">
                                    <label for="opciones">Filtrar por:</label>
                                    <select name="option" id="opciones" class="form-control">
                                        <option value="">...</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <button class="btn btn-secondary btn-block" type="submit" name="enviar_opcion"><b>Filtrar</b></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

    </div>
    <style>

    </style>
</body>
</html>