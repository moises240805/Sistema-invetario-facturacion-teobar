<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Venta</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard/ Ventas</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Ventas</h6>
            <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarVentaModal">
    Agregar Venta +
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
                <th>Nro Venta</th>
                <th>Producto</th>
                <th>Cliente</th>
                <th>Cantidad</th>
                <th>F/E</th>
                <th>Modalidad de Pago</th>
                <th>Monto</th>
                <th>Entrega</th>
                <th>Banco</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                        require_once "controllers/VentaController.php";


                $venta = new Venta();
                    
                $venta = $venta->Mostrar_Venta();
                
                foreach ($venta as $venta): 
            ?>
            <tr>
                <td><?php echo htmlspecialchars($venta['id_venta']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($venta['nombre'])); ?></td>
                <td><?php echo htmlspecialchars($venta['id_cliente']) . " " . htmlspecialchars($venta['nombre_cliente']); ?></td>
                <td><?php echo nl2br(htmlspecialchars($venta['cantidad'])); ?></td>
                <td><?php echo htmlspecialchars($venta['fech_emision']); ?></td>
                <td><?php echo htmlspecialchars($venta['nombre_modalidad']) . ' ' . htmlspecialchars($venta['tlf']); ?></td>
                <td><?php echo htmlspecialchars($venta['monto']); ?></td>
                <td><?php echo htmlspecialchars($venta['tipo_entrega']); ?></td>
                <td><?php echo htmlspecialchars($venta['nombre_banco']); ?></td>
                <td>
                    <a href="#" title="Modificar">
                        <img src="views/img/edit.png" width="30px" height="30px">
                    </a>
                    <a href="#" title="Eliminar" style="margin-left: 1rem;">
                        <img src="views/img/delet.png" width="30px" height="30px">
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php
                        require_once "controllers/ClienteController.php";

                        require_once "controllers/ProductoController.php";
?>


<div class="modal fade show" id="agregarVentaModal" tabindex="-1" role="dialog" aria-labelledby="agregarVentaModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="agregarVentaModalLabel">Agregar Venta</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario2" action="index.php?action=venta&a=agregar" method="post" name="form">
                <div class="modal-body">
                    <div class="container-fluid">


                        <?php


                        $banco = new Venta;
                        $bancos = $banco->obtenerBancos();

                        $pago = new Venta;
                        $pagos = $pago->obtenerPagos();



                        $cliente = new Cliente();
                        $clientes = $cliente->Mostrar_Cliente();



                        $producto = new Producto();
                        $productos = $producto->Mostrar_Producto2();
                        ?>
                       
                       <table class="table table-bordered" id="tablaFormulario">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="id_venta">Nro Venta</label>
                                            <input type="number" class="form-control" name="id_venta" placeholder="Nro VENTA" required oninput="validateInput(this)">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label for="id_cliente">Cliente</label>
                                            <div class="input-group">
                                                <select name="id_cliente" class="form-control">
                                                    <option value="">Seleccione Cliente</option>
                                                    <?php foreach ($clientes as $cliente): ?>
                                                        <option value="<?php echo $cliente['id_cliente']; ?>">
                                                            <?php echo $cliente['id_cliente'] . ' ' . $cliente['nombre_cliente']; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                                <div class="input-group-append">
                                                    <a class="btn btn-success" style="text-decoration: none;" href="crud_cliente.php?action=formulario">+</a>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label>Tipo de pago</label>
                                            <select name="id_modalidad_pago" class="form-control">
                                                <option value="5">Selecione pago</option>
                                                <option value="1">Divisas</option>
                                                <option value="2">Efectivo</option>
                                                <option value="3">Pago Movil</option>
                                                <option value="4">Transferencia</option>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label>Tipo de Compra</label>
                                            <select name="tipo_compra" class="form-control">
                                                <option value="">Selecione</option>
                                                <option value="5">Credito</option>
                                                <option value="6">Descontado</option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="form-group">
                                            <label for="id_banco">Banco</label>
                                            <select id="banco" name="rif_banco" class="form-control">
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
                                            <label for="tlf">Tlf o Nro.F</label>
                                            <input type="number" id="tlf" name="tlf" class="form-control" oninput="validatePhoneNumber(this)">
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
                                    <td colspan="4"><hr></td>
                                </tr>
                                <tr id="filaTemplate">
                                    <td>
                                        <div class="form-group">
                                            <label>Producto</label>
                                            <select name="id_producto[]" class="form-control" oninput="obtenerPrecioProducto()">
                                                <option>Seleccione un producto</option>
                                                <?php foreach ($productos as $producto): ?>
                                                    <option value="<?php echo htmlspecialchars(json_encode(['id_producto' => $producto['id_producto'], 'precio' => $producto['precio'], 'id_unidad_medida' => $producto['id_unidad_medida']])); ?>">
                                                        <?php echo $producto['nombre'] . ' ' . $producto['presentacion'] . ' ' . $producto['nombre_medida'] . ' - $' . number_format($producto['precio'], 2); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label>Cantidad</label>
                                            <input type="number" name="cantidad[]" class="form-control" placeholder="cantidad" required oninput="obtenerPrecioProducto()">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <label>Monto</label>
                                            <input type="number" step="0.01" name="monto" class="form-control" placeholder="monto" required readonly>
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
                            <input type="number" name="subtotal" class="form-control" readonly>
                        </div>
                        <p><b>+ IVA 16%.</b></p>
                        <div class="form-group">
                            <label for="monto">Total</label>
                            <input type="number" step="0.01" name="total" class="form-control" placeholder="MONTO TOTAL" required readonly>
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
        <button type="button" onclick="cerrarModal()" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>


    <script src="views/js/modal_venta.js"></script>
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

        function validateInput(input) {
    const value = input.value;
    if (value.length > 11) {
        alert("Por favor, ingresa un número de compra de hasta 11 caracteres.");
    }
}

function validatePhoneNumber(input) {
    const value = input.value;
    // Convert the number to a string to check its length
    if (value.toString().length > 11) {
        alert("Por favor, ingresa un número de teléfono de hasta 11 caracteres.");
        input.value = value.toString().slice(0, 11); // Truncate the input to the first 11 characters
    }
}

const today = new Date().toISOString().split('T')[0];
document.getElementById('fecha_registro').value = today;

</script>
</body>
</html>