<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teobar : Tienda Online</title>
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="shortcut icon" href="views/img/logo.jpeg">
<?php require_once 'alert.php';
require_once 'link.php'; ?>

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
                    <?php if ($_SESSION['s_usuario']["rol"] != "Usuario"): ?>
                    <a href="index.php?action=dashboard" class="login-button">Home</a>
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <a href="index.php?action=login" class="login-button">Iniciar Sesión</a>
                           <button type="button" class="btn btn-primary" id="myBtn" data-toggle="modal" data-target="#registrarClienteModal">
                            Registrar
                            </button>
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



<section class="products-by-category">
    <div class="container">
        <h2 class="section-title">Productos por Categoría</h2>
        <?php foreach ($productos_por_categoria as $categoria => $lista): ?>
            <div class="category-block">
                <div class="category-header">
                    <h3 class="category-title"><?php echo htmlspecialchars($categoria); ?></h3>
                </div>
                <div class="slider-wrapper">
                    <button class="slider-btn prev-btn" aria-label="Anterior">&lt;</button>
                    <div class="products-slider">
                        <?php foreach ($lista as $producto): ?>
                            <div class="product-card">
                                <img src="<?php echo $producto['enlace']; ?>" alt="<?php echo $producto['nombre']; ?>" class="product-image">
                                <div class="product-details">
                                    <h5><?php echo $producto['nombre']; ?></h5>
                                    <h6><?php echo nl2br(htmlspecialchars($producto['precio'])); ?> $</h6>
                                    <p>
                                        Presentación: <?php echo $producto['presentacion']; ?><br>
                                        Cantidad: <?php echo nl2br(htmlspecialchars($producto['cantidad'])); ?> <?php echo nl2br(htmlspecialchars($producto['nombre_medida'])); ?>
                                    </p>
                                </div>
                                <!-- Botón de agregar al carrito -->
                    <div class="product-actions">
                        <button 
    class="add-to-cart-button"
    data-id="<?php echo $producto['id_producto']; ?>" 
    data-name="<?php echo $producto['nombre']; ?>" 
    data-price="<?php echo $producto['precio']; ?>"
    data-presentation="<?php echo $producto['id_unidad_medida']; ?>"
    data-presentationM="<?php echo $producto['nombre_medida']; ?>"
    data-unidades='[{"id":1,"nombre":"Kg"},{"id":2,"nombre":"Gr"},{"id":3,"nombre":"Bulto"},{"id":4,"nombre":"Saco"},{"id":5,"nombre":"L"},{"id":6,"nombre":"ml"},{"id":7,"nombre":"Galon"}]'>
    Agregar al carrito
</button>
                    </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <button class="slider-btn next-btn" aria-label="Siguiente">&gt;</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>








<section class="products-section">
    <div class="container">
        <div class="products-grid">
            <?php 
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
    data-presentation="<?php echo $producto['id_unidad_medida']; ?>"
    data-presentationM="<?php echo $producto['nombre_medida']; ?>"
    data-unidades='[{"id":1,"nombre":"Kg"},{"id":2,"nombre":"Gr"},{"id":3,"nombre":"Bulto"},{"id":4,"nombre":"Saco"},{"id":5,"nombre":"L"},{"id":6,"nombre":"ml"},{"id":7,"nombre":"Galon"}]'>
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
                    <li><a href="#">TEOBARC.ADISTRIBUIDORA@gmail.com</a></li>
                    <li><a href="#">+58 424 561 48 48</a></li>
                    <li><a href="#">Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara</a></li>
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


<div class="modal fade" id="registrarClienteModal" tabindex="-1" role="dialog" aria-labelledby="agregarClienteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="registrarClienteModalLabel">Registrarse</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=usuario&a=registrar" method="post" name="form" id="miFormulario">
    <div class="modal-body">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-md-10">
                <div class="form-group row">
                    <label for="username" class="col-md-3">Usuario</label>
                        <div class="col-md-9">
                        <input type="text" class="form-control" id="username" name="username" maxlength="15" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="pw" class="col-md-3">Contraseña</label>
                        <div class="col-md-9">
                        <input type="password" class="form-control" id="password" name="password"  maxlength="9" required oninput="Password()">
                        <span id="Error" class="error-message"></span>
                    </div>
                </div>
                    <!-- CI del Cliente -->
                    <div class="form-group row justify-content-center mb-4">
                        <div class="col-md-10 text-center">
                            <label for="id" style="font-size: 18px;">Cedula de Identidad</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <select name="tipo_cedula" class="form-control">
                                    <option value="V-">V-</option>
                                    <option value="E-">E-</option>
                                </select>
                                <input type="text" class="form-control numeric" id="id" name="id_usuario" 
                                    placeholder="123456789" maxlength="8" required>
                            </div>
                            <span id="idError" class="error-message"></span>
                        </div>
                    </div>

                    <!-- Nombre -->
                    <div class="form-group row justify-content-center mb-4">
                        <div class="col-md-10 text-center">
                            <label for="nombre" style="font-size: 18px;">Nombre</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control alpha" id="nombre" name="nombre" 
                                placeholder="Nombre" maxlength="50" required>
                            <span id="nameError" class="error-message"></span>
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div class="form-group row justify-content-center mb-4">
                        <div class="col-md-10 text-center">
                            <label for="tlf" style="font-size: 18px;">Nro telefonico</label>
                        </div>
                        <div class="col-md-10">
                            <div class="input-group">
                                <select name="codigo_tlf" class="form-control">
                                    <option value="0412">0412</option>
                                    <option value="0416">0416</option>
                                    <option value="0426">0426</option>
                                    <option value="0414">0414</option>
                                    <option value="0424">0424</option>
                                    <option value="0251">0251</option>
                                </select>
                                <input type="text" class="form-control numeric" id="numero_tlf" name="telefono" 
                                    placeholder="Ejem: 1234567" maxlength="7" required>
                            </div>
                            <span id="phoneError" class="error-message"></span>
                        </div>
                    </div>

                    <!-- Email -->
                    <div class="form-group row justify-content-center mb-4">
                        <div class="col-md-10 text-center">
                            <label for="email" style="font-size: 18px;">Correo electronico</label>
                        </div>
                        <div class="col-md-10">
                            <input type="email" class="form-control" id="email" name="email" 
                                placeholder="user@gmail.com" maxlength="50" required>
                            <span id="emailError" class="error-message"></span>
                        </div>
                    </div>

                    <!-- Dirección -->
                    <div class="form-group row justify-content-center mb-4">
                        <div class="col-md-10 text-center">
                            <label for="direccion" style="font-size: 18px;">Dirección</label>
                        </div>
                        <div class="col-md-10">
                            <input type="text" class="form-control" id="direccion2" name="direccion" 
                                placeholder="Dirección" maxlength="120" required>
                            <span id="addressError" class="error-message"></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-footer justify-content-center">
        <button type="button" class="btn btn-secondary" onclick="cerrarModal()" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-primary">Registrar</button>
    </div>
</form>
        </div>
    </div>
</div>

<div id="modal-cedula" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; 
    background: rgba(0,0,0,0.5); justify-content:center; align-items:center;">
  <div style="background:#fff; padding:20px; border-radius:5px; width:300px;">
    <h3>Ingrese su cédula</h3>
    <input type="text" id="input-cedula" placeholder="Cédula" />
                                    <div class="form-group">
                                    <label>Tipo de pago</label>
                                    <select id="id_modalidad_pago" name="id_modalidad_pago" class="form-control">
                                        <option value="">Selecione pago</option>
                                        <option value="1">Divisas</option>
                                        <option value="2">Efectivo</option>
                                        <option value="3">Pago Movil</option>
                                        <option value="4">Transferencia</option>
                                    </select>
                                </div>
    <div style="margin-top:15px; text-align:right;">
      <button id="cancel-cedula">Cancelar</button>
      <button id="confirm-cedula">Confirmar</button>
    </div>
  </div>
</div>


<script>
  document.getElementById('myBtn').addEventListener('click', function() {
    $('#registrarClienteModal').modal('show');
  });
</script>

<style>
.products-by-category .container {
    padding: 30px 0 10px 0;
    background: #fafafa;
        display: block; /* o flex con dirección columna */
    width: 100%;
}

.category-block {
    margin-bottom: 40px;
}

.category-title {
    font-size: 1.3em;
    color: #2c3e50;
    font-weight: 600;
    margin: 0 0 12px 0;
    border-left: 4px solid #e67e22;
    padding-left: 10px;
}

.slider-wrapper {
    position: relative;
    display: flex;
    align-items: center;
}

.slider-btn {
    background: rgba(230,126,34,0.85);
    border: none;
    color: #fff;
    font-size: 1.7em;
    padding: 5px 12px;
    cursor: pointer;
    border-radius: 50%;
    user-select: none;
    z-index: 10;
    transition: background 0.2s;
}

.slider-btn:hover {
    background: #e67e22;
}

.prev-btn { margin-right: 8px; }
.next-btn { margin-left: 8px; }

.products-slider {
    display: flex;
    overflow-x: auto;
    scroll-behavior: smooth;
    gap: 16px;
    padding-bottom: 10px;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none;  /* IE 10+ */
    flex-grow: 1;
    /* Solo 4 productos visibles */
    width: calc(220px * 4 + 16px * 3); /* 4 cards + 3 gaps */
    max-width: 100%;
}

.products-slider::-webkit-scrollbar {
    display: none;
}

.product-card {
    flex: 0 0 220px;
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 10px rgba(44,62,80,0.07);
    padding: 12px;
    transition: transform 0.2s;
    display: flex;
    flex-direction: column;
    align-items: center;
}

.product-card:hover {
    transform: translateY(-4px) scale(1.03);
}

.product-image {
    width: 100%;
    height: 120px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
}

.product-details h5 {
    margin: 0 0 4px 0;
    font-size: 1.08em;
    color: #222;
    font-weight: 600;
    text-align: center;
}

.product-details h6 {
    color: #e67e22;
    margin-bottom: 5px;
    font-size: 1em;
    text-align: center;
}

.product-details p {
    font-size: 0.95em;
    color: #555;
    margin: 0;
    text-align: center;
}

/* Responsive para tablets */
@media (max-width: 1000px) {
    .products-slider {
        width: calc(170px * 3 + 16px * 2);
    }
    .product-card { flex: 0 0 170px; }
}
/* Responsive para móviles */
@media (max-width: 700px) {
    .products-slider {
        width: calc(120px * 2 + 16px * 1);
    }
    .product-card { flex: 0 0 120px; }
    .category-title { font-size: 1.05em; }
    .slider-btn { font-size: 1.2em; padding: 3px 7px;}
}

</style>

<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.slider-wrapper').forEach(wrapper => {
        const slider = wrapper.querySelector('.products-slider');
        const prevBtn = wrapper.querySelector('.prev-btn');
        const nextBtn = wrapper.querySelector('.next-btn');

        if (!slider || !prevBtn || !nextBtn) return;

        // Calcula el ancho total de una tarjeta + gap
        const card = slider.querySelector('.product-card');
        const gap = 16; // Debe coincidir con el gap en CSS
        const cardWidth = card ? card.offsetWidth + gap : 236;

        prevBtn.addEventListener('click', () => {
            slider.scrollBy({ left: -cardWidth * 2, behavior: 'smooth' });
        });

        nextBtn.addEventListener('click', () => {
            slider.scrollBy({ left: cardWidth * 2, behavior: 'smooth' });
        });
    });
});




</script>

    <script src="views/js/carrusel.js"></script>
    <script src="views/js/carrito.js"></script>
</body>
</html>
