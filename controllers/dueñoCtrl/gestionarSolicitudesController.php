<?php

session_start();

include("../../conexionBD.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Verificar que el usuario esté logueado y sea dueño
    if (!isset($_SESSION["codUsuario"]) || $_SESSION["tipoUsuario"] !== 'dueño') {
        $_SESSION["mensaje_error"] = "Acceso no autorizado";
        header("location:../../views/auth/login.php");
        exit();
    }
    
    $codDueño = $_SESSION["codUsuario"];
    $id_solicitud = $_POST["id_solicitud"] ?? '';
    $accion = $_POST["accion"] ?? '';
    
    // Validar datos
    if (empty($id_solicitud) || empty($accion)) {
        $_SESSION["mensaje_error"] = "Datos incompletos";
        header("location:../../views/dueño/solicitudes.php");
        exit();
    }
    
    // Verificar que la solicitud pertenezca a una promoción del local del dueño
    $sql_verificar = "SELECT sd.id_solicitud, sd.estado, p.codLocal, l.codUsuario, u.nombreUsuario as cliente
                      FROM solicitudes_descuentos sd
                      JOIN promociones p ON sd.codPromo = p.codPromo
                      JOIN locales l ON p.codLocal = l.codLocal
                      JOIN usuarios u ON sd.codCliente = u.codUsuario
                      WHERE sd.id_solicitud = '$id_solicitud' AND l.codUsuario = '$codDueño'";
    
    $resultado_verificar = mysqli_query($conexion, $sql_verificar);
    
    if (!$resultado_verificar || mysqli_num_rows($resultado_verificar) == 0) {
        $_SESSION["mensaje_error"] = "Solicitud no encontrada o no autorizada";
        header("location:../../views/dueño/solicitudes.php");
        exit();
    }
    
    $solicitud = mysqli_fetch_assoc($resultado_verificar);
    
    // Verificar que la solicitud esté pendiente
    if ($solicitud['estado'] !== 'pendiente') {
        $_SESSION["mensaje_warning"] = "Esta solicitud ya fue procesada anteriormente";
        header("location:../../views/dueño/solicitudes.php");
        exit();
    }
    
    // Actualizar el estado según la acción
    $nuevo_estado = '';
    $mensaje_accion = '';
    
    switch ($accion) {
        case 'aceptar':
            $nuevo_estado = 'aceptada';
            $mensaje_accion = 'aceptada';
            break;
        case 'rechazar':
            $nuevo_estado = 'rechazada';
            $mensaje_accion = 'rechazada';
            break;
        default:
            $_SESSION["mensaje_error"] = "Acción no válida";
            header("location:../../views/dueño/solicitudes.php");
            exit();
    }
    
    // Ejecutar la actualización
    $sql_actualizar = "UPDATE solicitudes_descuentos 
                       SET estado = '$nuevo_estado' 
                       WHERE id_solicitud = '$id_solicitud'";
    
    $resultado_actualizar = mysqli_query($conexion, $sql_actualizar);
    
    if ($resultado_actualizar) {
        $_SESSION["mensaje_exito"] = "Solicitud de '{$solicitud['cliente']}' ha sido $mensaje_accion exitosamente";
    } else {
        $_SESSION["mensaje_error"] = "Error al procesar la solicitud: " . mysqli_error($conexion);
    }
    
} else {
    $_SESSION["mensaje_error"] = "Método no permitido";
}

// Redireccionar de vuelta a solicitudes
header("location:../../views/dueño/solicitudes.php");
exit();

?>