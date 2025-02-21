<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Abono</title>
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
        <center><form class="formulario" action="crud_cobrar.php?action=abonado" method="POST" name="form">
            <h1 class="titulo_form">Abono</h1>
            <?php if (!empty($message)): ?>
        <p class="alert alert-<?php echo ($message == "ABONADO CORRECTAMENTE") ? 'success' : 'danger'; ?>">
            <?php echo $message; ?>
        </p>
    <?php endif; ?>
    <?php
            $admin=$_GET["id_cuenta"];
        ?>
    <br>
    <input name="id_cuenta" type="number" value="<?php echo $admin; ?>" style="display: none;">
    <b><label for="username">Fecha del Abono</label></b>
    <input class="entrada" type="date" name="fecha" required>
    <br><br>
    <b><label for="rol">Monto</label></b>
    <input class="entrada" type="number" step="0.01" min="0" name="monto" required>
    <br>
    <a href="crud_cobrar.php?action=cobrar" class="hero__agg3">Cancelar</a>
    <input class="hero__agg2" type="submit" value="Registrar">
</form></center>
    </header>
    </main>
<style>
    input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
</style>
</div>
</body>
</html>