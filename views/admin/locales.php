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
    <h1>Crear local</h1>
    <div class="main-center">
        <div class="form__container-l">
            <form action="" method="POST" class="form-locales">
                <label>Codigo Dueño</label><br>
                <input type="text" name="codProp"><br>
                <label >Nombre de local</label><br>
                <input type="text" name= "nombreLocal"><br>
                <label >Rubro</label><br>
                <input type="text" name="rubroLocal"><br>
                <label>Ubicacion</label><br>
                <input type="text"><br>
                <input type="submit" value="Crear local">
            </form>
        </div>
    </div>
</body>
</html>