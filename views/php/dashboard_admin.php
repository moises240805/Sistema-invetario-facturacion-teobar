<?php 
if (!isset($_SESSION["s_usuario"])) {
    // Si no está iniciada y no es la acción de inicio de sesión, redirige a la página de inicio de sesión
    require_once "views/php/login.php";
    exit(); // Asegúrate de que el script termine aquí
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrador</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard/ Usuario</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Usuarios</h6>
            <button class="btn btn-primary" id="myBtn">Agregar Usuario +</button>
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
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            require_once "controllers/AdminController.php";
                            $admins = $controller->Mostrar_Usuario();
                            foreach ($admins as $ad):
                        ?>
                            <tr>
                                <td><?php echo $ad['usuario']; ?></td>
                                <td><?php echo $ad['rol']; ?></td>
                                <td>
                                    <a onclick="abrirModalModificar(<?php echo $ad['ID']; ?>)" title="Modificar"><img src="views/img/edit.png" width="30px" height="30px"></a>
                                    <a onclick="return eliminar()" href="index.php?action=usuario&a=eliminar&ID=<?php echo $ad['ID']; ?>" title="Eliminar"><img src="views/img/delet.png" width="30px" height="30px"></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




    <div id="myModal" class="modal">
    <div class="modal-content">
        <form class="formulario" action="index.php?action=usuario&a=agregar" method="post" name="form">
            <h1 class="titulo_form">Agregar Usuario</h1>
            <div class="form-group row">
                <label for="username" class="col-md-3">Usuario</label>
                <div class="col-md-9">
                    <input type="text" class="form-control" id="username" name="username" maxlength="30" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="rol" class="col-md-3">Rol</label>
                <div class="col-md-9">
                    <select class="form-control" name="rol" id="rol" required>
                        <option value="">...</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Usuario">Usuario</option>
                        <option value="Cajero">Cajero</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="pw" class="col-md-3">Password</label>
                <div class="col-md-9">
                    <input type="password" class="form-control" id="pw" name="pw"  maxlength="9" required oninput="Password()">
                    <span id="Error" class="error-message"></span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                    <input type="submit" class="btn btn-primary" onclick="return Password()" value="Registrar">
                </div>
            </div>
        </form>
    </div>
</div>



    <!-- Modal para Modificar Usuario -->
<div id="modalModificar" class="modal">
    <div class="modal-content">
        <form class="formulario" id="formModificar" action="index.php?action=usuario&a=actualizar" method="post" name="form">
            <h1 class="titulo_form">Modificar Usuario</h1>
            <?php if (!empty($message2)): ?>
                <p class="alert alert-<?php echo ($message2 == "USUARIO ACTUALIZADO CORRECTAMENTE") ? 'success' : 'danger'; ?>">
                    <?php echo $message2; ?>
                </p>
            <?php endif; ?>
            <?php
                require_once "controllers/AdminController.php";
                if (isset($id)) {
                    $admin = $controller->obtenerUsuario($id);
                }
            ?>
            <input class="form-control" type="hidden" name="id" value="<?php echo $admin['ID']; ?>" required>
            <div class="form-group row">
                <label for="usuario" class="col-md-3">Usuario</label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="usuario" value="<?php echo $admin['usuario']; ?>" maxlength="30" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="pw" class="col-md-3">Password</label>
                <div class="col-md-9">
                    <input class="form-control" type="password" name="clave" value="<?php echo $admin['pw']; ?>" maxlength="9" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="rol" class="col-md-3">Rol</label>
                <div class="col-md-9">
                    <select class="form-control" name="roles" id="" required>
                        <option value="Administrador">Administrador</option>
                        <option value="Usuario">Usuario</option>
                        <option value="Cajero">Cajero</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalModificar()">Cancelar</button>
                    <input type="submit" class="btn btn-primary" onclick="return modificar()" value="Modificar">
                </div>
            </div>
        </form>
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

<script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<button type="button" id="openModalBtn" style="display: none;" data-bs-toggle="modal" data-bs-target="#successModal"></button>

<script src="views/js/modal_user.js"></script>
</body>
</html>