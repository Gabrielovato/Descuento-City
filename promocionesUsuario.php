<?php

session_start();

include("conexionBD.php");

date_default_timezone_set('America/Argentina/Buenos_Aires');

$hoy = date('Y-m-d');

$dias_en_español = [
    'Monday' => 'lunes',
    'Tuesday' => 'martes',
    'Wednesday' => 'miércoles',
    'Thursday' => 'jueves',
    'Friday' => 'viernes',
    'Saturday' => 'sábado',
    'Sunday' => 'domingo',
];

$dia_semana_server = date('l'); // Servidor devuelve dias en ingles.

$dia_semana = $dias_en_español[$dia_semana_server]; //Realizo conversion. Para comparar con los datos de la BD.


// Consulta optimizada para promociones vigentes
$sql_promos = "SELECT p.*, l.nombreLocal, l.rubroLocal, i.rutaArchivo 
            FROM promociones p
            JOIN locales l ON p.codLocal = l.codLocal
            LEFT JOIN imagenes i ON i.idIdentidad = p.codPromo AND i.tipoImg = 'portada'
            WHERE p.estadoPromo = 'aprobada'
            AND l.estadoLocal = 'activo'
            AND '$hoy' BETWEEN p.fechaDesdePromo AND p.fechaHastaPromo
            AND (p.diasSemana LIKE '%$dia_semana%' OR p.diasSemana = '' OR p.diasSemana IS NULL)
            ORDER BY p.fechaDesdePromo DESC";

$resultado_promos = mysqli_query($conexion, $sql_promos);

// Verificar si hay error en la consulta
if (!$resultado_promos) {
    die("Error en la consulta: " . mysqli_error($conexion));
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promociones - Invitado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
</head>
<body>
<?php include("includes/header.php"); ?>

<img src="/Descuento-City/assets/img/promociones-portada.png" class="img-fluid" alt="...">

<div class="container my-4">

    <?php
    // Sistema de alertas categorizado
    if(isset($_SESSION['mensaje_exito'])){
        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
        echo "<i class='fas fa-check-circle'></i> ".$_SESSION['mensaje_exito'];
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
        echo "</div>";
        unset($_SESSION['mensaje_exito']);
    }
    if(isset($_SESSION['mensaje_error'])){
        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
        echo "<i class='fas fa-exclamation-circle'></i> ".$_SESSION['mensaje_error'];
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
        echo "</div>";
        unset($_SESSION['mensaje_error']);
    }
    if(isset($_SESSION['mensaje_warning'])){
        echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
        echo "<i class='fas fa-exclamation-triangle'></i> ".$_SESSION['mensaje_warning'];
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
        echo "</div>";
        unset($_SESSION['mensaje_warning']);
    }
    if(isset($_SESSION['mensaje_info'])){
        echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>";
        echo "<i class='fas fa-info-circle'></i> ".$_SESSION['mensaje_info'];
        echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
        echo "</div>";
        unset($_SESSION['mensaje_info']);
    }
    ?>

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
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card" style="width: 18rem;">
                        <?php if(!empty($promo["rutaArchivo"])):?>
                        <img src="<?= htmlspecialchars($promo["rutaArchivo"]) ?>" class="card-img-top" alt="portada promocion" style="height: 200px; object-fit: cover;"> 
                        <?php else: ?>
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                <span class="text-muted"><i class="fas fa-image"></i> Sin portada</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body card-color">
                            <h5 class="card-title">
                                <i class="fas fa-store"></i> <?= htmlspecialchars($promo['nombreLocal']) ?>
                            </h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                <i class="fas fa-tag"></i> <?= htmlspecialchars($promo['rubroLocal']) ?>
                            </h6>
                            <p class="card-text"><?= htmlspecialchars($promo['textoPromo']) ?></p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="fas fa-calendar"></i> Hasta :<?=$promo['fechaHastaPromo'] ?> 
                                </small>
                            </p>
                            <form action="controllers/promocionesCtrl/usoPromocionController.php" method="POST">
                                <input type="hidden" name="codPromo" value="<?= $promo['codPromo']?>">
                                <input type="submit" class="btn btn-outline-success" name="usar" value="Usar promoción">       
                            </form>
                        </div>
                    </div>
                </div>
            <?php
            }
        } else {
            ?>
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    <i class="fas fa-info-circle"></i> 
                    <strong>No hay promociones disponibles en este momento.</strong><br>
                    <small>Vuelve pronto para ver las últimas ofertas y descuentos.</small>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<?php include("includes/footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
