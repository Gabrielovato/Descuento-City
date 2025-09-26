<?php

// base de datos
include("../../conexionBD.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <title>Descuento City</title>
</head>
<body>
    <?php include("../../includes/header.php");?>
    <div class="main-center">
        <div class="form__container">
            <h3>Registrarse</h3>
            <form action="../../controllers/registroController.php" method="POST">
                <!-- Email -->
                <div class="datos-container"> 
                    <label>Email</label><br>
                    <input type="email" name="email" placeholder="Email" class="input-form" required ><br> 
                <!-- Contraseña Usuario -->
                    <label>Contraseña</label><br>
                    <input type="password" name="clave" placeholder="Contraseña" class="input-form" required ><br> 
                </div>
                <!-- Rol de usuario -->
                <div class ="rol-container">
                    <label>Rol</label><br>
                    <input type="radio" name="rol" value="cliente" >Cliente<br>
                    <input type="radio" name="rol" value="dueño">Dueño de local<br>
                </div>

                <input type="submit" name="confirm" value="Registrarse" class="button-form">
            </form>
        </div>
    </div>
</body>
</html>

<!-- Mensajes Registro. -->
<?php

session_start();

if (isset($_SESSION['mensaje'])) {
    echo "<p style='color:red'>" . $_SESSION['mensaje'] . "</p>";
    unset($_SESSION['mensaje']);
}
?>


