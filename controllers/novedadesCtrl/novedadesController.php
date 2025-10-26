<?php
session_start();
include("../../conexionBD.php");


//tengo q usar mysqli_real_escape_string????

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['crear'])) {
    $textoNovedad = $_POST['textoNovedad'];
    $fechaDesdeNovedad = $_POST['fechaDesdeNovedad'];
    $fechaHastaNovedad = $_POST['fechaHastaNovedad'];
    $tipoUsuario = $_POST['tipoUsuario'];

    if (!empty($textoNovedad) && !empty($fechaDesdeNovedad) && !empty($fechaHastaNovedad) && !empty($tipoUsuario)) {
        $sql = "INSERT INTO novedades (textoNovedad, fechaDesdeNovedad, fechaHastaNovedad, tipoUsuario) VALUES ('$textoNovedad', '$fechaDesdeNovedad', '$fechaHastaNovedad', '$tipoUsuario')";
        if (mysqli_query($conexion, $sql)) {
            $_SESSION['mensaje'] = "Novedad creada exitosamente.";
        } else {
            $_SESSION['error'] = "Error al crear la novedad: " . mysqli_error($conexion);
        }

    } else {
        $_SESSION['mensaje'] = "Por favor, complete todos los campos.";
    }

    header("Location: ../../views/admin/novedades/novedades.php");  //lo mando d nuevo a la pag del form.
    exit();

} else {
    header("Location: ../../index.php");
    exit();

}

?>