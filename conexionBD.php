<?php

//conexion BD descuento City
try{
    $conexion = mysqli_connect("localhost","root","","descuentocitydb_Datos");

}
catch(mysqli_sql_exception){
    echo "Ocurrio un error al conectar base de datos...";
}

?>

