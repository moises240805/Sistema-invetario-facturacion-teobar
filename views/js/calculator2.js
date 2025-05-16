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

function calcularCantidad() {
    // Obtener valores y elementos por ID
    const peso = parseFloat(document.getElementById('peso4').value) || 0;
    const peso3 = parseFloat(document.getElementById('peso6').value) || 0;
    const cantidad1 = parseFloat(document.getElementById('cantidad4').value) || 0;
    const precio1 = parseFloat(document.getElementById('precio4').value) || 0;

    const precio2Input = document.getElementById('precio5');
    const precio3Input = document.getElementById('precio6');
    const uniMedida1 = document.getElementById('uni_medida').value;
    const cantidad2Input = document.getElementById('cantidad5');
    const uniMedida2Select = document.getElementById('uni_medida5');
    const cantidad3Input = document.getElementById('cantidad6');
    const uniMedida6Select = document.getElementById('uni_medida6');

    if (uniMedida1 === "4") { // Saco
        const cantidadKilogramos = cantidad1 * peso;
        const cantidadGramos = cantidadKilogramos * 1000;

        const precioKilogramos = peso !== 0 ? precio1 / peso : 0;
        const precioGramos = precioKilogramos * peso3;

        cantidad2Input.value = cantidadKilogramos.toFixed(2);
        precio2Input.value = precioKilogramos.toFixed(2);
        uniMedida2Select.value = "1"; // Kilogramos

        cantidad3Input.value = cantidadGramos.toFixed(2);
        precio3Input.value = precioGramos.toFixed(2);
        uniMedida6Select.value = "2"; // Gramos

        // Habilitar solo lectura en resultados
        cantidad2Input.readOnly = true;
        precio2Input.readOnly = true;
        cantidad3Input.readOnly = true;
        precio3Input.readOnly = true;
        uniMedida2Select.readOnly = true;
        uniMedida6Select.readOnly = true;

    } else if (uniMedida1 === "3") { // Bulto
        const cantidadKilogramos = cantidad1 * peso;
        const cantidadGramos = cantidadKilogramos * 1000;

        const precioKilogramos = peso !== 0 ? precio1 / peso : 0;
        const precioGramos = precioKilogramos * peso3;

        cantidad2Input.value = cantidadKilogramos.toFixed(2);
        precio2Input.value = precioKilogramos.toFixed(2);
        uniMedida2Select.value = "1"; // Kilogramos

        cantidad3Input.value = cantidadGramos.toFixed(2);
        precio3Input.value = precioGramos.toFixed(2);
        uniMedida6Select.value = "2"; // Gramos

        // Deshabilitar selectores y inputs de resultados
        cantidad2Input.readOnly = true;
        precio2Input.readOnly = true;
        cantidad3Input.readOnly = true;
        precio3Input.readOnly = true;
        uniMedida2Select.readOnly = true;
        uniMedida6Select.readOnly = true;

    } else if (uniMedida1 === "7") { // Galón
        const cantidadLitros = cantidad1 * 3.7854;
        const cantidadMililitros = cantidadLitros * 1000;

        const precioLitros = cantidadLitros !== 0 ? precio1 / cantidadLitros : 0;
        const precioMililitros = precioLitros * peso3;

        cantidad2Input.value = cantidadLitros.toFixed(2);
        precio2Input.value = precioLitros.toFixed(2);
        uniMedida2Select.value = "5"; // Litros

        cantidad3Input.value = cantidadMililitros.toFixed(2);
        precio3Input.value = precioMililitros.toFixed(2);
        uniMedida6Select.value = "6"; // Mililitros

        // Deshabilitar selectores y inputs de resultados
        cantidad2Input.readOnly = true;
        precio2Input.readOnly = true;
        cantidad3Input.readOnly = true;
        precio3Input.readOnly = true;
        uniMedida2Select.readOnly = true;
        uniMedida6Select.readOnly = true;

    } else {
        // Si no coincide ninguna unidad, limpiar campos y habilitar inputs
        cantidad2Input.value = "";
        precio2Input.value = "";
        cantidad3Input.value = "";
        precio3Input.value = "";
        uniMedida2Select.value = "";
        uniMedida6Select.value = "";

        cantidad2Input.readOnly = false;
        precio2Input.readOnly = false;
        cantidad3Input.readOnly = false;
        precio3Input.readOnly = false;
        uniMedida2Select.readOnly = false;
        uniMedida6Select.readOnly = false;
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