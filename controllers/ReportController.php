<?php
require_once 'models/Report.php'; // Asegúrate de incluir el modelo

class ReporteController {
    private $model;

    public function __construct() {
        $this->model = new ReporteModel(); // Instancia el modelo, que ya maneja la conexión
    }

    public function generarPDF() { 
        require_once 'libs/fpdf.php'; 
        $datos = $this->model->obtenerDatos(); 
    
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

    public function generarPDF2() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos2();

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

    public function generarPDF3() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos3();

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
            $pdf->Cell(27, 10, $row['nombre']);
            $pdf->Cell(40, 10, $row['direccion']);
            $pdf->Cell(37, 10, $row['tlf']);
            $pdf->Cell(30, 10, $row['tipo_id2'] . $row['id_representante']);
            $pdf->Cell(32, 10, $row['nombre_representante']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_proveedores.pdf');
    }

    public function generarPDF4() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos5();

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
            $pdf->Cell(22, 10, $row['id_modalidad_pago']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Cell(22, 10, $row['tipo_entrega']);
            $pdf->Cell(22, 10, $row['nombre_banco']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_ventas.pdf');
    }

    public function generarPDF6() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos6();

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
            $pdf->Cell(37, 10, $row['rif_proveedor'] . $row['nombre_proveedor']);
            $pdf->Cell(22, 10, $row['cantidad_compra']);
            $pdf->Cell(24, 10, $row['fecha']);
            $pdf->Cell(22, 10, $row['pago']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_compras.pdf');
    }

    public function generarPDF5() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos4();

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
            $pdf->Cell(22, 10, $row['id_venta']);
            $pdf->Cell(37, 10, $row['id_cliente']);
            $pdf->Cell(24, 10, $row['fech_emision']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_Cobrar.pdf');
    }

    public function generarPDF7() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos7();

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
            $pdf->Cell(37, 10, $row['rif_proveedor']);
            $pdf->Cell(24, 10, $row['fecha_cuentaPagar']);
            $pdf->Cell(22, 10, $row['monto_cuentaPagar']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_Pagar.pdf');
    }

    public function generarPDF8() { 
        require_once 'libs/fpdf.php'; 
        $datos = $this->model->obtenerDatos8(); 
    
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

    public function generarPDF9() { 
        require_once 'libs/fpdf.php'; 
        $datos = $this->model->obtenerDatos9(); 
    
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

    public function generarPDF10() { 
        require_once 'libs/fpdf.php'; 
        $datos = $this->model->obtenerDatos10(); 
    
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

    public function generarPDF11() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos11();

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

        $pdf->Output('D', 'reporte_clientes_centas.pdf');
    }

    public function generarPDF12() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos12();

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
            $pdf->Cell(27, 10, $row['nombre_proveedor']);
            $pdf->Cell(37, 10, $row['tlf']);
            $pdf->Cell(25, 10, $row['id_compra']);
            $pdf->Cell(25, 10, $row['monto']);
            $pdf->Cell(45, 10, $row['direccion']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_proveedor_compras.pdf');
    }

    public function generarPDF13() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos13();

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

    public function generarPDF14() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos14();

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

    public function generarPDF15() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos15();

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

    public function generarPDF16() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos16();

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
            $pdf->Cell(37, 10, $row['rif_proveedor'] . $row['nombre_proveedor']);
            $pdf->Cell(22, 10, $row['cantidad_compra']);
            $pdf->Cell(24, 10, $row['fecha']);
            $pdf->Cell(33, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_compras_trans.pdf');
    }

    public function generarPDF17() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos17();

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
            $pdf->Cell(37, 10, $row['rif_proveedor'] . $row['nombre_proveedor']);
            $pdf->Cell(22, 10, $row['cantidad_compra']);
            $pdf->Cell(24, 10, $row['fecha']);
            $pdf->Cell(33, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_compras_PM.pdf');
    }

    public function generarPDF18() {
        require_once 'libs/fpdf.php';
        $datos = $this->model->obtenerDatos18();

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
            $pdf->Cell(37, 10, $row['rif_proveedor'] . " ".  $row['nombre_proveedor']);
            $pdf->Cell(22, 10, $row['cantidad_compra']);
            $pdf->Cell(24, 10, $row['fecha']);
            $pdf->Cell(33, 10, $row['nombre_modalidad']);
            $pdf->Cell(22, 10, $row['monto']);
            $pdf->Ln();
        }

        $pdf->Output('D', 'reporte_compras_DE.pdf');
    }
}
?>
