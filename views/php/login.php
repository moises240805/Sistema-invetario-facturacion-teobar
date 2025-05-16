<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="views/img/logo.jpeg">
    <?php 
    require_once "views/php/link.php";
    require_once "views/php/alert.php"; 
    ?>
    <title>Teobar login</title>
</head>
<body class="bg-gradient-primary">
    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center">
        <div class="col-xl-8 col-lg-10 col-md-12 mx-auto">
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-flex align-items-center justify-content-center">
                                <div class="text-center">
                                    <h1 class="h2 text-gray-900 mb-4 mt-4">Bienvenido</h1>
                                <img class="logo" src="views/img/logo.jpeg" alt="logo">
                                </div>
                            </div>
                            <div class="col-lg-6">
                            <div class="divider-vertical"></div>
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Iniciar Sesión</h1>
                                    </div>
                                    <form class="formulario user" action="index.php?action=usuario&a=ingresar" method="post">
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <img class="icon" src="views/img/user.png" width="25px" height="20px" alt="img_user">
                                                </span>
                                                <input class="form-control form-control-user input_usuario" type="text" name="usuario" placeholder="@usuario" required>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-text">
                                                    <img class="icon" src="views/img/lock.png" width="25px" height="20px" alt="img_pass">
                                                </span>
                                                <input class="form-control form-control-user input_pw" type="password" name="pw" id="pw" placeholder="password" required oninput="Password()">
                                                <span id="Error" class="error-message"></span>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block iniciar_seccion" onclick="return Password()" type="submit">INGRESAR</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>








<style>
.error-message {
    color: red;
    font-size: 1rem;
}

.formulario {
    margin-top: 20px;
}

.input_usuario, .input_pw {
    padding-left: 45px; /* Ajusta el padding para que los iconos no se superpongan */
}

label[for="usuario"], label[for="pw"] {
    position: absolute;
    margin-left: 15px;
    margin-top: 10px;
}

.bg-login-image {
    background-image: url('views/img/fondo-login.jpg'); /* Ajusta la imagen de fondo */
    background-size: cover;
    background-position: center;
}

.logo {
    width: 250px; /* Ajusta el ancho */
    height: 250px; /* Ajusta la altura */
    object-fit: cover; /* Asegura que la imagen se adapte sin deformarse */
    margin: 0 0 2rem 0;
}

.divider-vertical {
    position: absolute;
    top: 0;
    left: 0;
    width: 3px; /* Ajusta el grosor de la línea */
    height: 100%;
    background-color: #ccc; /* Color de la línea */
    background: linear-gradient(to top, #ccc, rgba(204, 204, 204, 0));
    background: linear-gradient(to bottom, #ccc rgba(204, 204, 204, 0));
    background-size: 100% 100%;
    border-radius: 2px; /* Suaviza los bordes */
    box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Agrega un efecto de sombra para dar profundidad */
}



</style>
</body>
</html>