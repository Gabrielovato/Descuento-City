

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
    <link rel="icon" type="image/png" href="assets/img/logo-ventana/logo-fondo-b-circular.png"/>
</head>
<body>
    <?php include("../../includes/cliente/clienteHeader.php")  ?>
    <h2>DASHBOARD CLIENTE</h2>
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