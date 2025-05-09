document.addEventListener('DOMContentLoaded', function() {
    const celdas = document.querySelectorAll('td.estatus-cell');

    celdas.forEach(function(celda) {
        const valor = celda.textContent.trim();

        if (valor === '0' || valor === '1') {
            const checkbox = document.createElement('input');
            checkbox.type = 'checkbox';
            checkbox.checked = (valor === '1');

            // Pasar datos para identificar el permiso
            checkbox.dataset.idModulo = celda.dataset.idModulo;
            checkbox.dataset.idRol = celda.dataset.idRol;
            checkbox.dataset.idPermiso = celda.dataset.idPermiso;

            celda.textContent = '';
            celda.appendChild(checkbox);

            // Escuchar cambios y enviar actualización
            checkbox.addEventListener('change', function() {
                const nuevoValor = this.checked ? 1 : 0;
                const idModulo = this.dataset.idModulo;
                const idRol = this.dataset.idRol;
                const idPermiso = this.dataset.idPermiso;

                // Aquí llamas a la función para actualizar el estatus en el servidor
                actualizarEstatus(idModulo, idRol, idPermiso, nuevoValor);
            });
        }
    });

    function actualizarEstatus(idModulo, idRol, idPermiso, estatus) {
        fetch('index.php?action=roles&a=actualizar', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({
                id_modulo: idModulo,
                id_rol: idRol,
                id_permiso: idPermiso,
                estatus: estatus
            })
        })
        .then(response => response.json())
        .then(data => {
            if (!data.success) {
                alert('Error al actualizar estatus');
            }
            else{                
                alert('Error al actualizar estatus');
            }
        })
        .catch(() => {
            //alert('Error en la conexión con el servidor');
            //alert('Permiso asignado correctamente');
        });
    }
});