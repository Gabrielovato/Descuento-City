

<?php
session_start();
// base de datos
include("../../conexionBD.php");
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <title>Descuento City</title>
</head>
<body>
    <?php include("../../includes/header.php");?>
    <div class="main-center">
        <div class="form__container-reg">
            <h2>Registrarse</h2>
            <form action="../../controllers/registroController.php" method="POST" >
                <!-- Email -->
                <div class="datos-container"> 
                    <label>Email</label><br>
                    <input type="email" name="email" placeholder="example@gmail.com" class="input-form" required ><br> 
                <!-- Contraseña Usuario -->
                    <label>Contraseña</label><br>
                    <input type="password" name="clave" class="input-form" required ><br> 
                    <label>Confirma tu contraseña</label><br>
                    <input type="password" name="claveConfirm" class="input-form" required ><br> 
                </div>
                <!-- Rol de usuario -->
                <div class ="rol-container">
                    <label>Rol</label><br>
                    <input class="input-radio" type="radio" name="rol" value="cliente" >Cliente<br>
                    <input class="input-radio" type="radio" name="rol" value="dueño">Dueño de local<br>
                </div>
                <input type="submit" name="confirm" value="Registrarse" class="button-form">
                <p>¿Ya estas registrado?</p>
                <button class="button-form-login"><a href="/Descuento-City/views/auth/login.php">Iniciar Sesion</a></button>
            </form>
            <?php
            // Sistema de alertas categorizado
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
            
            // Compatibilidad con mensaje simple (por si algún controlador aún no está actualizado)
            if(isset($_SESSION["mensaje"])){
                echo "<div class='alert alert-info alert-dismissible fade show' role='alert'>";
                echo "<i class='fas fa-info-circle'></i> " . $_SESSION['mensaje'];
                echo "<button type='button' class='btn-close' data-bs-dismiss='alert'></button>";
                echo "</div>";
                unset($_SESSION['mensaje']);
            }
            ?>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>



