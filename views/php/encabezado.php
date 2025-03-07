<header class="hero py-3">
    <div class="container-fluid d-flex align-items-center justify-content-between">
        <b><div style="color: black; font-size:1.3rem;" id="precioDolar">Cargando...</div></b>
        <div class="user d-flex align-items-center">
            <img class="logo_user rounded-circle mr-2" src="views/img/avatar-male.png" alt="user">
            <span name="user" style="color: black;"><?php echo $_SESSION['s_usuario']['usuario'];?></span>
        </div>
        <a href="views/php/logout.php" class="hero__logger btn btn-primary btn-sm shadow-sm">
            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
            Log Out
        </a>
    </div>
</header>
