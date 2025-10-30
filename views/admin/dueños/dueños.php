

<?php


session_start();

include("../../../conexionBD.php");


//llamo a funcion consultDueños.Donde selecciono dueños que esten pendientes.
//$listaDueños = consultaDueños($conexion);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="icon" type="image/png" href="assets/img/logo-ventana/logo-fondo-b-circular.png"/>
</head>
<body>
    <?php include("../../../includes/admin/adminHeader.php");?>


    <?php

        //paginacion

        $cant_por_pag =6;
        $pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;

        if(!$pagina){
            $inicio = 0;
            $pagina=1;
        }
        else{
            $inicio = ($pagina - 1) * $cant_por_pag;
        }

        //total dueños
        $consulta = "SELECT * FROM usuarios WHERE tipoUsuario='dueño'";
        $resultado = mysqli_query($conexion,$consulta);
        $total_registros = mysqli_num_rows($resultado);

        //Consulta Paginada
        $consultaDueños = "SELECT * FROM usuarios WHERE tipoUsuario='dueño' ORDER BY FIELD(LOWER(estadoUsuario), 'pendiente','activo','eliminado'), fechaRegistro  DESC LIMIT $inicio,$cant_por_pag;";
        $listaDueños = mysqli_query($conexion,$consultaDueños);

        $total_paginas = ceil($total_registros / $cant_por_pag);


        //Lista dueños pendientes.
        echo "<table class='tabla table table-striped'>";
        echo "<caption>Solicitudes de Dueños</caption>";
        echo "<tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Estado</th>
                <th>Fecha registro</th>
                <th>Activar/Eliminar</th>
            </tr>";
        
        while($dueño = mysqli_fetch_assoc($listaDueños)){
            ?>
            <tr>
                <td> <?= $dueño["codUsuario"]    ?></td>
                <td> <?= $dueño["nombreUsuario"] ?></td>
                <td>
                    <?php
                    $estado = $dueño["estadoUsuario"];
                    $estado_class = '';
                    $estado_icon = '';
                    switch($estado) {
                        case 'pendiente':
                            $estado_class = 'bg-warning text-dark';
                            $estado_icon = 'fas fa-clock';
                            break;
                        case 'activo':
                            $estado_class = 'bg-success';
                            $estado_icon = 'fas fa-check';
                            break;
                        case 'eliminado':
                            $estado_class = 'bg-danger';
                            $estado_icon = 'fas fa-times';
                            break;
                    }
                    ?>
                    <span class="badge <?= $estado_class ?>">
                        <i class="<?= $estado_icon ?>"></i> <?= ucfirst($estado) ?>
                    </span>
                </td>
                <td> <?= $dueño["fechaRegistro"] ?></td>
                <td>
                    <form action="../../../controllers/dueñoCtrl/activacionDueñoController.php" method="POST">
                        <input type="hidden" name="codUsuario" value="<?= $dueño['codUsuario'] ?>">
                        <input type="hidden" name="nombreUsuario" value="<?= $dueño['nombreUsuario']?>">
                        <!-- Si dueño = pendiente -->
                        <?php if($dueño["estadoUsuario"] == 'pendiente'): ?>
                            <button type="submit"  name="activar"  class="button-activar">Activar</button>
                            <button type="submit"  name="eliminar" class="button-eliminar">Eliminar</button>
                            <!-- Si dueño = activo -->
                        <?php elseif($dueño["estadoUsuario"] == 'activo'):  ?>
                            <button type="submit"  name="eliminar" class="button-eliminar">Eliminar</button>
                            <!-- Si dueño = eliminado -->
                        <?php elseif($dueño["estadoUsuario"] == 'eliminado'):  ?>
                            <button type="submit"  name="activar" class="button-activar">Activar</button>
                        <?php endif; ?>
                    </form>
                </td>
            </tr>
        <?php
        }
        echo "</table>"; 

        mysqli_free_result($listaDueños); //libera la memoria que fue utilizada por un resultado de consulta de base de datos
    
        mysqli_close($conexion);

        echo "<div class='paginacion mt-3'>";
        for($i = 1;$i <= $total_paginas;$i++){
            if($pagina == $i){
                echo $pagina . "";
            }
            else{
                echo "<a href='dueños.php?pagina=$i' class='btn btn-outline-primary btn-sm mx-1' id='paginacion'>$i</a>";
            }
        }
        echo "</div>";?>

        <!-- Sistema de mensajes organizados -->
        <?php if(isset($_SESSION['mensaje_exito'])): ?>
            <div class="alert alert-success">
                <p><?= $_SESSION['mensaje_exito'] ?></p>
            </div>
            <?php unset($_SESSION['mensaje_exito']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['mensaje_error'])): ?>
            <div class="alert alert-danger">
                <p><?= $_SESSION['mensaje_error'] ?></p>
            </div>
            <?php unset($_SESSION['mensaje_error']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['mensaje_warning'])): ?>
            <div class="alert alert-warning">
                <p><?= $_SESSION['mensaje_warning'] ?></p>
            </div>
            <?php unset($_SESSION['mensaje_warning']); ?>
        <?php endif; ?>

        <?php if(isset($_SESSION['mensaje_info'])): ?>
            <div class="alert alert-info">
                <p><?= $_SESSION['mensaje_info'] ?></p>
            </div>
            <?php unset($_SESSION['mensaje_info']); ?>
        <?php endif; ?>

        <!-- Mensaje legacy (por compatibilidad) -->
        <?php if(isset($_SESSION['mensaje'])): ?>
            <div class="alert alert-success">
                <p><?= $_SESSION['mensaje'] ?></p>
            </div>
            <?php unset($_SESSION['mensaje']); ?>
        <?php endif; ?>
</body>
</html> 


