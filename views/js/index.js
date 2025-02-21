fetch("https://ve.dolarapi.com/v1/dolares/oficial")
.then(response => response.json())
.then(data => {

              const precio = data.promedio;
              const fecha = data.fechaActualizacion;
              document.getElementById('precioDolar').innerText = `BCV $: ${precio} Bs`;
          })
          .catch(error => {
              console.error('Hubo un problema con la solicitud:', error);
              document.getElementById('precioDolar').innerText = 'Error al cargar el precio';
          });


          

function calcularCantidad() {
    const cantidad1 = document.querySelector('input[name="cantidad"]').value;
    const uniMedida1 = document.querySelector('select[name="uni_medida"]').value;
    const cantidad2Input = document.querySelector('input[name="cantidad2"]');
    const uniMedida2Select = document.querySelector('select[name="uni_medida2"]');

    // Verificamos si la unidad medida es "Bulto"
    if (uniMedida1 === "3") { // Asumiendo que "Bulto" tiene valor "3"
        const cantidadKilogramos = cantidad1 * 50; // Cambia 50 por el valor real de kg en un bulto
        cantidad2Input.value = cantidadKilogramos;
        uniMedida2Select.value = "1"; // Seleccionamos Kilogramos
    }
}