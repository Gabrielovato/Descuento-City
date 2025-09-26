

<?php

session_start();
include("../../conexionBD.php")

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php include("../../includes/dueño/dueñoHeader.php") ?>
    <h2>DASHBOARD DUEÑO</h2>

    <?php 
    
    //Es una prueba para ver si funciona $_SESSION (no queda)
    echo "Codigo :" . $_SESSION['codUsuario'] . "<br>";
    echo "Nombre : " . $_SESSION['nombreUsuario'] . "<br>";
    echo "Tipo : " . $_SESSION['tipoUsuario']. "<br>";    
    echo "categoria : " . $_SESSION['categoriaCliente']. "<br>";
    echo "Estado : " . $_SESSION['estadoUsuario']. "<br>";
    echo "Fecha Registro : " . $_SESSION['fechaRegistro']. "<br>";


    ?>
</body>
</html>