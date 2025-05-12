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
            require_once "alert.php";
            //require_once "menu.php";
            ?>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Ventas</h1>
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
        <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover datatablesss" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
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
                //verifica si cliente existe o esta vacia en dado caso que este vacia muestra clientes no 
                // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                // si lo tiene muestra la informacion
                if(isset($venta) && is_array($venta) && !empty($venta)){ 
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
                    <?php
                    //Imprime esta informacion en caso de estar vacia la variable             
                    endforeach; 
                } else {
                    echo "<tr><td colspan='6'>No hay ventas registrados.</td></tr>";
                }
            ?>
        </tbody>
    </table>
</div>







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
                        <div class="row">
                        <table class="table table-bordered" id="tablaFormulario">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Monto</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr id="filaTemplate">
                                    <td>
                                        <div class="form-group">
                                            <select name="id_producto[]" class="form-control productoSelect" oninput="actualizarMonto()">
                                                <option value="">Seleccione un producto</option>
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
                                            <input type="number" name="cantidad[]" class="form-control cantidadInput" maxlength="10"  onkeypress="return SoloNumeros(event)" placeholder="cantidad" oninput="actualizarMonto()" required value="1">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" step="0.01" name="monto" class="form-control montoInput" maxlength="10"  onkeypress="return SoloNumeros(event)" maxlength= "11" placeholder="monto" required readonly>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <button type="button" style="display:none;" class="btn btn-danger eliminarFilaBtn" onclick="eliminarFila(this)">Eliminar</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-success" onclick="agregarFila()">Agregar Producto</button>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="subtotal">Sub Total</label>
                                    <input type="number" name="subtotal" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="iva">IVA (16%)</label>
                                    <input type="number" name="iva" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="monto">Total</label>
                                    <input type="number" step="0.01" name="total" class="form-control" placeholder="MONTO TOTAL" required readonly>
                                </div>
                            </div>
                        </div>
                        <hr>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_venta">Nro Venta</label>
                                    <input type="number" class="form-control" name="id_venta" placeholder="Nro VENTA" required oninput="validateInput(this)" value="<?=$numero_venta; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de Compra</label>
                                    <select name="tipo_compra" class="form-control">
                                        <option value="">Selecione</option>
                                        <option value="5">Credito</option>
                                        <option value="6">Contado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Tipo de pago</label>
                                    <select id="id_modalidad_pago" name="id_modalidad_pago" class="form-control">
                                        <option value="">Selecione pago</option>
                                        <option value="1">Divisas</option>
                                        <option value="2">Efectivo</option>
                                        <option value="3">Pago Movil</option>
                                        <option value="4">Transferencia</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="id_banco">Banco</label>
                                    <select id="banco" name="rif_banco" class="form-control">
                                        <option value="">Seleccione Banco</option>
                                        <?php foreach ($bancos as $banco): ?>
                                            <option value="<?php echo $banco['rif_banco']; ?>">
                                                <?php if($banco['rif_banco']!="0"){ echo "0"; } echo $banco['rif_banco'] . ' ' . $banco['nombre_banco']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tlf">Tlf o Nro.F</label>
                                    <!-- onkeypress="return SoloNumeros(event)" -->
                                    <input type="number" id="tlf" name="tlf"  maxlength="11"  oninput="validatePhoneNumber(this)" class="form-control" >
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="fech_emision">F/E</label>
                                    <input type="date" id="fecha_registro" min="<?=date('Y-m-d', time()-((60*60)*24)); ?>" max="<?=date('Y-m-d'); ?>" name="fech_emision" class="form-control" placeholder="fecha_emision" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="`fech_vencimiento`">F/C</label>
                                    <input type="date" id="fecha_vencimiento" min="<?=date('Y-m-d'); ?>" max="<?=date('Y-m-d', time()+(((60*60)*24*7))); ?>" value="<?=date('Y-m-d', time()+(((60*60)*24*7))); ?>" name="fech_vencimiento" class="form-control" placeholder="fecha_vencimiento" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipo_entrega">Tipo entrega</label>
                                    <select name="tipo_entrega" class="form-control">
                                        <option value="">...</option>
                                        <option value="Directa">Directa</option>
                                        <option value="Delivery">Delivery</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <hr>


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






    <script src="views/js/modal_venta.js"></script>
    <script>
function agregarFila() {
    const tabla = document.getElementById("tablaFormulario");
    const filaTemplate = document.getElementById("filaTemplate");
    const nuevaFila = filaTemplate.cloneNode(true);
    nuevaFila.removeAttribute('id'); // Remove id to avoid duplicate IDs

    // Obtener referencia al botón de eliminar en la nueva fila
    const botonEliminar = nuevaFila.querySelector('.eliminarFilaBtn');

    // Si el botón de eliminar existe, lo mostramos
    if (botonEliminar) {
        botonEliminar.style.display = ''; // O 'block' según tu estilo
    }

    // Get references to the select and input elements in the new row
    const nuevoSelect = nuevaFila.querySelector("select[name='id_producto[]']");
    const inputCantidad = nuevaFila.querySelector('input[name="cantidad[]"]');
    const inputMonto = nuevaFila.querySelector('input[name="monto"]');
    // Function to update monto
    function actualizarMonto() {
        const selectedIndex = nuevoSelect.selectedIndex;
        if (selectedIndex === -1) return; // No product selected

        const selectedOption = nuevoSelect.options[selectedIndex];
        if (!selectedOption || !selectedOption.value) return;

        try {
            const producto = JSON.parse(selectedOption.value);
            const precio = producto.precio;
            const cantidad = parseInt(inputCantidad.value || 0);
            const monto = cantidad * precio;

            inputMonto.value = monto.toFixed(2);
        } catch (error) {
            console.error("Error parsing product data:", error);
            inputMonto.value = '';
        }

        calcularSubtotalYTotal();
    }

    // Attach event listeners to the new row elements
    nuevoSelect.addEventListener('change', actualizarMonto);
    inputCantidad.addEventListener('input', actualizarMonto);

    // Make sure initial event is triggered
    actualizarMonto();

    tabla.querySelector('tbody').appendChild(nuevaFila);
}

function eliminarFila(boton) {
    const fila = boton.closest('tr'); // Gets the closest <tr> ancestor of the button
    fila.parentNode.removeChild(fila); // Removes the row
    calcularSubtotalYTotal(); // Recalculate totals after removing a row
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
        input.value = value.slice(0, 11);
    }
}

function validatePhoneNumber(input) {
    const value = input.value;
    if (value.toString().length > 11) {
        alert("Por favor, ingresa un número de teléfono de hasta 11 caracteres.");
        input.value = value.toString().slice(0, 11);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('fecha_registro').value = today;

    // Inicializar la fila template
    const initialSelect = document.querySelector('#filaTemplate select[name="id_producto[]"]');
    const initialCantidadInput = document.querySelector('#filaTemplate input[name="cantidad[]"]');

    function actualizarMontoInicial() {
        if (!initialSelect) return;
        const selectedIndex = initialSelect.selectedIndex;
        if (selectedIndex === -1) return;

        const selectedOption = initialSelect.options[selectedIndex];
        if (!selectedOption || !selectedOption.value) return;

        try {
            const producto = JSON.parse(selectedOption.value);
            const precio = producto.precio;
            const cantidad = parseInt(initialCantidadInput.value || 0);
            const monto = cantidad * precio;

            document.querySelector('#filaTemplate input[name="monto"]').value = monto.toFixed(2);
        } catch (error) {
            console.error("Error parsing product data:", error);
            document.querySelector('#filaTemplate input[name="monto"]').value = '';
        }
        calcularSubtotalYTotal();
    }

    initialSelect.addEventListener('change', actualizarMontoInicial);
    initialCantidadInput.addEventListener('input', actualizarMontoInicial);

    actualizarMontoInicial(); // Llama a la función al cargar la página
});

      
      

document.addEventListener('DOMContentLoaded', () => {
    const tipoCompraSelect = document.querySelector('select[name="tipo_compra"]');
    const tipoPagoSelect = document.querySelector('select[name="id_modalidad_pago"]');

    // Función para manejar el tipo de compra
    function manejarTipoCompra() {
        const tipoCompra = tipoCompraSelect.value;
        const filaTipoPago = document.querySelector('#id_modalidad_pago').closest('.form-group');
        const filaBanco = document.querySelector('#banco').closest('.form-group');
        const filaTlf = document.querySelector('#tlf').closest('.form-group');
        const filaTipoEntrega = document.querySelector('select[name="tipo_entrega"]').closest('.form-group');
        if (tipoCompra === '5') { // Crédito
            filaTipoPago.style.display = 'none';
            filaBanco.style.display = 'none';
            filaTlf.style.display = 'none';
            filaTipoEntrega.style.display = 'none';
        } else if (tipoCompra === '6') { // Descontado
            filaTipoPago.style.display = 'block';
            filaBanco.style.display = 'block';
            filaTlf.style.display = 'block';
            filaTipoEntrega.style.display = 'block';
        } else { // Sin selección
            filaTipoPago.style.display = 'block';
            filaBanco.style.display = 'block';
            filaTlf.style.display = 'block';
            filaTipoEntrega.style.display = 'block';
        }
    }

    // Función para manejar el tipo de pago
    function manejarTipoPago() {
        const tipoPago = tipoPagoSelect.value;
        const filaBanco = document.querySelector('#banco').closest('.form-group');
        const filaTlf = document.querySelector('#tlf').closest('.form-group');

        if (tipoPago === '1' || tipoPago === '2') { // Divisas o Efectivo
            filaBanco.style.display = 'none';
            filaTlf.style.display = 'none';
        } else { // Otras opciones
            filaBanco.style.display = 'block';
            filaTlf.style.display = 'block';
        }
    }

    // Agregar listeners para cambios en los selectores
    tipoCompraSelect.addEventListener('change', manejarTipoCompra);
    tipoPagoSelect.addEventListener('change', manejarTipoPago);

    // Llamar las funciones al inicio para configurar según la selección inicial
    manejarTipoCompra();
    manejarTipoPago();
});
</script>
<script src="views/js/validate2.js"></script>

<link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/DataTables/datatables.js"></script>

</body>
</html>