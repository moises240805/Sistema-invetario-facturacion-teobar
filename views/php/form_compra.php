<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Compra</title>
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
            <form style="margin-top: 3.5rem;" class="formulario2" action="crud_compra.php?action=agregar" method="post" name="form">
                <h1 style="margin-bottom: 0;" class="titulo">Agregar Compra</h1><br>  
                <?php if (!empty($message)):
                ?>
                <p class="alert alert-<?php echo ($message == "COMPRA AGREGADA CORRECTAMENTE") ? 'success' : 'danger'; ?>">
                    <?php echo $message; ?>
                </p>
                <?php endif; ?>  
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
                <center>
                <head>
                <body>
                <?php

                require_once "models/Venta.php";
                $banco= new Venta;
                $bancos=$banco->obtenerBancos();

                $pago= new Venta;
                $pagos=$pago->obtenerPagos();

                require_once "models/Proveedor.php";
                $id_proveedor="";
                $nombre_proveedor="";
                $direccion_proveedor="";
                $tlf_proveedor="";
                $id_representante_legal="";
                $nombre_representante_legal="";
                $tlf_representante_legal="";
                $tipo="";
                $tipo2="";

                 $cliente = new Proveedor($id_proveedor, $nombre_proveedor,
                 $direccion_proveedor, $tlf_proveedor, $id_representante_legal, 
                 $nombre_representante_legal, $tlf_representante_legal,$tipo,$tipo2);
                 $clientes = $cliente->Mostrar_Proveedor();

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
                        <b><label for="id_venta"> Nro Compra 
                        <input type="number" name="id_venta" placeholder="Nro Compra" required oninput="validateInput(this)"></label></b>
                      </td>

                      <td> 
                        <b><label for="id_cliente">Proveedor  
                        <select name="id_cliente" > 
                          <option value="">Seleccione Proveedor</option> 
                          <?php foreach ($clientes as $cliente): ?> 
                            <option value="<?php echo $cliente['id_proveedor']; ?>"> 
                              <?php echo $cliente['nombre_proveedor']; ?> 
                            </option> 
                          <?php endforeach; ?> 
                        </select> 
                        <button style="border-radius:6px; padding: 5px; border:none; background-color:lightgreen;"><a style="text-decoration: none;" href="crud_proveedor.php?action=formulario">+</a></button> 
                      </td>
                      
                      <td><b><label style="margin-left: 1rem;"> Tipo de pago
                        <select name="id_modalidad_pago">
                          <option value="">Selecione pago</option>
                          <?php foreach ($pagos as $pago): ?> 
                            <option value="<?php echo $pago['ID']; ?>"> 
                              <?php echo $pago['nombre_modalidad']; ?> 
                            </option> 
                          <?php endforeach; ?> 
                        </select>
                        </label></b>
                      </td>
                    </tr>
                    <tr>

                      <td>
                        <b><label for="id_banco">Banco
                        <select style="margin-top: 1rem; margin-right: 1rem" name="rif_banco">
                        <option value="">Seleccione Banco</option> 
                          <?php foreach ($bancos as $banco): ?> 
                            <option value="<?php echo $banco['rif_banco']; ?>"> 
                              <?php echo $banco['rif_banco'] . ' ' . $banco['nombre_banco']; ?> 
                            </option> 
                          <?php endforeach; ?> 
                        </select>
                        </label></b>
                      </td>

                      <td>
                        <b><label for="fech_emision"> F/E
                          <input style="margin-top: 1rem; margin-right: 1rem" type="date" id="fecha_registro" name="fech_emision" placeholder="fecha_emision" required>
                          </label></b>
                        </td>
                      
                      <td>
                        <b><label for="tipo_entrega" style="margin-left: 1rem;"> Tipo entrega
                        <select style="margin-top: 1rem; margin-right: 1rem" name="tipo_entrega">
                        <option value="">...</option>  
                        <option value="Directa">Directa</option>
                          <option value="Delivery">Delivery</option>
                        </select>
                        </label></b>
                      </td>
                  </tr>
                  <tr>
                    <td><hr></td>
                    <td><hr></td>
                    <td><hr></td>
                  </tr>
                  <tr id="filaTemplate">
                    <td>
                      <b><label> Producto
                        <select name="id_producto[]" style="margin-top: 1rem; margin-right: 1rem" oninput="obtenerPrecioProducto()">
                        <option>Seleccione un producto</option>
                        <?php foreach ($productos as $producto): ?>
                          <option value="<?php echo htmlspecialchars(json_encode(['id_producto' => $producto['id_producto'],  'id_unidad_medida' => $producto['id_unidad_medida']])); ?>">
                            <?php echo $producto['nombre'] . ' ' . $producto['presentacion'] . ' ' . ($producto['nombre_medida']);; ?>
                        </option>
                    <?php endforeach; ?>
                      </select></label></b></td>
                      <td><input style="margin-top: 1rem; margin-right: 1rem" type="number" name="cantidad[]" placeholder="cantidad" required oninput="obtenerPrecioProducto()"></td>
                      <td><input style="margin-top: 1rem; margin-right: 1rem" type="number" step="0.01" name="monto"  placeholder="monto" required >
                      <input style="margin-top: 1rem; margin-right: 1rem" type="button" value="Eliminar" onclick="eliminarFila(this)">
                      <input style="margin-top: 1rem; margin-right: 1rem" type="button" value="Agregar fila" onclick="agregarFila()"></td>
                    </tr>
                  </table>
                  <b><label for=""> Sub Total
                    <input style="margin-top: 1rem; margin-right: 1rem" type="number" name="subtotal" >
                  </label></b>
                  
                  <b><label for="monto"> Total
                    <input style="margin-top: 1rem; margin-right: 1rem" type="number" step="0.01" name="total" placeholder="MONTO TOTAL" required >
                  </label></b><br>
                </table>
                  <a href="crud_compra.php" class="hero__agg3" type="button">Cancelar</a>
                  <input class="hero__agg2" type="submit" value="Registrar"></center>
                </form>
              </header>
            </main>
          </div>
          <style>
            input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
          </style>
          <script>
                const today = new Date().toISOString().split('T')[0];
                document.getElementById('fecha_registro').value = today;
          </script>
</body>
</html>