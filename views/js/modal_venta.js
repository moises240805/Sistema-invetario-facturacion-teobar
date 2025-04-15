// Get the modal
var modal = document.getElementById("agregarVentaModal");

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

function abrirModal() {
    document.getElementById("agregarVentaModal").style.display = "block";
}

// When the user clicks anywhere outside of the modal, close it
function cerrarModal() {
    document.getElementById("agregarVentaModal").style.display = "none";
}

// Si deseas cerrar al hacer clic fuera del modal (no es necesario con Bootstrap):
window.onclick = function(event) {
    if (event.target == document.getElementById("agregarVentaModal")) {
        document.getElementById("agregarVentaModal").style.display = "none";
    }

}