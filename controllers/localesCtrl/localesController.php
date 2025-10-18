<?php

session_start();

include("../../conexionBD.php");
include("../../funciones/funcionesSQL.php");


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm"])){

    $codDueño = trim(filter_input(INPUT_POST,"codDueño",FILTER_SANITIZE_SPECIAL_CHARS));
    $nombreLocal = trim(filter_input(INPUT_POST,"nombreLocal",FILTER_SANITIZE_SPECIAL_CHARS));
    $rubroLocal = trim(filter_input(INPUT_POST,"rubroLocal",FILTER_SANITIZE_SPECIAL_CHARS));
    $ubicacionLocal = filter_input(INPUT_POST,"ubicacionLocal",FILTER_SANITIZE_SPECIAL_CHARS);
    $imgLocal = $_POST["imgLocal"];

    if(!empty($codDueño) &&
        !empty($nombreLocal) &&
        !empty($rubroLocal) &&
        !empty($ubicacionLocal) &&
        !empty($imgLocal)){

            $listaLocales = consultaLocales($conexion);
            $listaDueños  = consultaDueños($conexion);

            $dueños = mysqli_fetch_assoc($listaDueños);
            $local = mysqli_fetch_assoc($listaLocales);

            if($codDueño == $dueños["codUsuario"]){

                if($nombreLocal != $local["nombreLocal"]){

                    if($ubicacionLocal != $local["ubicacionLocal"]){

                        if($imgLocal != $local["ImgLocal"]){


                            






                        }
                        else{
                            $_SESSION['mensaje'] = "Logo ya en uso... ";
                        }


                    }
                    else{
                        $_SESSION['mensaje'] = "Ubicacion no disponible.. ";
                    }


                }
                else{
                    $_SESSION['mensaje'] = "Nombre de local ya existente... ";
                }

            }
            else{
                $_SESSION['mensaje'] = "Codigo de dueño no existe...";
            }









    }else{
        $_SESSION['mensaje'] = "⚠️ Complete todos los datos..";
    }





}

?>