

<?php

include("../../conexionBD.php");
require("../../funciones/funcionesSQL.php");

//llamo a funcion consultDueños.Donde selecciono dueños que esten pendientes.
$listaDueños = consultaDueños($conexion);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=/Descuento-City/assets/css/estilos.css">
</head>
<body>
    <?php include("../../includes/admin/adminHeader.php");?>
    <?php 
    if(!empty($listaDueños)):

        echo "<table class='tabla__dueños'>";
        echo "<caption>Solicitudes de Dueños</caption>";
        echo "<tr><th>ID</th><th>Nombre</th><th>Estado</th><th>Fecha registro</th><th>Activar</th><tr";
    
        while($dueño = mysqli_fetch_assoc($listaDueños)){
            ?>
            <tr>
                <td> <?= $dueño["codUsuario"]    ?></td>
                <td> <?= $dueño["nombreUsuario"] ?></td>
                <td> <?= $dueño["estadoUsuario"] ?></td>
                <td> <?= $dueño["fechaRegistro"] ?></td>
                <td>
                    <form action="../../controllers/activacionDueñoController.php" method="POST">
                        <input type="hidden" name="id" value="> <?= $dueño['codUsuario']?> ">
                        <button type="submit"  name="activar"  class="button-activar">Activar</button>
                        <button type="submit"  name="bloquear" class="button-bloquear">bloquear</button>                        
                    </form>
                </td>
            </tr>
            <?php
        }
        echo "</table>";
    endif;?>
</body>
</html>