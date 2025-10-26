<?php
include("conexionBD.php");

$dia_semana = date('l'); // Lunes, Martes...
$hoy = date('Y-m-d');



$sql_promos = "SELECT p.*, l.nombreLocal
            FROM promociones p
            JOIN locales l ON p.codLocal = l.codLocal
            WHERE p.estadoPromo = 'aprobada'
            AND '$hoy' BETWEEN p.fechaDesde AND p.fechaHasta
            AND FIND_IN_SET('$dia_semana', p.diasSemana)
            ORDER BY p.fechaDesde DESC";

$resultado_promos = mysqli_query($conexion, $sql_promos);

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promociones - Invitado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<div class="container my-4">
    <h2>Promociones Vigentes</h2>

    <!-- Filtros -->
    <form class="row mb-3" method="GET">
        <div class="col-md-6">
            <select name="local" class="form-select">
                <option value="">Todos los locales</option>
                
            </select>
        </div>
        <div class="col-md-6">
            <select name="categoria" class="form-select">
                <option>Todas las categorias</option>
               
            </select>
        </div>
    </form>

    <div class="row">
        <?php
        if($resultado_promos && mysqli_num_rows($resultado_promos) > 0){
            while($promo = mysqli_fetch_assoc($resultado_promos)){
                echo '<div class="col-md-4 mb-3">';
                echo '<div class="card">';
                echo '<div class="card-body">';
                echo '<h5 class="card-title">'.htmlspecialchars($promo['nombreLocal']).'</h5>';
                echo '<p class="card-text">'.htmlspecialchars($promo['textoPromo']).'</p>';
                echo '<p class="card-text">Válido: '.$promo['fechaDesde'].' a '.$promo['fechaHastas'].'</p>';
                echo '<p class="card-text">Días: '.$promo['diasSemana'].'</p>';
                echo '</div></div></div>';
            }
        } else {
            echo '<p>No hay promociones disponibles en este momento.</p>';
        }
        ?>
    </div>
</div>

<?php include("includes/footer.php"); ?>
</body>
</html>
