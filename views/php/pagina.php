<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tienda Online</title>
    <link rel="stylesheet" href="views/css/styles.css">
</head>
<body>
<nav class="navbar">
    <div class="container">
        <a class="navbar-brand" href="#">Tienda Online</a>
        <button class="navbar-toggler" type="button" id="toggle-nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="nav-collapse" id="nav-collapse">
            <ul class="nav-list">
                <li class="nav-item"><a class="nav-link active" href="#">Inicio</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Productos</a></li>
            </ul>
            <form class="cart-form">
    <button class="cart-button" type="button" id="cart-link">
        Carrito
        <span class="cart-count" id="cart-count">0</span>
    </button>
</form>

            <!-- Botón de Iniciar Sesión -->
            <a href="index.php?action=login" class="login-button">Iniciar Sesión</a>
        </div>
    </div>
</nav>

<header class="header">
    <div class="container">
        <div class="header-content">
            <h1 class="header-title">Tienda Online</h1>
            <p class="header-description">Explora nuestros productos con estilo</p>
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
                    <img src="views/img/default-product.png" alt="<?php echo $producto['nombre']; ?>" class="product-image">
                    
                    <!-- Detalles del producto -->
                    <div class="product-details">
                        <h5 class="product-name"><?php echo $producto['nombre']; ?></h5>
                        <p class="product-description">
                            Presentación: <?php echo $producto['presentacion']; ?><br>
                            Cantidad: <?php echo nl2br(htmlspecialchars($producto['cantidad'])); ?> <?php echo nl2br(htmlspecialchars($producto['nombre_medida'])); ?><br>
                            Precio: <?php echo nl2br(htmlspecialchars($producto['precio'])); ?>
                        </p>
                    </div>

                    <!-- Botón de agregar al carrito -->
                    <div class="product-actions">
                    <button 
                        class="add-to-cart-button"
                        data-id="<?php echo $producto['id_producto']; ?>" 
                        data-name="<?php echo $producto['nombre']; ?>" 
                        data-price="<?php echo $producto['precio']; ?>"
                        data-presentation="<?php echo $producto['presentacion']; ?>">
                        Agregar al carrito
                    </button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section id="cart" style="display:none;">
    <div class="cart-header">
        <button id="close-cart" class="close-button">&times;</button>
        <h2>Carrito de Compras</h2>
    </div>
    <div id="cart-content"></div>
    <div id="cart-summary">
        <p id="subtotal">Subtotal: $0</p>
        <p id="taxes">Impuestos (10%): $0</p>
        <p id="total">Total: $0</p>
    </div>
    <button id="clear-cart">Vaciar carrito</button>
    <button id="checkout">Pagar</button>
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

<script src="./views/js/scripts.js"></script>

