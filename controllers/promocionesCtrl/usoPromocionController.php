<?php

session_start();

include("../../conexionBD.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usar"])){

    //Datos promocion.
    $codPromo = $_POST["codPromo"] ?? '';
    $catPromo = $_POST["cateogoriaPromo"];



    //Si usuario no inicio sesion.
    if(!isset($_SESSION["codUsuario"])){
        $_SESSION["mensaje_warning"] = "Debes iniciar sesión para utilizar una promoción";
        header("location:../../views/auth/login.php");
        exit();
    }
    
    $codCliente = $_SESSION["codUsuario"];


    //Realizo consulta de solicitud de descuento.

    $consultaSolicitud = "INSERT INTO solicitudes_descuentos (codCliente,codPromo,fecha_solicitud) VALUES ('$codCliente','$codPromo')";
    $resultadoSolicitud = mysqli_query($conexion,$consultaSolicitud);

    if($resultadoSolicitud){

        $_SESSION["mensaje_exito"] = "Solicitud de uso de descuento enviada con exito.";

    }else{
        $_SESSION["mensaje_error"] = "Error al enviar solicitud de descuento" . mysqli_error($conexion);
    }

    //Comparo con atributos de la promocion.

}
else {
    $_SESSION["mensaje_error"] = "Acceso no válido";
    header("location:../../views/cliente/promocionesCliente.php");
    exit();
}

?>