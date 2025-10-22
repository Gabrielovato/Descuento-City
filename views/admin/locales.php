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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Locales</title>
</head>
<body>
    <?php include("../../includes/admin/adminHeader.php");?>
    <?php

    $consulta = "SELECT l.* , i.rutaArchivo FROM locales l LEFT JOIN imagenes i ON i.idIdentidad = l.codLocal AND i.tipoImg = 'logo'";

    $listaLocales = mysqli_query($conexion,$consulta);
    
    if(!empty($listaLocales)):
        echo "<table class='tabla table table-striped'>";
        echo "<caption>Locales</caption>";
        echo "<tr>
        <th>Codigo</th>
        <th>Nombre</th>
        <th>Logo</th>
        <th>Ubicacion</th>
        <th>Rubro</th>
        <th>Codigo Dueño</th>
        <th>Estado</th>
        <th>Editar/Eliminar</th>";

        while($fila = mysqli_fetch_assoc($listaLocales)){
            ?>
            <tr>
                <td> <?= $fila["codLocal"]?></td>
                <td> <?= $fila["nombreLocal"]?></td>
                <!-- Logo -->
                <td>
                    <?php if(!empty($fila["rutaArchivo"])):?>
                        <img src="../../<?= $fila["rutaArchivo"] ?>" alt="Logo del local" width="70" height="50" style="object-fit:cover;border-radius:8px;">
                    <?php else: ?>
                        <span style="color: gray;">Sin logo</span>
                    <?php endif; ?>
                </td>
                <td> <?= $fila["ubicacionLocal"]?></td>
                <td> <?= $fila["rubroLocal"]?></td>
                <td> <?= $fila["codUsuario"]?></td>
                <td> <?= ucfirst($fila["estadoLocal"])?></td>
                <td>
                    <form action="../../controllers/localesCtrl/localesController.php" method="POST">

                        <!-- Si local esta eliminado -->
                        <?php if($fila["estadoLocal"] == 'eliminado' ):?>
                            <input type="hidden" name="codLocal" value="<?= $fila["codLocal"] ?>">
                            <button type="submit" name="activar" class="button-activar">Activar</button>
                            <!-- Boton para editar -->
                            <button type="submit" name="editar" class="button-editar"><a href="/Descuento-City/views/admin/locales/localUpdate.php?codLocal=<?php echo $fila['codLocal']; ?>">Editar</a></button>
    
                        <!-- Si local esta activo, Permitir editar o eliminar -->
                        <?php elseif($fila["estadoLocal"] == 'activo' ):?>
                            <input type="hidden" name="codLocal" value="<?= $fila["codLocal"] ?>">
                            <!-- Boton para editar -->
                            <button type="submit" name="editar" class="button-editar"><a href="/Descuento-City/views/admin/locales/localUpdate.php?codLocal=<?php echo $fila['codLocal']; ?>">Editar</a></button>
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

    
    <div class="main-center">
        <div class="form__container-locales">
            <h1>Crear local</h1>
            <form class="form-locales" action="../../controllers/localesCtrl/localesController.php" method="POST" enctype="multipart/form-data">
                <label>Codigo Dueño</label><br>
                <input type="text" name="codDueño" required><br>
                <label >Nombre de local</label><br>
                <input type="text" name= "nombreLocal" ><br>
                <label >Rubro</label><br>
                <input type="text" name="rubroLocal"><br>
                <label>Ubicacion</label><br>
                <input type="text" name="ubicacionLocal"><br>
                <label>Logo</label><br>
                <input class="input-img" type="file" name="imgLocal" accept="image/*"><br>
                <input class="button-form" type="submit" name="confirm" value="Crear local">
            </form>
        </div>
    </div>
</body>
</html>