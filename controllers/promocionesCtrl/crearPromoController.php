<?php
session_start();
include("../../../conexionBD.php");

if (!isset($_SESSION['tipoUsuario']) || $_SESSION['tipoUsuario'] !== 'dueño') {
    header("Location: ../../../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['crear'])) {
    $textoPromo = mysqli_real_escape_string($conexion, $_POST['textoPromo']);
    $fechaDesde = mysqli_real_escape_string($conexion, $_POST['fechaDesde']);
    $fechaHasta = mysqli_real_escape_string($conexion, $_POST['fechaHasta']);
    $categoriaCliente = mysqli_real_escape_string($conexion, $_POST['categoriaCliente']);
    $diasSemana = $_POST['diasSemana'] ?? [];
    $codDueño = $_SESSION['codUsuario'];
    $sql_local = "SELECT codLocal FROM locales WHERE codUsuario = '$codDueño' LIMIT 1";


    if ($resultado_local && mysqli_num_rows($resultado_local) == 1) {
        $local = mysqli_fetch_assoc($resultado_local);
        $codLocal = $local['codLocal'];

        $diasArray = [0,0,0,0,0,0,0];
        foreach ($diasSemana as $dia) {
            $indice = intval($dia);
            if ($indice >= 0 && $indice <= 6) {
                $diasArray[$indice] = 1;
            }
        }

        $diasJSON = json_encode($diasArray); //está bn el json o hay otra forma de hacerlo?

        $sql = "INSERT INTO promociones (textoPromo, fechaDesdePromo, fechaHastaPromo, categoriaCliente, diasSemana, estadoPromo, codLocal) 
                VALUES ('$textoPromo', '$fechaDesde', '$fechaHasta', '$categoriaCliente', '$diasJSON', 'pendiente', '$codLocal')";
        if (mysqli_query($conexion, $sql)) {
            $_SESSION['mensaje'] = "Promoción creada con exito! Está pendiente de aprobación.";
        } else { 
            $_SESSION['mensaje'] = "Error al crear la promoción: " . mysqli_error($conexion);
        }

    } else {
        $_SESSION['mensaje'] = "No se encontró un local asociado a tu cuenta.";
    }

    header("Location: ../../views/dueño/crearPromocion.php"); //para volver al form
    exit ();

} else {
    header("Location: ../../index.php");
    exit();
}
?>