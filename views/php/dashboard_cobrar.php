<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cuentas por Cobrar</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Cuentas por cobrar</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Cuentas por cobrar</h6>
            
        </div>
        <div class="card-body">
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover datatablesss" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th>Nro Venta</th>
                <th>Cliente</th>
                <th>F/E</th>
                <th>Monto</th>
                <th>Modalidad Pago</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                require_once "controllers/CobrarController.php";
                $cuenta = new Cobrar;
                $venta = $cuenta->obtenerCuentas();
                foreach ($venta as $venta): 
            ?>
            <tr>
                <td><?php echo $venta['id_cuentaCobrar']; ?></td>
                <td><?php echo $venta['tipo_id'].$venta['id_cliente'] . " " . $venta['nombre_cliente'] . " tlf: " . $venta['tlf']; ?></td>
                <td><?php echo $venta['fecha_cuentaCobrar']; ?></td>
                <td><?php echo $venta['monto_cuentaCobrar']; ?></td>
                <td><?php echo $venta['nombre_modalidad']; ?></td>
                <td>
                    <a onclick="abrirModal(<?php echo $venta['id_cuentaCobrar']; ?>)" class="btn btn-success btn-sm" title="Abono">Abono</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



<div class="modal fade show" id="abonoModal" tabindex="-1" role="dialog" aria-labelledby="abonoModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="abonoModalLabel">Abono</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=cobrar&a=abonado" method="POST" name="form">
                <div class="modal-body">
                    <input type="hidden" name="id_cuenta" id="id_cuenta"  >
                    <div class="form-group row justify-content-center mb-4">
                        <div class="col-md-10 text-center">
                            <label for="fecha" style="font-size: 18px;">Fecha del Abono</label>
                        </div>
                        <div class="col-md-10">
                            <input type="date" class="form-control" name="fecha" id="fecha" required>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center mb-4">
                        <div class="col-md-10 text-center">
                            <label for="monto" style="font-size: 18px;">Monto</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" step="0.01" min="0" class="form-control" name="monto" id="monto"  maxlength = "11" required>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center mb-4">
                        <div class="col-md-10 text-center">
                            <label for="monto" style="font-size: 18px;">Cliente</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text"  class="form-control" name="cliente" id="cliente"  maxlength = "11" required>
                        </div>
                    </div>
                    <div class="form-group row justify-content-center mb-4">
                        <div class="col-md-10 text-center">
                            <label for="monto" style="font-size: 18px;">Tipo de pago</label>
                            <select name="id_pago" id="" class="form-control" required>
                                <option value=""></option>
                                <option value="1">Divisas</option>
                                <option value="2">Efectivo</option>
                                <option value="3">Pago Movil</option>
                                <option value="4">Transferencia</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <input class="btn btn-primary" type="submit" value="Registrar">
                </div>
            </form>
        </div>
    </div>
</div>




    <script src="views/js/modal_cobrar.js"></script>
    <script src="views/js/validate.js"></script>
    
<link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/DataTables/datatables.js"></script>

</body>
</html>