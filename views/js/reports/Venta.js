function crearGraficoVentasMes() {
  const ctx = document.getElementById('graficaVentas').getContext('2d');
  return new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: [{
        label: 'Ventas por Mes',
        data: data,
        backgroundColor: 'rgba(54, 162, 235, 0.6)',
        borderColor: 'rgba(54, 162, 235, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
}



function crearGraficoVentasProducto() {
  const ctx = document.getElementById('graficaProducto').getContext('2d');
  return new Chart(ctx, {
    type: 'pie',
    data: {
      labels: labelsProducto,
      datasets: [{
        label: 'Ventas por Producto',
        data: dataProducto,
        backgroundColor: [
          'rgba(255, 99, 132, 0.6)',
          'rgba(255, 206, 86, 0.6)',
          'rgba(75, 192, 192, 0.6)',
          // Añade más colores si tienes más productos
        ],
        borderColor: 'rgba(255, 255, 255, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true
    }
  });
}


function crearGraficoVentasCliente() {
  const ctx = document.getElementById('graficaCliente').getContext('2d');
  return new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labelsCliente, // Array con nombres o identificadores de clientes
      datasets: [{
        label: 'Ventas por Cliente',
        data: dataCliente,
        backgroundColor: 'rgba(153, 102, 255, 0.6)',
        borderColor: 'rgba(153, 102, 255, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
}

function crearGraficoVentasModalidad() {
  const ctx = document.getElementById('graficaModalidad').getContext('2d');
  return new Chart(ctx, {
    type: 'doughnut',
    data: {
      labels: labelsModalidad, // Array con modalidades de venta (ej. online, presencial)
      datasets: [{
        label: 'Ventas por Modalidad',
        data: dataModalidad,
        backgroundColor: [
          'rgba(255, 159, 64, 0.6)',
          'rgba(54, 162, 235, 0.6)',
          'rgba(255, 99, 132, 0.6)',
          // Añade más colores si tienes más modalidades
        ],
        borderColor: 'rgba(255, 255, 255, 1)',
        borderWidth: 1
      }]
    },
    options: {
      responsive: true
    }
  });
}

// Llamadas para crear los gráficos
crearGraficoVentasMes();
crearGraficoVentasProducto();
crearGraficoVentasCliente();
crearGraficoVentasModalidad();
