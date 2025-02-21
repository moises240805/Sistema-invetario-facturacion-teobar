let page = 1;
const content = document.getElementById('content');
const loader = document.getElementById('loader');

// Función para simular la carga de contenido
function loadMoreContent() {
    loader.style.display = 'block';

    // Simula una llamada a una API
    setTimeout(() => {
        for (let i = 0; i < 5; i++) { // Cargar 5 elementos a la vez
            const item = document.createElement('div');
            item.className = 'item';
            item.innerText = `Item ${((page - 1) * 5) + i + 1}`;
            content.appendChild(item);
        }
        loader.style.display = 'none';
        page++;
    }, 1000); // Simula un retardo de 1 segundo
}

// Evento para detectar cuando el usuario hace scroll hacia abajo
window.addEventListener('scroll', () => {
    // Si el usuario está cerca del final de la página
    if (window.innerHeight + window.scrollY >= document.body.offsetHeight - 100) {
        loadMoreContent();
    }
});

// Cargar contenido inicial
loadMoreContent();