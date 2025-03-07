function calcularCantidad2() {
    const peso = document.getElementById('peso').value;
    const peso3 = document.getElementById('peso3').value;
    const cantidad1 = document.getElementById('cantidad').value;
    const precio1 = document.getElementById('precio').value;
    const precio2Input = document.getElementById('precio2');
    const precio3Input = document.getElementById('precio3');
    const uniMedida1 = document.getElementById('uni_medida').value;
    const cantidad2Input = document.getElementById('cantidad2');
    const uniMedida2Select = document.getElementById('uni_medida2');
    const cantidad3Input = document.getElementById('cantidad3');
    const uniMedida3Select = document.getElementById('uni_medida3');

    if (uniMedida1 === "4") { 
        const cantidadKilogramos = cantidad1 * peso; 
        const cantidadgramos = cantidadKilogramos * 1000;

        const preciokilogramos = precio1 / peso;
        const preciogramos = preciokilogramos * peso3;
        
        cantidad2Input.value = cantidadKilogramos;
        precio2Input.value = preciokilogramos.toFixed(2);
        uniMedida2Select.value = "1";
        
        cantidad3Input.value = cantidadgramos;
        precio3Input.value = preciogramos.toFixed(2);
        uniMedida3Select.value = "2"; // Corregido
        
    }
    if (uniMedida1 === "3") { 
        const cantidadKilogramos = cantidad1 * peso; 
        const cantidadgramos = cantidadKilogramos * 1000;

        const preciokilogramos = precio1 / peso;
        const preciogramos = preciokilogramos * peso3;
        
        cantidad2Input.value = cantidadKilogramos;
        precio2Input.value = preciokilogramos.toFixed(2);
        uniMedida2Select.value = "1";
        
        cantidad3Input.value = cantidadgramos;
        precio3Input.value = preciogramos.toFixed(2);
        uniMedida3Select.value = "2"; // Corregido
        
        uniMedida2Select.readOnly = true;
        uniMedida3Select.readOnly = true;
        cantidad2Input.readOnly = true;
        precio2Input.readOnly = true;
        cantidad3Input.readOnly = true;
        precio3Input.readOnly = true;
    
    }
    if (uniMedida1 === "7") { 
        const cantidadLitros = cantidad1 * 3.7854; 
        const cantidadMililitros = cantidadLitros * 1000;

        const preciolitros = precio1 / cantidadLitros;
        const preciomililitros = preciolitros * peso3;
        
        cantidad2Input.value = cantidadLitros;
        precio2Input.value = preciolitros.toFixed(2);
        uniMedida2Select.value = "5";
        
        cantidad3Input.value = cantidadMililitros;
        precio3Input.value = preciomililitros.toFixed(2);
        uniMedida3Select.value = "6"; // Corregido
        
        uniMedida2Select.readOnly = true;
        uniMedida3Select.readOnly = true;
        cantidad2Input.readOnly = true;
        precio2Input.readOnly = true;
        cantidad3Input.readOnly = true;
        precio3Input.readOnly = true;
    }
}


function validateNumber() {
    const idInput = document.getElementById('cantidad');
    const idError = document.getElementById('numberError');

    const regex = /^-?\d+(\.\d+)?$/;
    if (!regex.test(idInput.value)) {
        idError.textContent = "Solo puede contener numeros.";
    } else {
        idError.textContent = "";
    }
}