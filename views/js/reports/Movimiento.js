function crearGrafico() {
  const ctx = document.getElementById('graficaMovimientos').getContext('2d');
  const graficoMovimientos = new Chart(ctx, {
    type: 'bar',
    data: datosMovimientos,
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true }
      }
    }
  });
}

crearGrafico();

