<?php  

//Inicio Session
session_start();

//incluyo conexion BD
include("../conexionBD.php");

//verifico si method = POST Y input confirm fue presionado.
if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm"])) {

    //coloco datos del post en variables
    $email = trim(filter_input(INPUT_POST,"email",FILTER_SANITIZE_EMAIL));
    $clave = trim(filter_input(INPUT_POST,"clave",FILTER_SANITIZE_SPECIAL_CHARS));
    $claveConfirm = trim(filter_input(INPUT_POST,"claveConfirm",FILTER_SANITIZE_SPECIAL_CHARS));
    $rol = trim(filter_input(INPUT_POST,"rol",FILTER_SANITIZE_SPECIAL_CHARS));
    //hasher contraseña antes de guardar
    $hash = password_hash($clave , PASSWORD_DEFAULT);

    //Verifico que POST no este
    if(!empty($email) && !empty($clave) && !empty($claveConfirm) && !empty($rol)){

        //Controlo que contraseña y contraseña confirmacion sean iguales
        if($clave == $claveConfirm){

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
                    $_SESSION['mensaje_error'] = "Error al cargar datos en la base de datos";
                    header("Location: ../views/auth/registro.php");
                    exit();
                }
            }
            else{
                //Email ya exisitente en BD. Muestro mensaje 
                $_SESSION['mensaje_warning'] = "Usuario ya existente";
                header("Location: ../views/auth/registro.php");
                exit();
            }
        }
        else{
            //Contraseñas no coinciden
            $_SESSION['mensaje_warning'] = "Las contraseñas no coinciden";
            header("Location: ../views/auth/registro.php");
            exit();
        }
    }
    else{
        //Faltan completar datos. Muestro mensaje
        $_SESSION['mensaje_warning'] = "Complete todos los campos";
        header("Location: ../views/auth/registro.php");
        exit();
    }
        
}


mysqli_close($conexion);

?>