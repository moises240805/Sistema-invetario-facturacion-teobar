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
                <i class="fas fa-bell fa-lg text-dark" id="bell-icon" style="cursor: pointer;"></i>
                <!-- Contenedor de notificaciones -->
                <!-- Contenedor de notificaciones -->
                <div class="notification-dropdown">
                    <!-- Notificación 1 -->
                    <div class="notification-item">
                        <div class="notification-title">El arroz Mary está por agotarse</div>
                        <div class="notification-meta">03/04/2025 12:30:00</div>
                        <div class="notification-desc">Responsable: Juan Pérez</div>
                        <a href="#" class="notification-link">Haz clic para más detalles</a>
                    </div>
                    <!-- Notificación 2 -->
                    <div class="notification-item">
                        <div class="notification-title">El azúcar Montalbán está por vencer</div>
                        <div class="notification-meta">03/04/2025 11:00:00</div>
                        <div class="notification-desc">Responsable: Laura Gómez</div>
                        <a href="#" class="notification-link">Haz clic para más detalles</a>
                    </div>
                    <!-- Notificación 3 -->
                    <div class="notification-item">
                        <div class="notification-title">La harina de trigo está por agotarse</div>
                        <div class="notification-meta">03/04/2025 09:15:00</div>
                        <div class="notification-desc">Responsable: Dpto de Inventario</div>
                        <a href="#" class="notification-link">Haz clic para más detalles</a>
                    </div>
                    <!-- Notificación 3 -->
                    <div class="notification-item text-center">
                        <a href="#" class="notification-link">Ver más notificaciones</a>
                    </div>
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
    document.addEventListener("DOMContentLoaded", function() {
        const bellIcon = document.getElementById("bell-icon");
        const dropdown = document.querySelector(".notification-dropdown");

        // Alternar visibilidad al hacer clic en la campana
        bellIcon.addEventListener("click", function(e) {
            e.stopPropagation(); // Evita cerrar inmediatamente por el click global
            dropdown.classList.toggle("show");
        });

        // Cerrar dropdown si se hace clic fuera
        document.addEventListener("click", function() {
            dropdown.classList.remove("show");
        });

        // Evita que se cierre si haces clic dentro del dropdown
        dropdown.addEventListener("click", function(e) {
            e.stopPropagation();
        });
    });
</script>

<!-- FontAwesome para el ícono de la campana -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
