function agregarFila() {
    const tabla = document.getElementById("tablaFormulario");
    const nuevaFila = document.getElementById("filaTemplate").cloneNode(true);
  
              // No limpiar los valores en la nueva fila clonada
              // Solo asegurarse de que el evento se asigne correctamente
              const nuevoSelect = nuevaFila.querySelector("select[name='id_producto[]']");
              nuevoSelect.addEventListener('change', function() {
                  obtenerPrecioProducto(nuevaFila);
              });
  
              const inputCantidad = nuevaFila.querySelector('input[name="cantidad[]"]');
              inputCantidad.addEventListener('input', function() {
                  obtenerPrecioProducto(nuevaFila);
              });
  
              tabla.appendChild(nuevaFila);
          }
  function eliminarFila(boton) {
      const fila = boton.parentNode.parentNode; // Obtiene la fila padre del botón
      fila.parentNode.removeChild(fila); // Elimina la fila
  }
  
  
  
  function obtenerPrecioProducto(fila) {
    const selectProducto = document.querySelector('select[name="id_producto[]"]');
    const inputCantidad = document.querySelector('input[name="cantidad[]"]');
    const inputMonto = document.querySelector('input[name="monto"]');
    const subtotalInput = document.querySelector('input[name="subtotal"]');
    const totalInput = document.querySelector('input[name="total"]');
  
    const selectedIndex = selectProducto.selectedIndex;
    const selectedOption = selectProducto.options[selectedIndex];
    const producto = JSON.parse(selectedOption.value);
    const precio = producto.precio;
  
    const cantidad = parseInt(inputCantidad.value);
    const monto = cantidad * precio;
  
    inputMonto.value = monto.toFixed(2);
  
    // Calculate subtotal, VAT, and total
    calcularSubtotalYTotal(); // Llamar a la función para actualizar subtotal y total
  }
  
  function calcularSubtotalYTotal() {
              let subtotal = 0;
              document.querySelectorAll('input[name="monto"]').forEach(montoInput => {
                  subtotal += parseFloat(montoInput.value) || 0;
              });
              
              const iva = subtotal * 0.16;
              const total = subtotal + iva;
  
              document.querySelector('input[name="subtotal"]').value = subtotal.toFixed(2);
              document.querySelector('input[name="total"]').value = total.toFixed(2);
          }