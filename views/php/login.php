<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="views/css/login.css">
    <link rel="shortcut icon" href="views/img/logo.jpeg">
    <script src="views/js/validate_login.js"></script>
    <title>Teobar login</title>
</head>
<body  >
    <header>
        <form  class="formulario" action="index.php?action=ingresar" method="post">
            <img class="logo" src="views/img/logo.jpeg" width="100px" height="100px" alt="logo">
            <h1 class="titulo-form">Iniciar Sesion</h1>
            <div>
            <label for="usuario" ><img class="icon" src="views/img/user.png" width="35px" height="25px" alt="img_user"></label>
            <input class="input_usuario" type="text" name="usuario" placeholder="@usuario" required>
            </div>
            <div>
            <label for="pw"><img class="icon" src="views/img/lock.png" width="35px" height="25px" alt="img_pass"></label>
            <input class="input_pw" type="password" name="pw" id="pw" placeholder="password" required oninput="Password()"><br>
            <span id="Error" class="error-message"></span>
            </div>
            <br>
            <button class="iniciar_seccion" onclick="return Password()" type="submit">INGRESAR</button>
        </form>
    </header>
    <script>

</script>

<style>
.error-message {
    color: red;
    font-size: 1rem;
}
</style>
</body>
</html>