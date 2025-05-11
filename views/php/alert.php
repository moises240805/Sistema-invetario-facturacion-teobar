 <?php

if (isset($_SESSION['message']) && isset($_SESSION['message_type'])) {
    $message = $_SESSION['message'];
    $message_type = $_SESSION['message_type'];

    // Limpia los datos para JS
    $js_message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');
    $js_message_type = htmlspecialchars($message_type, ENT_QUOTES, 'UTF-8');

    echo "<script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: '" . ($js_message_type === 'success' ? 'success' : 'error') . "',
                title: '" . ($js_message_type === 'success' ? '¡Exitoso!' : '¡Error!') . "',
                text: '{$js_message}',
                confirmButtonText: 'Cerrar'
            });
        });
    </script>";

    unset($_SESSION['message']);
    unset($_SESSION['message_type']);
}
?>