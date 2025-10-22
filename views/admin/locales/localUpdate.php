<?php
// localUpdate.php - form para editar local (corregido)
session_start();
require("../../../conexionBD.php");
include("../../../includes/admin/adminHeader.php");


$codLocal = isset($_GET['codLocal']) ? intval($_GET['codLocal']) : 0;
if ($codLocal >= 0) {
    
    // consulto datos local 
    $consulta = "SELECT * FROM locales WHERE codLocal = $codLocal";
    $resultado = mysqli_query($conexion, $consulta);

    if ($resultado && mysqli_num_rows($resultado) > 0) {
        $local = mysqli_fetch_assoc($resultado);

        // consulto datos imagen (logo)
        $consultaImg = "SELECT * FROM imagenes WHERE idIdentidad = '$codLocal' AND tipoImg = 'logo'";
        $resultadoImg = mysqli_query($conexion, $consultaImg);

        //Verifico si existe img
        if ($resultadoImg && mysqli_num_rows($resultadoImg) > 0) {
            $img = mysqli_fetch_assoc($resultadoImg);
        }

    } else {
        echo "No se encontro el local";
        mysqli_close($conexion);
        exit;
    }

} else {
    echo "No se recibio el ID local..";
    mysqli_close($conexion);
    exit;
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="estilos.css">
    <title>Editar Local</title>
</head>
<body>
    <h1>Editar Local</h1>

    <?php if (!empty($_SESSION['mensaje'])): ?>
        <p style="color:green;"><?= htmlspecialchars($_SESSION['mensaje']); unset($_SESSION['mensaje']); ?></p>
    <?php endif; ?>

    <div class="main-center">
        <div class="form__container-locales">
            <form class="form-locales" action="/Descuento-City/controllers/localesCtrl/localesUpdateController.php" method="POST" enctype="multipart/form-data">
                <!-- Codigo Local -->
                <input type="hidden" name="codLocal" value="<?php echo isset($local['codLocal']) ? htmlspecialchars($local['codLocal']) : ''; ?>">
                <!-- Nombre Local -->
                <label> Nombre de local </label><br>
                <input type="text" name="nombreLocal" value="<?php echo isset($local['nombreLocal']) ? htmlspecialchars($local['nombreLocal']) : ''; ?>" ><br>
                <!-- Rubro Local -->
                <label>Rubro</label><br>
                <input type="text" name="rubroLocal" value="<?php echo isset($local['rubroLocal']) ? htmlspecialchars($local['rubroLocal']) : ''; ?>" ><br>
                <!-- Ubicacion Local -->
                <label>Ubicacion</label><br>
                <input type="text" name="ubicacionLocal" value="<?php echo isset($local['ubicacionLocal']) ? htmlspecialchars($local['ubicacionLocal']) : ''; ?>" ><br>

                <!-- Logo actual -->
                <label>Logo actual</label><br>
                <?php
                // ruta guardada en BD (por ejemplo "uploads/logos/nombre.jpg")
                $ruta = $img["rutaArchivo"] ?? '';

                // Construyo ruta absoluta segura usando DOCUMENT_ROOT + ruta relativa en BD
                // Asegurate que la ruta en BD sea relativa a la raíz del proyecto (ej: "uploads/logos/xxx.png")
                $rutaPublica = '/Descuento-City/' . ltrim($ruta, '/\\');

                if (!empty($ruta)): ?>
                    <img src="<?php echo htmlspecialchars($rutaPublica); ?>" alt="Logo del local" width="150" height="100" style="object-fit:cover;border-radius:8px;"><br>
                <?php else: ?>
                    <span style="color: gray;">Sin logo</span><br>
                <?php endif; ?>

                <!-- Cambiar logo -->
                <label>Cambiar Logo</label><br>
                <input type="file" name="nuevoLogo" accept="image/*"><br>

                <input type="hidden" name="existeLogo" value="<?php echo htmlspecialchars($ruta); ?>" >

                <input class="button-form" type="submit" name="confirm" value="Guardar cambios">
            </form>

        </div>
    </div>
</body>
</html>
<?php
mysqli_close($conexion);
?>