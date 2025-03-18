// Selecciona todos los slides
const slides = document.querySelectorAll('.slogan-slide');

// Inicializa el índice del slide actual
let currentSlide = 0;

// Asegúrate de que el primer slide tenga la clase 'active'
slides[currentSlide].classList.add('active');

// Función para cambiar el slide cada 3 segundos
setInterval(() => {
    // Elimina la clase 'active' del slide actual
    slides[currentSlide].classList.remove('active');
    
    // Avanza al siguiente slide (o regresa al primero si es el último)
    currentSlide = (currentSlide + 1) % slides.length;
    
    // Agrega la clase 'active' al nuevo slide
    slides[currentSlide].classList.add('active');
}, 3000);

