function validateId() { 
    const idInput = document.getElementById('id'); 
    const idError = document.getElementById('idError'); 

    // Verifica si la longitud del valor está entre 6 y 8
    if (idInput.value.length < 6 || idInput.value.length > 8) { 
        idError.textContent = "CI debe tener entre 6 y 8 dígitos."; 
        return false;
    } else { 
        idError.textContent = "";
        return true; 
    } 
}

function validateId2() { 
    const idInput = document.getElementById('id2'); 
    const idError = document.getElementById('idError2'); 

    // Verifica si la longitud del valor está entre 6 y 8
    if (idInput.value.length < 6 || idInput.value.length > 8) { 
        idError.textContent = "El RIF debe tener entre 6 y 10 dígitos."; 
        return false;
    } else { 
        idError.textContent = "";
        return true; 
    } 
}

function validateName() {   
    const nameInput = document.getElementById('nombre');  
    const nameError = document.getElementById('nameError');   
     
    // Expresión regular que permite letras, espacios y guiones  
    const regex = /^[A-Za-z\s-]+$/;   
    if (!regex.test(nameInput.value)) {   
        nameError.textContent = "El nombre solo puede contener letras.";  
        return false; 
    } else {   
        nameError.textContent = "";   
        return true;
    }   
}      

function validatePhone() {
    const phoneInput = document.getElementById('numero_tlf');
    const phoneError = document.getElementById('phoneError');
    
    if (phoneInput.value.length !== 7) {
        phoneError.textContent = "El teléfono debe tener exactamente 7 dígitos.";
        return false;
    } else {
        phoneError.textContent = "";
        return true;
    }
}

function validatePhone2() {
    const phoneInput = document.getElementById('numero_tlf2');
    const phoneError = document.getElementById('phoneError2');
    
    if (phoneInput.value.length !== 7) {
        phoneError.textContent = "El teléfono debe tener exactamente 7 dígitos.";
        return false;
    } else {
        phoneError.textContent = "";
        return true;
    }
}

function validateEmail() {
    const emailInput = document.getElementById('email');
    const emailError = document.getElementById('emailError');
    
    // Corrige la expresión regular para el email
    const regex = /^[^.@]+@[^.]+\.[^.]+$/;
    
    if (!regex.test(emailInput.value)) {
        emailError.textContent = "Por favor ingresa un correo electrónico válido.";
        return false;
    } else {
        emailError.textContent = "";
        return true;
    }
}

function validateAddress() {
    const addressInput = document.querySelector('input[name="direccion"]');
    const addressError = document.getElementById('addressError');
    
    if (addressInput.value.trim() === "") {
        addressError.textContent = "Este campo no puede estar vacío.";
        return false;
    } else {        
      addressError.textContent = "";
      return true;
   }
}

// Función para validar todo el formulario antes de enviar
function validateForm2() {
   const isValidId = validateId();
   const isValidId2 = validateId2();
   const isValidName = validateName();
   const isValidPhone = validatePhone();
   const isValidPhone2 = validatePhone2();
   const isValidEmail = validateEmail();
   const isValidAddress = validateAddress();

   return isValidId && isValidId2 && isValidName && isValidPhone && isValidPhone2 && isValidEmail && isValidAddress;
}

function validateForm() {
    const isValidId = validateId();
    const isValidName = validateName();
    const isValidPhone = validatePhone();
    const isValidEmail = validateEmail();
    const isValidAddress = validateAddress();
 
    return isValidId && isValidName && isValidPhone && isValidEmail && isValidAddress;
 }