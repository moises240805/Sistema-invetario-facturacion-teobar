<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Usuario</title>
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
        <center><form class="formulario" action="crud_admin.php?action=agregar" method="post" name="form">
            <h1 class="titulo_form">Agregar Usuario</h1>
            <?php if (!empty($message)): ?>
    <?php endif; ?>
    <br>
            <b><label for="username">Usuario
            <input class="entrada" type="text" min="0" name="username" required>
            </label></b>
            <b><label  for="rol">Rol
                <select style="margin-left: .3rem;" class="entrada" name="rol" id="" required>
                    <option value="">...</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Usuario">Usuario</option>
                </select required>    
            </label></b>
            <b><label for="pw">Password
            <input class="entrada" type="password" id="pw" name="pw" required oninput="Password()">
            </label></b>
            <span id="Error" class="error-message"></span>
            <br>
            <a href="crud_admin.php?action=d" class="hero__agg3" type="button">Cancelar</a>
            <input class="hero__agg2" onclick="return Password()" type="submit" value="Registrar">
        </form></center>
    </header>
    </main>
    <script>
function Password() {
    const idInput = document.getElementById('pw'); 
    const idError = document.getElementById('Error'); 
    idError.textContent = ""; // Limpiar mensaje de error

    // Verifica la longitud
    if (idInput.value.length < 6 || idInput.value.length > 9) { 
        idError.textContent = "La contraseña debe tener entre 6 y 9 caracteres."; 
        return false; // Salir de la función si hay un error
    }

    // Verifica si contiene al menos una mayúscula y un punto
    const tieneMayuscula = /[A-Z]/.test(idInput.value);
    const tienePunto = /\./.test(idInput.value);

    if (!tieneMayuscula || !tienePunto) {
        idError.textContent = "Debe contener una mayúscula y un punto."; 
        return false
    }
}
</script>

<style>
.error-message {
    color: red;
    font-size: 1rem;
}
</style>
</div>
</body>
</html>