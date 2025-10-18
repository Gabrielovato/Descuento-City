<?php

session_start();

include("../../conexionBD.php");
require("../../funciones/funcionesSQL.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=/Descuento-City/assets/css/estilos.css">
    <title>Document</title>
</head>
<body>
    <?php include("../../includes/admin/adminHeader.php");?>
    <?php

    $listaLocales = consultaLocales($conexion);
    
    if(!empty($listaLocales)):
        echo "<table class='tabla__locales'>";
        echo "<caption>Locales</caption>";
        echo "<tr><th>Codigo</th><th>Nombre</th><th>Ubicacion</th><th>Rubro</th><th>Codigo Dueño</th><th>Estado</th><th>Editar/Eliminar</th>";

        while($fila = mysqli_fetch_assoc($listaLocales)){
            ?>
            <tr>
                <td> <?= $fila["codLocal"]?></td>
                <td> <?= $fila["nombreLocal"]?></td>
                <td> <?= $fila["ubicacionLocal"]?></td>
                <td> <?= $fila["rubroLocal"]?></td>
                <td> <?= $fila["codUsuario"]?></td>
                <td> <?= $fila["estadoLocal"]?></td>
                <td>
                    <form action="../../controllers/localesCtrl/localesControllers.php" method="POST">
                        <!-- Si local esta eliminado -->
                        <?php if($fila["estadoLocal"] == 'eliminado' ):?>
                            <button type="submit" name="activar" class="button-activar">Activar</button>

                        <!-- Si local esta activo, Permitir editar o eliminar -->
                        <?php elseif($fila["estadoLocal"] == 'activo' ):?>
                            <button type="submit" name="editar" class="button-editar">Editar</button>
                            <button type="submit" name="eliminar" class="button-eliminar">Eliminar</button>

                        <?php endif;?>
                    </form>
                </td>
            </tr>
        <?php
        }
        echo "</table>";
        if(isset($_SESSION['mensaje'])){
            echo "<p style='color :green'>".$_SESSION['mensaje']."</p>";
            unset($_SESSION['mensaje']);
        }

    endif;?>

    <h1>Crear local</h1>
    <div class="main-center">
        <div class="form__container-locales">
            <form class="form-locales" action="../../controllers/localesCtrl/localesController.php" method="POST" >
                <label>Codigo Dueño</label><br>
                <input type="text" name="codDueño" required><br>
                <label >Nombre de local</label><br>
                <input type="text" name= "nombreLocal" ><br>
                <label >Rubro</label><br>
                <input type="text" name="rubroLocal"><br>
                <label>Ubicacion</label><br>
                <input type="text" name="ubicacionLocal"><br>
                <label>Logo</label><br>
                <input class="input-img" type="file" name="imgLocal" accept="image/"><br>
                <input class="button-form" type="submit" name="confirm" value="Crear local">
            </form>
        </div>
    </div>
</body>
</html>