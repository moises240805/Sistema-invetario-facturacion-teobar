<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proveedor</title>
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
                        <h1 class="h3 mb-0 text-gray-800">Proveedores</h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a>
                    </div>

                    <!-- Content Row -->
                    <div class="row mx-3">
                    <div class="card shadow ">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Gestionar Proveedores</h6>
            <button type="button" id="myBtn" class="btn btn-primary" data-toggle="modal" data-target="#agregarProveedorModal">
    Agregar Proveedor +
</button>
        </div>
        <div class="card-body">
    <div class="table-responsive">
    <table class="table table-bordered table-striped table-hover datatablesss" style="background-color: transparent;" id="dataTable" width="100%" cellspacing="0">
        <thead class="thead-light">
            <tr>
                <th>RIF</th>
                <th>Nombre</th>
                <th>Dirección</th>
                <th>TLF</th>
                <th>CI Representante</th>
                <th>Representante</th>
                <th>TLF Representante</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                //verifica si cliente existe o esta vacia en dado caso que este vacia muestra clientes no 
                // registrados ya que si el usuario que realizo la pedticion no tiene el permiso en cambio 
                // si lo tiene muestra la informacion
                if(isset($proveedor) && is_array($proveedor) && !empty($proveedor)){
                foreach ($proveedor as $proveedor): 
            ?>
            <tr>
                <td><?php echo $proveedor['tipo_id'] . $proveedor['id_proveedor']; ?></td>
                <td><?php echo $proveedor['nombre_proveedor']; ?></td>
                <td><?php echo $proveedor['direccion']; ?></td>
                <td><?php echo $proveedor['tlf']; ?></td>
                <td><?php echo $proveedor['tipo_id2'] . $proveedor['id_representante']; ?></td>
                <td><?php echo $proveedor['nombre_representante']; ?></td>
                <td><?php echo $proveedor['tlf_representante']; ?></td>
                <td>
                    <a onclick="abrirModalModificar(<?php echo $proveedor['id_proveedor']; ?>)" title="Modificar">
                        <img src="views/img/edit.png" width="30px" height="30px">
                    </a>
                    <a onclick="return eliminar()" href="index.php?action=proveedor&a=eliminar&ID=<?php echo $proveedor['id_proveedor']; ?>" title="Eliminar">
                        <img src="views/img/delet.png" width="30px" height="30px">
                    </a>
                </td>
            </tr>
            <?php
            //Imprime esta informacion en caso de estar vacia la variable             
            endforeach; 
        } else {
            echo "<tr><td colspan='6'>No hay proveedores registrados.</td></tr>";
        } ?>
        </tbody>
    </table>
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



<div id="modalModificarProveedor" class="modal fade show" tabindex="-1" role="dialog" aria-labelledby="modalModificarProveedorLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="titulo_form text-center" id="modalModificarProveedorLabel">Modificar Proveedor</h1>
                <button type="button" class="close" onclick="cerrarModalModificarProveedor()">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="formulario" action="index.php?action=proveedor&a=actualizar" method="post" name="form">
                <div class="modal-body">
                    <input type="hidden" name="id_proveedor" id="id_proveedor">
                    <div class="form-group row">
                        <label for="id_proveedor" class="col-md-3">RIF del Proveedor</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="tipo" id="tipo" class="form-control">
                                    <option value="J-">J-</option>
                                    <option value="G-">G-</option>
                                </select>
                                <input class="entrada form-control" type="text" name="id_proveedor2" id="id_proveedor2" maxlength="10" onkeypress="return SoloNumeros(event)" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nombre" class="col-md-3">Nombre del Proveedor</label>
                        <div class="col-md-9">
                            <input class="entrada form-control" type="text" name="nombre" id="nombre_proveedor" maxlength="50" onkeypress="return onlyLetters(event)" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="direccion" class="col-md-3">Dirección del Proveedor</label>
                        <div class="col-md-9">
                            <input class="entrada form-control" type="text" name="direccion" id="direccion_proveedor" maxlength="100" required oninput="validateAddress()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tlf" class="col-md-3">Tlf del Proveedor</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="codigo_tlf" id="codigo_tlf" class="form-control">
                                    <option value="0412">0412</option>
                                    <option value="0416">0416</option>
                                    <option value="0426">0426</option>
                                    <option value="0414">0414</option>
                                    <option value="0424">0424</option>
                                </select>
                                <input class="entrada form-control" type="text" name="numero_tlf" id="telefono" maxlength="7" onkeypress="return SoloNumeros(event)" required oninput="validatePhone2()">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="id_representante" class="col-md-3">CI del Representante Legal</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="tipo2" id="tipo2" class="form-control">
                                    <option value="V-">V-</option>
                                    <option value="E-">E-</option>
                                </select>
                                <input class="entrada form-control" type="text" name="id_representante" id="id_representante" maxlength="8" onkeypress="return SoloNumeros(event)" required oninput="validateId2()">
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nombre_representante" class="col-md-3">Nombre del Representante Legal</label>
                        <div class="col-md-9">
                            <input class="entrada form-control" type="text" name="nombre_representante" id="nombre_representante" maxlength="40" onkeypress="return onlyLetters(event)" required oninput="validateName2()">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="tlf_representante" class="col-md-3">Tlf del Representante Legal</label>
                        <div class="col-md-9">
                            <div class="input-group">
                                <select name="codigo_tlf_representante" id="codigo_tlf_representante" class="form-control">
                                    <option value="0412">0412</option>
                                    <option value="0416">0416</option>
                                    <option value="0426">0426</option>
                                    <option value="0414">0414</option>
                                    <option value="0424">0424</option>
                                    <option value="0251">0251</option>
                                </select>
                                <input class="entrada form-control" type="text" name="numero_tlf_representante" id="numero_tlf_representante" maxlength="7" pattern="[0-9]{8}"onkeypress="return SoloNumeros(event)" required oninput="validatePhone()" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-secondary" onclick="cerrarModalModificar()">Cancelar</button>
                    <input onclick="return modificar()" class="btn btn-primary" type="submit" value="Modificar">
                </div>
            </form>
        </div>
    </div>
</div>





    <script src="views/js/modal_prooveedor.js"></script>
    <script src="views/js/validate2.js"></script>
    <script src="views/js/validate.js"></script>

    <link rel="stylesheet" type="text/css" href="views/js/DataTables/datatables.css">
<script src="views/js/jquery.js"></script>
<script src="views/js/DataTables/datatables.js"></script>
</body>
</html>