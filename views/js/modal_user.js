// Get the modal
var modal = document.getElementById("myModal");

// Get the button that opens the modal
var btn = document.getElementById("myBtn");

// Get the <span> element that closes the modal
//var span = document.getElementsByClassName("close")[0];

// When the user clicks the button, open the modal 
btn.onclick = function() {
    modal.style.display = "block";
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

function cerrarModal() {
    modal.style.display = "none";
}


        // JavaScript para abrir y cerrar el modal de modificar
        function abrirModalModificar(id) {
            // Abrir el modal
            document.getElementById("modalModificar").style.display = "block";

            // Obtener los datos del usuario mediante AJAX
            fetch('index.php?action=usuario&a=mid_form&ID=' + id)
                .then(response => response.json())
                .then(data => {
                    document.getElementsByName('id')[0].value = data.ID;
                    document.getElementsByName('usuario')[0].value = data.usuario;
                    document.getElementsByName('clave')[0].value = data.pw;
        
                    // Actualizar el select de roles
                    var selectRol = document.getElementsByName('roles')[0];
                    for (var i = 0; i < selectRol.options.length; i++) {
                        if (selectRol.options[i].value === data.rol) {
                            selectRol.options[i].selected = true;
                        }
                    }
                })
                .catch(error => console.error('Error:', error));
        }

        function cerrarModalModificar() {
            document.getElementById("modalModificar").style.display = "none";
        }