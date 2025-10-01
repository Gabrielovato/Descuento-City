


<?php

//Consulto : nombreUsuario = email | token = token | estadoUsuario = 'Pendiente '
function consultaSQL($con,$email,$token){
    $consultaEstado = "SELECT * FROM usuarios WHERE nombreUsuario = '$email' AND token= '$token' AND estadoUsuario= 'pendiente' ";
    $resultado = mysqli_query($con,$consultaEstado);
    return $resultado;
}


//Consulto : tipoUsuario ="dueños" | estadoUsuario="pendiente/activo/bloquedo" ordenados . DESC para que aparezca el mas reciente primero 
function consultaDueños($con){
    $consultaDueños = "SELECT * FROM usuarios WHERE  tipoUsuario='dueño' ORDER BY FIELD(estadoUsuario, 'pendiente', 'activo', 'bloqueado') , fechaRegistro DESC";
    $resultado = mysqli_query($con,$consultaDueños);
    return $resultado;

}
// Actualizar estado pendiente -> activo.
function update_estado_SQL($con,$email){
    $consulta_update = "UPDATE usuarios SET estadoUsuario='activo', token=NULL  WHERE nombreUsuario='$email'";
    $resultado_update = mysqli_query($con,$consulta_update);
    return $resultado_update;
}

?>