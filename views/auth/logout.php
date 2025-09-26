<?php

session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="../../controllers/logoutController.php" method="POST">
        <h2>Cerrar sesion</h2><br>
        <input type="submit" name="confirm" value="Si">
    </form>
</body>
</html>