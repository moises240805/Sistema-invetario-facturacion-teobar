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
</a>
                                <a onclick="return eliminar()" href="index.php?action=compra&a=eliminar&id_compra=<?php echo $compra['id_compra']; ?>" title="Eliminar"><img src="views/img/delet.png" width="30px" height="30px"></a>
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
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_compra">Nro Compra</label>
                                    <input type="text" class="form-control" name="id_compra" placeholder="Nro Compra" maxlength="11" required oninput="validateInput(this)" value="<?=$numero_compra; ?>" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="id_proveedor">Proveedor</label>
                                    <div class="input-group">
                                        <select name="id_proveedor" id="id_proveedor" class="form-control" onchange="actualizarProductosPorProveedor()">
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
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Tipo de pago</label>
                                    <select id="id_modalidad_pago" name="id_modalidad_pago" class="form-control">
                                        <option value="">Seleccione pago</option>
                                        <?php foreach ($pagos as $pago): ?>
                                            <option value="<?php echo $pago['id_modalidad_pago']; ?>">
                                                <?php echo $pago['nombre_modalidad']; ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                            <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="fech_emision">F/E</label>
                                            <input type="date" id="fecha_registro" name="fech_emision" class="form-control" required>
                                        </div>
                                    </div>
                                                                        <div class="col-md-4" id="campo_caducidad" >
                                        <div class="form-group">
                                            <label for="fecha_caducidad">F/C</label>
                                            <input type="date" id="fecha_caducidad" name="fecha_caducidad" class="form-control" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="tipo_entrega">Tipo entrega</label>
                                            <select name="tipo_entrega" class="form-control">
                                                <option value="">...</option>
                                                <option value="Directa">Directa</option>
                                                <option value="Delivery">Delivery</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="rif_banco">Banco</label>
                                            <select name="rif_banco" id="rif_banco" class="form-control">
                                                <option value="">Seleccione Banco</option>
                                                <?php foreach ($bancos as $banco): ?>
                                                    <option value="<?php echo $banco['rif_banco']; ?>">
                                                        <?php echo $banco['rif_banco'] . ' ' . $banco['nombre_banco']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>
                        </div>
                        <hr>

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
                                            <select name="id_producto[]" id="id_producto" class="form-control productoSelect" oninput="obtenerPrecioProducto()">
                                                <option>Seleccione un producto</option>
                                                <!-- Opciones llenadas dinámicamente -->
                                            </select>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" name="cantidad[]" class="form-control cantidadInput" maxlength="10" placeholder="Cantidad" oninput="obtenerPrecioProducto()" required value="1">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group">
                                            <input type="number" step="0.01" name="monto" class="form-control montoInput" maxlength="11" placeholder="Monto" required readonly>
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

                        <div class="row mt-3">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="subtotal">Sub Total</label>
                                    <input type="number" name="subtotal" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <input type="checkbox" class="form-check-input" id="checkboxIva" checked>
                                    <label class="form-check-label" for="checkboxIva">Aplicar IVA (16%)</label>
                                    <input type="number" name="iva" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="total">Total</label>
                                    <input type="number" step="0.01" name="total" class="form-control" placeholder="MONTO TOTAL" required readonly>
                                </div>
                            </div>
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
// Función para actualizar el monto de una fila específica
function actualizarMontoFila(element) {
    const fila = element.closest('tr');
    const selectProducto = fila.querySelector("select[name='id_producto[]']");
    const inputCantidad = fila.querySelector("input[name='cantidad[]']");
    const inputMonto = fila.querySelector("input[name='monto']");

    const selectedOption = selectProducto.options[selectProducto.selectedIndex];
    if (!selectedOption || !selectedOption.value) {
        inputMonto.value = '';
        calcularSubtotalYTotal();
        return;
    }

    try {
        const producto = JSON.parse(selectedOption.value);
        const precio = producto.precio || 0;
        const cantidad = parseFloat(inputCantidad.value) || 0;
        const monto = cantidad * precio;
        inputMonto.value = monto.toFixed(2);
    } catch (error) {
        console.error("Error al parsear producto:", error);
        inputMonto.value = '';
    }
    calcularSubtotalYTotal();
}

// Función para agregar una nueva fila
function agregarFila() {
    const tabla = document.getElementById("tablaFormulario");
    const filaTemplate = document.getElementById("filaTemplate");
    const nuevaFila = filaTemplate.cloneNode(true);
    nuevaFila.removeAttribute('id');

    // Mostrar botón eliminar en filas nuevas
    const botonEliminar = nuevaFila.querySelector('.eliminarFilaBtn');
    if (botonEliminar) {
        botonEliminar.style.display = 'inline-block';
    }

    // Limpiar valores
    const selectProducto = nuevaFila.querySelector("select[name='id_producto[]']");
    const inputCantidad = nuevaFila.querySelector("input[name='cantidad[]']");
    const inputMonto = nuevaFila.querySelector("input[name='monto']");
    selectProducto.selectedIndex = 0;
    inputCantidad.value = 1;
    inputMonto.value = '';

    // Añadir eventos para actualizar monto al cambiar producto o cantidad
    selectProducto.addEventListener('change', () => actualizarMontoFila(selectProducto));
    inputCantidad.addEventListener('input', () => actualizarMontoFila(inputCantidad));

    tabla.querySelector('tbody').appendChild(nuevaFila);

    // Actualizar totales al agregar fila
    calcularSubtotalYTotal();
}

// Función para eliminar fila
function eliminarFila(boton) {
    const fila = boton.closest('tr');
    if (fila) {
        fila.remove();
        calcularSubtotalYTotal();
    }
}

// Función para calcular subtotal, iva y total con control de checkbox IVA
function calcularSubtotalYTotal() {
    let subtotal = 0;
    document.querySelectorAll('input[name="monto"]').forEach(input => {
        subtotal += parseFloat(input.value) || 0;
    });

    const checkboxIva = document.getElementById('checkboxIva');
    const aplicarIva = checkboxIva ? checkboxIva.checked : true; // Por defecto aplica IVA si no encuentra checkbox
    let iva = 0;
    let total = subtotal;

    if (aplicarIva) {
        iva = subtotal * 0.16;
        total = subtotal + iva;
    }

    const inputSubtotal = document.querySelector('input[name="subtotal"]');
    const inputIva = document.querySelector('input[name="iva"]');
    const inputTotal = document.querySelector('input[name="total"]');

    if (inputSubtotal) inputSubtotal.value = subtotal.toFixed(2);
    if (inputIva) inputIva.value = iva.toFixed(2);
    if (inputTotal) inputTotal.value = total.toFixed(2);
}

// Validaciones de inputs
function validateInput(input) {
    if (input.value.length > 11) {
        alert("Por favor, ingresa un número de compra de hasta 11 caracteres.");
        input.value = input.value.slice(0, 11);
    }
}

function validatePhoneNumber(input) {
    if (input.value.length > 11) {
        alert("Por favor, ingresa un número de teléfono de hasta 11 caracteres.");
        input.value = input.value.slice(0, 11);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Fecha actual en campo fecha_registro
    const fechaRegistro = document.getElementById('fecha_registro');
    if (fechaRegistro) {
        fechaRegistro.value = new Date().toISOString().split('T')[0];
    }

    // Inicializar fila template (la primera fila)
    const filaTemplate = document.getElementById('filaTemplate');
    if (filaTemplate) {
        const selectProducto = filaTemplate.querySelector('select[name="id_producto[]"]');
        const inputCantidad = filaTemplate.querySelector('input[name="cantidad[]"]');

        function actualizarMontoInicial() {
            if (!selectProducto) return;
            const selectedOption = selectProducto.options[selectProducto.selectedIndex];
            if (!selectedOption || !selectedOption.value) {
                filaTemplate.querySelector('input[name="monto"]').value = '';
                calcularSubtotalYTotal();
                return;
            }
            try {
                const producto = JSON.parse(selectedOption.value);
                const precio = producto.precio || 0;
                const cantidad = parseFloat(inputCantidad.value) || 0;
                const monto = cantidad * precio;
                filaTemplate.querySelector('input[name="monto"]').value = monto.toFixed(2);
            } catch (error) {
                console.error("Error al parsear producto en fila inicial:", error);
                filaTemplate.querySelector('input[name="monto"]').value = '';
            }
            calcularSubtotalYTotal();
        }

        selectProducto.addEventListener('change', actualizarMontoInicial);
        inputCantidad.addEventListener('input', actualizarMontoInicial);

        actualizarMontoInicial();
    }

    // Listener para checkbox IVA
    const checkboxIva = document.getElementById('checkboxIva');
    if (checkboxIva) {
        checkboxIva.addEventListener('change', calcularSubtotalYTotal);
    }

    // Manejo de visibilidad y lógica para tipo de pago (especialmente crédito)
    const tipoPagoSelect = document.getElementById('id_modalidad_pago');
    const filaBanco = document.getElementById('rif_banco') ? document.getElementById('rif_banco').closest('.form-group') : null;
    const campoCaducidad = document.getElementById('campo_caducidad');
    const fechaCaducidad = document.getElementById('fecha_caducidad');

    function manejarTipoPago() {
        const tipoPago = tipoPagoSelect.value;

        if (tipoPago === '5' || tipoPago === '1' || tipoPago === '2') { // Crédito
            if (filaBanco) filaBanco.style.display = 'none';
            if (campoCaducidad) {
                campoCaducidad.style.display = 'block';
                if (fechaRegistro && fechaCaducidad) {
                    const fechaEmision = new Date(fechaRegistro.value);
                    fechaEmision.setDate(fechaEmision.getDate() + 7);
                    fechaCaducidad.value = fechaEmision.toISOString().split('T')[0];
                }
            }
        } else {
            if (filaBanco) filaBanco.style.display = 'block';
            if (campoCaducidad) campoCaducidad.style.display = 'none';
        }
    }

    if (fechaRegistro) {
        fechaRegistro.addEventListener('change', () => {
            if (tipoPagoSelect.value === '5') {
                manejarTipoPago();
            }
        });
    }

    if (tipoPagoSelect) tipoPagoSelect.addEventListener('change', manejarTipoPago);

    manejarTipoPago();
});
</script>

<script src="views/js/validate.js"></script>



<script>
  const labelsCompra = <?php echo json_encode($labelsCompra); ?>;
  const dataCompra = <?php echo json_encode($dataCompra); ?>;

  const labelsProveedor = <?php echo json_encode($labelsProveedor); ?>;
  const dataProveedor = <?php echo json_encode($dataProveedor); ?>;

  const labelsModalidadCompra = <?php echo json_encode($labelsModalidadCompra); ?>;
  const dataModalidadCompra = <?php echo json_encode($dataModalidadCompra); ?>;

  const labelsProductoCompra = <?php echo json_encode($labelsProductoCompra); ?>;
  const dataProductoCompra = <?php echo json_encode($dataProductoCompra); ?>;
</script>


<script>
function actualizarProductosPorProveedor() {
    var proveedorId = document.getElementById('id_proveedor').value;
    var productoSelect = document.getElementById('id_producto');
    productoSelect.innerHTML = '<option>Cargando productos...</option>';

    if (proveedorId === "") {
        productoSelect.innerHTML = '<option>Seleccione un producto</option>';
        return;
    }

    fetch('index.php?action=compra&a=obtener_proveedor&id_proveedor=' + proveedorId)
        .then(response => response.json())
        .then(data => {
            productoSelect.innerHTML = '<option>Seleccione un producto</option>';
            data.forEach(function(producto) {
                var option = document.createElement('option');
                option.value = JSON.stringify({
                    id_producto: producto.id_producto,
                    id_unidad_medida: producto.id_unidad_medida,
                    precio: producto.precio
                });
                option.text = producto.nombre + ' ' + producto.presentacion + ' ' + producto.nombre_medida + ' ' + producto.id_unidad_medida;
                productoSelect.appendChild(option);
            });
        })
        .catch(function(error) {
            productoSelect.innerHTML = '<option>Error al cargar productos</option>';
            console.error('Error:', error);
        });
}
</script>


<link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/DataTables/datatables.js"></script>
</body>
</html>