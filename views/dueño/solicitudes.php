<?php

session_start();

include("../../conexionBD.php");

include("../../includes/dueño/dueñoHeader.php");

$codDueño = $_SESSION['codUsuario'];

// +Consulto local del dueño
$sql_local = "SELECT codLocal, nombreLocal FROM locales WHERE codUsuario = '$codDueño' AND estadoLocal = 'activo' LIMIT 1";
$resultado_local = mysqli_query($conexion, $sql_local);

if ($resultado_local && mysqli_num_rows($resultado_local) == 1) {
    $local = mysqli_fetch_assoc($resultado_local);
    $codLocal = $local['codLocal'];
    $nombreLocal = $local['nombreLocal'];
} else {
    $_SESSION['mensaje_error'] = "No tienes un local activo asignado.";
    header("location:../dueño/dueñoDashboard.php");
    exit();
}

// Paginación

$cant_por_pag =5;
$pagina = isset($_GET["pagina"]) ? $_GET["pagina"] : 1;
if(!$pagina){

$inicio = 0;
$pagina=1;

}
else{
    $inicio = ($pagina - 1) * $cant_por_pag;
}


// Consulta principal para obtener las solicitudes de descuentos
$consultaSolicitudes = "SELECT 
                        sd.id_solicitud,
                        sd.codCliente,
                        sd.codPromo,
                        sd.fecha_solicitud,
                        sd.estado,
                        u.nombreUsuario,
                        p.textoPromo,
                        p.fechaDesdePromo,
                        p.fechaHastaPromo,
                        p.categoriaCliente
                    FROM solicitudes_descuentos sd
                    JOIN promociones p ON sd.codPromo = p.codPromo
                    JOIN usuarios u ON sd.codCliente = u.codUsuario
                    WHERE p.codLocal = '$codLocal'
                    ORDER BY sd.fecha_solicitud DESC
                    LIMIT $inicio, $cant_por_pag";

$resultado_solicitudes = mysqli_query($conexion, $consultaSolicitudes);

?>


<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <title>Gestionar Solicitudes</title>
</head>
<body>
    <div class="container my-4">
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1><i class="fas fa-clipboard-list"></i> Solicitudes de Descuentos</h1>
                    <div class="badge bg-primary fs-6">
                        <i class="fas fa-store"></i> <?= htmlspecialchars($nombreLocal) ?>
                    </div>
                </div>

                <?php
                // Sistema de mensajes organizados
                if(isset($_SESSION['mensaje_exito'])){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
                    echo "<i class='fas fa-check-circle'></i> ".$_SESSION['mensaje_exito'];
                    echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
                    echo "</div>";
                    unset($_SESSION['mensaje_exito']);
                }
                
                if(isset($_SESSION['mensaje_error'])){
                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>";
                    echo "<i class='fas fa-exclamation-circle'></i> ".$_SESSION['mensaje_error'];
                    echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
                    echo "</div>";
                    unset($_SESSION['mensaje_error']);
                }
                
                if(isset($_SESSION['mensaje_warning'])){
                    echo "<div class='alert alert-warning alert-dismissible fade show' role='alert'>";
                    echo "<i class='fas fa-exclamation-triangle'></i> ".$_SESSION['mensaje_warning'];
                    echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
                    echo "</div>";
                    unset($_SESSION['mensaje_warning']);
                }
                
                if(isset($_SESSION['mensaje_info'])){
                    echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>";
                    echo "<i class='fas fa-info-circle'></i> ".$_SESSION['mensaje_info'];
                    echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
                    echo "</div>";
                    unset($_SESSION['mensaje_info']);
                }

                // Mensaje legacy (por compatibilidad)
                if(isset($_SESSION['mensaje'])){
                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>";
                    echo "<i class='fas fa-check-circle'></i> ".$_SESSION['mensaje'];
                    echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
                    echo "</div>";
                    unset($_SESSION['mensaje']);
                }
                

                
                /* if ($resultado_solicitudes && mysqli_num_rows($resultado_solicitudes) > 0):
                    <!-- Tabla de solicitudes -->
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th><i class="fas fa-hashtag"></i> ID</th>
                                    <th><i class="fas fa-user"></i> Cliente</th>
                                    <th><i class="fas fa-tag"></i> Promoción</th>
                                    <th><i class="fas fa-star"></i> Categoría</th>
                                    <th><i class="fas fa-calendar"></i> Fecha Solicitud</th>
                                    <th><i class="fas fa-traffic-light"></i> Estado</th>
                                    <th><i class="fas fa-cogs"></i> Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while($solicitud = mysqli_fetch_assoc($resultado_solicitudes)): ?>
                                    <tr>
                                        <td>#<?= $solicitud['id_solicitud'] ?></td>
                                        <td>
                                            <span class="fw-bold"><?= htmlspecialchars($solicitud['textoPromo']) ?></span>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt"></i> 
                                                Válida: <?= date('d/m/Y', strtotime($solicitud['fechaDesdePromo'])) ?> - 
                                                <?= date('d/m/Y', strtotime($solicitud['fechaHastaPromo'])) ?>
                                            </small>
                                        </td>
                                        <td>
                                            <?php
                                            $categoria = $solicitud['categoriaCliente'];
                                            $badge_class = '';
                                            $icon = '';
                                            switch($categoria) {
                                                case 'Premium':
                                                    $badge_class = 'bg-warning text-dark';
                                                    $icon = 'fas fa-crown';
                                                    break;
                                                case 'Medium':
                                                    $badge_class = 'bg-info';
                                                    $icon = 'fas fa-star';
                                                    break;
                                                case 'Inicial':
                                                default:
                                                    $badge_class = 'bg-secondary';
                                                    $icon = 'fas fa-circle';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $badge_class ?>">
                                                <i class="<?= $icon ?>"></i> <?= $categoria ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?= date('d/m/Y H:i', strtotime($solicitud['fecha_solicitud'])) ?>
                                        </td>
                                        <td>
                                            <?php
                                            $estado = $solicitud['estado'];
                                            $estado_class = '';
                                            $estado_icon = '';
                                            switch($estado) {
                                                case 'pendiente':
                                                    $estado_class = 'bg-warning text-dark';
                                                    $estado_icon = 'fas fa-clock';
                                                    break;
                                                case 'aceptada':
                                                    $estado_class = 'bg-success';
                                                    $estado_icon = 'fas fa-check';
                                                    break;
                                                case 'rechazada':
                                                    $estado_class = 'bg-danger';
                                                    $estado_icon = 'fas fa-times';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge <?= $estado_class ?>">
                                                <i class="<?= $estado_icon ?>"></i> <?= ucfirst($estado) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($estado == 'pendiente'): ?>
                                                <div class="btn-group" role="group">
                                                    <form method="POST" action="../../controllers/dueñoCtrl/gestionarSolicitudesController.php" style="display: inline;">
                                                        <input type="hidden" name="id_solicitud" value="<?= $solicitud['id_solicitud'] ?>">
                                                        <input type="hidden" name="accion" value="aceptar">
                                                        <button type="submit" class="btn btn-success btn-sm" 
                                                                onclick="return confirm('¿Aceptar esta solicitud de descuento?')">
                                                            <i class="fas fa-check"></i> Aceptar
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="../../controllers/dueñoCtrl/gestionarSolicitudesController.php" style="display: inline;">
                                                        <input type="hidden" name="id_solicitud" value="<?= $solicitud['id_solicitud'] ?>">
                                                        <input type="hidden" name="accion" value="rechazar">
                                                        <button type="submit" class="btn btn-danger btn-sm" 
                                                                onclick="return confirm('¿Rechazar esta solicitud de descuento?')">
                                                            <i class="fas fa-times"></i> Rechazar
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">
                                                    <i class="fas fa-check-circle"></i> Procesada
                                                </span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>

                <?php else: ?>
                    <!-- Sin solicitudes -->
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <i class="fas fa-inbox fa-4x text-muted"></i>
                        </div>
                        <h4 class="text-muted">No hay solicitudes de descuentos</h4>
                        <p class="text-muted">
                            Aún no tienes solicitudes de descuentos para tu local.<br>
                            Las solicitudes aparecerán aquí cuando los clientes soliciten usar tus promociones.
                        </p>
                        <a href="../dueño/mis_promos.php" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Ver mis promociones
                        </a>
                    </div>
                <?php endif; */?>

            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>