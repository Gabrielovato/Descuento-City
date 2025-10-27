<?php

session_start();

include("../../conexionBD.php");

//Recibo datos email y token
$codUsuario = $_POST["codUsuario"] ?? '';
$nombreUsuario =  $_POST["nombreUsuario"] ?? '';

if(isset($_POST["activar"])){

    $consultaUpdate = "UPDATE usuarios SET estadoUsuario='activo' WHERE codUsuario ='$codUsuario'";
    $resultado = mysqli_query($conexion,$consultaUpdate);
    if($resultado){

        //si activo dueño envio mensaje.
        $_SESSION["mensaje_exito"] = "Cuenta de dueño activada";
        //Envio mail de aviso a dueño

        require("../../funciones/funcionesMail.php");
        enviar_mail($nombreUsuario,"dueño","activo",NULL);
        header("location:../../views/admin/dueños/dueños.php");
        exit();
    }
    else{
        $_SESSION["mensaje_error"] = "Error en actualizar cuenta";
        header("location:../../views/admin/dueños/dueños.php");
        exit();
    }
    
}
elseif(isset($_POST["eliminar"])){
    $consultaUpdate = "UPDATE usuarios SET estadoUsuario='eliminado' WHERE codUsuario ='$codUsuario'";
    $resultado = mysqli_query($conexion,$consultaUpdate);
    if($resultado){

        $_SESSION["mensaje_warning"] = "Cuenta de dueño eliminada";

        require("../../funciones/funcionesMail.php");
        enviar_mail($nombreUsuario,"dueño","eliminado",NULL);        
        header("location:../../views/admin/dueños/dueños.php");
        exit();
    }
    else{

        $_SESSION["mensaje_error"] = "Error en actualizar cuenta";
        header("location:../../views/admin/dueños/dueños.php");
        exit();
    }
}



mysqli_close($conexion);

?>