function Password() {
    const idInput = document.getElementById('pw'); 
    const idError = document.getElementById('Error'); 
    idError.textContent = ""; // Limpiar mensaje de error

    // Verifica la longitud
    if (idInput.value.length < 6 || idInput.value.length > 9) { 
        idError.textContent = "La contraseña debe tener entre 6 y 9 caracteres."; 
        return false; // Salir de la función si hay un error
    }

    // Verifica si contiene al menos una mayúscula y un punto
    const tieneMayuscula = /[A-Z]/.test(idInput.value);
    const tienePunto = /\./.test(idInput.value);

    if (!tieneMayuscula || !tienePunto) {
        idError.textContent = "Debe contener una mayúscula y un punto."; 
        return false
    }
}