<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Productos</title>
    <?php 
        require_once "link.php";
    ?>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
            
        <?php 
            require_once "menu.php";
        ?>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <?php 
            require_once "encabezado.php";
            require_once "alert.php";
            //require_once "menu.php";
            ?>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Productos</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Productos</h6>
            <button class="btn btn-primary" id="myBtnAgregarProducto" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto">Agregar Producto Complejo +</button>
            <button class="btn btn-primary" id="myBtnAgregarProducto2" data-bs-toggle="modal" data-bs-target="#modalAgregarProducto2">Agregar Producto Simple +</button>

        </div>
        <div class="card-body">
                    <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover datatablesss" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
                <thead class="thead-light">
                    <tr>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Presentación</th>
                        <th>F.R</th>
                        <th>F.V</th>
                        <th>Cantidad</th>
                        <th>U.M</th>
                        <th>Peso</th>
                        <th>Precio</th>
                        <th>Actualización</th>
                        <th>Acción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    //verifica si producto existe o esta vacia en dado caso que este vacia muestra clientes no 
                    // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                    // si lo tiene muestra la informacion
                    if(isset($producto) && is_array($producto) && !empty($producto)){
                        foreach ($producto as $producto):
                    ?>
                        <tr>
                            <td><?php echo $producto['nombre']; ?></td>
                            <td><?php echo $producto['marca']; ?></td>
                            <td><?php echo $producto['presentacion']; ?></td>
                            <td><?php echo $producto['fecha_registro']; ?></td>
                            <td><?php echo $producto['fecha_vencimiento']; ?></td>
                            <td><?php echo nl2br(htmlspecialchars($producto['cantidad'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($producto['nombre_medida'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($producto['peso'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($producto['precio'])); ?></td>
                            <td><?php echo $producto['nombre_motivo']; ?></td>
                            <td>
                                <a onclick="abrirModalModificar(<?php echo $producto['id_producto']; ?>)" title="Modificar"><img src="views/img/edit.png" width="30px" height="30px"></a>
                                <a onclick="return eliminar()" href="index.php?action=producto&a=eliminar&id_producto=<?php echo $producto['id_producto']; ?>" title="Eliminar"><img src="views/img/delet.png" width="30px" height="30px"></a>
                            </td>
                        </tr>
                        <?php
                            //Imprime esta informacion en caso de estar vacia la variable             
                            endforeach; 
                        } else {
                            echo "<tr><td colspan='6'>No hay productos registrados.</td></tr>";
                        } ?>
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>




<!-- Modal para Modificar Producto -->
<div id="modalModificarProducto" class="modal">
<div class="modal-dialog modal-xl" style="max-width: 110%;">
        <div class="modal-content">
            <div class="modal-header">
       <form class="formulario" action="index.php?action=producto&a=actualizar" method="post" name="form">
            <h1 class="titulo_form">Modificar Producto</h1>
            <input class="form-control" type="hidden" name="id_producto" value="<?php echo $producto['id_producto']; ?>" required>
            <div class="form-group row">
                <label for="nombre" class="col-md-3">Nombre del Producto</label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="nombre" maxlength='50' value="<?php echo $producto['nombre']; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="marca" class="col-md-3">Marca del Producto</label>
                <div class="col-md-9">
                    <input class="form-control" type="text" name="marca" maxlength='50' value="<?php echo $producto['marca']; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="presentacion" class="col-md-3">Presentación del Producto</label>
                <div class="col-md-9">
                    <select class="form-control" name="presentacion">
                        <?php foreach ($tipos as $tipo): ?> 
                            <option value="<?php echo $tipo['id_presentacion'] ?>" <?php echo ($tipo['id_presentacion'] == $producto['id_presentacion']) ? 'selected' : ''; ?>><?php echo $tipo['presentacion'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="cantidad" class="col-md-3">Cantidad</label>
                <div class="col-md-9 d-flex justify-content-between">
                    <input style="width: 6rem;" class="form-control" type="number" min="0" name="cantidad" maxlength value="<?php echo $producto['cantidad']; ?>" required>
                    <input style="width: 6rem;" class="form-control" type="number" min="0" name="cantidad2" value="<?php echo $producto['cantidad']; ?>" required>
                    <input style="width: 6rem;" class="form-control" type="number" min="0" name="cantidad3" value="<?php echo $producto['cantidad']; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <label for="precio" class="col-md-3">Precio</label>
                <div class="col-md-9 d-flex justify-content-between">
                    <input style="width: 6rem;" class="form-control" type="number" step="0.01" min="0" name="precio" maxlength='10' value="<?php echo $producto['precio']; ?>" required><b> $ Bs</b>
                    <input style="width: 6rem;" class="form-control" type="number" step="0.01" min="0" name="precio2" value="<?php echo $producto['precio']; ?>" required><b> $ Bs</b>
                    <input style="width: 6rem;" class="form-control" type="number" step="0.01" min="0" name="precio3" value="<?php echo $producto['precio']; ?>" required><b> $ Bs</b>
                </div>
            </div>
            <div class="form-group row">
                <label for="uni_medida" class="col-md-3">U.M</label>
                <div class="col-md-9 d-flex justify-content-between">
                    <div style="margin-right: 10px;">
                        <input style="width: 3rem;" class="form-control" type="number" step="0.01" min="0" name="peso" value="<?php echo $producto['peso']; ?>" required oninput="calcularCantidad()">
                    </div>
                    <div style="margin-right: 10px;">
                        <select class="form-control" style="width: 8rem;" name="uni_medida" oninput="calcularCantidad()">
                            <option value="">...</option>
                            <option value="4">Saco</option>
                            <option value="3">Bulto</option>
                            <option value="7">Galon</option>
                        </select>
                    </div>
                    <div style="margin-right: 10px;">
                        <select class="form-control" style="width: 8rem;" readOnly name="uni_medida2">
                            <option value="">...</option>
                            <option value="1">Kilogramos</option>
                            <option value="5">Litros</option>
                        </select>
                    </div>
                    <div style="margin-right: 10px;">
                        <input style="width: 3rem;" class="form-control" type="number" step="0.01" min="0" name="peso3" value="<?php echo $producto['peso']; ?>" required oninput="calcularCantidad()">
                    </div>
                    <div>
                        <select class="form-control" style="width: 8rem;" readOnly name="uni_medida3">
                            <option value="">...</option>
                            <option value="2">Gramos</option>
                            <option value="6">Mililitro</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label for="motivo_actualizacion" class="col-md-3">Motivo de Actualización</label>
                <div class="col-md-9">
                    <select class="form-control" name="id_actualizacion">
                        <option value="">...</option>
                        <option value="2">Caducidad</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="fecha_vencimiento" class="col-md-3">Fecha de Vencimiento</label>
                <div class="col-md-9">
                    <input class="form-control" type="date" name="fecha_vencimiento" value="<?php echo $producto['fecha_vencimiento']; ?>" required>
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-3"></div>
                <div class="col-md-9">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalModificarProducto()">Cancelar</button>
                    <input type="submit" class="btn btn-primary" onclick="return modificar()" value="Modificar">
                </div>
            </div>
        </form>
        </div>
    </div>        
    </div>
</div>



<!-- Modal para Agregar Producto -->
<div id="modalAgregarProducto" class="modal fade show" tabindex="-1" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 110%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form" >Agregar Producto</h1>
            </div>
            <div class="modal-body">
                <form class="formulario" action="index.php?action=producto&a=agregar" method="post" name="form">
                    <?php 
                       
                    ?>
                    <div class="form-group row">
                        <label for="id_producto" class="col-md-3">Código del Producto</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" id="id_producto" name="id_producto" maxlength='10' placeholder="Código del Producto" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nombre" class="col-md-3">Nombre del Producto</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength='50' placeholder="Nombre del Producto" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="marca" class="col-md-3">Marca del Producto</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="marca" name="marca" maxlength='50' placeholder="Marca del Producto" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="presentacion" class="col-md-3">Presentación del Producto</label>
                        <div class="col-md-9" style="display:flex">
                            <select class="form-control"  id="presentacion" name="presentacion">
                                <?php foreach ($tipos as $tipo): ?>
                                    <option value="<?php echo $tipo['id_presentacion'] ?>"><?php echo $tipo['presentacion'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarTipoModal">+</button>
                        </div>
                    </div>
                    <fieldset><legend>Cantidades y precios del producto por:</legend></fieldset>
                    <div class="form-group row">
                        <label for="cantidad" class="col-md-3" >Bulto o Saco</label>
                        <div class="col-md-9 d-flex justify-content-between">
                            <input style="width: 6rem;" class="form-control" type="number" id="cantidad" name="cantidad" maxlength='10' placeholder="Cantidad" required oninput="validateNumber()">
                            <input style="width: 6rem;" class="form-control" type="number" step="0.01" id="precio" name="precio" maxlength='10' placeholder="Precio" required oninput="validateNumber()"><b> $ Bs</b>
                            <input style="width: 4rem;" class="form-control" type="number" step="0.01" id="peso" name="peso" placeholder="Peso" required oninput="calcularCantidad2()">
                            <select class="form-control"  style="width: 5rem;" id="uni_medida" name="uni_medida" oninput="calcularCantidad2()">
                                    <option value="4">Saco</option>
                                    <option value="3">Bulto</option>
                                    <option value="7">Galon</option>
                                </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="precio" class="col-md-3">Kilogramo o Litros</label>
                        <div class="col-md-9 d-flex justify-content-between">
                        <input style="width: 6rem;" class="form-control" type="text" id="cantidad2" name="cantidad2" readonly placeholder="Cantidad" required oninput="validateNumber()">
                            <input style="width: 6rem;" class="form-control" type="text" step="0.01" id="precio2" name="precio2" readonly placeholder="Precio" required oninput="validateNumber()"><b>$ Bs</b>
                            <select class="form-control"  style="width: 10rem;" id="uni_medida2" name="uni_medida2" readOnly>
                                    <option value="1">Kilogramos</option>
                                    <option value="5">Litros</option>
                                </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="uni_medida" class="col-md-3">Gramos o mililitros</label>
                        <div class="col-md-9 d-flex justify-content-between">
                        <input style="width: 6rem;" class="form-control" type="text" id="cantidad3" name="cantidad3" readonly placeholder="Cantidad" required oninput="validateNumber()">
                        <input style="width: 6rem;" class="form-control" type="text" step="0.01" id="precio3" name="precio3" readonly placeholder="Precio" required oninput="validateNumber()"><b> $ Bs</b>
                        <div style="margin-right: 10px;">
                                <input style="width: 4rem;" class="form-control" type="number" step="0.01" id="peso3" name="peso3" placeholder="Peso" required oninput="calcularCantidad2()">
                            </div>
                            <div>
                                <select class="form-control" id="uni_medida3" name="uni_medida3" readOnly>
                                    <option value="2">Gramos</option>
                                    <option value="6">Mililitro</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fech_venci" class="col-md-3">Fecha de Vencimiento</label>
                        <div class="col-md-9">
                            <input class="form-control" type="date" id="fech_venci" name="fecha_vencimiento" placeholder="Fecha de Vencimiento" required oninput="validarFechaVencimiento();">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="fech_registro" class="col-md-3">Fecha de Registro</label>
                        <div class="col-md-9">
                            <input class="form-control" type="date" id="fecha_registro" name="fecha_registro" placeholder="Fecha de Registro" oninput="setFechaActual()" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="imagen" class="col-md-3">Imagen del Producto</label>
                    <div class="col-md-9">
                    <input type="file" class="form-control" id="imagen" name="imagen" required">
                    </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <button type="button" class="btn btn-secondary" onclick="cerrarModalAgregarProducto()">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Registrar</button>  <!-- Submit button -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Modal para Agregar Producto -->
<div id="modalAgregarProducto2" class="modal fade show" tabindex="-1" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 110%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form" >Agregar Producto</h1>
            </div>
            <div class="modal-body">
                <form class="formulario" action="index.php?action=producto&a=agregar2" method="post" name="form" enctype="multipart/form-data">

                    <div class="form-group row">
                        <label for="id_producto" class="col-md-3">Código del Producto</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" id="id_producto" name="id_producto" maxlength='10' placeholder="Código del Producto" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nombre" class="col-md-3">Nombre del Producto</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength='50' placeholder="Nombre del Producto" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="marca" class="col-md-3">Marca del Producto</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="marca2" name="marca" maxlength='50' placeholder="Marca del Producto" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="presentacion" class="col-md-3">Presentación del Producto</label>
                        <div class="col-md-9" style="display:flex">
                            <select class="form-control" id="presentacion" name="presentacion">
                                <?php foreach ($tipos as $producto): ?>
                                    <option value="<?php echo $producto['id_presentacion'] ?>"><?php echo $producto['presentacion'] ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarTipoModal">+</button>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="cantidad" class="col-md-3">Cantidad</label>
                        <div class="col-md-9">
                            <input type="number" class="form-control" id="cantidad" name="cantidad" maxlength='10' placeholder="Cantidad" required oninput="validateNumber()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="uni_medida" class="col-md-3">U.M</label>
                        <div class="col-md-9">
                            <select class="form-control" id="uni_medida" name="uni_medida">
                                <option value="">...</option>
                                <option value="1">Kilogramos</option>
                                <option value="5">Litros</option>
                                <option value="2">Gramos</option>
                                <option value="6">Mililitro</option>
                                <option value="4">Saco</option>
                                <option value="3">Bulto</option>
                                <option value="7">Galon</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="precio" class="col-md-3">Precio</label>
                        <div class="col-md-9">
                            <input type="number" step="0.01" class="form-control" id="precio" name="precio" placeholder="Precio" maxlength='10' required oninput="validateNumber()"><b> $ Bs</b>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fech_venci" class="col-md-3">Fecha de Vencimiento</label>
                        <div class="col-md-9">
                            <input class="form-control" type="date" id="fech_venci" name="fecha_vencimiento" placeholder="Fecha de Vencimiento" required oninput="validarFechaVencimiento();">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fech_registro" class="col-md-3">Fecha de Registro</label>
                        <div class="col-md-9">
                            <input class="form-control" type="date" id="fecha_registro" name="fecha_registro" placeholder="Fecha de Registro" oninput="setFechaActual()" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="imagen" class="col-md-3">Imagen del Producto</label>
                    <div class="col-md-9">
                    <input type="file" class="form-control" id="imagen" name="imagen" required">
                    </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-3"></div>
                        <div class="col-md-9">
                            <button type="button" class="btn btn-secondary" onclick="cerrarModalAgregarProducto2()">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Registrar</button>  <!-- Submit button -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<div class="modal fade show" id="agregarTipoModal" tabindex="-1" role="dialog" aria-labelledby="agregarTipoModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="agregarTipoModalLabel">Agregar Tipo Producto</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=tipo&a=agregar" method="post" name="form">
                <div class="modal-body">
                    <div class="container text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-21">
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="tipo_producto" style="font-size: 18px;">Tipo Producto</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="tipo_producto" name="tipo_producto"  maxlength="50"  onkeypress="return onlyLetters(event)" required>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="presentacion" style="font-size: 18px;">Presentación</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="presentacion" name="presentacion"  maxlength="50" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal()">Cancelar</button>
                    <input type="submit" class="btn btn-primary" value="Registrar">
                </div>
            </form>
        </div>
    </div>
</div>


<script src="views/js/modal_producto.js"></script>

<script src="views/js/calculator.js"></script>
<script src="views/js/calculator2.js"></script>
<script src="views/js/validate.js"></script>

<link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/DataTables/datatables.js"></script>

</body>
</html>