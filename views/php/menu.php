<?php
// Assuming you have a session started and the user's role is stored in $_SESSION['rol']

$rol = $_SESSION['s_usuario']['rol']; // Get the user's role from the session

?>

<aside class="aside sb-sidenav">
    <header class="aside__hero sb-sidenav-header">
        <a href="index.php?action=dashboard"><img class="logo" src="views/img/logo.jpeg" alt="Logo"></a>
        <span style="color: white; margin-left:2rem;" >Teobar.CA</span>
    </header>
    <hr class="sidebar-divider my-0">
    <nav class="aside__navbar sb-sidenav-menu">
        <ul class="aside__list nav flex-column sb-sidenav-menu-nested nav">

        <?php if ($rol == 'Superusuario'): ?>
              <!-- Full Menu for Administrator -->
                <li class="aside__item nav-item"><a href="index.php?action=dashboard" class="aside__link nav-link">Home</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pedido&a=ecommerce" class="aside__link nav-link">E-conmerce</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pagina" class="aside__link nav-link">Pagina</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=usuario&a=d" class="aside__link nav-link">Usuarios</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=categoria" class="aside__link nav-link">Categorias</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=marca" class="aside__link nav-link">Marcas</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=tipo&a=t" class="aside__link nav-link">Tipo Productos</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=producto&a=d" class="aside__link nav-link">Productos</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=cliente&a=d" class="aside__link nav-link">Clientes</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=proveedor&a=d" class="aside__link nav-link">Proveedores</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=venta&a=v" class="aside__link nav-link">Ventas</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=compra&a=c" class="aside__link nav-link">Compras</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pago" class="aside__link nav-link">Pagos</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=movimientos" class="aside__link nav-link">Cajas Ingreso Egreso</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=reportes" class="aside__link nav-link">Reportes</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=bitacora" class="aside__link nav-link">Bitacora</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=roles" class="aside__link nav-link">Roles</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=notificacion" class="aside__link nav-link">Notificaciones</a></li>

            <?php elseif ($rol == 'Administrador'): ?>

                <!-- Full Menu for Administrator -->
                <li class="aside__item nav-item"><a href="index.php?action=dashboard" class="aside__link nav-link">Home</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pedido&a=ecommerce" class="aside__link nav-link">E-conmerce</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pagina" class="aside__link nav-link">Pagina</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=producto&a=d" class="aside__link nav-link">Productos</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=tipo&a=t" class="aside__link nav-link">Tipo Productos</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=cliente&a=d" class="aside__link nav-link">Clientes</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=proveedor&a=d" class="aside__link nav-link">Proveedores</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=venta&a=v" class="aside__link nav-link">Ventas</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=compra&a=c" class="aside__link nav-link">Compras</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pago" class="aside__link nav-link">Pagos</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=movimientos" class="aside__link nav-link">Cajas Ingreso Egreso</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=reportes" class="aside__link nav-link">Reportes</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=notificacion" class="aside__link nav-link">Notificaciones</a></li>

            <?php elseif ($rol == 'Contador'): ?>
                <!-- Full Menu for Administrator -->
                <li class="aside__item nav-item"><a href="index.php?action=dashboard" class="aside__link nav-link">Home</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pedido&a=ecommerce" class="aside__link nav-link">E-conmerce</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pagina" class="aside__link nav-link">Pagina</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=proveedor&a=d" class="aside__link nav-link">Proveedores</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=compra&a=c" class="aside__link nav-link">Compras</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pago" class="aside__link nav-link">Pagos</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=movimientos" class="aside__link nav-link">Cajas Ingreso Egreso</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=reportes" class="aside__link nav-link">Reportes</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=notificacion" class="aside__link nav-link">Notificaciones</a></li>

            <?php elseif ($rol == 'Vendedor'): ?>
                <!-- Limited Menu for Cajero -->
                <li class="aside__item nav-item"><a href="index.php?action=pedido&a=ecommerce" class="aside__link nav-link">E-conmerce</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pagina" class="aside__link nav-link">Pagina</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=cliente&a=d" class="aside__link nav-link">Clientes</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=venta&a=v" class="aside__link nav-link">Ventas</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=pago" class="aside__link nav-link">Pagos</a></li>
                <li class="aside__item nav-item"><a href="index.php?action=notificacion" class="aside__link nav-link">Notificaciones</a></li>

            <?php else: ?>
                <!-- Optional:  Default menu or error message if the role is not defined -->
                <li class="aside__item nav-item"><p class="nav-link">Acceso Denegado</p></li>
                <li class="aside__item nav-item"><a href="index.php?action=pagina" class="aside__link nav-link">Home</a></li>
            <?php endif; ?>

        </ul>
    </nav>
</aside>
