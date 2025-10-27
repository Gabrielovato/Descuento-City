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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Contacto</title>
</head>
<body>
    
    <?php include("includes/header.php"); ?>

    <div class="main-center">
        <div class="formulario-container" style="height: auto; padding: 20px; ">

            <h1>Contacto</h1>

            <form action="controllers/contactoController.php" method="post">
                <div class="datos-conteiner">
                    <label for="nombre">Nombre:</label><br>
                    <input type="text" id="nombre" name="nombre" required><br>

                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required><br>

                    <label for="asunto">Asunto:</label><br>
                    <input type="text" id="asunto" name="asunto" required><br>

                    <label for="mensaje">Mensaje:</label><br>
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