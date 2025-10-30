<?php

session_start();

include("../../conexionBD.php");

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"])){

    $idUso = $_POST["idUso"] ?? '';
    $codCliente = $_POST["codCliente"] ?? '';
    
    if($idUso != '' && $codCliente != '' ){

       $consultaUpdate = "UPDATE uso_promociones SET estado='eliminada' WHERE idUso='$idUso' AND codCliente ='$codCliente'";
       $resultadoUpdate = mysqli_query($conexion,$consultaUpdate);

       if(!$resultadoUpdate){

            $_SESSION["mensaje_error"] = "Error al eliminar uso de promocion" . mysqli_error($conexion);

       }
       else{
            $_SESSION["mensaje_exito"] = "Fila eliminada correctamente" ;
       }
    }

}


header("location:../../views/cliente/misUsoPromociones.php");
exit();
mysqli_close($conexion);


?>