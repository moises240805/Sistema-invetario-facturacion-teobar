<!-- Header -->
<header class="hero py-3">
    <div class="container-fluid  d-flex align-items-center justify-content-between">
        <!-- Precio del dólar -->
        <b>
            <div style="color: black; font-size:1.3rem;" id="precioDolar">Cargando...</div>
        </b>

        <!-- Usuario y Notificaciones -->
        <div class="user d-flex align-items-center position-relative" style="margin-left: 5px;">
           <!-- Botón de notificación -->
<div class="notification position-relative mr-3">
    <i class="fas fa-bell fa-lg text-dark" id="bell-icon" style="cursor: pointer; position: relative;"></i>
    <!-- Indicador de notificaciones nuevas -->
    <span id="notification-count" 
          style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 12px; display: none;">
    </span>

    <!-- Contenedor de notificaciones -->
    <div class="notification-dropdown" id="notification-dropdown" style="position: absolute; top: 30px; right: 0; width: 300px; max-height: 400px; overflow-y: auto; background: white; border: 1px solid #ccc; box-shadow: 0 2px 8px rgba(0,0,0,0.15); z-index: 100;">

        <!-- Aquí se inyectarán las notificaciones -->
    </div>
</div>

            <!-- Usuario -->
            <img class="logo_user rounded-circle mr-2" src="views/img/avatar-male.png" alt="user">
            <span name="user" style="color: black;"><?php echo $_SESSION['s_usuario']['usuario']; ?></span>
        </div>

        <!-- Botón Logout -->
        <a href="index.php?action=usuario&a=cerrar" class="hero__logger btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Log Out
        </a>
    </div>
</header>

<!-- Estilos CSS -->
<style>
    .notification {
        position: relative;
    }

    .notification-dropdown {
        position: absolute;
        top: 30px;
        right: 0;
        background-color: white;
        border: 1px solid #ccc;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        width: 300px;
        display: none;
        flex-direction: column;
        z-index: 1000;
        border-radius: 8px;
        padding: 8px 0;
    }

    /* Clase para mostrar el dropdown */
    .notification-dropdown.show {
        display: flex;
    }

    .notification-item {
        padding: 12px 16px;
        font-size: 0.9rem;
        color: #333;
        border-bottom: 1px solid #eee;
    }

    .notification-item:last-child {
        border-bottom: none;
    }

    .notification-title {
        font-weight: bold;
        margin-bottom: 4px;
    }

    .notification-desc {
        font-size: 0.85rem;
        margin-bottom: 4px;
        color: #555;
    }

    .notification-meta {
        font-size: 0.75rem;
        color: #888;
        margin-bottom: 6px;
    }

    .notification-link {
        font-size: 0.8rem;
        color: #007bff;
        text-decoration: none;
    }
</style>
<script>


</script>
<script>
 document.addEventListener("DOMContentLoaded", function() {
    const bellIcon = document.getElementById('bell-icon');
    const notificationDropdown = document.getElementById('notification-dropdown');
    const notificationCount = document.getElementById('notification-count');

    function formatDate(dateString) {
        const options = { year: 'numeric', month: '2-digit', day: '2-digit', hour: '2-digit', minute: '2-digit' };
        const date = new Date(dateString.replace(' ', 'T'));
        return date.toLocaleDateString(undefined, options);
    }

    function loadNotifications() {
        fetch('index.php?action=notificacion&a=consultar') // Ajusta esta URL si es necesario
            .then(response => {
                if (!response.ok) throw new Error('Error en la respuesta de la red');
                return response.json();
            })
            .then(data => {
                console.log("Notificaciones recibidas:", data); // Para depurar

                notificationDropdown.innerHTML = '';

                if (!Array.isArray(data) || data.length === 0) {
                    notificationDropdown.innerHTML = '<div class="notification-item text-center">No hay notificaciones.</div>';
                    notificationCount.style.display = 'none';
                    return;
                }

                const newNotifications = data.filter(n => n.status == 1);
                if (newNotifications.length > 0) {
                    notificationCount.textContent = newNotifications.length;
                    notificationCount.style.display = 'inline-block';
                } else {
                    notificationCount.style.display = 'none';
                }

                data.forEach(notif => {
                    const item = document.createElement('div');
                    item.classList.add('notification-item');

                    const linkHref = notif.enlace || '#';

                    item.innerHTML = `
                        <div class="notification-title">${notif.titulo}</div>
                        <div class="notification-meta">${formatDate(notif.fecha)}</div>
                        <a href="${linkHref}" class="notification-link">Haz clic para más detalles</a>
                    `;

                    notificationDropdown.appendChild(item);
                });

                const verMas = document.createElement('div');
                verMas.classList.add('notification-item', 'text-center');
                verMas.innerHTML = `<a href="index.php?action=notificaciones" class="notification-link">Ver más notificaciones</a>`;
                notificationDropdown.appendChild(verMas);
            })
            .catch(error => {
                console.error('Error al cargar notificaciones:', error);
                notificationDropdown.innerHTML = '<div class="notification-item text-center text-danger">Error al cargar notificaciones.</div>';
                notificationCount.style.display = 'none';
            });
    }

    bellIcon.addEventListener('click', function(e) {
        e.stopPropagation();
        notificationDropdown.classList.toggle('show');
        if (notificationDropdown.classList.contains('show')) {
            loadNotifications();
        }
    });

    document.addEventListener('click', function(event) {
        if (!bellIcon.contains(event.target) && !notificationDropdown.contains(event.target)) {
            notificationDropdown.classList.remove('show');
        }
    });

    notificationDropdown.addEventListener('click', function(e) {
        e.stopPropagation();
    });

    // Carga inicial para actualizar contador
    loadNotifications();
});

</script>

<!-- FontAwesome para el ícono de la campana -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
