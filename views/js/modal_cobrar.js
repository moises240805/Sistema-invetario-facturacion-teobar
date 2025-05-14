var modal = document.getElementById("abonoModal");

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
    document.getElementById("abonoModal").style.display = "none";
}

// Si deseas cerrar al hacer clic fuera del modal (no es necesario con Bootstrap):
window.onclick = function(event) {
    if (event.target == document.getElementById("abonoModal")) {
        document.getElementById("abonoModal").style.display = "none";
    }
    if (event.target == document.getElementById("abonoModal")) {
        document.getElementById("abonoModal").style.display = "none";
    }
}


function abrirModal(id) {
    // Abrir el modal
    $('#abonoModal').modal('show'); // Usa jQuery para mostrar el modal de Bootstrap
    console.log("Abriendo modal de abono con ID: " + id); // Para debugging

    // Establecer el id_cuenta en el campo correspondiente
    document.getElementById('id_cuenta').value = id;

    // Si necesitas obtener datos adicionales para llenar otros campos, puedes hacerlo mediante AJAX
     fetch('index.php?action=cobrar&a=abono&id_cuenta=' + id)
        .then(response => response.json())
        .then(data => { console.log(data);
           // Llenar los campos del formulario con los datos obtenidos
           document.getElementById('id_cuenta').value = data[0].id_cuentaCobrar;
           document.getElementById('cliente').value = data[0].nombre_cliente + ' ' + data[0].tipo_id + '' + data[0].id_cliente + ' tlf: ' + data[0].tlf;
       })
       .catch(error => console.error('Error:', error));
}
