<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Central</title>
    <link rel="shortcut icon" href="views/img/logo.jpeg">
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/main.css">
    <link rel="stylesheet" href="views/css/dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="views/js/index.js"></script>
</head>
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
                <h3 class="text-center tittles" style="margin: .15rem;">PANEL DE CONTROL</h3>
                <!-- Tiles -->
                <a href="crud_admin.php?action=d"><article class="full-width tile">
                    <div class="tile-text">
                        <span class="text-condensedLight">
                            1<br>
                            <small>Usuarios</small>
                        </span>
                    </div>
                    <i class="zmdi zmdi-account tile-icon"><img src="views/img/user2.png" width="100rem" height="100rem" alt=""></i>
                </article></a>
                <a href="crud_producto.php"><article class="full-width tile">
                    <div class="tile-text">
                        <span class="text-condensedLight">
                            121<br>
                            <small>Productos</small>
                        </span>
                    </div>
                    <i class="zmdi zmdi-washing-machine tile-icon"><img src="views/img/producto.png" width="100rem" height="100rem" alt=""></i>
                </article></a>
                <a href="crud_cliente.php"><article class="full-width tile">
                    <div class="tile-text">
                        <span class="text-condensedLight">
                            71<br>
                            <small>Clientes</small>
                        </span>
                    </div>
                    <i class="zmdi zmdi-accounts tile-icon"><img src="views/img/clientes.png" width="100rem" height="100rem" alt=""></i>
                </article></a>
                <a href="crud_proveedor.php"><article class="full-width tile">
                    <div class="tile-text">
                        <span class="text-condensedLight">
                            7<br>
                            <small>Proveedores</small>
                        </span>
                    </div>
                    <i class="zmdi zmdi-truck tile-icon"><img src="views/img/proveedor.png" width="100rem" height="100rem" alt=""></i>
                </article></a>
                <a href="crud_venta.php"><article class="full-width tile">
                    <div class="tile-text">
                        <span class="text-condensedLight">
                            49<br>
                            <small>Ventas</small>
                        </span>
                    </div>
                    <i class="zmdi zmdi-washing-machine tile-icon"><img src="views/img/venta.png" width="100rem" height="100rem" alt=""></i>
                </article></a>
                <a href="crud_compra.php"><article class="full-width tile">
                    <div class="tile-text">
                        <span class="text-condensedLight">
                            14<br>
                            <small>Compras</small>
                        </span>
                    </div>
                    <i class="zmdi zmdi-account tile-icon"><img src="views/img/compra.png" width="100rem" height="100rem" alt=""></i>
                </article></a>
                <a href="crud_pago.php"><article class="full-width tile">
                    <div class="tile-text">
                        <span class="text-condensedLight">
                            47<br>
                            <small>Pagos</small>
                        </span>
                    </div>
                    <i class="zmdi zmdi-shopping-cart tile-icon"><img src="views/img/pagos.png" width="100rem" height="100rem" alt=""></i>
                </article></a>
            </section>
        </main>
    </div>
</body>
</html>