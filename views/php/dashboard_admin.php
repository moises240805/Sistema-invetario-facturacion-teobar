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
            require_once "alert.php";
            //require_once "menu.php";
            ?>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Usuarios</h1>
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
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover datatablesss" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
                    <thead class="thead-light">
                        <tr>
                            <th>Usuario</th>
                            <th>Rol</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            //verifica si admin existe o esta vacia en dado caso que este vacia muestra clientes no 
                            // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                            // si lo tiene muestra la informacion
                            if(isset($admin) && is_array($admin) && !empty($admin)){
                                foreach ($admin as $ad){
                                    ?>
                                    <tr>
                                        <td><?php echo $ad['usuario']; ?></td>
                                        <td><?php echo $ad['nombre_rol']; ?></td>
                                        <td>
                                            <a onclick="abrirModalModificar(<?php echo $ad['ID']; ?>)" title="Modificar"><img src="views/img/edit.png" width="30px" height="30px"></a>
                                            <a onclick="return eliminar()" href="index.php?action=usuario&a=eliminar&ID=<?php echo $ad['ID']; ?>" title="Eliminar"><img src="views/img/delet.png" width="30px" height="30px"></a>
                                        </td>
                                    </tr>
                                    <?php
                                    //Imprime esta informacion en caso de estar vacia la variable             
                                } 
                            } else {
                                echo "<tr><td colspan='6'>No hay usuarios registrados.</td></tr>";
                            } ?>
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
                    <input type="text" class="form-control" id="username" name="username" maxlength="15" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="rol" class="col-md-3">Rol</label>
                <div class="col-md-9">
                    <select class="form-control" name="rol" id="rol" required>
                        <option value="">...</option>
                        <option value="2">Administrador</option>
                        <option value="3">Usuario</option>
                        <option value="4">Vendedor</option>
                        <option value="5">Contador</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="pw" class="col-md-3">Password</label>
                <div class="col-md-9">
                    <input type="password" class="form-control" id="password" name="pw"  maxlength="9" required oninput="Password()">
                    <span id="Error" class="error-message"></span>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                    <input type="submit" class="btn btn-primary"  value="Registrar">
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

            ?>
            <input class="form-control" type="hidden" name="id" value="" required>
            <div class="form-group row">
                <label for="usuario" class="col-md-3">Usuario</label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="usuario" value="" maxlength="30" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="pw" class="col-md-3">Password</label>
                <div class="col-md-9">
                    <input class="form-control" type="password" id='password2' name="clave" value="" maxlength="9" oninput='Password()' required>
                    <span id="Error2" class="error-message"></span>
                </div>
            </div>
            <div class="form-group row">
                <label for="rol" class="col-md-3">Rol</label>
                <div class="col-md-9">
                    <select class="form-control" name="roles" id="" required>
                        <option value="2">Administrador</option>
                        <option value="3">Usuario</option>
                        <option value="4">Vendedor</option>
                        <option value="5">Contador</option>
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




<button type="button" id="openModalBtn" style="display: none;" data-bs-toggle="modal" data-bs-target="#successModal"></button>

<script src="views/js/modal_user.js"></script>
<script src="views/js/validate_usuario.js"></script>

<link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/DataTables/datatables.js"></script>


</body>
</html>