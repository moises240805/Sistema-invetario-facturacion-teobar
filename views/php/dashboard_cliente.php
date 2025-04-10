<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard/ Clientes</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Clientes</h6>
            <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarClienteModal">
    Agregar Cliente +
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
                <th>CI</th>
                <th>Nombre</th>
                <th>TLF</th>
                <th>Email</th>
                <th>Dirección</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                require_once "controllers/ClienteController.php"; // Asegúrate de que la ruta sea correcta
                $clientes = $controller->Mostrar_Cliente();
                foreach ($clientes as $cliente): 
            ?>
            <tr>
                <td><?php echo $cliente['tipo_id'] . $cliente['id_cliente']; ?></td>
                <td><?php echo $cliente['nombre_cliente']; ?></td>
                <td><?php echo $cliente['tlf']; ?></td>
                <td><?php echo $cliente['email']; ?></td>
                <td><?php echo $cliente['direccion']; ?></td>
                <td>
                    <a onclick="abrirModalModificar(<?php echo $cliente['id_cliente']; ?>)" title="Modificar">
                        <img src="views/img/edit.png" width="30px" height="30px">
                    </a>
                    <a onclick="return eliminar()" href="index.php?action=cliente&a=eliminar&ID=<?php echo $cliente['id_cliente']; ?>" title="Eliminar">
                        <img src="views/img/delet.png" width="30px" height="30px">
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>


<div id="modalModificarCliente" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="modalModificarClienteLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="modalModificarClienteLabel">Modificar Cliente</h1>
                <button type="button" class="close" onclick="cerrarModalModificar()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=cliente&a=actualizar" method="post" name="form">
                <div class="modal-body">
                    <input class="entrada" type="hidden" name="id_cliente" id="id_cliente" required>
                    <div class="form-group row">
                        <label for="tipo_id" class="col-md-3">CI del Cliente</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="tipo_id" class="form-control">
                                    <option value="V-">V-</option>
                                    <option value="E-">E-</option>
                                </select>
                                <input class="entrada form-control" type="text" onkeypress="return SoloNumeros(event)" name="id_cliente2" id="id_cliente2" maxlength="8" pattern="[0-9]{8}" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nombre_cliente" class="col-md-3">Nombre del Cliente</label>
                        <div class="col-md-9">
                            <input class="entrada form-control" type="text" name="nombre_cliente" id="nombre_cliente" maxlength="50" onkeypress="return onlyLetters(event)" required oninput="validateName()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tlf" class="col-md-3">Tlf del Cliente</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="codigo_tlf" class="form-control">
                                    <option value="0412">0412</option>
                                    <option value="0416">0416</option>
                                    <option value="0426">0426</option>
                                    <option value="0414">0414</option>
                                    <option value="0424">0424</option>
                                </select>
                                <input class="entrada form-control" type="text" onkeypress="return SoloNumeros(event)" name="telefono" id="numero_tlf"  maxlength="7" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-md-3">Correo del Cliente</label>
                        <div class="col-md-9">
                            <input class="entrada form-control" type="email" name="email" id="email" maxlength="50" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="direccion" class="col-md-3">Dirección del Cliente</label>
                        <div class="col-md-9">
                            <input class="entrada form-control" type="text" name="direccion" id="direccion" maxlength="120" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalModificar()">Cancelar</button>
                    <input onclick="return modificarCliente()" class="btn btn-primary" type="submit" value="Modificar">
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade show" id="agregarClienteModal" tabindex="-1" role="dialog" aria-labelledby="agregarClienteModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="agregarClienteModalLabel">Agregar Cliente</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=cliente&a=agregar" method="post" name="form" id="miFormulario">
                <div class="modal-body">
                    <div class="container text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="id" style="font-size: 18px;">CI del Cliente</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <select name="tipo_cliente" class="form-control">
                                                <option value="V-">V-</option>
                                                <option value="E-">E-</option>
                                            </select>
                                            <input type="text" onkeypress="return SoloNumeros(event)" class="form-control" id="id" name="id_cliente" placeholder="CI"  maxlength="8" required oninput="validateId()">
                                        </div>
                                        <span id="idError" class="error-message"></span>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="nombre" style="font-size: 18px;">Nombre del Cliente</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="nombre" name="nombre_cliente" placeholder="Nombre"  maxlength="50"onkeypress="return onlyLetters(event)" required oninput="validateName()">
                                        <span id="nameError" class="error-message"></span>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="tlf" style="font-size: 18px;">Tlf del Cliente</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <select name="codigo_tlf" class="form-control">
                                                <option value="0412">0412</option>
                                                <option value="0416">0416</option>
                                                <option value="0426">0426</option>
                                                <option value="0414">0414</option>
                                                <option value="0424">0424</option>
                                                <option value="0251">0251</option>
                                            </select>
                                            <input type="text" class="form-control" id="numero_tlf" name="telefono" placeholder="Ejem: 1234567" maxlength="7" onkeypress="return SoloNumeros(event)" required oninput="validatePhone()">    
                                        </div>
                                        <span id="phoneError" class="error-message"></span>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="email" style="font-size: 18px;">Correo del Cliente</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Correo" maxlength="50" required oninput="validateEmail()">
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="direccion" style="font-size: 18px;">Dirección del Cliente</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" name="direccion" placeholder="Dirección" maxlength="120" required oninput="validateAddress()">
                                        <span id="addressError" class="error-message"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" onclick="cerrarModal()" data-dismiss="modal">Cancelar</button>
                    <input onclick="return validateForm()" class="btn btn-primary" type="submit" value="Registrar">
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


    <script src="views/js/modal_cliente.js"></script>
    <script src="views/js/validate.js"></script>
</body>
</html>