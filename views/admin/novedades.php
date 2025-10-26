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
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Locales</title>
</head>
<body>
    <?php include("../../includes/admin/adminHeader.php");?>

    <h1>Crear novedad</h1>
            <form class="form-locales" action="../../controllers/novedadesCtrl/novedadesController.php" method="POST">
                <label>Texto de la novedad</label><br>
                <textarea name="textoNovedad" rows="5" cols="40"></textarea><br>
                <label >Fecha de inicio de novedad</label><br>
                <input type="date" name= "fechaDesdeNovedad" ><br>
                <label >Fecha de finalizacion de novedad</label><br>
                <input type="date" name="fechaHastaNovedad"><br>
                <label>Dirigido a: </label><br>
                <select name="tipoUsuario"></select><br>
                    <option value="Inicial">Inicial</option>
                    <option value="Medium">Medium</option>
                    <option value="Premium">Premium</option>
                </select><br>
                <input type="submit" value="Crear Novedad" class="button-form">
            </form>
</body>