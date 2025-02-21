<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Proveedor</title>
    <link rel="shortcut icon" href="views/img/logo.jpeg">
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/main.css">
    <link rel="stylesheet" href="views/css/dashboard.css">
    <link rel="stylesheet" href="views/css/dashboard_producto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="views/js/index.js"></script>
    <script src="views/js/validate2.js"></script>
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
            <form style="margin-top: 4rem;" class="formulario" action="crud_proveedor.php?action=agregar" method="post" name="form">
                <h1 style="margin-bottom: 0;" class="titulo">Agregar Proveedor</h1><br>  
                <?php if (!empty($message)): ?>
                <p class="alert alert-<?php echo ($message == "PROVEEDOR AGREGADO CORRECTAMENTE") ? 'success' : 'danger'; ?>">
                    <?php echo $message; ?>
                </p>
                <?php endif; ?>
                <b><label for="id">RIF del Proveedor
                <select name="tipo">
                    <option value="J-">J-</option>
                    <option value="G-">G-</option>
                </select>
                <input class="entrada" type="number" min="0" id="id2" name="id" placeholder="RIF del Proveedor" required oninput="validateId2()">
                </label></b>
                <span id="idError2" class="error-message"></span>
                <b><label for="nombre">Nombre del Proveedor
                <input class="entrada" type="text" id="nombrep" name="nombre" placeholder="Nombre del Proveedor" required oninput="validateAddress2()">
                </label></b>
                <span id="addressError2" class="error-message"></span>
                <b><label for="direccion">Direccion del Proveedor
                <input class="entrada" type="text" id="direccion" name="direccion" placeholder="Direccion del Proveedor" required oninput="validateAddress()"> 
                </label></b>
                <span id="addressError" class="error-message"></span>
                <b><label for="tlf">Tlf del Proveedor
                    <select name="codigo_tlf">
                    <option value="0412">0412</option>
                    <option value="0416">0416</option>
                    <option value="0426">0426</option>
                    <option value="0414">0414</option>
                    <option value="0424">0424</option>
                    </select>
                <input class="entrada" type="number" min="0" id="numero_tlf" name="numero_tlf" placeholder="Tlf del Proveedor" required oninput="validatePhone()"> 
            </label></b>
            <span id="phoneError" class="error-message"></span>
                <b><label for="id_representante">CI del Representante Legal
                <select name="tipo2" id="">
                    <option value="V-">V-</option>
                    <option value="E-">E-</option>
                </select>
                <input class="entrada" type="number" min="0" id="id" name="id_representante" placeholder="CI o RIF" required oninput="validateId()"> 
                </label></b>
                <span id="idError" class="error-message"></span>
                <b><label for="nombre_representante">Nombre del Representante Legal
                <input class="entrada" type="text" id="nombre" name="nombre_representante" placeholder="Nombre" required oninput="validateName()"> 
                </label></b>
                <span id="nameError" class="error-message"></span>
                <b><label for="tlf_representante">Tlf del Representante Legal
                    <select name="codigo_tlf_representante">
                    <option value="0412">0412</option>
                    <option value="0416">0416</option>
                    <option value="0426">0426</option>
                    <option value="0414">0414</option>
                    <option value="0424">0424</option>
                    <option value="0424">0251</option>
                    </select>
                <input class="entrada" type="number" min="0" id="numero_tlf2" name="numero_tlf_representante" placeholder="Tlf del representante" required oninput="validatePhone2()"> 
            </label></b>
            <span id="phoneError2" class="error-message"></span>
                <a href="crud_proveedor.php" class="hero__agg3" type="button">Cancelar</a>
                <input class="hero__agg2" onclick="return validateForm()" type="submit" value="Registrar">
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

.error-message {
    color: red;
}
</style>
</body>
</html>