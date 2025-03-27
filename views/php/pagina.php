<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teobar : Tienda Online</title>
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="shortcut icon" href="views/img/logo.jpeg">
</head>
<body>
<nav class="navbar">
    <div class="container">
        <!-- Logo -->
        <img src="views/img/logo.jpeg" alt="Logo" class="logo">
        <h1 class="navbar-brand">Teobar.ca</h1>

        <!-- Botón de toggle para pantallas pequeñas -->
        <button class="navbar-toggler" type="button" id="toggle-nav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú de navegación -->
        <div class="nav-collapse" id="nav-collapse">
            <!-- Enlaces de navegación -->
            <ul class="nav-list">
                <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Productos</a></li>
            </ul>
            <!-- Formulario de búsqueda -->
            <form class="search-form">
                <input type="search" placeholder="Buscar productos..." class="search-input">
                <button type="submit" class="search-button">Buscar</button>
            </form>


            <!-- Botón del carrito -->
            <div class="cart-button-container">
    <button class="cart-button">
        <img src="views/img/venta.png" alt="Carrito" class="cart-icon">
        <span id="cart-count" class="cart-count">0</span>
    </button>
</div>

            <!-- Información del usuario -->
            <?php if (isset($_SESSION['s_usuario'])): ?>
                <div class="user-info">
                    <img src="views/img/avatar-male.png" alt="user" class="user-avatar">
                    <span class="user-name"><?php echo $_SESSION['s_usuario']['usuario']; ?></span>
                    <a href="views/php/logout.php" class="logout-button">Cerrar Sesión</a>
                </div>
            <?php else: ?>
                <a href="index.php?action=login" class="login-button">Iniciar Sesión</a>
            <?php endif; ?>
        </div>
    </div>
</nav>



<header class="header">
    <div class="container">
        <div class="header-content">
            <div class="header-text">
                <h1 class="header-title">Tienda Online</h1>
                <div class="slogan-carousel">
                    <div class="slogan-slide active">
                        <p class="header-description">Explora nuestros productos con estilo</p>
                    </div>
                    <div class="slogan-slide">
                        <p class="header-description">Compras seguras y rápidas</p>
                    </div>
                    <div class="slogan-slide">
                        <p class="header-description">Descubre las últimas tendencias</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>



<section class="products-section">
    <div class="container">
        <div class="products-grid">
            <?php 
                require_once "controllers/ProductoController.php"; 
                $productos = $controller->Mostrar_Producto();
                foreach ($productos as $producto):
            ?>
                <div class="product-card">
                    <!-- Imagen del producto -->
                    <center><div class="product-image-container">
                        <img src="<?php echo $producto['enlace']; ?>" alt="<?php echo $producto['nombre']; ?>" class="product-image">
                    </div></center>
                    
                    <!-- Detalles del producto -->
                    <div class="product-details">
                        <h5 class="product-name"><?php echo $producto['nombre']; ?></h5>
                        <h6 class="product-price"><?php echo nl2br(htmlspecialchars($producto['precio'])); ?> $</h6>
                        <p class="product-description">
                            Presentación: <?php echo $producto['presentacion']; ?><br>
                            Cantidad Disponible: <?php echo nl2br(htmlspecialchars($producto['cantidad'])); ?> <?php echo nl2br(htmlspecialchars($producto['nombre_medida'])); ?><br>
                        </p>
                    </div>
                    <!-- Botón de agregar al carrito -->
                    <div class="product-actions">
                        <button 
                            class="add-to-cart-button"
                            data-id="<?php echo $producto['id_producto']; ?>" 
                            data-name="<?php echo $producto['nombre']; ?>" 
                            data-price="<?php echo $producto['precio']; ?>"
                            data-presentation="<?php echo $producto['nombre_medida']; ?>">
                            Agregar al carrito
                        </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Carrito de compras -->
    <div id="cart" style="display:none;">
        <div class="cart-header">
            <h2>Carrito de Compras</h2>
            <button class="close-button" id="close-cart">X</button>
        </div>
        
        <div id="cart-content">
            <!-- Aquí se mostrarán los productos del carrito -->
        </div>
        
        <div id="cart-summary">
            <p id="subtotal">Subtotal: $0.00</p>
            <p id="taxes">Impuestos (10%): $0.00</p>
            <p id="total">Total: $0.00</p>
        </div>
        
        <div class="cart-actions">
            <button id="clear-cart">Vaciar Carrito</button>
            <button id="checkout">Pagar</button>
        </div>
    </div>
</section>




<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <!-- Sección de contacto -->
            <div class="footer-section">
                <h5>Contacto</h5>
                <ul>
                    <li><a href="#">info@example.com</a></li>
                    <li><a href="#">+1 234 567 890</a></li>
                    <li><a href="#">Dirección: Calle Ejemplo 123, Ciudad, País</a></li>
                </ul>
            </div>

            <!-- Redes sociales -->
            <div class="footer-section">
                <h5>Redes Sociales</h5>
                <ul>
                    <li><a href="#" target="_blank">Facebook</a></li>
                    <li><a href="#" target="_blank">Twitter</a></li>
                    <li><a href="#" target="_blank">Instagram</a></li>
                </ul>
            </div>

            <!-- Enlaces rápidos -->
            <div class="footer-section">
                <h5>Enlaces Rápidos</h5>
                <ul>
                    <li><a href="#">Inicio</a></li>
                    <li><a href="#">Productos</a></li>
                    <li><a href="#">Contacto</a></li>
                </ul>
            </div>

        </div>

        <!-- Derechos reservados -->
        <p>&copy; 2023 Tienda Online. Todos los derechos reservados.</p>

    </div>  
</footer>

    <script src="views/js/carrusel.js"></script>
    <script src="views/js/scripts.js"></script>
</body>
</html>
