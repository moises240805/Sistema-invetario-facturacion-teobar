<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Compra</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Compras</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Compras</h6>
            <button type="button" id="myBtn" class="btn btn-primary">
    Agregar Compra +
</button>
        </div>
        <div class="card-body">
        <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover datatablesss" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th>Nro Compra</th>
                <th>Producto</th>
                <th>Proveedor</th>
                <th>Cantidad</th>
                <th>F/E</th>
                <th>Modalidad de Pago</th>
                <th>Monto</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                //verifica si cliente existe o esta vacia en dado caso que este vacia muestra clientes no 
                // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                // si lo tiene muestra la informacion
                if(isset($compras) && is_array($compras) && !empty($compras)){
                foreach ($compras as $compra): 
            ?>
            <tr>
                <td><?php echo htmlspecialchars($compra['id_compra']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($compra['nombre'])); ?></td>
                <td><?php echo htmlspecialchars($compra['tipo_id'] . $compra['id_proveedor'] . " " . $compra['nombre_cliente']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($compra['cantidad'])); ?></td>
                <td><?php echo htmlspecialchars($compra['fecha']); ?></td>
                <td><?php echo htmlspecialchars($compra['nombre_modalidad']); ?></td>
                <td><?php echo htmlspecialchars($compra['monto']); ?></td>
                <td>
                    <a href="#" title="Modificar">
                        <img src="views/img/edit.png" width="30px" height="30px">
                    </a>
                    <a href="#" title="Eliminar" style="margin-left: 1rem;">
                        <img src="views/img/delet.png" width="30px" height="30px">
                    </a>
                </td>
            </tr>
            <?php
            //Imprime esta informacion en caso de estar vacia la variable             
            endforeach; 
        } else {
            echo "<tr><td colspan='6'>No hay compras registrados.</td></tr>";
        } ?>
        </tbody>
    </table>
</div>


<div class="modal fade show" id="abrirModal" tabindex="-1" role="dialog" aria-labelledby="agregarCompraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="agregarCompraModalLabel">Agregar Compra</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario2" action="index.php?action=compra&a=agregar" method="post" name="form">
                <div class="modal-body">
                    <div class="container-fluid">
                        <table class="table table-bordered" id="tablaFormulario">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="id_venta">Nro Compra</label>
                                            <input type="text" class="form-control" name="id_venta" placeholder="Nro Compra" maxlength="11"required oninput="validateInput(this)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label for="id_cliente">Proveedor</label>
                                            <div class="input-group">
                                                <select name="id_cliente" class="form-control">
                                                    <option value="">Seleccione Proveedor</option>
                                                    <?php foreach ($proveedores as $proveedor): ?>
                                                        <option value="<?php echo $proveedor['id_proveedor']; ?>">
                                                            <?php echo $proveedor['nombre_proveedor']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="input-group-append">
                                                    <a class="btn btn-success" style="text-decoration: none;" href="crud_proveedor.php?action=formulario">+</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label>Tipo de pago</label>
                                            <select name="id_modalidad_pago" class="form-control">
                                                <option value="">Seleccione pago</option>
                                                <?php foreach ($pagos as $pago): ?>
                                                    <option value="<?php echo $pago['id_modalidad_pago']; ?>">
                                                        <?php echo $pago['nombre_modalidad']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="id_banco">Banco</label>
                                            <select name="rif_banco" class="form-control">
                                                <option value="">Seleccione Banco</option>
                                                <?php foreach ($bancos as $banco): ?>
                                                    <option value="<?php echo $banco['rif_banco']; ?>">
                                                        <?php echo $banco['rif_banco'] . ' ' . $banco['nombre_banco']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label for="fech_emision">F/E</label>
                                            <input type="date" id="fecha_registro" name="fech_emision" class="form-control" placeholder="fecha_emision" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label for="tipo_entrega">Tipo entrega</label>
                                            <select name="tipo_entrega" class="form-control">
                                                <option value="">...</option>
                                                <option value="Directa">Directa</option>
                                                <option value="Delivery">Delivery</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="3"><hr></td>
                                </tr>
                                <tr id="filaTemplate">
                                    <td>
                                        <div class="form-group">
                                            <label>Producto</label>
                                            <select name="id_producto[]" class="form-control" oninput="obtenerPrecioProducto()">
                                                <option>Seleccione un producto</option>
                                                <?php foreach ($productos as $producto): ?>
                                                    <option value="<?php echo htmlspecialchars(json_encode(['id_producto' => $producto['id_producto'], 'id_unidad_medida' => $producto['id_unidad_medida']])); ?>">
                                                        <?php echo $producto['nombre'] . ' ' . $producto['presentacion'] . ' ' . ($producto['nombre_medida']); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label>Cantidad</label>
                                            <input type="text" name="cantidad[]" class="form-control" placeholder="cantidad" maxlength="11" required oninput="obtenerPrecioProducto()">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label>Monto</label>
                                            <input type="text" step="0.01" name="monto" class="form-control" placeholder="monto" maxlength="11" required>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="button" class="btn btn-danger" value="Eliminar" onclick="eliminarFila(this)">
                                            <input type="button" class="btn btn-success" value="Agregar fila" onclick="agregarFila()">
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="form-group">
                            <label for="subtotal">Sub Total</label>
                            <input type="text" name="subtotal" class="form-control" maxlength="11"> 
                        </div>
                        <div class="form-group">
                            <label for="monto">Total</label>
                            <input type="text" step="0.01" name="total" class="form-control" placeholder="MONTO TOTAL" maxlength="11" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" onclick="cerrarModal()" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <input class="btn btn-primary" type="submit" value="Registrar">
                </div>
            </form>
        </div>
    </div>
</div>




    <script src="views/js/modal_compra.js"></script>
    <script>
function agregarFila() {
  const tabla = document.getElementById("tablaFormulario");
  const nuevaFila = document.getElementById("filaTemplate").cloneNode(true);

            // No limpiar los valores en la nueva fila clonada
            // Solo asegurarse de que el evento se asigne correctamente
            const nuevoSelect = nuevaFila.querySelector("select[name='id_producto[]']");
            nuevoSelect.addEventListener('change', function() {
                obtenerPrecioProducto(nuevaFila);
            });

            const inputCantidad = nuevaFila.querySelector('input[name="cantidad[]"]');
            inputCantidad.addEventListener('input', function() {
                obtenerPrecioProducto(nuevaFila);
            });

            tabla.appendChild(nuevaFila);
        }
function eliminarFila(boton) {
    const fila = boton.parentNode.parentNode; // Obtiene la fila padre del botón
    fila.parentNode.removeChild(fila); // Elimina la fila
}



function obtenerPrecioProducto(fila) {
  const selectProducto = document.querySelector('select[name="id_producto[]"]');
  const inputCantidad = document.querySelector('input[name="cantidad[]"]');
  const inputMonto = document.querySelector('input[name="monto"]');
  const subtotalInput = document.querySelector('input[name="subtotal"]');
  const totalInput = document.querySelector('input[name="total"]');

  const selectedIndex = selectProducto.selectedIndex;
  const selectedOption = selectProducto.options[selectedIndex];
  const producto = JSON.parse(selectedOption.value);
  const precio = producto.precio;

  const cantidad = parseInt(inputCantidad.value);
  const monto = cantidad * precio;

  inputMonto.value = monto.toFixed(2);

  // Calculate subtotal, VAT, and total
  calcularSubtotalYTotal(); // Llamar a la función para actualizar subtotal y total
}

function calcularSubtotalYTotal() {
            let subtotal = 0;
            document.querySelectorAll('input[name="monto"]').forEach(montoInput => {
                subtotal += parseFloat(montoInput.value) || 0;
            });
            
            const iva = subtotal * 0.16;
            const total = subtotal + iva;

            document.querySelector('input[name="subtotal"]').value = subtotal.toFixed(2);
            document.querySelector('input[name="total"]').value = total.toFixed(2);
        }

        function validatePhoneNumber(input) {
    const value = input.value;
    // Convert the number to a string to check its length
    if (value.toString().length > 11) {
        alert("Por favor, ingresa un número de teléfono de hasta 11 caracteres.");
        input.value = value.toString().slice(0, 11); // Truncate the input to the first 11 characters
    }
}

function validateInput(input) {
    const value = input.value;
    if (value.length > 11) {
        alert("Por favor, ingresa un número de compra de hasta 11 caracteres.");
    }
}

</script>
<script src="views/js/validate.js"></script>

<link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/DataTables/datatables.js"></script>
</body>
</html>