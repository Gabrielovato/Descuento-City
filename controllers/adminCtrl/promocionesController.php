<?php

session_start();

include("../../conexionBD.php");
require("../../funciones/funcionesSQL.php");

if($_SERVER["REQUEST_METHOD"] == "POST"){

    $codPromo = $_POST["codPromo"] ?? '';
    $accion = '';
    $mensajeExito = '';
    $mensajeError = '';

    if(isset($_POST["aprobar"])){
        $accion = 'aprobar';
        $mensajeExito = "Promoción aprobada exitosamente";
        $mensajeError = "Error al aprobar la promoción";
        $tipoExito = "mensaje_exito";
        $tipoError = "mensaje_error";
    }
    elseif(isset($_POST["denegar"])){
        $accion = 'denegar';
        $mensajeExito = "Promoción denegada exitosamente";
        $mensajeError = "Error al denegar la promoción";
        $tipoExito = "mensaje_warning";
        $tipoError = "mensaje_error";
    }
    elseif(isset($_POST["eliminar"])){
        $accion = 'eliminar';
        $mensajeExito = "Promoción eliminada exitosamente";
        $mensajeError = "Error al eliminar la promoción";
        $tipoExito = "mensaje_warning";
        $tipoError = "mensaje_error";
    }

    if($accion != '' && cambiarEstado($conexion,$codPromo,$accion)){
        $_SESSION[$tipoExito] = $mensajeExito;
        header("location: ../../views/admin/promociones/promociones.php");
        exit();
    }
    else{
        $_SESSION[$tipoError] = $mensajeError;
        header("location: ../../views/admin/promociones/promociones.php");
        exit();
    }
}

?>