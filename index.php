<?php

//HOME DECUENTO CITY

include("conexionBD.php");


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
    <section class="carrusel">
        <div class="carrusel">
            Carrusel
        </div>
    </section>
    <section class="locales" id="locales">
        <h2>Locales</h2>
        <div class="card local-card">local</div>
        <div class="card local-card">local</div>
        <div class="card local-card">local</div>
        <div class="card local-card">local</div>
        <div class="card local-card">local</div>
        <div class="card local-card">local</div>
        <div class="card local-card">local</div>
        <div class="card local-card">local</div>
    </section>
    <section class="promociones" id="promociones" id="novedades">
        <h2>Promociones Y novedades</h2>
        <div class="card promo-card">Promociones</div>
        <div class="card promo-card">Novedades</div>
    </section>
    <section class="servicios">
        <h2>Servicios</h2>
        <div class="card-servicios">1</div>
        <div class="card-servicios">2</div>
        <div class="card-servicios">3</div>
        <div class="card-servicios">4</div>
        <div class="card-servicios">5</div>
        <div class="card-servicios">6</div>
        <div class="card-servicios">7</div>
        <div class="card-servicios">8</div>
    </section>
    
    <?php include("includes/footer.php"); ?>  
</body>
</html>