// Get the modal
var modal = document.getElementById("agregarClienteModal");

// Get the button that opens the modal
// Asegúrate de que el botón tenga el id "myBtn"
// Si no, cambia "myBtn" por el id real del botón
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}

// When the user clicks anywhere outside of the modal, close it
function cerrarModal() {
    document.getElementById("agregarClienteModal").style.display = "none";
}

// Si deseas cerrar al hacer clic fuera del modal (no es necesario con Bootstrap):
window.onclick = function(event) {
    if (event.target == document.getElementById("agregarClienteModal")) {
        document.getElementById("agregarClienteModal").style.display = "none";
    }
    if (event.target == document.getElementById("modalModificarCliente")) {
        document.getElementById("modalModificarCliente").style.display = "none";
    }
}



function abrirModalModificar(id) {
    // Abrir el modal
    document.getElementById("modalModificarCliente").style.display = "block"; // ID corregido

    // Obtener los datos del cliente mediante AJAX
    fetch('index.php?action=cliente&a=mid_form&id_cliente=' + id)
    .then(response => response.json())
    .then(data => {


        // Llenar los campos del formulario de modificación
        document.getElementById('id_cliente').value = data.id_cliente; // ID del cliente (hidden)

        // Separar el tipo de documento y el número
        document.querySelector('select[name="tipo_id"]').value = data.tipo_id;
        document.getElementById('id_cliente2').value = data.id_cliente;

        document.getElementById('nombre_cliente').value = data.nombre_cliente;
        document.getElementById('email').value = data.email;
        document.getElementById('direccion').value = data.direccion;

        // Separar el código del teléfono y el número
        let telefono = data.tlf;
        let codigo = telefono.substring(0, 4);
        let numero = telefono.substring(4);

        let selectCodigo = document.querySelector('select[name="codigo_tlf"]');
        for (let option of selectCodigo.options) {
            if (option.value === codigo) {
                option.selected = true;
                break;
            }
        }
        document.getElementById('numero_tlf').value = numero;
    })
    .catch(error => console.error('Error:', error));
}


function cerrarModalModificar() {
    document.getElementById("modalModificarCliente").style.display = "none";
}

