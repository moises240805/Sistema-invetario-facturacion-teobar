function validateId() { 
    const idInput = document.getElementById('id'); 
    const idError = document.getElementById('idError'); 

    if (idInput.value.length < 6 || idInput.value.length > 8) { 
        idError.textContent = "CI debe tener entre 6 y 8 dígitos."; 
        return false;
    } 
    idError.textContent = "";
    return true; 
}

function validateId2() { 
    const idInput = document.getElementById('id2'); 
    const idError = document.getElementById('idError2'); 

    if (idInput.value.length < 6 || idInput.value.length > 10) { 
        idError.textContent = "El RIF debe tener entre 6 y 10 dígitos."; 
        return false;
    } 
    idError.textContent = "";
    return true; 
}

function validateName() {   
    const nameInput = document.getElementById('nombre');  
    const nameError = document.getElementById('nameError');   
     
    const regex = /^[A-Za-z\s-]+$/;   
    if (!regex.test(nameInput.value)) {   
        nameError.textContent = "El nombre solo puede contener letras.";  
        return false; 
    } 
    nameError.textContent = "";   
    return true;
}      

function validatePhone() {
    const phoneInput = document.getElementById('numero_tlf');
    const phoneError = document.getElementById('phoneError');
    
    if (phoneInput.value.length !== 7) {
        phoneError.textContent = "El teléfono debe tener exactamente 7 dígitos.";
        return false;
    } 
    phoneError.textContent = "";
    return true;
}

function validatePhone2() {
    const phoneInput = document.getElementById('numero_tlf2');
    const phoneError = document.getElementById('phoneError2');
    
    if (phoneInput.value.length !== 7) {
        phoneError.textContent = "El teléfono debe tener exactamente 7 dígitos.";
        return false;
    } 
    phoneError.textContent = "";
    return true;
}

function validateAddress() {
   const addressInput = document.querySelector('input[name="direccion"]');
   const addressError = document.getElementById('addressError');
    
   if (addressInput.value.trim() === "") {
       addressError.textContent = "Este campo no puede estar vacío.";
       return false;
   }        
   addressError.textContent = "";
   return true;
}

// Function to validate the entire form before submission
function validateForm() {
   const isValidId = validateId();
   const isValidId2 = validateId2();
   const isValidName = validateName();
   const isValidPhone = validatePhone();
   const isValidPhone2 = validatePhone2();
   const isValidAddress = validateAddress();

   // Add more validations as needed

   return isValidId && isValidId2 && isValidName && isValidPhone && isValidPhone2 && isValidAddress;
}