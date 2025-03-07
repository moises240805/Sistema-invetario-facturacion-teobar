var modal = document.getElementById("abrirModal");
var btn = document.getElementById("myBtn");

btn.onclick = function() {
    modal.style.display = "block";
    modal.style.visibility = "visible";
}

function cerrarModal() {
    modal.style.display = "none";
}

// Si deseas cerrar al hacer clic fuera del modal
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
