<?php

session_start();

include("../../conexionBD.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["usar"])){

    //Datos promocion.
    $codPromo = $_POST["codPromo"] ?? '';



    //Si usuario no inicio sesion.
    if(!isset($_SESSION["codUsuario"])){
        $_SESSION["mensaje_warning"] = "Debes iniciar sesión para utilizar una promoción";
        header("location:../../views/auth/login.php");
        exit();
    }
    
    $codCliente = $_SESSION["codUsuario"];

    //Consulto solicitudes del cliente.
    $consultaUso = "SELECT * FROM solicitudes_descuentos WHERE codCliente='$codCliente' AND codPromo='$codPromo'";

    $resultadoUso = mysqli_query($conexion,$consultaUso);
    
    $uso = mysqli_fetch_assoc($resultadoUso);

    if(mysqli_num_rows($resultadoUso) == 0){

        //Realizo consulta de solicitud de descuento.
        $consultaSolicitud = "INSERT INTO solicitudes_descuentos (codCliente,codPromo) VALUES ('$codCliente','$codPromo')";

        $resultadoSolicitud = mysqli_query($conexion,$consultaSolicitud);

        if($resultadoSolicitud){

            $_SESSION["mensaje_exito"] = "Solicitud de uso de descuento enviada con exito.";

        }else{
            $_SESSION["mensaje_error"] = "Error al enviar solicitud de descuento" . mysqli_error($conexion);
        }
    }
    elseif($uso['estado'] === 'pendiente'){

        $_SESSION["mensaje_warning"] = "La solicitud ya fue enviada anteriormente.Espere que sea aceptada";

    }
    elseif($uso['estado'] === 'aceptada'){

        $_SESSION["mensaje_warning"] = "Promocion ya en uso";

    }

    // Redirigir de vuelta a la página de promociones
    header("location:../../views/cliente/promociones.php");
    exit();

}
else {
    $_SESSION["mensaje_error"] = "Acceso no válido";
    header("location:../../views/cliente/promociones.php");
    exit();
}

?>