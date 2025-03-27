<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipo Productos</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard/ Tipo Productos</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Tipos Productos</h6>
            <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarTipoModal">
    Agregar Tipo Producto +
</button>
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
?>
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th>Tipo De Producto</th>
                <th>Presentación</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                require_once "controllers/TipoController.php"; // Asegúrate de que la ruta sea correcta
                $productos = $controller->Mostrar_Tipo();
                foreach ($productos as $producto):
            ?>
            <tr>
                <td><?php echo $producto['tipo_producto']; ?></td>
                <td><?php echo $producto['presentacion']; ?></td>
                <td>
                <a onclick="abrirModalModificar(<?php echo $producto['id_presentacion']; ?>)" title="Modificar">
                        <img src="views/img/edit.png" width="30px" height="30px">
                    </a>
                    <a onclick="return eliminar()" href="index.php?action=tipo&a=eliminar&id_presentacion=<?php echo $producto['id_presentacion']; ?>" title="Eliminar">
                        <img src="views/img/delet.png" width="30px" height="30px">
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<div class="modal fade show" id="agregarTipoModal" tabindex="-1" role="dialog" aria-labelledby="agregarTipoModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="agregarTipoModalLabel">Agregar Tipo Producto</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=tipo&a=agregar" method="post" name="form">
                <div class="modal-body">
                    <div class="container text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-21">
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="tipo_producto" style="font-size: 18px;">Tipo Producto</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="tipo_producto" name="tipo_producto"  maxlength="50"  onkeypress="return onlyLetters(event)" required>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="presentacion" style="font-size: 18px;">Presentación</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="presentacion" name="presentacion"  maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Registrar">
                </div>
            </form>
        </div>
    </div>
</div>



<div id="modalModificar" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="modalModificarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="modalModificarLabel">Modificar Tipo Producto</h1>
                <button type="button" class="close" onclick="cerrarModalModificar()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=tipo&a=actualizar" method="post" name="form">
                <div class="modal-body">
                    <input class="entrada" type="hidden" name="id_presentacion" id="id" required>
                    <div class="form-group row">
                        <label for="tipo_producto" class="col-md-3">Tipo Producto</label>
                        <div class="col-md-9">
                            <input class="entrada form-control" type="text" name="tipo_producto" id="tipo"  maxlength="50"  onkeypress="return onlyLetters(event)" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="presentacion" class="col-md-3">Presentación</label>
                        <div class="col-md-9">
                            <input class="entrada form-control" type="text" name="presentacion" id="presen"  maxlength="50" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalModificar()">Cancelar</button>
                    <input onclick="return modificar()" class="btn btn-primary" type="submit" value="Modificar">
                </div>
            </form>
        </div>
    </div>   
</div>




<!-- Modal -->
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="successModalLabel"></h5> <!-- Title will be dynamically set -->
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
          <!-- Message will be dynamically set -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


    <script src="views/js/modal_tipo.js"></script>
    <script src="views/js/validate.js"></script>
</body>
</html>