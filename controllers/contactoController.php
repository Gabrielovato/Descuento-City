<?php

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar"])) {

    $nombre = filter_input(INPUT_POST,"nombre",FILTER_SANITIZE_SPECIAL_CHARS);
    $email = trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL));
    $asuntoRecibido = trim(filter_input(INPUT_POST,"asunto",FILTER_SANITIZE_SPECIAL_CHARS));
    $mensaje = trim(filter_input(INPUT_POST,"mensaje",FILTER_SANITIZE_SPECIAL_CHARS));

    if(!empty($nombre) && !empty($email) && !empty($asuntoRecibido) && !empty($mensaje)){

        $destino  = "gabilovato45@gmail.com";     
        // Para enviar un correo HTML, el encabezado Content-type debe ser definido    
        $header = "MIME-Version: 1.0\r\n";
        $header .= "Content-type:text/html; charset=iso-8859-1\r\n";
        $header .= "From: ".$email ."\r\n";
        $header .= "Reply-To: " . $email . "\r\n";


        $asunto = 'Menaje de contacto DC. -' . $asuntoRecibido;
        $cuerpo = '
        <html>
            <head>
                <title>Mensaje de contacto - Descuento City</title>
            </head>
            <body>
                <h2>Nuevo mensaje de contacto</h2>
                <p><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</p>
                <p><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>
                <p><strong>Asunto:</strong> ' . htmlspecialchars($asuntoRecibido) . '</p>
                <p><strong>Mensaje:</strong></p>
                <div style="background: #f5f5f5; padding: 15px; border-left: 4px solid #007bff;">
                    ' . nl2br(htmlspecialchars($mensaje)) . '
                </div>
                <hr>
                <p><small>Este mensaje fue enviado desde el formulario de contacto de Descuento City</small></p>
            </body>
        </html>
        ';

        $envio =  mail($destino ,$asunto, $cuerpo ,$header);

        if($envio){
            $_SESSION["mensaje_exito"] = "Mensaje enviado correctamente. Te responderemos pronto.";
        } else {
            $_SESSION["mensaje_error"] = "Error al enviar el mensaje. Inténtalo de nuevo.";
        }

    } else {
        $_SESSION["mensaje_error"] = "Complete todos los campos.";
    }

    header("Location: ../contacto.php");
    exit();

} else {
    $_SESSION["mensaje_error"] = "Método no permitido.";
    header("Location: ../contacto.php");
    exit();
}

?>


    