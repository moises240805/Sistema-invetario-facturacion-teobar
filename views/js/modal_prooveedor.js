// Get the modal
var modal = document.getElementById("agregarProveedorModal");

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
    document.getElementById("agregarProveedorModal").style.display = "none";
}

// Si deseas cerrar al hacer clic fuera del modal (no es necesario con Bootstrap):
window.onclick = function(event) {
    if (event.target == document.getElementById("agregarProveedorModal")) {
        document.getElementById("agregarProveedorModal").style.display = "none";
    }
    if (event.target == document.getElementById("modalModificarProveedor")) {
        document.getElementById("modalModificarProveedor").style.display = "none";
    }
}

//MODAL MODIFICAR
function abrirModalModificar(id) {
    // Abrir el modal
    $('#modalModificarProveedor').modal('show'); // Usa jQuery para mostrar el modal de Bootstrap
    console.log("Abriendo modal de modificar con ID: " + id); // Para debugging

    // Obtener los datos del cliente mediante AJAX
    fetch('index.php?action=proveedor&a=mid_form&id_proveedor=' + id)
        .then(response => response.json())
        .then(data => {

            // Llenar los campos del formulario de modificación
            document.getElementById('id_proveedor').value = data.id_proveedor; // ID del proveedor (hidden)

            // Separar el tipo de documento y el número (RIF)
            document.querySelector('select[name="tipo"]').value = data.tipo_id;
            document.getElementById('id_proveedor2').value = data.id_proveedor;

            document.getElementById('nombre_proveedor').value = data.nombre_proveedor;
            document.getElementById('direccion_proveedor').value = data.direccion;

            // Telefono Proveedor
            let telefono = data.tlf;
            if (telefono) {
                let codigo = telefono.substring(0, 4);
                let numero = telefono.substring(4);

                let selectCodigo = document.querySelector('select[name="codigo_tlf"]');
                for (let option of selectCodigo.options) {
                    if (option.value === codigo) {
                        option.selected = true;
                        break;
                    }
                }
                document.getElementById('telefono').value = numero;
            }

            // Representante Legal
            document.querySelector('select[name="tipo2"]').value = data.tipo_id2;
            document.getElementById('id_representante').value = data.id_representante;
            document.getElementById('nombre_representante').value = data.nombre_representante;

            let telefonoRepresentante = data.tlf_representante;

            if (telefonoRepresentante) {
                let codigoRepresentante = telefonoRepresentante.substring(0, 4);
                let numeroRepresentante = telefonoRepresentante.substring(4);

                let selectCodigoRepresentante = document.querySelector('select[name="codigo_tlf_representante"]');

                if (selectCodigoRepresentante) {
                    for (let option of selectCodigoRepresentante.options) {
                        if (option.value === codigoRepresentante) {
                            option.selected = true;
                            break;
                        }
                    }
                }

                document.getElementById('numero_tlf_representante').value = numeroRepresentante;
            }
        })
        .catch(error => console.error('Error:', error));
}
function cerrarModalModificar() {
    $('#modalModificarProveedor').modal('hide');
}


//No es necesario el cerrar modal. ya boostrap lo hace solo con data-dismiss="modal"
