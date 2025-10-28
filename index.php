<?php

//HOME DECUENTO CITY

include("conexionBD.php");

$sql_locales = "SELECT * FROM locales WHERE estadoLocal = 'activo' LIMIT 6"; 
$resultado_locales = mysqli_query($conexion, $sql_locales);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Descuento City</title>
</head>
<body>
    <?php include("includes/header.php");?>

    <!-- CARRUSEL -->

    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/Descuento-City/assets/img/carrusel/40578.png" class="d-block w-100" alt="Promociones Descuento City" style="height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
                <img src="/Descuento-City/assets/img/carrusel/40578.png" class="d-block w-100" alt="Locales participantes" style="height: 400px; object-fit: cover;">
            </div>
            <div class="carousel-item">
                <img src="/Descuento-City/assets/img/carrusel/40578.png" class="d-block w-100" alt="Promociones vigentes" style="height: 400px; object-fit: cover;">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
            </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    <!-- LOCALES -->

    <section class="locales" id="locales">
        
        <h2>Locales</h2>

        <?php
        if ($resultado_locales && mysqli_num_rows($resultado_locales) > 0) {
            while ($local = mysqli_fetch_assoc($resultado_locales)) {
                echo '<div class="card local-card">';
                echo '<h3>' . htmlspecialchars($local['nombreLocal']) . '</h3>';
                echo '<p>' . htmlspecialchars($local['ubicacionLocal']) . '</p>';
                echo '</div>';

            }
            
        } else { 
            echo "<p>No hay locales disponibles en este momento.</p>";
        }
        ?>
    </section>


    <!-- PROMOCIONES -->

    </section>
    <section class="promociones" id="promociones" id="novedades">
        <h2>Promociones Y novedades</h2>
        <div class="card promo-card">Promociones</div>
        <div class="card promo-card">Novedades</div>

        <?php
        if ($resultado_novedades && mysqli_num_rows($resultado_novedades) > 0) {
            while ($novedad = mysqli_fetch_assoc($resultado_novedades)) {
                echo '<div class="card local">'; 
                echo '<h3> Novedad </h3>';
                echo '<p>' . htmlspecialchars($novedad['textoNovedad']) . '</p>';
                echo '<small> Válido hasta: '. htmlspecialchars($novedad['fechaHastaNovedad']) .'</small>';
                echo '</div>';
            }
        
        } else {
            echo '<div class="card promo-card">';
            echo '<h3> Novedades </h3>';
            echo '<p>No hay novedades disponibles en este momento.</p>';
            echo '</div>';
        }
        ?>
    </section>


    <!-- FOOTER -->

    <?php
    include("includes/footer.php");
    ?>  
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>