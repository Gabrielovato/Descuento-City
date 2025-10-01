<?php

session_start();

include("../conexionBD.php");

//Recibo datos email y token
$codUsuario = $_POST["codUsuario"] ?? '';
$nombreUsuario =  $_POST["nombreUsuario"] ?? '';

if(isset($_POST["activar"])){
    $consultaUpdate = "UPDATE usuarios SET estadoUsuario='activo' WHERE codUsuario ='$codUsuario'";
    $resultado = mysqli_query($conexion,$consultaUpdate);
    if($resultado){
        $_SESSION["mensaje"] = " Cuenta de dueño activada .";
        require("../funciones/funcionesMail.php");
        enviar_mail($nombreUsuario,"dueño","activo",NULL);
        header("location:../views/admin/dueños.php");
        exit();
    }
    else{
        $_SESSION['mensaje'] = "Error en actualizar cuenta .";
    }
    
}
elseif(isset($_POST["bloquear"])){
    $consultaUpdate = "UPDATE usuarios SET estadoUsuario='bloqueado' WHERE codUsuario ='$codUsuario'";
    $resultado = mysqli_query($conexion,$consultaUpdate);
    if($resultado){
        $_SESSION["mensaje"] = " Cuenta de dueño bloqueada .";
        require("../funciones/funcionesMail.php");
        enviar_mail($nombreUsuario,"dueño","bloqueado",NULL);        
        header("location:../views/admin/dueños.php");
        exit();
    }
    else{
        $_SESSION['mensaje'] = " Error en actualizar cuenta .";
    }
}



mysqli_close($conexion);

?>