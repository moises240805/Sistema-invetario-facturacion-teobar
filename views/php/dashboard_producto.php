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
                        <th>Categoria</th>
                        <th>Proveedor</th>
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
                            <td><?php echo $producto['nombre_marca']; ?></td>
                            <td><?php echo $producto['presentacion']; ?></td>
                            <td><?php echo $producto['nombre_categoria']; ?></td>
                            <td><?php echo $producto['nombre_proveedor']; ?></td>
                            <td><?php echo $producto['fecha_registro']; ?></td>
                            <td><?php echo $producto['fecha_vencimiento']; ?></td>
                            <td><?php echo nl2br(htmlspecialchars($producto['cantidad'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($producto['nombre_medida'])); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($producto['peso'])); ?></td>
                            <td class="precio-dolar"><?php echo nl2br(htmlspecialchars($producto['precio'])); ?></td>
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
                <label for="marca" class="col-md-3">marca del Producto</label>
                <div class="col-md-9">
                    <select class="form-control" name="marca">
                        <?php foreach ($marcas as $marca): ?> 
                            <option value="<?php echo $marca['ID'] ?>"><?php echo $marca['nombre_marca'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="presentacion" class="col-md-3">Presentación del Producto</label>
                <div class="col-md-9">
                    <select class="form-control" name="presentacion">
                        <?php foreach ($tipos as $tipo): ?> 
                            <option value="<?php echo $tipo['id_presentacion'] ?>"><?php echo $tipo['presentacion'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="presentacion" class="col-md-3">Categoria del Producto</label>
                <div class="col-md-9">
                    <select class="form-control" name="categoria">
                        <?php foreach ($categorias as $cat): ?> 
                            <option value="<?php echo $cat['ID'] ?>"><?php echo $cat['nombre_categoria'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="presentacion" class="col-md-3">Proveedor del Producto</label>
                <div class="col-md-9">
                    <select class="form-control" name="proveedor">
                        <?php foreach ($proveedores as $provedor): ?> 
                            <option value="<?php echo $provedor['id_proveedor'] ?>"><?php echo $provedor['nombre_proveedor'] ?></option>
                        <?php endforeach; ?>
                    </select>
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
                <form class="formulario" action="index.php?action=producto&a=agregar" method="post" name="form" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="nombre" class="col-md-3">Nombre del Producto</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength='50' placeholder="Nombre del Producto" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="presentacion" class="col-md-3">Marca del Producto</label>
                        <div class="col-md-9" style="display:flex">
                            <select class="form-control"  id="marca" name="marca">
                                <?php foreach ($marcas as $marca): ?>
                                    <option value="<?php echo $marca['ID'] ?>"><?php echo $marca['nombre_marca'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarMarcaModal">+</button>
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
                    <div class="form-group row">
                        <label for="presentacion" class="col-md-3">Categoria del Producto</label>
                        <div class="col-md-9" style="display:flex">
                            <select class="form-control"  id="categoria" name="categoria">
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?php echo $cat['ID'] ?>"><?php echo $cat['nombre_categoria'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarCategoriaModal">+</button>
                        </div>
                    </div>
                    <div class="form-group row">
                <label for="presentacion" class="col-md-3">Proveedor del Producto</label>
                    <div class="col-md-9" style="display:flex">
                        <select class="form-control" id="proveedor" name="proveedor">
                            <?php foreach ($proveedores as $provedor): ?> 
                                <option value="<?php echo $provedor['id_proveedor'] ?>"><?php echo $provedor['nombre_proveedor'] ?></option>
                                <?php endforeach; ?>
                             </select>
                             <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarProveedorModal">+</button>
                        </div>
                    </div>
                    <fieldset><legend>Cantidades y precios del producto por:</legend></fieldset>
                    <div class="form-group row">
                        <label for="cantidad" class="col-md-3" >Bulto o Saco</label>
                        <div class="col-md-9 d-flex justify-content-between">
                            <input style="width: 6rem;" class="form-control" type="number" id="cantidad4" name="cantidad" maxlength='10' placeholder="Cantidad" required oninput="validateNumber()">
                            <input style="width: 6rem;" class="form-control" type="number" step="0.01" id="precio4" name="precio" maxlength='10' placeholder="Precio" required oninput="validateNumber()"><b> $ Bs</b>
                            <input style="width: 4rem;" class="form-control" type="number" step="0.01" id="peso4" name="peso" placeholder="Peso" required oninput="calcularCantidad()">
                            <select class="form-control"  style="width: 5rem;" id="uni_medida" name="uni_medida" oninput="calcularCantidad()">
                                    <option value="4">Saco</option>
                                    <option value="3">Bulto</option>
                                    <option value="7">Galon</option>
                                </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="precio" class="col-md-3">Kilogramo o Litros</label>
                        <div class="col-md-9 d-flex justify-content-between">
                        <input style="width: 6rem;" class="form-control" type="text" id="cantidad5" name="cantidad2" readonly placeholder="Cantidad" required oninput="validateNumber()">
                            <input style="width: 6rem;" class="form-control" type="text" step="0.01" id="precio5" name="precio2" readonly placeholder="Precio" required oninput="validateNumber()"><b>$ Bs</b>
                            <select class="form-control"  style="width: 10rem;" id="uni_medida5" name="uni_medida2" readOnly>
                                    <option value="1">Kilogramos</option>
                                    <option value="5">Litros</option>
                                </select>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="uni_medida" class="col-md-3">Gramos o mililitros</label>
                        <div class="col-md-9 d-flex justify-content-between">
                        <input style="width: 6rem;" class="form-control" type="text" id="cantidad6" name="cantidad3" readonly placeholder="Cantidad" required oninput="validateNumber()">
                        <input style="width: 6rem;" class="form-control" type="text" step="0.01" id="precio6" name="precio3" readonly placeholder="Precio" required oninput="validateNumber()"><b> $ Bs</b>
                        <div style="margin-right: 10px;">
                                <input style="width: 4rem;" class="form-control" type="number" step="0.01" id="peso6" name="peso3" placeholder="Peso" required oninput="calcularCantidad()">
                            </div>
                            <div>
                                <select class="form-control" id="uni_medida6" name="uni_medida3" readOnly>
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



<!-- Modal para Agregar Producto2 -->
<div id="modalAgregarProducto2" class="modal fade show" tabindex="-1" aria-labelledby="modalAgregarProductoLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width: 110%;">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form" >Agregar Producto</h1>
            </div>
            <div class="modal-body">
                <form class="formulario" action="index.php?action=producto&a=agregar2" method="post" name="form" enctype="multipart/form-data">
                    <div class="form-group row">
                        <label for="nombre" class="col-md-3">Nombre del Producto</label>
                        <div class="col-md-9">
                            <input type="text" class="form-control" id="nombre" name="nombre" maxlength='50' placeholder="Nombre del Producto" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="presentacion" class="col-md-3">Marca del Producto</label>
                        <div class="col-md-9" style="display:flex">
                            <select class="form-control"  id="marca" name="marca">
                                <?php foreach ($marcas as $marca): ?>
                                    <option value="<?php echo $marca['ID'] ?>"><?php echo $marca['nombre_marca'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarMarcaModal">+</button>
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
                        <label for="presentacion" class="col-md-3">Categoria del Producto</label>
                        <div class="col-md-9" style="display:flex">
                            <select class="form-control"  id="categoria" name="categoria">
                                <?php foreach ($categorias as $cat): ?>
                                    <option value="<?php echo $cat['ID'] ?>"><?php echo $cat['nombre_categoria'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarCategoriaModal">+</button>
                        </div>
                    </div>
                    <div class="form-group row">
                <label for="presentacion" class="col-md-3">Proveedor del Producto</label>
                <div class="col-md-9" style="display:flex">
                    <select class="form-control" id="proveedor" name="proveedor">
                        <?php foreach ($proveedores as $provedor): ?> 
                            <option value="<?php echo $provedor['id_proveedor'] ?>"><?php echo $provedor['nombre_proveedor'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarProveedorModal">+</button>
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
                            <input class="form-control" type="date" id="fecha_venci" name="fecha_vencimiento" placeholder="Fecha de Vencimiento" required oninput="validarFechaVencimiento2();">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="fech_registro" class="col-md-3">Fecha de Registro</label>
                        <div class="col-md-9">
                            <input class="form-control" type="date" id="fecha_registro2" name="fecha_registro" placeholder="Fecha de Registro" oninput="setFechaActual2()" required>
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



<!-- Modal para Agregar Tipo Producto -->
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

<!-- Modal para Agregar categoria Producto -->
<div class="modal fade show" id="agregarCategoriaModal" tabindex="-1" role="dialog" aria-labelledby="agregarCategoriaModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="agregarCategoriaModalLabel">Agregar Categoria de Producto</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=categoria&a=agregar" method="post" name="form">
                <div class="modal-body">
                    <div class="container text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-21">
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="tipo_producto" style="font-size: 18px;">Categoria de Producto</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="Categoria" name="categoria"  maxlength="70"  onkeypress="return onlyLetters(event)" required>
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





<!-- Modal para Agregar marca Producto -->
<div class="modal fade show" id="agregarMarcaModal" tabindex="-1" role="dialog" aria-labelledby="agregarMarcaModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="agregarMarcaModalLabel">Agregar Marca de Producto</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=marca&a=agregar" method="post" name="form">
                <div class="modal-body">
                    <div class="container text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-21">
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="tipo_producto" style="font-size: 18px;">Marca de Producto</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="marca" name="marca"  maxlength="70"  onkeypress="return onlyLetters(event)" required>
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



<div class="modal fade show" id="agregarProveedorModal" tabindex="-1" role="dialog" aria-labelledby="agregarProveedorModalLabel" aria-hidden="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="agregarProveedorModalLabel">Agregar Proveedor</h1>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=proveedor&a=agregar" method="post" name="form">
                <div class="modal-body">
                    <div class="container text-center">
                        <div class="row justify-content-center">
                            <div class="col-md-10">
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="id" style="font-size: 18px;">RIF del Proveedor</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <select name="tipo" class="form-control">
                                                <option value="J-">J-</option>
                                                <option value="G-">G-</option>
                                            </select>
                                            <input onkeypress="return SoloNumeros(event)" type="text" class="form-control" id="id2" name="id" placeholder="RIF del Proveedor" maxlength="7" required oninput="validateId2()">
                                        </div>
                                        <span id="idError2" class="error-message"></span>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="nombre" style="font-size: 18px;">Nombre del Proveedor</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="nombrep" name="nombre" placeholder="Nombre del Proveedor" maxlength="40" onkeypress="return onlyLetters(event)" required oninput="validateAddress2()">
                                        <span id="addressError2" class="error-message"></span>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="direccion" style="font-size: 18px;">Dirección del Proveedor</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="direccion" name="direccion" placeholder="Dirección del Proveedor" maxlength="100" required oninput="validateAddress()">
                                        <span id="addressError" class="error-message"></span>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="tlf" style="font-size: 18px;">Tlf del Proveedor</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <select name="codigo_tlf" class="form-control">
                                                <option value="0412">0412</option>
                                                <option value="0416">0416</option>
                                                <option value="0426">0426</option>
                                                <option value="0414">0414</option>
                                                <option value="0424">0424</option>
                                            </select>
                                            <input type="text" class="form-control" id="numero_tlf" name="numero_tlf" placeholder="Tlf del Proveedor" maxlength="7"onkeypress="return SoloNumeros(event)" required oninput="validatePhone()">
                                        </div>
                                        <span id="phoneError" class="error-message"></span>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="id_representante" style="font-size: 18px;">CI del Representante Legal</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <select name="tipo2" class="form-control">
                                                <option value="V-">V-</option>
                                                <option value="E-">E-</option>
                                            </select>
                                            <input type="text" class="form-control" id="id" name="id_representante" placeholder="CI o RIF" maxlength="8" required oninput="validateId()" onkeypress="return SoloNumeros(event)"> 
                                        </div>
                                        <span id="idError" class="error-message"></span>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="nombre_representante" style="font-size: 18px;">Nombre del Representante Legal</label>
                                    </div>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control" id="nombre" name="nombre_representante" placeholder="Nombre" maxlength="40" required oninput="validateName()">
                                        <span id="nameError" class="error-message"></span>
                                    </div>
                                </div>
                                <div class="form-group row justify-content-center mb-4">
                                    <div class="col-md-10 text-center">
                                        <label for="tlf_representante" style="font-size: 18px;">Tlf del Representante Legal</label>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="input-group">
                                            <select name="codigo_tlf_representante" class="form-control">
                                                <option value="0412">0412</option>
                                                <option value="0416">0416</option>
                                                <option value="0426">0426</option>
                                                <option value="0414">0414</option>
                                                <option value="0424">0424</option>
                                                <option value="0251">0251</option>
                                            </select>
                                            <input type="text" class="form-control" id="numero_tlf2" name="numero_tlf_representante" placeholder="Tlf del representante" maxlength="7" onkeypress="return SoloNumeros(event)" required oninput="validatePhone2()">
                                        </div>
                                        <span id="phoneError2" class="error-message"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModal()" data-dismiss="modal">Cancelar</button>
                    <input onclick="return validateForm()" class="btn btn-primary" type="submit" value="Registrar">
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
<script>
fetch("index.php?action=tasa&a=mid_form")
.then(response => response.json())
.then(data => {
    const precioDolar = parseFloat(data.valor);

    const preciosDolar = document.querySelectorAll('.precio-dolar');

    preciosDolar.forEach(celda => {
        let precioUSD = parseFloat(celda.textContent.replace(/[^0-9.]/g, ''));
        if (!isNaN(precioUSD)) {
            let precioEnBs = (precioUSD * precioDolar).toFixed(2);
            celda.textContent = `${precioUSD.toFixed(2)} USD / Bs ${precioEnBs}`;
        } else {
            celda.textContent = "N/A";
        }
    });
})

</script>


</body>
</html>