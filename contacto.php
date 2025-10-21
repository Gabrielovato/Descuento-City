<?php
session_start();

include ("conexionBD.php");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <title>Contacto</title>
</head>
<body>
    
    <?php include("includes/header.php"); ?>

    <div class="main">
        <div class="formulario-container" style="height: auto; padding: 20px; ">

            <h1>Contacto</h1>

            <form action="controllers/contactoController.php" method="post">
                <div class="datos-conteiner">
                    <label for="nombre">Nombre:</label>
                    <input type="text" id="nombre" name="nombre" required>

                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="asunto">Asunto:</label>
                    <input type="text" id="asunto" name="asunto" required>

                    <label for="mensaje">Mensaje:</label>
                    <textarea id="mensaje" name="mensaje" required></textarea>
                </div>
                <input type="submit" name="enviar" value="Enviar" class="button-form">
                <?php

                // Para mostrar mensajes de éxito o error que vengan del controlador , está bien???
                if(isset($_SESSION["mensaje_contacto"])){
                    echo "<p style='color:green; font-weight:bold;'>" . $_SESSION['mensaje_contacto']. "</p>";
                    unset($_SESSION['mensaje_contacto']);
                }
                ?>
            </form>
        </div>
    </div>
    <?php include("includes/footer.php"); ?>

</body>
</html>