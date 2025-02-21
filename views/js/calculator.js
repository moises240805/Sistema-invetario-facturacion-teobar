function calcularCantidad() {
    const peso = document.querySelector('input[name="peso"]').value;
    const peso3 = document.querySelector('input[name="peso3"]').value;
    const cantidad1 = document.querySelector('input[name="cantidad"]').value;
    const precio1 = document.querySelector('input[name="precio"]').value;
    const precio2Input = document.querySelector('input[name="precio2"]');
    const precio3Input = document.querySelector('input[name="precio3"]');
    const uniMedida1 = document.querySelector('select[name="uni_medida"]').value;
    const cantidad2Input = document.querySelector('input[name="cantidad2"]');
    const uniMedida2Select = document.querySelector('select[name="uni_medida2"]');
    const cantidad3Input = document.querySelector('input[name="cantidad3"]');
    const uniMedid32Select = document.querySelector('select[name="uni_medida3"]');

    // Verificamos si la unidad medida es "Bulto"
    if (uniMedida1 === "4") { 
        const cantidadKilogramos = cantidad1 * peso; // Cambia 50 por el valor real de kg en un bulto
        const cantidadgramos = cantidadKilogramos * 1000;

        const preciokilogramos = precio1 / peso;
        const preciogramos = preciokilogramos * peso3;
        
        cantidad2Input.value = cantidadKilogramos;
        precio2Input.value = preciokilogramos.toFixed(2);
        uniMedida2Select.value = "1";
        
        cantidad3Input.value = cantidadgramos;
        precio3Input.value = preciogramos.toFixed(2);
        uniMedid32Select.value = "2";

        // Seleccionamos Kilogramos
    }
    if (uniMedida1 === "3") { // Asumiendo que "Bulto" tiene valor "3"
        const cantidadKilogramos = cantidad1 * peso; // Cambia 50 por el valor real de kg en un bulto
        const cantidadgramos = cantidadKilogramos * 1000;

        const preciokilogramos = precio1 / peso;
        const preciogramos = preciokilogramos * peso3;
        
        cantidad2Input.value = cantidadKilogramos;
        precio2Input.value = preciokilogramos.toFixed(2);
        uniMedida2Select.value = "1";
        
        cantidad3Input.value = cantidadgramos;
        precio3Input.value = preciogramos.toFixed(2);
        uniMedid32Select.value = "2";

                // Deshabilitar los selectores
                uniMedida2Select.readOnly = true;
        uniMedid32Select.readOnly = true;
        cantidad2Input.readOnly = true;
    precio2Input.readOnly = true;
    cantidad3Input.readOnly = true;
    precio3Input.readOnly = true;

    }if (uniMedida1 === "7") { // Asumiendo que "Bulto" tiene valor "3"
        const cantidadKilogramos = cantidad1 * 3.7854; // Cambia 50 por el valor real de kg en un bulto
        const cantidadgramos = cantidadKilogramos * 1000;

        const preciokilogramos = precio1 / cantidadKilogramos;
        const preciogramos = preciokilogramos * peso3;
        
        cantidad2Input.value = cantidadKilogramos;
        precio2Input.value = preciokilogramos.toFixed(2);
        uniMedida2Select.value = "5";
        
        cantidad3Input.value = cantidadgramos;
        precio3Input.value = preciogramos.toFixed(2);
        uniMedid32Select.value = "6";

                // Deshabilitar los selectores
                uniMedida2Select.readOnly = true;
        uniMedid32Select.readOnly = true;
        cantidad2Input.readOnly = true;
    precio2Input.readOnly = true;
    cantidad3Input.readOnly = true;
    precio3Input.readOnly = true;
    }

    function validateNumber() { 
            const idInput = document.getElementById('number'); 
            const idError = document.getElementById('numberError'); 
        
            const regex = /^-?\d+(\.\d+)?$/;   
            if (!regex.test(idInput.value)) {   
                idError.textContent = "Solo puede contener numeros.";   
            } else {   
                idError.textContent = "";   
            }  
        }

    function validateNumber2() { 
            const idInput2 = document.getElementById('number2'); 
            const idError2 = document.getElementById('numberError2'); 
        
            const regex = /^-?\d+(\.\d+)?$/;   
            if (!regex.test(idInput2.value)) {   
                idError2.textContent = "Solo puede contener numeros.";   
            } else {   
                idError2.textContent = "";   
            }  
        }
}