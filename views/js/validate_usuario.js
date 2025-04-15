function Password() {
    const idInput = document.getElementById('password'); 
    const idError = document.getElementById('Error');
    const idInput2 = document.getElementById('password2'); 
    const idError2 = document.getElementById('Error2'); 
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

        // Verifica la longitud
        if (idInput2.value.length < 6 || idInput2.value.length > 9) { 
            idError2.textContent2 = "La contraseña debe tener entre 6 y 9 caracteres."; 
            return false; // Salir de la función si hay un error
        }
    
        // Verifica si contiene al menos una mayúscula y un punto
        const tieneMayuscula2 = /[A-Z]/.test(idInput2.value);
        const tienePunto2 = /\./.test(idInput2.value);
    
        if (!tieneMayuscula2 || !tienePunto2) {
            idError2.textContent2 = "Debe contener una mayúscula y un punto."; 
            return false
        }
}