function setFechaActual() {
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('fecha_registro').value = today;
}

// Llamar a la función al cargar la página
setFechaActual();

// Función para validar la fecha de vencimiento
function validarFechaVencimiento() {
    const fechaVencimientoInput = document.getElementById('fech_venci');
    
    // Escuchar el evento de cambio en el campo de fecha
    fechaVencimientoInput.addEventListener('change', function() {
        const fechaVencimiento = new Date(this.value);
        const fechaActual = new Date();
        
        // Establecer la fecha mínima como 15 días a partir de hoy
        const fechaMinima = new Date(fechaActual);
        fechaMinima.setDate(fechaActual.getDate() + 15);
        
        // Validar si la fecha de vencimiento es menor que la fecha mínima
        if (fechaVencimiento < fechaMinima) {
            alert('La fecha de vencimiento debe ser al menos 15 días a partir de hoy.');
            this.value = ''; // Limpiar el campo si no es válido
        }
    });
}

// Llamar a la función al cargar la página
validarFechaVencimiento();