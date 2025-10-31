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
    <link rel="icon" type="image/png" href="assets/img/logo-ventana/logo-fondo-b-circular.png"/>

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
        <div class="container">

            <!-- FALTARIA BUSCADOR. -->
            <h2 class="text-center mb-4">Locales Participantes</h2>

        <?php
            if ($resultado_locales && mysqli_num_rows($resultado_locales) > 0) {
                echo '<div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">';
                
                while ($local = mysqli_fetch_assoc($resultado_locales)) {
                    // Consulta para obtener la imagen del local
                    $codLocal = $local['codLocal'];
                    $sql_imagen = "SELECT rutaArchivo FROM imagenes WHERE idIdentidad = '$codLocal' AND tipoImg = 'logo' LIMIT 1";
                    $resultado_imagen = mysqli_query($conexion, $sql_imagen);
                    $imagen = mysqli_fetch_assoc($resultado_imagen);
                    $rutaImagen = $imagen ? $imagen['rutaArchivo'] : '/Descuento-City/assets/img/default-local.jpg';
                    
                    echo '<div class="col">';
                    echo '  <div class="card h-100 shadow-sm">';
                    echo '    <img src="' . htmlspecialchars($rutaImagen) . '" class="card-img-top" alt="Logo ' . htmlspecialchars($local['nombreLocal']) . '" style="height: 200px; object-fit: cover;">';
                    echo '    <div class="card-body d-flex flex-column">';
                    echo '      <h5 class="card-title">' . htmlspecialchars($local['nombreLocal']) . '</h5>';
                    echo '      <p class="card-text">';
                    echo '        <small class="text-muted"><i class="bi bi-geo-alt"></i> ' . htmlspecialchars($local['ubicacionLocal']) . '</small><br>';
                    echo '        <small class="text-muted"><i class="bi bi-tag"></i> ' . htmlspecialchars($local['rubroLocal']) . '</small><br>';
                    echo '        <small class="text-muted"><i class="bi bi-tag"></i> #' . htmlspecialchars($local['codLocal']) . '</small>';
                    echo '      </p>';
                    echo '      <div class="mt-auto">';
                    echo '        <a href="/Descuento-City/views/locales/localDetalle.php?id=' . $local['codLocal'] . '" class="btn btn-primary btn-sm">Ver promociones</a>';
                    echo '      </div>';
                    echo '    </div>';
                    echo '  </div>';
                    echo '</div>';
                }
                
                echo '</div>';
            } else { 
                echo '<div class="text-center">';
                echo '  <p class="text-muted">No hay locales disponibles en este momento.</p>';
                echo '</div>';
            }?>
        </div>
    </section>


    <!-- PROMOCIONES Y NOVEDADES. Solo son dos card con un boton que diga ver mas y lo mande a promociones o novedades.-->
    <!-- Faltaria agregarle una imagen de fondo -->

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card h-100 text-center">
                        <div class="card-body d-flex flex-column">
                            <i class="bi bi-percent display-1 text-primary mb-3"></i>
                            <h5 class="card-title">PROMOCIONES</h5>
                            <p class="card-text">Descubre todas las promociones disponibles en nuestros locales participantes.</p>
                            <div class="mt-auto">
                                <a href="/Descuento-City/promocionesUsuario.php" class="btn btn-primary">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card h-100 text-center">
                        <div class="card-body d-flex flex-column">
                            <i class="bi bi-newspaper display-1 text-success mb-3"></i>
                            <h5 class="card-title">NOVEDADES</h5>
                            <p class="card-text">Mantente al día con las últimas noticias y actualizaciones de Descuento City.</p>
                            <div class="mt-auto">
                                <a href="/Descuento-City/novedadesUsuarios.php" class="btn btn-primary">Ver más</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- FOOTER -->
    <?php
    include("includes/footer.php");
    ?>  
    

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>