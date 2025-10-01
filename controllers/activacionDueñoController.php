<?php

session_start();

include("../conexionBD.php");

//Recibo datos email y token
$nombreUsuario =  $_POST["emailDueño"] ?? '';
$codigoUsuario = $_POST["codigoDueño"] ?? '';


if(isset($_POST["activar"])){
    $consultaUpdate = "UPDATE usuarios SET estadoUsuario='activo' WHERE codUsuario ='$codigoUsuario'";
    $resultado = mysqli_query($conexion,$consultaUpdate);
    if($resultado){
        $_SESSION['mensaje'] = " Cuenta de dueños activada .";
        header("location:../views/admin/dueños.php");
        exit();
        require("../funciones/funcionesMail.php");
        enviar_mail($nombreUsuario,'dueño','activo',NULL);
    }
    else{
        $_SESSION['mensaje'] = " Error en actualizar cuenta .";
    }
    
}
elseif(isset($_POST["bloquear"])){
    $codUsuario = $_POST["codUsuario"];
    $consultaUpdate = "UPDATE usuarios SET estadoUsuario='bloqueado' WHERE codUsuario ='$codUsuario'";
    $resultado = mysqli_query($conexion,$consultaUpdate);
    if($resultado){
        $_SESSION['mensaje'] = " Cuenta de dueño bloqueada .";
        header("location:../views/admin/dueños.php");
        exit();
        require("../funciones/funcionesMail.php");
        enviar_mail($email,'dueño','bloqueado',NULL);
    }
    else{
        $_SESSION['mensaje'] = " Error en actualizar cuenta .";
    }
}

if(isset($_SESSION["mensaje"])){
    echo "<p style='color:green>" . $_SESSION['mensaje']. "</p>";
    unset($_SESSION['mensaje']);
}



mysqli_close($conexion);

?>