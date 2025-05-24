// Gráfica Compras por Mes
const ctxMes = document.getElementById('graficaVentas').getContext('2d');
const graficaComprasMes = new Chart(ctxMes, {
    type: 'bar',
    data: {
        labels: labelsCompra,
        datasets: [{
            label: 'Monto Compras',
            data: dataCompra,
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

// Gráfica Compras por Producto
const ctxProducto = document.getElementById('graficaProducto').getContext('2d');
const graficaComprasProducto = new Chart(ctxProducto, {
    type: 'pie',
    data: {
        labels: labelsProductoCompra,
        datasets: [{
            label: 'Monto Compras',
            data: dataProductoCompra,
            backgroundColor: [
                'rgba(255, 99, 132, 0.6)',
                'rgba(255, 206, 86, 0.6)',
                'rgba(75, 192, 192, 0.6)',
                // Agrega más colores si tienes más productos
            ],
            borderColor: 'rgba(255, 255, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});

// Gráfica Compras por Proveedor
const ctxProveedor = document.getElementById('graficaCliente').getContext('2d');
const graficaComprasProveedor = new Chart(ctxProveedor, {
    type: 'bar',
    data: {
        labels: labelsProveedor,
        datasets: [{
            label: 'Monto Compras',
            data: dataProveedor,
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

// Gráfica Compras por Modalidad de Pago
const ctxModalidad = document.getElementById('graficaModalidad').getContext('2d');
const graficaComprasModalidad = new Chart(ctxModalidad, {
    type: 'doughnut',
    data: {
        labels: labelsModalidadCompra,
        datasets: [{
            label: 'Monto Compras',
            data: dataModalidadCompra,
            backgroundColor: [
                'rgba(255, 159, 64, 0.6)',
                'rgba(54, 162, 235, 0.6)',
                'rgba(255, 99, 132, 0.6)',
                // Más colores si es necesario
            ],
            borderColor: 'rgba(255, 255, 255, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true
    }
});
