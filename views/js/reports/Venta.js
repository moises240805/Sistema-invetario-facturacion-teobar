// Función para crear gráfico de barras
function crearGrafico(ctxId, labels, data, titulo) {
    const ctx = document.getElementById(ctxId).getContext('2d');
    return new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: titulo,
          data: data,
          backgroundColor: 'rgba(54, 162, 235, 0.6)',
          borderColor: 'rgba(54, 162, 235, 1)',
          borderWidth: 1
        }]
      },
      options: {
        scales: {
          y: { beginAtZero: true }
        }
      }
    });
  }
  
  // Crear los gráficos con los datos ya cargados en variables globales
  crearGrafico('graficaVentas', labels, data, 'Ventas por Mes');
  crearGrafico('graficaProducto', labelsProducto, dataProducto, 'Ventas por Producto');
  crearGrafico('graficaCliente', labelsCliente, dataCliente, 'Ventas por Cliente');
  crearGrafico('graficaModalidad', labelsModalidad, dataModalidad, 'Ventas por Modalidad de Pago');