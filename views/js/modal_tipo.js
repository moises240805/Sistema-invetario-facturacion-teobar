// Get the modal
var modal = document.getElementById("agregarTipoModal");

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
    document.getElementById("agregarTipoModal").style.display = "none";
}

// Si deseas cerrar al hacer clic fuera del modal (no es necesario con Bootstrap):
window.onclick = function(event) {
    if (event.target == document.getElementById("agregarTipoModal")) {
        document.getElementById("agregarTipoModal").style.display = "none";
    }
    if (event.target == document.getElementById("modalModificar")) {
        document.getElementById("modalModificar").style.display = "none";
    }
}


function abrirModalModificar(id) {
    // Abrir el modal
    document.getElementById("modalModificar").style.display = "block";

    // Obtener los datos del producto mediante AJAX
    fetch('index.php?action=tipo&a=mid_form&id_presentacion=' + id)
    .then(response => response.json())
    .then(data => {
        document.getElementById('id').value = data.id_presentacion;
        document.getElementById('tipo').value = data.tipo_producto;
        document.getElementById('presen').value = data.presentacion;
    })
    .catch(error => console.error('Error:', error));
}

function cerrarModalModificar() {
    document.getElementById("modalModificar").style.display = "none";
}

