function abrirModalModificar(id) {
    // Obtener los datos del producto mediante AJAX
    fetch('index.php?action=movimientos&a=mid_form&ID=' + id)
    .then(response => response.json())
    .then(data => { 
        document.getElementById('id').value = data.ID;
        document.getElementById('caja').value = data.nombre_caja;
        document.getElementById('movimiento').value = data.tipo_movimiento;
        document.getElementById('monto').value = data.monto_movimiento;
        document.getElementById('modalidad').value = data.nombre_modalidad;
        document.getElementById('concepto').value = data.concepto;
        document.getElementById('fecha').value = data.fecha;

        // Mostrar el modal usando Bootstrap 5
        var modal = new bootstrap.Modal(document.getElementById('modalModificar'));
        modal.show();
    })
    .catch(error => console.error('Error:', error));
}


function cerrarModalModificar() {
    var modalElement = document.getElementById('modalModificar');
    var modalInstance = bootstrap.Modal.getInstance(modalElement);
    if (modalInstance) {
        modalInstance.hide();
    }
}