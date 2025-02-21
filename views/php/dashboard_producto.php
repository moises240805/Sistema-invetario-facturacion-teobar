<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Productos</title>
    <link rel="shortcut icon" href="views/img/logo.jpeg">
    <link rel="stylesheet" href="views/css/styles.css">
    <link rel="stylesheet" href="views/css/main.css">
    <link rel="stylesheet" href="views/css/dashboard.css">
    <link rel="stylesheet" href="views/css/dashboard_producto.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="views/js/index.js"></script>
    <script src="views/js/confirm.js"></script>
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
      <div><a style="margin-top: .5rem;" class="hero__agg" href="crud_producto.php?action=formulario">Agregar Producto +</a>
    <h2 class="titulo">Gestionar Productos</h2>

      </div><?php if (!empty($message)): ?>
          <p class="alert alert-<?php echo ($message == "PRODUCTO ELIMINADO CORRECTAMENTE") ? 'success' : 'danger'; ?>">
              <?php echo $message; ?>
          </p>
      <?php endif; ?>
      <?php if (!empty($message2)): ?>
        <p class="alert alert-<?php echo ($message2 == "PRODUCTO ACTUALIZADO CORRECTAMENTE") ? 'success' : 'danger'; ?>">
            <?php echo $message2; ?>
        </p>
        <?php endif; ?>
        <?php if (!empty($message3)): ?>
        <p class="alert alert-<?php echo ($message3 == "PRODUCTO AGREGADO CORRECTAMENTE") ? 'success' : 'danger'; ?>">
            <?php echo $message3; ?>
        </p>
        <?php endif; ?>
        <div class="div">
      <table border="2px" class="table">
        <thead>
          <tr>
            <th style="background-color: rgba(0,0,0,.2);" scope="col">Nombre</th>
            <th style="background-color: rgba(0,0,0,.2);" scope="col">Presentacion</th>
            <th style="background-color: rgba(0,0,0,.2);" scope="col">F.R</th>
            <th style="background-color: rgba(0,0,0,.2);" scope="col">F.V</th>
            <th style="background-color: rgba(0,0,0,.2);" scope="col">CANT.</th>
            <th style="background-color: rgba(0,0,0,.2);" scope="col">U.N</th>
            <th style="background-color: rgba(0,0,0,.2);" scope="col">Peso</th>
            <th style="background-color: rgba(0,0,0,.2);" scope="col">PRECIO</th>
            <th style="background-color: rgba(0,0,0,.2);" scope="col">Actualizacion</th>
            <th style="background-color: rgba(0,0,0,.2);" scope="col">ACCION</th>
          </tr>
          <tr>
            <?php 
              require_once "models/Producto.php"; // Asegúrate de que la ruta sea correcta
              $id_producto="";
              $nombre_producto="";
              $presentacion="";
              $fech_vencimiento="";
              $cantidad_producto="";
              $cantidad_producto2="";
              $cantidad_producto3="";
              $precio_producto="";
              $precio_producto2="";
              $precio_producto3="";
              $uni_medida="";
              $uni_medida2="";
              $uni_medida3="";
              $id_actualizacion="";
              $marca="";
              $peso="";
              $peso2="";
              $peso3="";
              
              $producto = new Producto( $id_producto,$nombre_producto,
              $presentacion,$fech_vencimiento, $cantidad_producto,$cantidad_producto2,$cantidad_producto3, 
              $precio_producto,$precio_producto2,$precio_producto3, $uni_medida,$uni_medida2,$uni_medida3, $id_actualizacion,$marca,$peso,$peso2,$peso3);
              $productos = $producto->Mostrar_Producto();
              foreach ($productos as $producto):
            ?>
            <tr>
              <td><?php echo $producto['nombre']; ?></td>
              <td><?php echo $producto['presentacion']; ?></td>
              <td><?php echo $producto['fecha_registro']; ?></td>
              <td><?php echo $producto['fecha_vencimiento']; ?></td>
              <td><?php echo nl2br(htmlspecialchars($producto['cantidad'])); ?></td>
              <td><?php echo nl2br(htmlspecialchars($producto['nombre_medida'])); ?></td>
              <td><?php echo nl2br(htmlspecialchars($producto['peso'])); ?></td>
              <td><?php echo nl2br(htmlspecialchars($producto['precio'])); ?> $ Bs</td>
              <td><?php echo $producto['nombre_motivo']; ?></td>
              <td><a href="crud_producto.php?action=mid_form&id_producto=<?php echo $producto['id_producto']; ?>"><img title="Modificar" src="views/img/edit.png" width="40px" height="40px"></a>
              <a onclick="return eliminar()" href="crud_producto.php?action=eliminar&id_producto=<?php echo $producto['id_producto']; ?>"><img title="Eliminar"  src="views/img/delet.png" width="40px" height="40px"></a><td>
            </tr>
            <?php endforeach; ?>
        </thead>
        <tbody>
        </tbody>
      </table>
      </div>
    </div>
  </main>
</body>
</html>