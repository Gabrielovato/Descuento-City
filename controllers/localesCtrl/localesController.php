<?php

session_start();

include("../../conexionBD.php");

require("../../funciones/funcionesSQL.php");


$codLocal = $_POST["codLocal"] ?? '';

if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm"])){

    $codDueño = trim(filter_input(INPUT_POST,"codDueño",FILTER_SANITIZE_SPECIAL_CHARS));
    $nombreLocal = trim(filter_input(INPUT_POST,"nombreLocal",FILTER_SANITIZE_SPECIAL_CHARS));
    $rubroLocal = trim(filter_input(INPUT_POST,"rubroLocal",FILTER_SANITIZE_SPECIAL_CHARS));
    $ubicacionLocal = filter_input(INPUT_POST,"ubicacionLocal",FILTER_SANITIZE_SPECIAL_CHARS);
    $imgLocal = $_POST["imgLocal"];
    
    if(!empty($codDueño) &&
        !empty($nombreLocal) &&
        !empty($rubroLocal) &&
        !empty($ubicacionLocal)){

            $verificarLocal = "SELECT * FROM locales WHERE nombreLocal='$nombreLocal' OR ubicacionLocal='$ubicacionLocal'";

            $resultadoLocal = mysqli_query($conexion,$verificarLocal);

            $consultaDueño = "SELECT * FROM usuarios WHERE codUsuario='$codDueño' AND tipoUsuario='dueño'";

            $resultado = mysqli_query($conexion,$consultaDueño);

            


            if(mysqli_num_rows($resultado) > 0){

                //si existe dueño

                $dueño = mysqli_fetch_assoc($resultado);

                if(!mysqli_num_rows($resultadoLocal) > 0){            

                    $local = mysqli_fetch_assoc($resultadoLocal);

                    $consulta = "INSERT INTO locales (nombreLocal,ubicacionLocal,rubroLocal,codUsuario) VALUES ('$nombreLocal','$ubicacionLocal','$rubroLocal','$codDueño')";

                    $resultado = mysqli_query($conexion,$consulta);

                    if($resultado){
                        $_SESSION['mensaje'] = "Local creado con exito... ";
                        header("location:../../views/admin/locales.php");
                        exit();

                    }
                    else{
                        $_SESSION['mensaje'] = " Error al crear local ";
                        header("location:../../views/admin/locales.php");
                        exit();
                    }


                }
                else{
                    $_SESSION['mensaje'] = "Nombre de local o ubicacion ya existente... ";
                    header("location:../../views/admin/locales.php");
                    exit();
                }

            }
            else{
                $_SESSION['mensaje'] = "Codigo de dueño no existe...";
                header("location:../../views/admin/locales.php");
                exit();
               }
    }
    else{
        $_SESSION['mensaje'] = "⚠️ Complete todos los datos..";
        header("location:../../views/admin/locales.php");
        exit();
    }

}
elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["activar"])){


    $consulta = "UPDATE locales SET estadoLocal ='activo' WHERE codLocal='$codLocal'";

    $resultado = mysqli_query($conexion,$consulta);

    if($resultado){

        $_SESSION['mensaje'] = "Local activado correctamente";
        header("location:../../views/admin/locales.php");
        exit();
    }
    else{

        $_SESSION['mensaje'] = "Error al activar local";
        header("location:../../views/admin/locales.php");
        exit();
    }




}
elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["eliminar"])){


    $consulta = "UPDATE locales SET estadoLocal ='eliminado' WHERE codLocal='$codLocal'";

    $resultado = mysqli_query($conexion,$consulta);



    if($resultado){

        $_SESSION['mensaje'] = "Local eliminado correctamente.";
        header("location:../../views/admin/locales.php");
        exit();

    }else{

        $_SESSION['mensaje'] = "Error al eliminar local";
        header("location:../../views/admin/locales.php");
        exit();

    }

    

}
elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["editar"])){

    header("location: ../../views/admin/locales/localUpdate.php");
    exit();
}


mysqli_close($conexion);

?>