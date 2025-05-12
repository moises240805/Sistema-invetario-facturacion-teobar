<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Movimientos</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>
                    <?php
require_once "controllers/CajaController.php";
?>
<!-- Contenedor de tarjetas -->
<center><div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-2">
    <?php foreach ($caja as $caja): ?>
        <!-- Tarjeta -->
        <div class="col">
            <div class="card h-100">
                <div class="card-header">
                    <h3>Manejo de cajas</h3>
                </div>
                <div class="card-body">
                    <h4 class="card-title"><?php echo $caja["nombre_caja"]; ?></h4>
                    <p class="card-text"><b style='font-size:1.2em;'><?=number_format($caja["saldo_caja"],2,',','.'); ?></b></p>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div></center><br>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Movimientos</h6>

        </div>
    
        <div class="card-body">
    <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover datatablesss" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th>Nro de movimiento</th>
                <th>Caja</th>
                <th>Tipo de movimiento</th>
                <th>Monto</th>
                <th>Tipo de pago</th>
                <th>Descripcion</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                foreach ($movimiento as $movimiento): 
            ?>
            <tr>
                <td><?php echo $movimiento['ID']; ?></td>
                <td><?php echo $movimiento["nombre_caja"]; ?></td>
                <td><?php echo $movimiento['tipo_movimiento']; ?></td>
                <td><?php echo $movimiento['monto_movimiento']; ?></td>
                <td><?php echo $movimiento['nombre_modalidad']; ?></td>
                <td><?php echo $movimiento['concepto']; ?></td>
                <td><?php echo $movimiento['fecha']; ?></td>

            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>



 
<link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/DataTables/datatables.js"></script>

</body>
</html>