<?php
session_start();
include("../../../conexionBD.php");
include("../../../includes/admin/adminHeader.php");

$sql_reporte = "SELECT l.nombreLocal, p.textoPromo, COUNT(up.codPromo) AS totalUsos
                FROM uso_promociones up
                JOIN promociones p ON up.codPromo = p.codPromo
                JOIN locales l ON p.codLocal = l.codLocal
                WHERE up.estado = 'aceptada'
                GROUP BY l.codLocal, p.codPromo
                ORDER BY l.nombreLocal, totalUsos DESC;
";  //unimos las 3 tablas para sacar los datos

$resultado_reporte = mysqli_query($conexion, $sql_reporte);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <title>Reportes Gerenciales</title>
    <link rel="icon" type="image/png" href="assets/img/logo-ventana/logo-fondo-b-circular.png"/>
</head>
<body>
    <div class="tabla__dueños" style="margin: 20px auto; max-width: 900px;">
        <h1 style="text-align: center;">Reporte de Uso de Descuentos </h1>
        <table>
            <caption>Uso de promociones por local</caption>
            <thead>
                <tr>
                    <th>Nombre del local</th>
                    <th>Texto de la promoción</th>
                    <th>Total de usos</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($resultado_reporte && mysqli_num_rows($resultado_reporte) > 0){
                    while ($reporte = mysqli_fetch_assoc($resultado_reporte)) {
                ?>
                        <tr>
                            <td><?= htmlspecialchars($reporte['nombreLocal'])?></td>
                            <td><?= htmlspecialchars($reporte['textoPromo'])?></td>
                            <td><strong><?= htmlspecialchars($reporte['totalUsos'])?></strong></td>
                        </tr>
                <?php
                    }

                } else {
                    echo '<tr><td colspan= "3"> No hay datos de promociones aceptadas para mostrar. </td></tr>';
                }
                ?>

            </tbody>
        </table>
    </div>
</body>
</html>

