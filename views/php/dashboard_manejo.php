<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
    <?php 
        require_once "link.php";
        require_once "alert.php";
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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#reporteModal"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</button>
                    </div>
<!-- Botón para abrir el modal -->
<center>
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#cajasModal">
        Ver Manejo de Cajas
    </button>

<!-- Botón para abrir el modal -->

    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#ingresosEgresosModal">
        Ver Ingresos y Egresos
    </button>
</center>
<br>

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
                <th>Accion</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                //verifica si cliente existe o esta vacia en dado caso que este vacia muestra clientes no 
                // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                // si lo tiene muestra la informacion
                if(isset($movimiento) && is_array($movimiento) && !empty($movimiento)){
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
                <td>
                    <a onclick="abrirModalModificar(<?php echo $movimiento['ID']; ?>)" title="Modificar">
                        <img src="views/img/edit.png" width="30px" height="30px">
                    </a>
                </td>

            </tr>
            <?php
            //Imprime esta informacion en caso de estar vacia la variable             
            endforeach; 
        } else {
            echo "<tr><td colspan='6'>No hay registros.</td></tr>";
        } ?>
        </tbody>
    </table>
</div>


<!-- Modal -->
<div class="modal fade" id="cajasModal" tabindex="-1" aria-labelledby="cajasModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" style="max-width: 110%;">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="cajasModalLabel">Manejo de cajas</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="container-fluid">
          <!-- Fila superior: botones + tarjetas -->
          <div class="row mb-3">
            <!-- Columna botones -->
            <div class="col-md-3 d-flex flex-column gap-2">
              <button id="btnAperturarCaja" class="btn btn-primary w-100" type="button">Aperturar Caja</button>
              <form id="formAperturarCaja" action="index.php?action=caja&a=open" method="post" style="display:none;">
                <input type="hidden" name="status" id="statusInput" value="">
              </form>
              <form action="index.php?action=caja&a=close" method="post">
                <button class="btn btn-primary w-100" type="submit">Cerrar Caja</button>
              </form>
            </div>
            <!-- Columna tarjetas -->
            <div class="col-md-9">
              <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                <?php 
                if(isset($caja) && is_array($caja) && !empty($caja)){
                  foreach ($caja as $item): ?>
                    <div class="col">
                      <div class="card h-100">
                        <div class="card-header">
                          <h3>Manejo de cajas</h3>
                        </div>
                        <div class="card-body">
                          <h4 class="card-title"><?php echo htmlspecialchars($item["nombre_caja"]); ?></h4>
                          <p class="card-text">
                            <b style="font-size:1.2em;">
                              <?= number_format($item["saldo_caja"], 2, ',', '.'); ?>
                            </b>
                          </p>
                        </div>
                      </div>
                    </div>
                <?php
                  endforeach; 
                } else {
                  echo "<p>No hay registros.</p>";
                } ?>
              </div>
            </div>
          </div>
          <!-- Fila inferior: tabla -->
          <div class="row">
            <div class="col-12 table-responsive">
              <table class="table table-bordered table-striped table-hover datatablesss" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                  <tr>
                    <th>Nro</th>
                    <th>Caja</th>
                    <th>Tipo de movimiento</th>
                    <th>Monto</th>
                    <th>Fecha</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  if(isset($status) && is_array($status) && !empty($status)){
                    foreach ($status as $items): ?>
                      <tr>
                        <td><?php echo htmlspecialchars($items["ID"]); ?></td>
                        <td><?php echo htmlspecialchars($items["nombre_caja"]); ?></td>
                        <td><?php echo htmlspecialchars($items['tipo_movimiento']); ?></td>
                        <td><?php echo htmlspecialchars($items['monto']); ?></td>
                        <td><?php echo htmlspecialchars($items['Fecha_hora']); ?></td>
                      </tr>
                  <?php
                    endforeach; 
                  } else {
                    echo "<tr><td colspan='4'>No hay registros.</td></tr>";
                  } ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>



<!-- Modal -->
<div class="modal fade " id="ingresosEgresosModal" tabindex="-1" aria-labelledby="ingresosEgresosModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl "> <!-- modal-xl para mayor ancho, scrollable para scroll si hay mucho contenido -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="ingresosEgresosModalLabel">Manejo de Ingresos y Egresos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <!-- Contenedor de tarjetas -->
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
            <?php 
            if(isset($ingresosegresos) && is_array($ingresosegresos) && !empty($ingresosegresos)){
            foreach ($ingresosegresos as $ingresoegreso): ?>
                <div class="col">
                    <div class="card h-100">
                        <div class="card-header">
                            <h6><?php echo htmlspecialchars($ingresoegreso['nombre']); ?></h6>
                        </div>
                        <div class="card-body">
                            <p class="card-text"><?php echo htmlspecialchars($ingresoegreso['descripcion']); ?></p>
                            <p class="card-text">
                                <b style="font-size:1.2em;">
                                    $<?= number_format($ingresoegreso['monto'], 2, ',', '.'); ?>
                                </b>
                            </p>
                        </div>
                    </div>
                </div>
            <?php
            //Imprime esta informacion en caso de estar vacia la variable             
            endforeach; 
        } else {
            echo "<tr><td colspan='6'>No hay registros.</td></tr>";
        } ?>
            <form action="" method="post">
                <h5>Registrar Ingreso o Egreso Externo</h5>
                <label for="nombre">
                    <input class="form-control" type="text" placeholder='nombre' required>
                </label>
                    <label for="descripcion">
                    <input class="form-control" type="text" placeholder='descripcion' required>
                </label>
                    <label for="monto">
                    <input class="form-control" type="number" placeholder='monto' required>
                </label>
                <button type="submit" class='btn btn-primary'>Registrar</button>
            </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


<div id="modalModificar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="modalModificarLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
              <h1 class="titulo_form text-center" id="modalModificarLabel">Movimiento Seleccionado</h1>
              <button type="button" class="close" onclick="cerrarModalModificar()">
                  <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="formMovimiento" autocomplete="off">
  <div class="mb-3">
    <label for="id" class="form-label">Nro de movimiento</label>
    <input style="width: 26rem;" type="text" class="form-control" id="id" name="id" readonly>
  </div>
  <div class="mb-3">
    <label for="caja" class="form-label">Caja</label>
    <input style="width: 26rem;" type="text" class="form-control" id="caja" name="caja" readonly>
  </div>
  <div class="mb-3">
    <label for="movimiento" class="form-label">Tipo de Movimiento</label>
    <input style="width: 26rem;" type="text" class="form-control" id="movimiento" name="movimiento" readonly>
  </div>
  <div class="mb-3">
    <label for="monto" class="form-label">Monto</label>
    <input style="width: 26rem;" type="text" class="form-control" id="monto" name="monto" readonly>
  </div>
  <div class="mb-3">
    <label for="modalidad" class="form-label">Modalidad</label>
    <input style="width: 26rem;" type="text" class="form-control" id="modalidad" name="modalidad" readonly>
  </div>
  <div class="mb-3">
    <label for="concepto" class="form-label">Concepto</label>
    <input style="width: 26rem;" type="text" class="form-control" id="concepto" name="concepto" readonly>
  </div>
  <div class="mb-3">
    <label for="fecha" class="form-label">Fecha</label>
    <input style="width: 26rem;" type="text" class="form-control" id="fecha" name="fecha" readonly>
  </div>
  <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalModificar()">Cancelar</button>
                </div>
</form>
</div>
    </div>   
</div>


<script>
document.getElementById('btnAperturarCaja').addEventListener('click', function() {
    Swal.fire({
        title: 'Confirmar apertura',
        text: '¿Desea aperturar la caja en $0.00?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, aperturar',
        cancelButtonText: 'No, cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('statusInput').value = '1';
            document.getElementById('formAperturarCaja').submit();
        } else {
            document.getElementById('statusInput').value = '0';
            document.getElementById('formAperturarCaja').submit();
        }
    });
});
</script>



<script>
  const datosMovimientos = <?php echo json_encode($datosGrafico, JSON_NUMERIC_CHECK); ?>;
</script>



<div class="modal fade" id="reporteModal" tabindex="-1" role="dialog" aria-labelledby="reporteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">

      <div class="modal-header">
        <h5 class="modal-title" id="reporteModalLabel">Reporte de Compras</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <div class="modal-body" >
        <div class="row justify-content-center  align-items-center">
          <!-- Columna de botones -->
          <div class="col-md-5 col-lg-8 mb-4">
            <div class="d-flex flex-column gap-3">
                <button type="button" data-toggle="modal" data-target="#reporteModal1" class="btn btn-outline-primary btn-lg mb-3">Ingresos / Egresos Por Mes</button>
        
            </div>
          </div>
          <!-- Columna de tarjeta -->
         

      <div class="modal-footer justify-content-center">
        <button type="button" onclick="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>

    </div>
  </div>
</div>



<div class="modal fade" id="reporteModal1" tabindex="-1" role="dialog" aria-labelledby="reporteModalLabel1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="reporteModalLabel">Ingresos / Egresos por Mes</h5>
      </div>
        <canvas id="graficaMovimientos"></canvas>

        <div class="modal-footer justify-content-center">
        <button type="button" onclick="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
      </div>
    </div>
  </div>
</div>

 
<link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/reports/Movimiento.js"></script>
<script src="views/js/modal_movimiento.js"></script>
<script src="views/js/DataTables/datatables.js"></script>

</body>
</html>