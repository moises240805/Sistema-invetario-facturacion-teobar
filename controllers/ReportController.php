<?php
require_once "models/Admin.php";
require_once "models/Producto.php";
require_once "models/Tipo.php";
require_once "models/Cliente.php";
require_once "models/Proveedor.php";
require_once "models/Venta.php";
require_once "models/Compra.php";
require_once "models/Cobrar.php";
require_once "models/Pagar.php";
require_once "models/Manejo.php";
require_once "models/Caja.php";


$usuarios=new Admin();
$productos=new Producto();
$tipos=new Tipo();
$clientes=new Cliente();
$proveedores=new Proveedor();
$ventas=new Venta();
$compras=new Compra();
$cuentascobrar=new Cobrar();
$cuentaspagar=new Pagar();
$manejos=new Manejo();
$cajas=new Caja();

$action = isset($_GET['a']) ? $_GET['a'] : '';

//Indiferentemente sea la accion por el post o get el switch llama a cada funcion 
switch ($action) {
    case "":
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            consultar(); 
        }
        break;
    }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $option = htmlspecialchars($_POST['option'] ?? '');

    switch ($option) {
        case 'tipo_producto':
            TiposPDF($tipos);
            break;
        case 'fecha':
            ProductosVencidosPDF($productos);
            break;
        case 'stock':
            ProductosStockPDF($productos);
        break;
        case 'cliente_v':
            ClientesVentasPDF($ventas);
            break;
        case 'proveedor_c':
            ProveedoresComprasPDF($compras);
            break;
        case 'trans':
            VentasTransferenciasPDF($ventas);
            break;
        case 'movil':
            VentasPagoMovilPDF($ventas);
            break;
        case 'divisa':
            VentasEfectivoPDF($ventas);
            break;
        case 'trans_c':
            ComprasTransferenciaPDF($compras);
            break;
        case 'movil_c':
            ComprasPagoMovilPDF($compras);
            break;
        case 'divisa_c':
            ComprasEfectivoPDF($compras);
            break;
        case '':
            
            break;
        default:
            break;
    }

    // Manejo de las otras acciones según POST
    if (isset($_POST['productos_pdf'])) {
        ProductosPDF($productos);
    } elseif (isset($_POST['clientes_pdf'])) {
        ClientesPDF($clientes);
    } elseif (isset($_POST['proveedores_pdf'])) {
        ProveedoresPDF($proveedores);
    } elseif (isset($_POST['ventas_pdf'])) {
        VentasPDF($ventas);
    } elseif (isset($_POST['compras_pdf'])) {
        ComprasPDF($compras);
    } elseif (isset($_POST['cobrar_pdf'])) {
        CuentasCobrarPDF($cuentascobrar);
    } elseif (isset($_POST['pagar_pdf'])) {
        CuentasPagarPDF($cuentaspagar);
    }
}






    function consultar(){
        require_once "views/php/dashboard_reporte.php";
    }


    function ProductosPDF($productos) { 
        require_once 'libs/fpdf.php'; 
        $datos = $productos->manejarAccion("consultar",null); 
    
        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R'); 
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Productos' , 0, 1, 'C');
        $pdf->Ln(5); // Espacio antes de la tabla
    
        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(20, 10, 'Nombre', 1);
        $pdf->Cell(65, 10, 'Presentacion', 1);
        $pdf->Cell(22, 10, 'F.V', 1);
        $pdf->Cell(20, 10, 'Cant.', 1);
        $pdf->Cell(15, 10, 'Precio', 1);
        $pdf->Cell(20, 10, 'U.M', 1);
        $pdf->Cell(30, 10, 'Actualizacion', 1);
        $pdf->Ln();
    
        // Datos de productos
        $pdf->SetFont('Arial', '', 10);    

        foreach ($datos as $row) {
            $pdf->Cell(20, 10, $row['nombre']);
            $pdf->Cell(65, 10, $row['presentacion']);
            $pdf->Cell(22, 10, $row['fecha_vencimiento']);
            $pdf->Cell(20, 10, $row['cantidad']);
            $pdf->Cell(15, 10, $row['precio'] . '$');
            $pdf->Cell(20, 10, $row['nombre_medida']);
            $pdf->Cell(30, 10, $row['nombre_motivo']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_productos.pdf');
    }

     function ClientesPDF($clientes) {
        require_once 'libs/fpdf.php';
        $datos = $clientes->manejarAccion("consultar",null);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Clientes' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla
    
        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(23, 10, 'CI', 1);
        $pdf->Cell(32, 10, 'Nombre', 1);
        $pdf->Cell(27, 10, 'TLF', 1);
        $pdf->Cell(45, 10, 'Email', 1);
        $pdf->Cell(40, 10, 'Direccion', 1);
        $pdf->Ln();
    
        // Datos de productos
        $pdf->SetFont('Arial', '', 10);

        foreach ($datos as $row) {
            $pdf->Cell(27, 10, $row['tipo_id'] . $row['id_cliente']);
            $pdf->Cell(27, 10, $row['nombre_cliente']);
            $pdf->Cell(37, 10, $row['tlf']);
            $pdf->Cell(45, 10, $row['email']);
            $pdf->Cell(37, 10, $row['direccion']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_clientes.pdf');
    }

     function ProveedoresPDF($proveedores) {
        require_once 'libs/fpdf.php';
        $datos = $proveedores->manejarAccion("consultar",null);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Proveedores' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(27, 10, 'RIF', 1);
        $pdf->Cell(27, 10, 'Nombre', 1);
        $pdf->Cell(40, 10, 'Direccion', 1);
        $pdf->Cell(37, 10, 'TLF', 1);
        $pdf->Cell(27, 10, 'CI', 1);
        $pdf->Cell(32, 10, 'Representante', 1);
        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(27, 10, $row['tipo_id'] . $row['id_proveedor']);
            $pdf->Cell(27, 10, $row['nombre_proveedor']);
            $pdf->Cell(40, 10, $row['direccion']);
            $pdf->Cell(37, 10, $row['tlf']);
            $pdf->Cell(30, 10, $row['tipo_id2'] . $row['id_representante']);
            $pdf->Cell(32, 10, $row['nombre_representante']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_proveedores.pdf');
    }

     function VentasPDF($ventas) {
        require_once 'libs/fpdf.php';
        $datos = $ventas->manejarAccion("consultar",null);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Ventass' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(22, 10, 'Producto', 1);
        $pdf->Cell(37, 10, 'Cliente', 1);
        $pdf->Cell(22, 10, 'Cantidad', 1);
        $pdf->Cell(24, 10, 'F/E', 1);
        $pdf->Cell(22, 10, 'Pago', 1);
        $pdf->Cell(22, 10, 'Monto', 1);
        $pdf->Cell(22, 10, 'Entrega', 1);
        $pdf->Cell(22, 10, 'Banco', 1);
        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(22, 10, $row['nombre']);
            $pdf->Cell(37, 10, $row['id_cliente'] . $row['nombre_cliente']);
            $pdf->Cell(22, 10, $row['cantidad']);
            $pdf->Cell(24, 10, $row['fech_emision']);
            $pdf->Cell(22, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Cell(22, 10, $row['tipo_entrega']);
            $pdf->Cell(22, 10, $row['nombre_banco']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_ventas.pdf');
    }

     function ComprasPDF($compras) {
        require_once 'libs/fpdf.php';
        $datos = $compras->manejarAccion("consultar",null);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Compras' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(27, 10, 'Nro Compra', 1);
        $pdf->Cell(22, 10, 'Producto', 1);
        $pdf->Cell(37, 10, 'Proveedor', 1);
        $pdf->Cell(22, 10, 'Cantidad', 1);
        $pdf->Cell(24, 10, 'F/E', 1);
        $pdf->Cell(22, 10, 'Pago', 1);
        $pdf->Cell(22, 10, 'Monto', 1);
        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(27, 10, $row['id_compra']);
            $pdf->Cell(22, 10, $row['nombre']);
            $pdf->Cell(37, 10, $row['id_proveedor'] . $row['nombre_cliente']);
            $pdf->Cell(22, 10, $row['cantidad']);
            $pdf->Cell(24, 10, $row['fecha']);
            $pdf->Cell(22, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_compras.pdf');
    }

    function CuentasCobrarPDF($cuentascobrar) {
        require_once 'libs/fpdf.php';
        $datos = $cuentascobrar->manejarAccion("consultar",null);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Cuentas por Cobrar' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(22, 10, 'Nro Venta', 1);
        $pdf->Cell(37, 10, 'Cliente', 1);
        $pdf->Cell(24, 10, 'F/E', 1);
        $pdf->Cell(22, 10, 'Monto', 1);

        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(22, 10, $row['id_cuentaCobrar']);
            $pdf->Cell(37, 10, $row['id_cliente'] . $row["nombre_cliente"]);
            $pdf->Cell(24, 10, $row['fecha_cuentaCobrar']);
            $pdf->Cell(22, 10, $row['monto_cuentaCobrar']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_Cobrar.pdf');
    }

     function CuentasPagarPDF($cuentaspagar) {
        require_once 'libs/fpdf.php';
        $datos = $cuentaspagar->manejarAccion("consultar",null);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Cuentas por Pagar' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(27, 10, 'Nro Cuenta', 1);
        $pdf->Cell(37, 10, 'Proveedor', 1);
        $pdf->Cell(24, 10, 'F/E', 1);
        $pdf->Cell(22, 10, 'Monto', 1);

        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(27, 10, $row['id_cuentaPagar']);
            $pdf->Cell(37, 10, $row['rif_proveedor'] . $row['nombre_proveedor']);
            $pdf->Cell(24, 10, $row['fecha_cuentaPagar']);
            $pdf->Cell(22, 10, $row['monto_cuentaPagar']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_Pagar.pdf');
    }

     function TiposPDF($tipos) { 
        require_once 'libs/fpdf.php'; 
        $datos = $tipos->manejarAccion("consultar",null); 
    
        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R'); 
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte Tipos de Productos' , 0, 1, 'C');
        $pdf->Ln(5); // Espacio antes de la tabla
    
        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(33, 10, 'Tipo Producto', 1);
        $pdf->Cell(52, 10, 'Presentacion', 1);
        $pdf->Ln();
    
        // Datos de productos
        $pdf->SetFont('Arial', '', 10);    

        foreach ($datos as $row) {
            $pdf->Cell(33, 10, $row['tipo_producto']);
            $pdf->Cell(52, 10, $row['presentacion']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_tipo_productos.pdf');
    }

     function ProductosVencidosPDF($productos) { 
        require_once 'libs/fpdf.php'; 
        $datos = $productos->manejarAccion("vencidos",null); 
    
        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R'); 
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Productos Vencidos' , 0, 1, 'C');
        $pdf->Ln(5); // Espacio antes de la tabla
    
        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(23, 10, 'Nombre', 1);
        $pdf->Cell(32, 10, 'Presentacion', 1);
        $pdf->Cell(27, 10, 'F.V', 1);
        $pdf->Cell(15, 10, 'Cant.', 1);
        $pdf->Cell(27, 10, 'U.M', 1);
        $pdf->Cell(32, 10, 'Actualizacion', 1);
        $pdf->Ln();
    
        // Datos de productos
        $pdf->SetFont('Arial', '', 10);    

        foreach ($datos as $row) {
            $pdf->Cell(23, 10, $row['nombre']);
            $pdf->Cell(32, 10, $row['presentacion']);
            $pdf->Cell(27, 10, $row['fecha_vencimiento']);
            $pdf->Cell(15, 10, $row['cantidad']);
            $pdf->Cell(27, 10, $row['nombre_medida']);
            $pdf->Cell(32, 10, $row['nombre_motivo']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_productos_vencidos.pdf');
    }

     function ProductosStockPDF($productos) { 
        require_once 'libs/fpdf.php'; 
        $datos = $productos->manejarAccion("stock",null); 
    
        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R'); 
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Productos Stock' , 0, 1, 'C');
        $pdf->Ln(5); // Espacio antes de la tabla
    
        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(23, 10, 'Nombre', 1);
        $pdf->Cell(62, 10, 'Presentacion', 1);
        $pdf->Cell(15, 10, 'Cant.', 1);
        $pdf->Cell(27, 10, 'U.M', 1);
        $pdf->Ln();
    
        // Datos de productos
        $pdf->SetFont('Arial', '', 10);    

        foreach ($datos as $row) {
            $pdf->Cell(23, 10, $row['nombre']);
            $pdf->Cell(62, 10, $row['presentacion']);
            $pdf->Cell(15, 10, $row['cantidad']);
            $pdf->Cell(27, 10, $row['nombre_medida']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_productos_stock.pdf');
    }

     function ClientesVentasPDF($ventas) {
        require_once 'libs/fpdf.php';
        $datos = $ventas->manejarAccion("consultar",null);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Clientes con Ventas' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla
    
        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(23, 10, 'CI', 1);
        $pdf->Cell(32, 10, 'Nombre', 1);
        $pdf->Cell(27, 10, 'TLF', 1);
        $pdf->Cell(25, 10, 'Nro Venta', 1);
        $pdf->Cell(25, 10, 'Monto', 1);
        $pdf->Cell(45, 10, 'Direccion', 1);
        $pdf->Ln();
    
        // Datos de productos
        $pdf->SetFont('Arial', '', 10);

        foreach ($datos as $row) {
            $pdf->Cell(27, 10, $row['tipo_id'] . $row['id_cliente']);
            $pdf->Cell(27, 10, $row['nombre_cliente']);
            $pdf->Cell(37, 10, $row['tlf']);
            $pdf->Cell(25, 10, $row['id_venta']);
            $pdf->Cell(25, 10, $row['monto']);
            $pdf->Cell(45, 10, $row['direccion']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_clientes_ventas.pdf');
    }

     function ProveedoresComprasPDF($compras) {
        require_once 'libs/fpdf.php';
        $datos = $compras->manejarAccion("consultar",null);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Proveedores con Compras' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla
    
        // Encabezado de la tabla
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(23, 10, 'RIF', 1);
        $pdf->Cell(32, 10, 'Nombre', 1);
        $pdf->Cell(27, 10, 'TLF', 1);
        $pdf->Cell(25, 10, 'Nro Compra', 1);
        $pdf->Cell(25, 10, 'Monto', 1);
        $pdf->Cell(45, 10, 'Direccion', 1);
        $pdf->Ln();
    
        // Datos de productos
        $pdf->SetFont('Arial', '', 10);

        foreach ($datos as $row) {
            $pdf->Cell(27, 10, $row['tipo_id'] . $row['id_proveedor']);
            $pdf->Cell(27, 10, $row['nombre']);
            $pdf->Cell(37, 10, $row['tlf']);
            $pdf->Cell(25, 10, $row['id_compra']);
            $pdf->Cell(25, 10, $row['monto']);
            $pdf->Cell(45, 10, $row['direccion']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_proveedor_compras.pdf');
    }

     function VentasTransferenciasPDF($ventas) {
        require_once 'libs/fpdf.php';
        $datos = $ventas->manejarAccion("consultar_v",4);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Ventas por Transferencia' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(22, 10, 'Producto', 1);
        $pdf->Cell(37, 10, 'Cliente', 1);
        $pdf->Cell(22, 10, 'Cantidad', 1);
        $pdf->Cell(24, 10, 'F/E', 1);
        $pdf->Cell(27, 10, 'Pago', 1);
        $pdf->Cell(22, 10, 'Monto', 1);
        $pdf->Cell(22, 10, 'Entrega', 1);
        $pdf->Cell(22, 10, 'Banco', 1);
        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(22, 10, $row['nombre']);
            $pdf->Cell(37, 10, $row['id_cliente'] . $row['nombre_cliente']);
            $pdf->Cell(22, 10, $row['cantidad']);
            $pdf->Cell(24, 10, $row['fech_emision']);
            $pdf->Cell(27, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Cell(22, 10, $row['tipo_entrega']);
            $pdf->Cell(22, 10, $row['nombre_banco']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_ventas_trans.pdf');
    }

     function VentasPagoMovilPDF($ventas) {
        require_once 'libs/fpdf.php';
        $datos = $ventas->manejarAccion("consultar_v",3);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Ventas por Pago Movil' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(22, 10, 'Producto', 1);
        $pdf->Cell(37, 10, 'Cliente', 1);
        $pdf->Cell(22, 10, 'Cantidad', 1);
        $pdf->Cell(24, 10, 'F/E', 1);
        $pdf->Cell(27, 10, 'Pago', 1);
        $pdf->Cell(22, 10, 'Monto', 1);
        $pdf->Cell(22, 10, 'Entrega', 1);
        $pdf->Cell(22, 10, 'Banco', 1);
        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(22, 10, $row['nombre']);
            $pdf->Cell(37, 10, $row['id_cliente'] . $row['nombre_cliente']);
            $pdf->Cell(22, 10, $row['cantidad']);
            $pdf->Cell(24, 10, $row['fech_emision']);
            $pdf->Cell(27, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Cell(22, 10, $row['tipo_entrega']);
            $pdf->Cell(22, 10, $row['nombre_banco']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_ventas_PM.pdf');
    }

     function VentasEfectivoPDF($ventas) {
        require_once 'libs/fpdf.php';
        $datos = $ventas->manejarAccion("consultar_v",2);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Ventas por Divisas y Efectivo' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(22, 10, 'Producto', 1);
        $pdf->Cell(37, 10, 'Cliente', 1);
        $pdf->Cell(22, 10, 'Cantidad', 1);
        $pdf->Cell(24, 10, 'F/E', 1);
        $pdf->Cell(27, 10, 'Pago', 1);
        $pdf->Cell(22, 10, 'Monto', 1);
        $pdf->Cell(22, 10, 'Entrega', 1);
        $pdf->Cell(22, 10, 'Banco', 1);
        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(22, 10, $row['nombre']);
            $pdf->Cell(37, 10, $row['id_cliente'] . $row['nombre_cliente']);
            $pdf->Cell(22, 10, $row['cantidad']);
            $pdf->Cell(24, 10, $row['fech_emision']);
            $pdf->Cell(27, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Cell(22, 10, $row['tipo_entrega']);
            $pdf->Cell(22, 10, $row['nombre_banco']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_ventas_DE.pdf');
    }

     function ComprasTransferenciaPDF($compras) {
        require_once 'libs/fpdf.php';
        $datos = $compras->manejarAccion("consultar_c",4);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Compras Transferencia' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(27, 10, 'Nro Compra', 1);
        $pdf->Cell(22, 10, 'Producto', 1);
        $pdf->Cell(37, 10, 'Proveedor', 1);
        $pdf->Cell(22, 10, 'Cantidad', 1);
        $pdf->Cell(24, 10, 'F/E', 1);
        $pdf->Cell(33, 10, 'Pago', 1);
        $pdf->Cell(22, 10, 'Monto', 1);
        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(27, 10, $row['id_compra']);
            $pdf->Cell(22, 10, $row['nombre']);
            $pdf->Cell(37, 10, $row['id_proveedor'] . $row['nombre_cliente']);
            $pdf->Cell(22, 10, $row['cantidad']);
            $pdf->Cell(24, 10, $row['fecha']);
            $pdf->Cell(33, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_compras_trans.pdf');
    }

     function ComprasPagoMovilPDF($compras) {
        require_once 'libs/fpdf.php';
        $datos = $compras->manejarAccion("consultar_c",3);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Compras Pago Movil' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(27, 10, 'Nro Compra', 1);
        $pdf->Cell(22, 10, 'Producto', 1);
        $pdf->Cell(37, 10, 'Proveedor', 1);
        $pdf->Cell(22, 10, 'Cantidad', 1);
        $pdf->Cell(24, 10, 'F/E', 1);
        $pdf->Cell(33, 10, 'Pago', 1);
        $pdf->Cell(22, 10, 'Monto', 1);
        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(27, 10, $row['id_compra']);
            $pdf->Cell(22, 10, $row['nombre']);
            $pdf->Cell(37, 10, $row['id_proveedor'] . $row['nombre_cliente']);
            $pdf->Cell(22, 10, $row['cantidad']);
            $pdf->Cell(24, 10, $row['fecha']);
            $pdf->Cell(33, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_compras_PM.pdf');
    }

     function ComprasEfectivoPDF($compras) {
        require_once 'libs/fpdf.php';
        $datos = $compras->manejarAccion("consultar_c",2);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    
        // Encabezado
        $pdf->Image('views/img/logo.jpeg', 10, 10, 30); // Ajusta la ruta y tamaño del logo
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C'); // Nombre de la empresa
        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 10, 'Venta de Materia Prima para Panaderia', 0, 1, 'C'); // Nombre de la empresa
        $pdf->Cell(0, 10, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C'); // Dirección
        $pdf->Cell(0, 10, 'Telefono: (0424) 561-48-48', 0, 1, 'C'); // Teléfono
        $pdf->Cell(0, 10, 'RIF: J-31036859-7', 0, 1, 'C'); // RIF
        $pdf->Ln(5); // Espacio entre encabezado y tabla
    
        // Fecha y hora actual
        $fechaHora = date('d/m/Y H:i:s');
        $pdf->Cell(0, 10, 'Fecha de generacion: ' . $fechaHora, 0, 1, 'R');
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, 'Reporte de Compras Divisas y Efectivo' , 0, 1, 'C'); 
        $pdf->Ln(10); // Espacio antes de la tabla

        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(27, 10, 'Nro Compra', 1);
        $pdf->Cell(22, 10, 'Producto', 1);
        $pdf->Cell(37, 10, 'Proveedor', 1);
        $pdf->Cell(22, 10, 'Cantidad', 1);
        $pdf->Cell(24, 10, 'F/E', 1);
        $pdf->Cell(33, 10, 'Pago', 1);
        $pdf->Cell(22, 10, 'Monto', 1);
        $pdf->Ln();

        foreach ($datos as $row) {
            $pdf->Cell(27, 10, $row['id_compra']);
            $pdf->Cell(22, 10, $row['nombre']);
            $pdf->Cell(37, 10, $row['id_proveedor'] . " ".  $row['nombre_proveedor']);
            $pdf->Cell(22, 10, $row['cantidad']);
            $pdf->Cell(24, 10, $row['fecha']);
            $pdf->Cell(33, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_compras_DE.pdf');
    }

    function FacturaPDF($data) {
        require_once 'libs/fpdf.php';
        $datos = json_decode($data, true);

        $pdf = new FPDF(); 
        $pdf->AddPage(); 
    

    // --- Encabezado ---
    $pdf->Image('views/img/logo.jpeg', 10, 10, 30);
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(0, 10, 'TEOBAR.CA.', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, 'Venta de Materia Prima para Panaderia', 0, 1, 'C');
    $pdf->Cell(0, 6, 'Calle 48 entre Carrera 13 y Callejon 11 Casa Nro 12-47 Zona Oeste - Barquisimeto, Estado Lara', 0, 1, 'C');
    $pdf->Cell(0, 6, 'Telefono: (0424) 561-48-48', 0, 1, 'C');
    $pdf->Cell(0, 6, 'RIF: J-31036859-7', 0, 1, 'C');
    $pdf->Ln(5);

    // --- Datos de la factura ---
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'FACTURA ELECTRÓNICA', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 10);

    // Fecha y número de factura desde el JSON
    $fechaFactura = date('d/m/Y', strtotime($data['fecha']));
    $numeroFactura = $data['numeroFactura'];
    $pdf->Cell(100, 6, "Fecha: $fechaFactura", 0, 0, 'L');
    $pdf->Cell(0, 6, "Factura N°: $numeroFactura", 0, 1, 'R');
    $pdf->Ln(5);

    // Datos del cliente desde el JSON
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(0, 6, 'Datos del Cliente:', 0, 1);
    $pdf->SetFont('Arial', '', 10);
    $pdf->Cell(0, 6, 'Nombre: ' . utf8_decode($data['cliente']['nombre']), 0, 1);
    $pdf->Cell(0, 6, 'RIF/C.I.: ' . $data['cliente']['rif'], 0, 1);
    $pdf->Cell(0, 6, 'Dirección: ' . utf8_decode($data['cliente']['direccion']), 0, 1);
    $pdf->Cell(0, 6, 'Teléfono: ' . $data['cliente']['telefono'], 0, 1);
    $pdf->Ln(8);

    // --- Tabla de productos ---
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->SetFillColor(200, 200, 200);
    $pdf->Cell(20, 10, 'Cant.', 1, 0, 'C', true);
    $pdf->Cell(90, 10, 'Descripción', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Precio Unit.', 1, 0, 'C', true);
    $pdf->Cell(30, 10, 'Total', 1, 1, 'C', true);

    $pdf->SetFont('Arial', '', 10);

    $totalFactura = 0;
    foreach ($data['productos'] as $prod) {
        $total = $prod['cantidad'] * $prod['precio_unit'];
        $totalFactura += $total;

        $pdf->Cell(20, 8, $prod['cantidad'], 1, 0, 'C');
        $pdf->Cell(90, 8, utf8_decode($prod['descripcion']), 1);
        $pdf->Cell(30, 8, number_format($prod['precio_unit'], 2, ',', '.'), 1, 0, 'R');
        $pdf->Cell(30, 8, number_format($total, 2, ',', '.'), 1, 1, 'R');
    }

    // --- Totales ---
    $pdf->SetFont('Arial', 'B', 11);
    $pdf->Cell(140, 10, 'TOTAL', 1, 0, 'R', true);
    $pdf->Cell(30, 10, number_format($totalFactura, 2, ',', '.'), 1, 1, 'R', true);

    $pdf->Ln(10);

    // --- Pie de página ---
    $pdf->SetFont('Arial', 'I', 9);
    $pdf->Cell(0, 6, 'Gracias por su compra.', 0, 1, 'C');
    $pdf->Cell(0, 6, 'Factura generada electrónicamente y válida sin firma.', 0, 1, 'C');

    // Salida del PDF (descarga directa)
    $pdf->Output('D', 'Factura_Electronica.pdf');

    }
?>
