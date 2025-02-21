<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Productos</title>
    <link rel="shortcut icon" href="views/img/logo.jpeg">
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/main.css">
    <link rel="stylesheet" href="views/css/dashboard.css">
    <link rel="stylesheet" href="views/css/dashboard_producto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="views/js/index.js"></script>
    <script src="views/js/calculator.js"></script>
    <script src="views/js/today.js"></script>
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
        <form class="formulario" action="crud_producto.php?action=agregar" method="post" name="form">
            <h1 class="titulo_form">Agregar Producto</h1>
            <?php if (!empty($message)): ?>
        <p class="alert alert-<?php echo ($message == "PRODUCTO AGREGADO CORRECTAMENTE") ? 'success' : 'danger'; ?>">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>
    <?php 
              require_once "models/Tipo.php"; // Asegúrate de que la ruta sea correcta
              $id_presentacion="";
              $tipo_producto="";
              $presentacion="";
              
              $producto = new Tipo( $id_presentacion,$tipo_producto,
              $presentacion);
              $productos = $producto->Mostrar_Tipo();
?>
    <b><label for="id_producto">Codigo del Producto
        <input class="entrada" type="number" min="0" name="id_producto" placeholder="Cog del Producto" required>
    </label></b>
            <b><label for="nombre">Nombre del Producto
                <input class="entrada" type="text" name="nombre" placeholder="Nombre del Producto" required>
            </label></b>
            <b><label for="nombre">Presentacion del Producto
                <select style="margin-bottom: 10px;" name="presentacion" id="">
                    <?php foreach ($productos as $producto): ?> 
                    <option value=<?php echo $producto['id_presentacion'] ?>><?php echo $producto['presentacion'] ?></option>
                    <?php endforeach; ?>
                </select>
            </label></b>
            <b><label for="cantidad">Cantidad
            <input style="width: 6rem;" class="entrada" type="number" id="number" min="0" name="cantidad" placeholder="Cantidad" required oninput="validateNumber2()">
            <input style="width: 6rem;" class="entrada" type="text" id="number" min="0" name="cantidad2" readonly placeholder="Cantidad" required oninput="validateNumber()">
            <input style="width: 6rem;" class="entrada" type="text" id="number" min="0" name="cantidad3" readonly placeholder="Cantidad" required oninput="validateNumber()">
            </label></b>
            <b><label for="precio">Precio
            <input style="width: 6rem;" class="entrada" type="number" step="0.01" id="number2" min="0" name="precio" placeholder="Precio" required oninput="validateNumber2()"><b> $ Bs</b>
            <input style="width: 6rem;" class="entrada" type="text" step="0.01"  id="number" min="0" name="precio2" readonly placeholder="Precio" required oninput="validateNumber()"><b> $ Bs</b>
            <input style="width: 6rem;" class="entrada" type="text" step="0.01" id="number" min="0" name="precio3" readonly placeholder="Precio" required oninput="validateNumber()"><b> $ Bs</b>
            </label></b>
            <b><label>U.M
            <input style="width: 3rem;" class="entrada" type="number" step="0.01" id="number2" min="0" name="peso" placeholder="Peso" required oninput="calcularCantidad()">
                <select name="uni_medida" oninput="calcularCantidad()">
                    <option value="">...</option>
                    <option value="4">Saco</option>
                    <option value="3">Bulto</option>
                    <option value="7">Galon</option>
                </select required>
                <select readonly name="uni_medida2" step="0.01">
                <option value="">...</option>
                    <option value="1">Kilogramos</option>
                    <option value="5">Litros</option>
                </select required>
                <input style="width: 3rem;" class="entrada" type="number" step="0.01" id="number2" min="0" name="peso3" placeholder="Peso" required oninput="calcularCantidad()">
                <select readOnly name="uni_medida3">
                <option value="">...</option>
                    <option value="2">Gramos</option>
                    <option value="6">Mililitro</option>
                </select required>
            </label></b>
            <b><label for="fech_venci">Fecha de Vencimiento
            <input class="entrada" type="date" name="fech_venci" id="fech_venci" placeholder="Fecha de Vencimiento" required oninput="validarFechaVencimiento();">
            </label></b>
            <b><label for="fech_venci">Fecha de Registro
            <input class="entrada" type="date" name="fecha_registro" id="fecha_registro" placeholder="Fecha de Registro" oninput="setFechaActual()" required>
            </label></b>
            <a href="crud_producto.php" class="hero__agg3" type="button">Cancelar</a>
            <input class="hero__agg2" type="submit" value="Registrar">
        </form>
    </header>
    </main>

</div>
</body>
</html>
<script>
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('fecha_registro').value = today;

        // Función para validar la fecha de vencimiento
function validarFechaVencimiento() {
    const fechaVencimientoInput = document.getElementById('fech_venci');
    
    // Escuchar el evento de cambio en el campo de fecha
    fechaVencimientoInput.addEventListener('change', function() {
        const fechaVencimiento = new Date(this.value);
        const fechaActual = new Date();
        
        // Establecer la fecha mínima como 15 días a partir de hoy
        const fechaMinima = new Date(fechaActual);
        fechaMinima.setDate(fechaActual.getDate() + 15);
        
        // Validar si la fecha de vencimiento es menor que la fecha mínima
        if (fechaVencimiento < fechaMinima) {
            alert('La fecha de vencimiento debe ser al menos 15 días a partir de hoy.');
            this.value = ''; // Limpiar el campo si no es válido
        }
    });
}

// Llamar a la función al cargar la página
validarFechaVencimiento();
</script>