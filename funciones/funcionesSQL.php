


<?php

//Seleccion de nombreUsuario y token 
function consultaSQL($con,$email,$token){
    $consultaEstado = "SELECT * FROM usuarios WHERE nombreUsuario = '$email' AND token= '$token' AND estadoUsuario= 'pendiente' ";
    $resultado = mysqli_query($con,$consultaEstado);
    return $resultado;
}


// Funcion actualizar estado pendiente -> activo.
function update_estado_SQL($con,$email){
    $consulta_update = "UPDATE usuarios SET estadoUsuario='activo', token=NULL  WHERE nombreUsuario='$email'";
    $resultado_update = mysqli_query($con,$consulta_update);
    return $resultado_update;
}

?>