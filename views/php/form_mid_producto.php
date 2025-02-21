<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Productos</title>
    <link rel="shortcut icon" href="views/img/logo.jpeg">
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/main.css">
    <link rel="stylesheet" href="views/css/dashboard.css">
    <link rel="stylesheet" href="views/css/dashboard_producto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="views/js/index.js"></script>
    <script src="views/js/calculator.js"></script>
    <script src="views/js/confirm.js"></script>
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
        <form class="formulario" action="crud_producto.php?action=actualizar" method="post" name="form">
            <h1 class="titulo_form">Modificar Producto</h1>
            <?php if (!empty($message)): ?>
        <p class="alert alert-<?php echo ($message == "PRODUCTO ACTUALIZADO CORRECTAMENTE") ? 'success' : 'danger'; ?>">
            <?php echo $message; ?>
        </p>
        <?php endif; ?>
        <?php
            $producto=$controller->Obtener_Producto($id_producto);

            ?>
            <?php
            require_once "models/Tipo.php"; // Asegúrate de que la ruta sea correcta
            $id_presentacion="";
            $tipo_producto="";
            $presentacion="";
            
            $tipo = new Tipo( $id_presentacion,$tipo_producto,
            $presentacion);
            $tipo->Mostrar_Tipo();
        ?>
            
            <input class="entrada" type="hidden" name="id_producto" value=<?php echo $producto['id_producto']; ?> required>
            <b><label for="nombre">Nombre del Producto
            <input class="entrada" type="text" name="nombre" value=<?php echo $producto['nombre']; ?> required>
            </label></b>
            <b><label style="margin-bottom: 10px;" for="nombre">Presentacion del Producto
                <select name="presentacion" id="">

                    <option value=<?php echo $producto['id_presentacion'] ?>><?php echo $producto['presentacion'] ?></option>

                </select>
            </label></b>
            <br>
            <b><label for="cantidad">Cantidad
            <input  style="width: 6rem;" class="entrada" type="number" min="0" name="cantidad" value=<?php echo $producto['cantidad']; ?> required>
            <input  style="width: 6rem;" class="entrada" type="number" min="0" name="cantidad2" value=<?php echo $producto['cantidad']; ?> required>
            <input  style="width: 6rem;" class="entrada" type="number" min="0" name="cantidad3" value=<?php echo $producto['cantidad']; ?> required>
            </label></b>
            <b><label for="precio">Precio
            <input  style="width: 6rem;" class="entrada" type="number" step="0.01" min="0" name="precio" value=<?php echo $producto['precio']; ?> required><b> $ Bs</b>
            <input  style="width: 6rem;" class="entrada" type="number" step="0.01" min="0" name="precio2" value=<?php echo $producto['precio']; ?> required><b> $ Bs</b>
            <input  style="width: 6rem;" class="entrada" type="number" step="0.01" min="0" name="precio3" value=<?php echo $producto['precio']; ?> required><b> $ Bs</b>
            </label></b>
            <b><label>U.M
            <input  style="width: 3rem;" class="entrada" type="number" min="0" name="peso" value=<?php echo $producto['peso']; ?> required oninput="calcularCantidad()">
                <select  name="uni_medida"  oninput="calcularCantidad()">
                    <option value=""></option>
                    <option value="4">Saco</option>
                    <option value="3">Bulto</option>
                    <option value="7">Galon</option>
                </select required>
                <select readonly name="uni_medida2">
                <option value=""></option>
                    <option value="1">Kilogramos</option>
                    <option value="5">Litros</option>
                </select required>
                <input  style="width: 3rem;" class="entrada" type="number" step="0.01" min="0" name="peso3" value=<?php echo $producto['peso']; ?> required oninput="calcularCantidad()">
                <select readonly name="uni_medida3">
                <option value=""></option>
                    <option value="2">Gramos</option>
                    <option value="6">Mililitro</option>
                </select required>
            </label></b>
            <b><label>Motivo de Actualizacion
                <select style="margin-bottom: 10px;" name="id_actualizacion">
                    <option value="">...</option>
                    <option value="2">Caducidad</option>
                </select required>
            </label></b>
            <b><label for="fecha_vencimiento">Fecha de vencimiento
            <input class="entrada" type="date" name="fecha_vencimiento" value=<?php echo $producto['fecha_vencimiento']; ?> required>
            </label></b>
            <a href="crud_producto.php" class="hero__agg3" type="button">Cancelar</a>
            <input onclick="return modificar()" class="hero__agg2" type="submit" value="Modificar">
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

</script>
</body>
</html>