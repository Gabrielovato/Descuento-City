<?php
session_start();
include("../../conexionBD.php");
include("../../includes/dueño/dueñoHeader.php");

if (!isset($_SESSION['tipoUsuario']) || $_SESSION['tipoUsuario'] != 'dueño') {
    header("Location: ../../views/auth/login.php");
    exit();
}

$codDueño = $_SESSION['codUsuario'];
$sql_local = "SELECT codLocal FROM locales WHERE codUsuario = '$codDueño' LIMIT 1";
$resultado_local = mysqli_query($conexion, $sql_local);
$codLocal = 0;

if ($resultado_local && mysqli_num_rows($resultado_local) == 1) {
    $local = mysqli_fetch_assoc($resultado_local);
    $codLocal = $local['local'];
}

// traer las solicitudes pendientes del local

$sql_solicitudes = "SELECT up.codCliente, up.codPromo, u.nombreUsuario AS emailCliente, p.textoPromo, up.fechaUsoPromo
                    FROM uso_promociones up
                    JOIN promociones p ON up.codPromo = p.codPromo
                    JOIN usuarios u ON up.codCliente = u.codUsuario
                    WHERE p.codLocal = '$codLocal' AND up.estado = 'enviada'
                    ORDER BY up.fechaUsoPromo ASC;
";

$resultado_solicitudes = mysqli_query($conexion, $sql_solicitudes);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel= "stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <title>Gestionar solicitudes </title>
</head>
<body>
    <div class="tabla__dueños" style="margin: 20px auto; max-width: 900px; ">
        <h1 style="text-align: center;">Solicitudes de clientes</h1>
    
        <?php
        if (isset($_SESSION["mensaje"])){
            echo "<p style='color: green; font-weight: bold; text-align: center;'>" . $_SESSION["mensaje"] . "</p>";
            unset($_SESSION["mensaje"]);
        }
        ?>
    
        <table>
            <caption>Solicitudes pendientes de aprobación</caption>
            <thead>
                <tr>
                    <th>Email del cliente</th>
                    <th>Promoción solicitada</th>
                    <th>Fecha de solicitud</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado_solicitudes && mysqli_num_rows($resultado_solicitudes) > 0){
                    while ($solicitud = mysqli_fetch_assoc($resultado_solicitudes)) {
                ?>
                    <tr>
                        <td><?=htmlspecialchars($solicitud['emailCliente'])?></td>
                        <td><?=htmlspecialchars($solicitud['textoPromo'])?></td>
                        <td><?=htmlspecialchars($solicitud['fechaUsoPromo'])?></td>
                        <td>
                            <form action="../../controllers/dueño/gestionarSolicitudController.php" method="POST" style="display: inline;">
                                <input type="hidden" name="codCliente" value="<?= $solicitud['codCliente'] ?>">
                                <input type="hidden" name="codPromo" value="<?= $solicitud['codPromo'] ?>">
           
                                <button type="submit" name="accion" value="aceptada" class="button-activar"> Aceptar </button> 
                                <button type="submit" name="accion" value="rechazada" class="button-eliminar"> Rechazar </button>                    
                    
                            </form>
                        </td>
                    </tr>
                <?php
                    }
                } else {
                    echo '<tr><td colspan= "4"> No hay solicitudes pendientes. </td></tr>';
                }
                mysqli_close($conexion);
                ?>
            </tbody>
        </table>
    </div>
</body>
</html>