<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["Enviar"])) {

    $nombre = $_POST["nombre"];
    $email = $_POST["email"];
    $asunto = $_POST["asunto"];
    $mensaje = $_POST["mensaje"];


    //falta la logica de mandarle mail al administrador

    $_SESSION['mensaje_contacto'] = "¡Mensaje enviado con éxito! Te responderemos a la brevedad.";
    header("Location: ../contacto.php");
    exit();


} else {
    header("Location: ../contacto.php");
    exit();
}
?>


    