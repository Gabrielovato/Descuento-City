<?php


session_start();
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
            <h3>Inicio Sesion</h3>
            <form action="../../controllers/loginController.php" method="POST">
                <div  class="datos-container">
                    <label>Email</label><br>
                    <input type="email" name="email" class="input-form" placeholder="Email" required ><br> 
                    <label>Contraseña</label><br>
                    <input type="password" name="clave" class="input-form" placeholder="Contraseña" required ><br> 
                </div>
                <input type="submit" name="confirm" value="Iniciar Sesion" class="button-form">
                <p>¿No tiene cuenta? <a href="/Descuento-City/views/auth/registro.php">Crear una.</a></p>
            </form>

            <?php
            if(isset($_SESSION["mensaje"])){
                echo "<p style='color:red'>" . $_SESSION['mensaje']. "</p>";
                unset($_SESSION['mensaje']);
            }
            ?>
        </div>
    </div>
</body>
</html>


