
<?php

session_start();

include("../../../conexionBD.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Promociones</title>
</head>
<body>
    <?php include("../../../includes/admin/adminHeader.php");?>
    <?php

    //paginacion

    $cant_por_pag =4;
    $pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;

    if(!$pagina){
        $inicio = 0;
        $pagina=1;
    }
    else{
        $inicio = ($pagina - 1) * $cant_por_pag;
    }


    //Consulta Promociones
    $consulta = "SELECT p.* , i.rutaArchivo FROM promociones p 
                    LEFT JOIN imagenes i ON i.idIdentidad = p.codPromo AND i.tipoImg = 'portada'
                    INNER JOIN locales l ON p.codLocal = l.codLocal 
                    WHERE p.estadoPromo IN ('pendiente', 'aprobada','denegada')";
                    //p.* seleccona todos los campos de la tabla promociones , i.rutaArchivo => la ruta del archivo
                    // LEFT JOIN => Trae todas las promos , tenga imagen o no. i.IdIdentidad = p.promociones = relaciona img con promo.
                    // INNER JOIN => Trea promos que tenga un local asociado 


    $resultado = mysqli_query($conexion,$consulta);
    $total_registros = mysqli_num_rows($resultado);

    //consulta Páginada
    $consultaPromociones = "SELECT p.* , i.rutaArchivo FROM promociones p 
                           LEFT JOIN imagenes i ON i.idIdentidad = p.codPromo AND i.tipoImg = 'portada'
                           INNER JOIN locales l ON p.codLocal = l.codLocal 
                           WHERE p.estadoPromo IN ('pendiente', 'aprobada','denegada') 
                           ORDER BY FIELD(estadoPromo, 'pendiente','aprobada','denegada'), p.codPromo DESC 
                           LIMIT $inicio,$cant_por_pag";

    $listaPromociones = mysqli_query($conexion,$consultaPromociones);

    $total_paginas = ceil($total_registros / $cant_por_pag);


    //Lista promociones 
    echo "<table class='tabla table table-striped'>";
    echo "<caption>Solicitudes de promociones</caption>";
    echo "<tr>
            <th>Codigo Local</th>
            <th>Descripcion</th>
            <th>Portada</th>
            <th>Fechas</th>
            <th>Categoria Cliente</th>
            <th>Dias semana</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>";
    
    while($promo = mysqli_fetch_assoc($listaPromociones)){
        ?>
        <tr>
            <td> <?= $promo["codLocal"] ?></td>
            <td> <?= $promo["textoPromo"] ?></td>
            <td>
                <?php 
                    //consulto imagen de promocion.
                    $codLocal = $promo["codLocal"];
                    $consultoImg = "SELECT * FROM imagenes WHERE idIdentidad = $codLocal AND tipoImg='portada'";
                    $resultadoImg = mysqli_query($conexion,$consultoImg);
                    $img = mysqli_fetch_assoc($resultadoImg);
                    if(!empty($promo["rutaArchivo"]))
                :?>
                    <img src="../../../<?= $promo["rutaArchivo"] ?>" alt="Logo del local" width="70" height="50" style="object-fit:cover;border-radius:8px;">

                <?php else: ?>
                    <span style="color: gray;">Sin portada</p></p></span>

                <?php endif; ?>
            </td>
            <td>
                <div style="background-color: #e8f5e8; padding: 2px 5px; border-radius: 3px; margin-bottom: 2px;">
                    Desde: <?= $promo["fechaDesdePromo"] ?>
                </div>
                <div style="background-color: #ffe8e8; padding: 2px 5px; border-radius: 3px;">
                    Hasta: <?= $promo["fechaHastaPromo"] ?>
                </div>
            </td>
            <td> <?= $promo["categoriaCliente"] ?></td>
            <td> 
                <?php
                    //Si esta disponible toda la semana.
                    if(strlen($promo["diasSemana"]) != 54){
                        
                        echo $promo["diasSemana"];
                    }
                    else{
                        echo "Todos los dias";
                    }
                ?>
            </td>
            <td> <?= ucfirst($promo["estadoPromo"]) ?></td>
            <td>
                <form action="../../../controllers/adminCtrl/promocionesController.php" method="POST">
                    <input type="hidden" name="codPromo" value="<?= $promo['codPromo'] ?>">

                    <!-- Si promocion = pendiente -->
                    <?php if($promo["estadoPromo"] == 'pendiente'): ?>
                        <button type="submit"  name="aprobar"  class="button-activar">Aprobar</button>
                        <button type="submit"  name="denegar" class="button-eliminar">Denegar</button>
                        <!-- Si promocion = aprobada -->
                    <?php elseif($promo["estadoPromo"] == 'aprobada'):  ?>
                        <button type="submit"  name="denegar" class="button-eliminar">Denegar</button>
                        <!-- Si promocion = denegada -->
                    <?php elseif($promo["estadoPromo"] == 'denegada'):  ?>
                        <button type="submit"  name="aprobar" class="button-activar">Aprobar</button>
                        <button type="submit"  name="eliminar" class="button-eliminar">Eliminar</button>
                    <?php endif; ?>
                </form>
            </td>
        </tr>
    <?php
    }
    echo "</table>"; 

    mysqli_free_result($listaPromociones);

    mysqli_close($conexion);

    echo "<div class='paginacion mt-3'>";
    for($i = 1;$i <= $total_paginas;$i++){
        if($pagina == $i){
            echo $pagina . "";
        }
        else{
            echo "<a href='promociones.php?pagina=$i' class='btn btn-outline-primary btn-sm mx-1' id='paginacion'>$i</a>";
        }
    }
    echo "</div>";?>

    <!-- Mensajes de alerta -->
    <?php if(isset($_SESSION['mensaje_exito'])): ?>
        <div class="alert alert-success">
            <p><?= $_SESSION['mensaje_exito'] ?></p>
        </div>
        <?php unset($_SESSION['mensaje_exito']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['mensaje_error'])): ?>
        <div class="alert alert-danger">
            <p><?= $_SESSION['mensaje_error'] ?></p>
        </div>
        <?php unset($_SESSION['mensaje_error']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['mensaje_warning'])): ?>
        <div class="alert alert-warning">
            <p><?= $_SESSION['mensaje_warning'] ?></p>
        </div>
        <?php unset($_SESSION['mensaje_warning']); ?>
    <?php endif; ?>

    <?php if(isset($_SESSION['mensaje_info'])): ?>
        <div class="alert alert-info">
            <p><?= $_SESSION['mensaje_info'] ?></p>
        </div>
        <?php unset($_SESSION['mensaje_info']); ?>
    <?php endif; ?>
    </div>
</body>
</html>