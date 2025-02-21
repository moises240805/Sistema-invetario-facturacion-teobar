<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Venta</title>
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
    <a class="hero__agg" href="crud_venta.php?action=formulario">Agregar Venta +</a>
    <h2 class="titulo">Gestionar Ventas</h2>
    <?php if (!empty($message)): ?>
          <p class="alert alert-<?php echo ($message == "VENTA ELIMINADA CORRECTAMENTE") ? 'success' : 'danger'; ?>">
              <?php echo $message; ?>
          </p>
          <?php endif; ?>
      <?php if (!empty($message2)): ?>
        <p class="alert alert-<?php echo ($message2 == "VENTA ACTUALIZADA CORRECTAMENTE") ? 'success' : 'danger'; ?>">
            <?php echo $message2; ?>
        </p>
        <?php endif; ?>
        <?php if (!empty($message3)): ?>
        <p class="alert alert-<?php echo ($message3 == "VENTA REGISTRADA Y CANTIDAD ACTUALIZADA CORRECTAMENTE") ? 'success' : 'danger'; ?>">
            <?php echo $message3; ?>
        </p>
        <?php endif; ?>
        <?php if (!empty($message4)): ?>
        <p class="alert alert-<?php echo ($message4 == "No hay suficiente cantidad del producto disponible.") ? 'success' : 'danger'; ?>">
            <?php echo $message4; ?>
        </p>
        <?php endif; ?>
        <div class="div">
    <table border="2px" class="table">
      <thead>
        <tr>
        <th style="background-color: rgba(0,0,0,.2);" scope="col">Nro VENTA</th>
          <th style="background-color: rgba(0,0,0,.2);" scope="col">PRODUCTO</th>
          <th style="background-color: rgba(0,0,0,.2);" scope="col">CLIENTE</th>
          <th style="background-color: rgba(0,0,0,.2);" scope="col">CANTIDAD</th>
          <th style="background-color: rgba(0,0,0,.2);" scope="col">F/E</th>
          <th style="background-color: rgba(0,0,0,.2);" scope="col">MODALIDAD DE PAGO</th>
          <th style="background-color: rgba(0,0,0,.2);" scope="col">MONTO</th>
          <th style="background-color: rgba(0,0,0,.2);" scope="col">ENTREGA</th>
          <th style="background-color: rgba(0,0,0,.2);" scope="col">BANCO</th>
          <th style="background-color: rgba(0,0,0,.2);" scope="col">ACCION</th>
        </tr>
        <tr>
          <?php 
            require_once "models/Venta.php";

            $id_venta="";
            $id_producto="";
            $id_cliente="";
            $cantidad="";
            $fech_emision="";
            $id_modalidad_pago="";
            $monto="";
            $tipo_entrega="";
            $rif_banco="";
            $id_medida="";
            $valor="";
            $tipo_compra="";
            $tlf="";

            $venta = new Venta($id_venta,$tipo_compra,$tlf, $id_producto,
            $id_cliente, $cantidad, $fech_emision, 
            $id_modalidad_pago, $monto, $tipo_entrega, $rif_banco,$id_medida,$valor);
            $venta = $venta->Mostrar_Venta();
            foreach ($venta as $venta): 
          ?>
          <tr>
            <td><?php echo $venta['id_venta']; ?></td>
            <td><?php echo nl2br($venta['nombre']); ?></td>
            <td><?php echo $venta['id_cliente'] . " " . $venta['nombre_cliente']; ?></td>
            <td><?php echo nl2br($venta['cantidad']); ?></td>
            <td><?php echo $venta['fech_emision']; ?></td>
            <td><?php echo $venta['nombre_modalidad'] . ' ' . $venta['tlf'];; ?></td>
            <td><?php echo $venta['monto']; ?></td>
            <td><?php echo $venta['tipo_entrega']; ?></td>
            <td><?php echo $venta['nombre_banco']; ?></td>
            <td><a href="#" class="btn"><img src="views/img/edit.png" width="40px" height="40px"></a>
            <a  href="#" class="btn"><img style="margin-left: 1rem;" src="views/img/delet.png" width="40px" height="40px"></a></td>
          </tr>
          <?php endforeach; ?>
        </tr>
      </thead>
      <tbody>
      </tbody>
    </table>
    </div>
    </div>
  </main> 
  </div>
  <script>
</script>
</body>
</html>