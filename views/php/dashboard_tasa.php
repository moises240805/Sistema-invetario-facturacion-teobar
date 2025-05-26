<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tasa</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Tasa Dolar</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Valores de la tasa del dolar</h6>
            <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarCategoriaModal">
    Agregar Valor +
</button>
        </div>
        <div class="card-body">
<div class="table-responsive">
    <table class="table table-bordered table-striped table-hover datatablesss" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th>Nro</th>
                <th>Valor</th>
                <th>Fecha</th>
                <th>Tipo de Cambio</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                    //verifica si producto existe o esta vacia en dado caso que este vacia muestra clientes no 
                    // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                    // si lo tiene muestra la informacion
                    if(isset($tasa) && is_array($tasa) && !empty($tasa)){
                foreach ($tasa as $tasa):
            ?>
            <tr>
                <td><?php echo $tasa['ID']; ?></td>
                <td><?php echo $tasa['valor']; ?></td>
                <td><?php echo $tasa['fecha_valor']; ?></td>
                <td><?php echo $tasa['tipo_cambio']; ?></td>
                
            </tr>
            <?php
                            //Imprime esta informacion en caso de estar vacia la variable             
                            endforeach; 
                        } else {
                            echo "<tr><td colspan='6'>No hay Tasa registrados.</td></tr>";
                        } ?>
        </tbody>
    </table>
</div>


<div class="modal fade show" id="agregarCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="agregarCategoriaModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="agregarCategoriaModalLabel">Agregar Valor de la Tasa del dia</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=tasa&a=agregar" method="post" name="form">
                <div class="modal-body">
                    <div class="container text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-21">
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="tipo_producto" style="font-size: 18px;">Tasa del Dia</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="number" class="form-control" id="tasa" name="valor"  maxlength="70"  required>
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





    
    <script src="views/js/validate.js"></script>

    <link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/DataTables/datatables.js"></script>
</body>
</html>