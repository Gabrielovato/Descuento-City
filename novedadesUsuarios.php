<?php

include("conexionBD.php");
//variable para rutas de navegacion (breadcrumb)
$breadcrumb_titulo_activo = 'Novedades';

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

$dia_semana = $dias_en_español[$dia_semana_server];

//traer novedades vigentes
$sql_novedades = "
SELECT *
FROM novedades
WHERE '$hoy' BETWEEN fechaDesdeNovedad AND fechaHastaNovedad
ORDER BY fechaDesdeNovedad DESC
";

$resultado_novedades = mysqli_query($conexion, $sql_novedades);

// Verificar si hay error en la consulta
if (!$resultado_novedades) {
    die("Error en la consulta: " . mysqli_error($conexion));
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novedades</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="icon" type="image/png" href="assets/img/logo-ventana/logo-fondo-b-circular.png"/>

</head>
<body>
    <?php include("includes/header.php"); ?>

    <!--Hago q las rutas (breadcrumb) queden sobre la imagen. No encontré otra manera -->
    <div class="portada-novedades position-relative"> 

    <img src="/Descuento-City/assets/img/novedades-portada.png" class="img-fluid" alt="">

    <div class="breadcrumb-overlay position-absolute top-0 start-0 w-100 text-white p-3">
        
        <div class="container small">
            <?php include 'includes/breadcrumb.php'; ?> 
        </div>
        
    </div>
    
</div>


<div class="container my-4">

    <!-- Filtros ??? -->
    

    <div class="row">
        <?php
        if($resultado_novedades && mysqli_num_rows($resultado_novedades) > 0){
            while($novedad = mysqli_fetch_assoc($resultado_novedades)){
                ?>
                <div class="col-md-4 mb-3">
                    <div class="card" style="width: 18rem;">
                        <?php if(!empty($novedad["rutaArchivo"])):?>
                        <img src="<?= htmlspecialchars($novedad["rutaArchivo"]) ?>" class="card-img-top" alt="portada novedad" style="height: 200px; object-fit: cover;"> 
                        <?php else: ?>
                            <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                <span class="text-muted"><i class="bi bi-image"></i> Sin portada</span>
                            </div>
                        <?php endif; ?>
                        <div class="card-body card-color">
                           
                            <p class="card-text"><?= htmlspecialchars($novedad['textoNovedad']) ?></p>
                            <p class="card-text">
                                <small class="text-muted">
                                    <i class="bi bi-calendar3"></i> Hasta :<?=$novedad['fechaHastaNovedad'] ?> 
                                </small>
                            </p>
                            <form action=""> <!--agregar ruta -->
                                <input type="sumbit"  class="btn btn-outline-success" name="usar" value="">       
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
                    <i class="bi bi-info-circle-fill"></i> 
                    <strong>No hay novedadees disponibles</strong><br>
                    <small>Vuelve pronto para ver las últimas novedades</small>
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