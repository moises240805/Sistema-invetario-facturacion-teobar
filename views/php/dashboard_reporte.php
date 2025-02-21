<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Reportes</title>
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
    <section class="full-width text-center" style="padding: 0;">
    <h2 style="margin-top: .2rem;" class="titulo">Generar Reportes</h2>
        <div class="full-width tile">
            <form method="POST" action="reportes.php">
                <center><h4>Productos</h4></center>
                <label for="opciones">
                    <button class="pdf" type="submit" name="generar_pdf"><b>PDF</b></button>
                    Flitrar por:
                <select name="option" id="opciones">
                    <option value="">...</option>
                    <option value="tipo_producto">Tipo de Producto</option>
                    <option value="fecha">Fecha de Vencimiento</option>
                    <option value="stock">stokc</option>
                </select></label>
                <center><button class="filtrar" type="submit" name="enviar_opcion"><b>Flitrar</b></button></center>
            </form>
        </div>
        <div class="full-width tile">
            <form method="POST" action="reportes.php" >
                <center><h4>Clientes</h4></center>
                <label for="option">
                    <button class="pdf" type="submit" name="generar_pdf2"><b>PDF</b></button>
                    Flitrar por:
                <select name="option" id="opciones">
                    <option value="">...</option>
                    <option value="cliente_v">Ventas</option>
                </select></label>
                <center><button class="filtrar" type="submit" name="enviar_opcion"><b>Flitrar</b></button></center>
            </form>
        </div>
        <div class="full-width tile">
            <form method="POST" action="reportes.php">
                <center><h4>Proveedor</h4></center>
                <label for="option">
                    <button class="pdf" type="submit" name="generar_pdf3"><b>PDF</b></button>
                    Flitrar por:
                <select name="option" id="opciones">
                    <option value="">...</option>
                    <option value="proveedor_c">Compras</option>
                </select></label>
                <center><button class="filtrar" type="submit" name="enviar_opcion"><b>Flitrar</b></button></center>
        </form>
        </div>
        <div class="full-width tile">
            <form method="POST" action="reportes.php" >
                <center><h4>Ventas</h4></center>
                <label for="opciones">
                    <button class="pdf" type="submit" name="generar_pdf4"><b>PDF</b></button>
                    Flitrar por:
                <select name="option" id="opciones">
                    <option value="">...</option>
                    <option value="trans">Transferencias</option>
                    <option value="movil">Pago movil</option>
                    <option value="divisa">Divisa y efectivo</option>
                </select></label>
                <center><button class="filtrar" type="submit" name="enviar_opcion"><b>Flitrar</b></button></center>
        </form>
        </div>
        <div class="full-width tile">
            <form method="POST" action="reportes.php" >
                <center><h4>Cuentas por Cobrar</h4></center>
                <label for="opciones">
                    <button class="pdf" type="submit" name="generar_pdf5"><b>PDF</b></button>
                    Flitrar por:
                <select name="option" id="opciones">
                    <option value="">...</option>
                </select></label>
                <center><button class="filtrar" type="submit" name="enviar_opcion"><b>Flitrar</b></button></center>
        </form>
        </div>
        <div class="full-width tile">
            <form method="POST" action="reportes.php" >
                <center><h4>Compras</h4></center>
                <label for="opciones">
                    <button class="pdf" type="submit" name="generar_pdf6"><b>PDF</b></button>
                    Flitrar por:
                <select name="option" id="opciones">
                    <option value="">...</option>
                    <option value="trans_c">Transferencias</option>
                    <option value="movil_c">Pago movil</option>
                    <option value="divisa_c">Divisa y efectivo</option>
                </select></label>
                <center><button class="filtrar" type="submit" name="enviar_opcion"><b>Flitrar</b></button></center>
        </form>
        </div>
        <div class="full-width tile">
            <form method="POST" action="reportes.php" >
                <center><h4>Cuentas por Pagar</h4></center>
                <label for="opciones">
                    <button class="pdf" type="submit" name="generar_pdf7"><b>PDF</b></button>
                    Flitrar por:
                <select name="option" id="opciones">
                    <option value="">...</option>
                </select></label>
                <center><button class="filtrar" type="submit" name="enviar_opcion"><b>Flitrar</b></button></center>
        </form>
        </div>
        </section>
    </main>
    </div>
    <style>

    </style>
</body>
</html>