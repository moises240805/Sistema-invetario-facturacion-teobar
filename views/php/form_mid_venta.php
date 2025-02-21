<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Venta</title>
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
        <header class="container">
            <form style="margin-top: 4rem;" class="formulario" action="#" method="post" name="form">
            <h1 class="titulo_form">Modificar Venta</h1><br>  
                <?php if (!empty($message)): ?>
        <p class="alert alert-<?php echo ($message == "VENTA ACTUALIZADA CORRECTAMENTE") ? 'success' : 'danger'; ?>">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>
    <?php
            $venta=$controller->Obtener_Venta($id_venta);
            ?>
            <label for="id_venta">ID VENTA</label>
            <input class="entrada" type="text" name="id_venta" value=<?php echo $venta['id_venta']; ?> required>
            <br><br>
            <label for="id_producto">ID PRODUCTO</label>
            <input class="entrada" type="text" name="id_producto" value=<?php echo $venta['id_producto']; ?> required>
            <br><br>
            <label for="id_cliente">ID CLIENTE</label>
            <input class="entrada" type="text" name="id_cliente" value=<?php echo $venta['id_cliente']; ?> required>
            <br><br>
            <label for="cantidad">CANTIDAD</label>
            <input class="entrada" type="text" name="cantidad" value=<?php echo $venta['cantidad']; ?> required>
            <br><br>
            <label for="fech_emision">FECHA DE EMISION</label>
            <input class="entrada" type="date" name="fech_emision" value=<?php echo $venta['fech_emision']; ?> required>
            <br><br>
            <label for="id_modalidad_pago">MODALIDAD DE PAGO</label>
            <input class="entrada" type="text" name="id_modalidad_pago" value=<?php echo $venta['id_modalidad_pago']; ?> required>
            <br><br>
            <label for="monto">MONTO TOTAL</label>
            <input class="entrada" type="text" name="monto" value=<?php echo $venta['monto']; ?> required>
            <br><br>
            <label for="tipo_entrega">TIPO DE ENTREGA</label>
            <input class="entrada" type="text" name="tipo_entrega" value=<?php echo $venta['tipo_entrega']; ?> required>
            <br><br>
            <label for="rif_banco">RIF BANCO</label>
            <input class="entrada" type="text" name="rif_banco" value=<?php echo $venta['rif_banco']; ?> required>
                <br>
                <a href="crud_venta.php" class="hero__agg3" type="button">Cancelar</a>
                <input onclick="return modificar()" class="hero__agg2" type="submit" value="Modificar">
            </form>
        </header>
    </main>
</div>
<script>
                function modificar(){
                var respuesta = confirm("¿Esta seguro que desea modificarlo?");
                return respuesta;
            }
</script>
</body>
</html>