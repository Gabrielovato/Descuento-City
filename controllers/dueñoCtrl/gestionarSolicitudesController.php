<?php

session_start ();
include ("../../conexionBD.php");

if (!isset ($_SESSION ['tipoUsuario']) || $_SESSION['tipoUsuario'] != 'dueño') {
    header("Location: ../../views/auth/login.php");
    exit();
}

if ($_REQUEST["REQUEST_METHOD"] == "POST") {
    $codCliente = $_POST['codCliente'];
    $codPromo = $_POST['codPromo'];
    $nuevaAccion = $_POST['accion'];

    if ($nuevaAccion == 'aceptada' || $nuevaAccion == 'rechazada') {
        $sql_update = 
                    "UPDATE uso_promociones
                    SET estado = '$nuevaAccion'
                    WHERE codCliente = '$codCliente' AND codPromo = '$codPromo' AND estado = 'enviada'";
        if (mysqli_query($conexion, $sql_update)) {
            $_SESSION['mensaje'] = "Solicitud " . $nuevaAccion . "con exito!";
        
        }else {
            $_SESSION['mensaje'] = "Error al gestionar solicitud: " . mysqli_error($conexion);
        }
    
} else {
    $_SESSION ['mensaje'] = "Error: acción no valida.";
}

header("Location: ../../index.php");
exit();
}
?>