// Get the modal
var modalAgregarProducto = document.getElementById("modalAgregarProducto");

// Get the button that opens the modal
var btnAgregarProducto = document.getElementById("myBtnAgregarProducto");

// When the user clicks the button, open the modal 
btnAgregarProducto.onclick = function() {
    modalAgregarProducto.style.display = "block";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modalAgregarProducto) {
        modalAgregarProducto.style.display = "none";
    }
}

function cerrarModalAgregarProducto() {
    var modalAgregarProducto = document.getElementById("modalAgregarProducto");
    modalAgregarProducto.style.display = "none";
}




function abrirModalModificar(id_producto) {
    // Abrir el modal
    document.getElementById("modalModificarProducto").style.display = "block";

    // Obtener los datos del producto mediante AJAX
    fetch('index.php?action=producto&a=mid_form&id_producto=' + id_producto)
        .then(response => response.json())
        .then(data => {
            // Establecer los campos del formulario con los datos recibidos
            document.getElementsByName('id_producto')[0].value = data.id_producto;
            document.getElementsByName('nombre')[0].value = data.nombre;
            document.getElementsByName('marca')[0].value = data.marca;
            document.getElementsByName('presentacion')[0].value = data.id_presentacion;

            // Cantidad y precio para diferentes variantes
            document.getElementsByName('cantidad')[0].value = data.cantidad;
            document.getElementsByName('cantidad2')[0].value = data.cantidad;
            document.getElementsByName('cantidad3')[0].value = data.cantidad;
            document.getElementsByName('precio')[0].value = data.precio;
            document.getElementsByName('precio2')[0].value = data.precio;
            document.getElementsByName('precio3')[0].value = data.precio;

            document.getElementsByName('peso')[0].value = data.peso;
            document.getElementsByName('peso3')[0].value = data.peso;

            // Unidades de medida
            document.getElementsByName('uni_medida')[0].value = data.id_unidad_medida;
            document.getElementsByName('uni_medida2')[0].value = data.id_unidad_medida2;
            document.getElementsByName('uni_medida3')[0].value = data.id_unidad_medida3;

            document.getElementsByName('fecha_vencimiento')[0].value = data.fecha_vencimiento;

            // Actualizar los selects
            var selectPresentacion = document.getElementsByName('presentacion')[0];
            for (var i = 0; i < selectPresentacion.options.length; i++) {
                if (selectPresentacion.options[i].value === data.id_presentacion) {
                    selectPresentacion.options[i].selected = true;
                }
            }

            var selectMarca = document.getElementsByName('marca')[0];
            for (var i = 0; i < selectMarca.options.length; i++) {
                if (selectMarca.options[i].value === data.id_marca) {
                    selectMarca.options[i].selected = true;
                }
            }

            var selectUniMedida = document.getElementsByName('uni_medida')[0];
            for (var i = 0; i < selectUniMedida.options.length; i++) {
                if (selectUniMedida.options[i].value === data.id_unidad_medida) {
                    selectUniMedida.options[i].selected = true;
                }
            }

            var selectUniMedida2 = document.getElementsByName('uni_medida2')[0];
            for (var i = 0; i < selectUniMedida2.options.length; i++) {
                if (selectUniMedida2.options[i].value === data.id_unidad_medida2) {
                    selectUniMedida2.options[i].selected = true;
                }
            }

            var selectUniMedida3 = document.getElementsByName('uni_medida3')[0];
            for (var i = 0; i < selectUniMedida3.options.length; i++) {
                if (selectUniMedida3.options[i].value === data.id_unidad_medida3) {
                    selectUniMedida3.options[i].selected = true;
                }
            }
        })
        .catch(error => console.error('Error:', error));
}


window.onclick = function(event) {
    var modalModificarProducto = document.getElementById("modalModificarProducto");
    if (event.target == modalModificarProducto) {
        cerrarModalModificarProducto();
    }
};

function cerrarModalModificarProducto() {
    var modalModificarProducto = document.getElementById("modalModificarProducto");
    modalModificarProducto.style.display = "none";
    // Remove backdrop if present
    var backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.remove();
    }
}





       


// Set today's date as the default for fecha_registro
const today = new Date().toISOString().split('T')[0];
document.getElementById('fecha_registro').value = today;

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
