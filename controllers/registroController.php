<?php  

//Inicio Session
session_start();

//incluyo conexion BD
include("../conexionBD.php");

//verifico si method = POST Y input confirm fue presionado.
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm"])) {

    //coloco datos del post en variables
    $email = filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL);
    $clave = filter_input(INPUT_POST,"clave",FILTER_SANITIZE_SPECIAL_CHARS);
    $rol = filter_input(INPUT_POST,"rol",FILTER_SANITIZE_SPECIAL_CHARS);

    //hasher contraseña antes de guardar
    $hash = password_hash($clave , PASSWORD_DEFAULT);

    //Verifico que POST no esten vacios.
    if(!empty($_POST["email"]) && !empty($_POST["clave"]) && !empty($_POST["rol"])){

        //Consulto email para verificar existecia 
        $consultaEmail = "SELECT * FROM usuarios WHERE nombreUsuario = '$email'";
        $resultado = mysqli_query($conexion,$consultaEmail);


        if(!(mysqli_num_rows($resultado) > 0)){            

            //Genero token unico
            $token = bin2hex(random_bytes(16));
            //Inserto  datos en BD 
            $consulta = "INSERT INTO usuarios (nombreUsuario,claveUsuario,tipoUsuario,token) VALUES ('$email','$hash','$rol','$token')";

            try{
                mysqli_query($conexion,$consulta);

                //Usuario registrado correctamente.Redirigo a pagina MENSAJE.
                header("location:../views/auth/mensajeRegistro.php?rol=$rol&email=$email&token=$token");
                exit();
            }
            catch(mysqli_sql_exception){
                //Muestro mensaje de ERROR. Falla conexion BD
                $_SESSION['mensaje'] = "⚠️ Error en cargar datos...";
                header("Location: ../views/auth/registro.php");
                exit();
            }
        }
        else{
            //Email ya exisitente en BD. Muestro mensaje 
            $_SESSION['mensaje'] = "⚠️ Usuario ya existente..";
            header("Location: ../views/auth/registro.php");
            exit();
        }

    }
    else{
        //Faltan completar datos. Muestro mensaje
        $_SESSION['mensaje'] = "⚠️ Complete todos los campos.";
        header("Location: ../views/auth/registro.php");
        exit();
    }
        
}


mysqli_close($conexion);

?>