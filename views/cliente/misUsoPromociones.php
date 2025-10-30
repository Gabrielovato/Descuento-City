<?php

session_start();
include("../../conexionBD.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <title>Mis uso promociones</title>
</head>
<body>

    <?php
    include("../../includes/cliente/clienteHeader.php");

    $codCliente = $_SESSION["codUsuario"];

    $consultaUsos = "SELECT * FROM uso_promociones WHERE codUsuario='$codCliente'";

    $resultadoUsos = mysqli_query($conexion,$consultaUsos);


    $total_registros = mysqli_num_rows($resultadoUsos);

    //consulta Páginada
    $consultaUsosPaginada = "SELECT * FROM uso_promociones WHERE codUsuario='$codCliente' LIMIT $inicio,$cant_por_pag";

    $listaUsos = mysqli_query($conexion,$consultaUsosPaginada);

    $total_paginas = ceil($total_registros / $cant_por_pag);

    echo "<table class='tabla table table-striped'>";
    echo "<caption>Mis uso promociones</caption>";
    echo "<tr>
            <th>ID</th>
            <th>codPromo</th>
            <th>Descripcion</th>
            <th>Portada</th>
            <th>fecha Uso</th>
            <th>Vencimiento</th>
            <th>Estado</th>
        </th>";
    
    if(mysqli_num_rows($resultadoUsos) <= 0){
        ?>
        <tr>
            <td colspan="9" style="text-align: center; padding: 20px; color: #666; font-style: italic;">
                No hay existen uso de promociones.
            </td>
        </tr>
        <?php
    }
    while($uso = mysqli_fetch_assoc($listaPromociones)){
        ?>
        <tr>
            <td> <?= $uso ?></td>
            <td> <?= $uso ?></td>
            <td> <?= $uso ?></td>
            <td> <?= $uso ?></td>
            <td> <?= $uso ?></td>
            <td> <?= $uso ?></td>
            <td> <?= $uso ?></td>
        </tr>
    <?php
    }
    echo "</table>;"?>

        <?php


    mysqli_free_result($listaPromociones);

    echo "<div class='paginacion mt-3'>";
    for($i = 1;$i <= $total_paginas;$i++){
        if($pagina == $i){
            echo $pagina . "";
        }
        else{
            echo "<a href='mis_promos.php?pagina=$i' class='btn btn-outline-primary btn-sm mx-1' id='paginacion'>$i</a>";
        }
    }
    echo "</div><br>";?>




    
</body>
</html>