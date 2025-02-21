<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Venta</title>
    <link rel="shortcut icon" href="views/img/logo.jpeg">
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/main.css">
    <link rel="stylesheet" href="views/css/dashboard.css">
    <link rel="stylesheet" href="views/css/dashboard_producto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="views/js/index.js"></script>
  </head>
<body>
<div id="root">
<header class="hero">
<b><div style="color: black; font-size:1.3rem;" id="precioDolar">Cargando...</div></b>
            <div class="user"><img class="logo_user" src="views/img/avatar-male.png" alt="user">
            <span name="user" style="color: black;" ><?php echo $_SESSION['s_usuario']['usuario'];?></span></div>
            <a href="views/php/logout.php" class="hero__logger">Log Out</a>
        </header>
        <aside class="aside">
            <header class="aside__hero">
                <a href="pag_inic.php"><img class="logo" src="views/img/logo.jpeg" alt="Logo"></a>
                <span style="color: white; margin-left:2rem;" >Teobar.CA</span>
            </header>
            <nav class="aside__navbar">
                <ul style="padding: 0;" class="aside__list">
                    <li class="aside__item"><a href="pag_inic.php" class="aside__link">Home</a></li>
                    <li class="aside__item"><a href="crud_admin.php?action=d" class="aside__link">Usuarios</a></li>
                    <li class="aside__item"><a href="crud_producto.php" class="aside__link">Productos</a></li>
                    <li class="aside__item"><a href="crud_tipo.php" class="aside__link">Tipo Productos</a></li>
                    <li class="aside__item"><a href="crud_cliente.php" class="aside__link">Clientes</a></li>
                    <li class="aside__item"><a href="crud_proveedor.php" class="aside__link">Proveedores</a></li>
                    <li class="aside__item"><a href="crud_venta.php" class="aside__link">Ventas</a></li>
                    <li class="aside__item"><a href="crud_compra.php" class="aside__link">Compras</a></li>
                    <li class="aside__item"><a href="crud_pago.php" class="aside__link">Pagos</a></li>
                    <li class="aside__item"><a href="reportes.php" class="aside__link">Reportes</a></li>
                </ul>            
            </nav>
        </aside>
        <main class="main">
        <header>
          <div class="div2">
            <form class="formulario2" action="crud_venta.php?action=agregar" method="post" name="form">
                <h1 style="margin-bottom: 0;" class="titulo">Agregar Venta</h1><br>  
                <?php if (!empty($message)):
                ?>
                <p class="alert alert-<?php echo ($message == "VENTA AGREGADO CORRECTAMENTE") ? 'success' : 'danger'; ?>">
                    <?php echo $message; ?>
                </p>
                <?php endif; ?>  
                <center>
                <head>
                <body>
                <?php

                require_once "models/Cliente.php";
                require_once "models/Venta.php";
                $banco= new Venta;
                $bancos=$banco->obtenerBancos();

                $pago= new Venta;
                $pagos=$pago->obtenerPagos();

                 $id_cliente="";
                 $nombre_cliente="";
                 $tlf_cliente="";
                 $direccion_cliente="";
                 $email_cliente="";
                 $tipo="";

                 $cliente = new Cliente($id_cliente, $nombre_cliente,
                 $tlf_cliente, $direccion_cliente,$email_cliente,$tipo);
                 $clientes = $cliente->Mostrar_Cliente();

                require_once "models/Producto.php"; // Asegúrate de que la ruta sea correcta
              $id_producto="";
              $nombre_producto="";
              $presentacion="";
              $fech_vencimiento="";
              $cantidad_producto="";
              $cantidad_producto2="";
              $cantidad_producto3="";
              $precio_producto="";
              $precio_producto2="";
              $precio_producto3="";
              $uni_medida="";
              $uni_medida2="";
              $uni_medida3="";
              $id_actualizacion="";
              $marca="";
              $peso="";
              $peso2="";
              $peso3="";

              $producto = new Producto( $id_producto,$nombre_producto,
              $presentacion,$fech_vencimiento, $cantidad_producto,$cantidad_producto2,$cantidad_producto3, 
              $precio_producto,$precio_producto2,$precio_producto3, $uni_medida,$uni_medida2,$uni_medida3,$marca,$peso,$peso2,$peso3, $id_actualizacion);
              $productos = $producto->Mostrar_Producto2();
                ?>
                  <table id="tablaFormulario"> 
                  <tr>

                      <td>
                        <b><label style="margin-left: 1rem;" for="id_venta"> Nro Venta 
                        <input type="number" name="id_venta" placeholder="Nro VENTA" required oninput="validateInput(this)"></label></b>
                      </td>

                      <td> 
                        <b><label for="id_cliente">Cliente  
                        <select name="id_cliente" > 
                          <option value="">Seleccione Cliente</option> 
                          <?php foreach ($clientes as $cliente): ?> 
                            <option value="<?php echo $cliente['id_cliente']; ?>"> 
                              <?php echo $cliente['id_cliente'] . ' ' . $cliente['nombre_cliente']; ?> 
                            </option> 
                          <?php endforeach; ?> 
                        </select>
                        <button style="border-radius:6px; padding: 5px; border:none; background-color:lightgreen;"><a style="text-decoration: none;" href="crud_cliente.php?action=formulario">+</a></button></label>
                      </td>
                      
                      <td><b><label > Tipo de pago
                        <select name="id_modalidad_pago">
                          <option value="5">Selecione pago</option>
                          <option value="1">Divisas</option>
                          <option value="2">Efectivo</option>
                          <option value="3">Pago Movil</option>
                          <option value="4">Transferencia</option>
                        </select>
                        </label></b>
                      </td>

                      <td>
                      <b><label > Tipo de Compra
                        <select name="tipo_compra">
                          <option value="">Selecione</option>
                          <option value="5">Credito</option>
                          <option value="6">Descontado</option>
                        </select>
                        </b>
                      </td>
                    </tr>
                    <tr>

                      <td>
                        <b><label style="margin-left: 1rem;" for="id_banco">Banco
                        <select id="banco" style="margin-top: 1rem; margin-right: 1rem" name="rif_banco">
                        <option value="">Seleccione Banco</option> 
                          <?php foreach ($bancos as $banco): ?> 
                            <option value="<?php echo $banco['rif_banco']; ?>"> 
                              <?php echo $banco['rif_banco'] . ' ' . $banco['nombre_banco']; ?> 
                            </option> 
                          <?php endforeach; ?> 
                        </select>
                      </td>

                      <td>
                      </label></b>
                      <b><label for="tlf">Tlf o Nro.F 
                      <input  type="number" id="tlf" name="tlf" oninput="validatePhoneNumber(this)">
                        </label></b>
                      </td>

                      <td>
                        <b><label for="fech_emision"> F/E
                          <input style="margin-top: 1rem; margin-right: 1rem" type="date" id="fecha_registro" name="fech_emision" placeholder="fecha_emision" required>
                          </label></b>
                        </td>
                      
                      <td>
                        <b><label for="tipo_entrega" ;"> Tipo entrega
                        <select name="tipo_entrega">
                        <option value="">...</option>  
                        <option value="Directa">Directa</option>
                          <option value="Delivery">Delivery</option>
                        </select>
                        </b>
                      </td>
                  </tr>
                  <tr>
                    <td><hr></td>
                    <td><hr></td>
                    <td><hr></td>
                    <td><hr></td>
                  </tr>
                  <tr id="filaTemplate">
                    <td>
                      <b><label style="margin-left: 1rem;"> Producto
                        <select name="id_producto[]" style="margin-top: 0rem; margin-right: 1rem" oninput="obtenerPrecioProducto()">
                        <option>Seleccione un producto</option>
                        <?php foreach ($productos as $producto): ?>
                          <option value="<?php echo htmlspecialchars(json_encode(['id_producto' => $producto['id_producto'], 'precio' => $producto['precio'], 'id_unidad_medida' => $producto['id_unidad_medida']])); ?>">
                            <?php echo $producto['nombre'] . ' ' . $producto['presentacion'] . ' ' . $producto['nombre_medida'] . ' - $' . number_format($producto['precio'], 2);; ?>
                        </option>
                    <?php endforeach; ?>
                      </select></label></b></td>
                      <td><input  type="number" name="cantidad[]" placeholder="cantidad" required oninput="obtenerPrecioProducto()"></td>
                      <td><input  type="number" step="0.01" name="monto"  placeholder="monto" required readonly></td>
                      <td><input  type="button" value="Eliminar" onclick="eliminarFila(this)">
                      <input  type="button" value="Agregar fila" onclick="agregarFila()"></td>
                    </tr>
                  </table>
                  <b><label style="margin-top: 1rem;" for=""> Sub Total
                    <input type="number" name="subtotal" readonly>
                  </label></b>
                  <p style="margin: 0;"><b>+ IVA 16%.</b></p>
                  <b><label for="monto"> Total
                    <input  type="number" step="0.01" name="total" placeholder="MONTO TOTAL" required readonly>
                  </label></b><br>
                </table>
                  <a href="crud_venta.php" class="hero__agg3" type="button">Cancelar</a>
                  <input class="hero__agg2" type="submit" value="Registrar"></center>
                </form>
                </div>
              </header>
            </main>
          </div>
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