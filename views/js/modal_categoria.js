
function abrirModalModificar(id) {
    // Abrir el modal
    document.getElementById("modalModificar").style.display = "block";

    // Obtener los datos del producto mediante AJAX
    fetch('index.php?action=categoria&a=mid_form&ID=' + id)
    .then(response => response.json())
    .then(data => { console.log(data);
        document.getElementById('id').value = data.ID;
        document.getElementById('categoria').value = data.nombre_categoria;
    })
    .catch(error => console.error('Error:', error));
}

function cerrarModalModificar() {
    document.getElementById("modalModificar").style.display = "none";
}

