<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>TEBOAR</title>
  <link rel="shortcut icon" href="views/img/logo.jpeg">
  <!-- Bootstrap CSS CDN -->
  <?php require_once 'link.php' ?>
  <style>
    /* Paleta de colores azul y azul pastel */
    :root {
      --color-azul-oscuro: #1e3a8a; /* azul oscuro */
      --color-azul-pastel: #bfdbfe; /* azul pastel */
      --color-azul-medio: #3b82f6; /* azul medio */
      --color-blanco: #ffffff;
      --color-texto: #1e293b; /* gris azulado oscuro */
    }

    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: var(--color-blanco);
      color: var(--color-texto);
      padding-top: 2rem;
      padding-bottom: 2rem;
    }

    h1, h2, h3 {
      color: var(--color-azul-oscuro);
      font-weight: 700;
    }

    h1 {
      font-size: 3rem;
      font-weight: 900;
    }

    h2 {
      margin-top: 2rem;
      margin-bottom: 1rem;
    }

    p {
      font-size: 1.1rem;
    }

    /* Navbar personalizado */
    .navbar-custom {
      background-color: var(--color-azul-oscuro);
    }

    .navbar-custom .navbar-brand,
    .navbar-custom .nav-link {
      color: var(--color-blanco);
      font-weight: 600;
    }

    .navbar-custom .nav-link:hover {
      color: var(--color-azul-medio);
    }

    /* Botones */
    .btn-primary {
      background-color: var(--color-azul-medio);
      border-color: var(--color-azul-medio);
      font-weight: 600;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: var(--color-azul-oscuro);
      border-color: var(--color-azul-oscuro);
    }

    /* Carrusel */
    .carousel-item {
      position: relative;
    }

    .carousel-item img {
      height: 400px;
      object-fit: cover;
      filter: brightness(0.95);
      border-radius: 0.5rem;
    }

    /* Contenedor botón tienda dentro del carrusel */
    .carousel-caption-custom {
      position: absolute;
      bottom: 25px;
      left: 50%;
      transform: translateX(-50%);
      background-color: rgba(191, 219, 254, 0.85); /* azul pastel semitransparente */
      padding: 1rem 2rem;
      border-radius: 0.75rem;
      box-shadow: 0 4px 10px rgb(191 219 254 / 0.6);
      max-width: 90%;
      text-align: center;
      color: var(--color-azul-oscuro);
      user-select: none;
    }

    .carousel-caption-custom p {
      margin-bottom: 0.75rem;
      font-weight: 700;
      font-size: 1.2rem;
    }

    /* Frases marketing */
    .marketing-phrases {
      background-color: var(--color-azul-pastel);
      color: var(--color-azul-oscuro);
      font-style: italic;
      font-weight: 700;
      padding: 2rem 1rem;
      border-radius: 0.5rem;
      text-align: center;
      margin-bottom: 1.5rem;
      box-shadow: 0 4px 10px rgb(191 219 254 / 0.5);
    }

    /* Sección contacto */
    .contact-info a {
      color: var(--color-azul-oscuro);
      font-weight: 600;
      text-decoration: none;
    }

    .contact-info a:hover {
      text-decoration: underline;
    }

    /* Lista de beneficios */
    .benefits-list li {
      margin-bottom: 0.75rem;
    }

    /* Footer simple */
    footer {
      text-align: center;
      padding: 1rem 0;
      color: var(--color-azul-oscuro);
      font-size: 0.9rem;
      border-top: 1px solid #ddd;
      margin-top: 3rem;
    }

    /* Sección botón tienda después beneficios */
    .store-button-section {
      max-width: 700px;
      margin: 2rem auto 4rem auto;
      text-align: center;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-custom">
    <div class="container">
      <a class="navbar-brand" href="#">Teobar</a>
    </div>
  </nav>

  <main class="container mt-4">
    <!-- Título principal -->
    <header class="text-center mb-5">
      <h1>Teobar</h1>
      <p class="fs-4 text-muted">Materia Prima para Panificadoras, Repostería y Heladerías</p>
    </header>

    <!-- Carrusel Bootstrap -->
    <div id="teobarCarousel" class="carousel slide mb-5" data-bs-ride="carousel" data-bs-interval="5000" aria-label="Galería de imágenes de Teobar">
      <div class="carousel-inner rounded-3 shadow-sm">
        <div class="carousel-item active">
          <img src="https://images.unsplash.com/photo-1565958011703-44f9829ba187?auto=format&fit=crop&w=900&q=80" class="d-block w-100" alt="Materia prima para panificadoras" />
          <div class="carousel-caption-custom">
            <p>Descubre nuestra tienda online y accede a la mejor materia prima con un clic.</p>
            <a href="index.php?action=pedido&a=ecommerce" rel="noopener" class="btn btn-primary btn-lg" aria-label="Ir a la tienda online de Teobar">
              Visitar Tienda Online
            </a>
          </div>
        </div>
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1505253210343-0e7d2c9e6d2c?auto=format&fit=crop&w=900&q=80" class="d-block w-100" alt="Repostería artesanal" />
        </div>
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93?auto=format&fit=crop&w=900&q=80" class="d-block w-100" alt="Heladerías con productos frescos" />
        </div>
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1556910103-1e6a1a5a0d8e?auto=format&fit=crop&w=900&q=80" class="d-block w-100" alt="Almacén de materia prima Teobar" />
        </div>
      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#teobarCarousel" data-bs-slide="prev" aria-label="Imagen anterior">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#teobarCarousel" data-bs-slide="next" aria-label="Imagen siguiente">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
      </button>
    </div>

    <!-- Bienvenida -->
    <section class="mb-5 text-center">
      <p>
        Con casi 20 años de experiencia en el mercado, <strong>Teobar</strong> es tu proveedor confiable de materia prima para panificadoras, repostería y heladerías. Ofrecemos productos de alta calidad al por mayor y al detalle, adaptándonos a las necesidades de tu negocio para ayudarte a crear productos deliciosos que conquisten a tus clientes.
      </p>
    </section>

    <!-- Misión y Visión -->
    <section class="row mb-5">
      <article class="col-md-6 mb-4">
        <h2>Nuestra Misión</h2>
        <p>
          Proveer materia prima de la más alta calidad para panificadoras, reposterías y heladerías, contribuyendo al éxito de nuestros clientes mediante un servicio personalizado, confiable y eficiente, fomentando relaciones duraderas basadas en la confianza y la excelencia.
        </p>
      </article>
      <article class="col-md-6 mb-4">
        <h2>Nuestra Visión</h2>
        <p>
          Ser la empresa líder en la distribución de materia prima para el sector de panadería, repostería y heladería, reconocida por la calidad de nuestros productos, innovación constante y compromiso con el crecimiento sostenible de nuestros clientes y colaboradores.
        </p>
      </article>
    </section>

    <!-- Por qué elegirnos -->
    <section class="mb-5">
      <h2 class="text-center mb-4">¿Por qué elegir Teobar?</h2>
      <ul class="benefits-list list-unstyled mx-auto" style="max-width: 700px;">
        <li>✔️ <strong>Calidad Garantizada:</strong> Solo trabajamos con proveedores certificados para asegurar la mejor materia prima.</li>
        <li>✔️ <strong>Experiencia:</strong> Casi dos décadas acompañando a negocios como el tuyo.</li>
        <li>✔️ <strong>Venta al Mayor y Detal:</strong> Flexibilidad para grandes pedidos o compras pequeñas.</li>
        <li>✔️ <strong>Atención Personalizada:</strong> Asesoría para que elijas lo que mejor se adapta a tus necesidades.</li>
        <li>✔️ <strong>Entrega Rápida y Segura:</strong> Logística eficiente para que recibas tu pedido a tiempo.</li>
      </ul>

      <!-- Botón tienda online aquí -->
      <div class="store-button-section">
        <a href="index.php?action=pedido&a=ecommerce" rel="noopener" class="btn btn-primary btn-lg" aria-label="Ir a la tienda online de Teobar">
          Visitar Tienda Online
        </a>
      </div>
    </section>

    <!-- Frases de marketing -->
    <section class="marketing-phrases" aria-live="polite" aria-atomic="true">
      "Impulsa tu negocio con la mejor materia prima." — "Calidad que se siente en cada bocado." — "Tu éxito, nuestro compromiso." — "De nuestra experiencia a tu mesa."
    </section>

    <!-- Contacto -->
    <section class="contact-info text-center">
      <h2>Contáctanos</h2>
      <p>¿Quieres saber más o realizar un pedido?</p>
      <p>Teléfono: <a href="tel:+1234567890">+1 234 567 890</a></p>
      <p>Correo: <a href="mailto:contacto@teobar.com">contacto@teobar.com</a></p>
      <p>Dirección: Calle Falsa 123, Ciudad, País</p>
    </section>
  </main>

  <footer>
    &copy; 2025 Teobar - Todos los derechos reservados
  </footer>

</body>
</html>
