<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marcas Productos</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Marcas Productos</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Marcas Productos</h6>
            <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarMarcaModal">
    Agregar Marca +
</button>
        </div>
        <div class="card-body">
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover datatablesss" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th>Nro</th>
                <th>Nombre de Marca</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                    //verifica si producto existe o esta vacia en dado caso que este vacia muestra clientes no 
                    // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                    // si lo tiene muestra la informacion
                    if(isset($marcas) && is_array($marcas) && !empty($marcas)){
                foreach ($marcas as $marca):
            ?>
            <tr>
                <td><?php echo $marca['ID']; ?></td>
                <td><?php echo $marca['nombre_marca']; ?></td>
                <td>
                <a onclick="abrirModalModificar(<?php echo $marca['ID']; ?>)" title="Modificar">
                        <img src="views/img/edit.png" width="30px" height="30px">
                    </a>
                    <a onclick="return eliminar()" href="index.php?action=marca&a=eliminar&ID=<?php echo $marca["ID"]; ?>" title="Eliminar">
                        <img src="views/img/delet.png" width="30px" height="30px">
                    </a>
                </td>
            </tr>
            <?php
                            //Imprime esta informacion en caso de estar vacia la variable             
                            endforeach; 
                        } else {
                            echo "<tr><td colspan='6'>No hay marcas de productos registrados.</td></tr>";
                        } ?>
        </tbody>
    </table>
</div>


<div class="modal fade show" id="agregarMarcaModal" tabindex="-1" role="dialog" aria-labelledby="agregarMarcaModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="agregarMarcaModalLabel">Agregar Marca de Producto</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=marca&a=agregar" method="post" name="form">
                <div class="modal-body">
                    <div class="container text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-21">
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="tipo_producto" style="font-size: 18px;">Marca de Producto</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="marca" name="marca"  maxlength="70"  onkeypress="return onlyLetters(event)" required>
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
                <h1 class="titulo_form text-center" id="modalModificarLabel">Modificar Marca de Producto</h1>
                <button type="button" class="close" onclick="cerrarModalModificar()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=marca&a=actualizar" method="post" name="form">
                <div class="modal-body">
                    <input class="entrada" type="hidden" name="id_marca" id="id" required>
                    <div class="form-group row">
                        <label for="marca" class="col-md-3">Marca Producto</label>
                        <div class="col-md-9">
                            <input class="entrada form-control" type="text" name="marca" id="Marca"  maxlength="70"  onkeypress="return onlyLetters(event)" required>
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



    <script src="views/js/modal_marca.js"></script>
    <script src="views/js/validate.js"></script>

    <link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/DataTables/datatables.js"></script>
</body>
</html>