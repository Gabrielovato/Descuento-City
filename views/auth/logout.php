<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="icon" type="image/png" href="assets/img/logo-ventana/logo-fondo-b-circular.png"/>
</head>
<body>
    <!-- tipoUsuario = cliente -->
    <?php 
    
    if($_SESSION["tipoUsuario"] == "cliente"):

    include("../../includes/cliente/clienteHeader.php");

    elseif($_SESSION["tipoUsuario"] == "dueño"): 

    include("../../includes/dueño/dueñoHeader.php");

    elseif($_SESSION["tipoUsuario"] == "admin"):

    include("../../includes/admin/adminHeader.php");

    endif; ?>




    <form action="../../controllers/logoutController.php" method="POST">
        <h2> ¿ Desea cerrar sesion ?</h2><br>
        <input type="submit" name="confirm" value="Si" class="button-form">
    </form>
</body>
</html>