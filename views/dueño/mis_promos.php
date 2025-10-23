<?php

include("../../conexionBD.php")

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href=/Descuento-City/assets/css/estilos.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <title>Mis promos</title>
</head>
<body>    

    <?php
    include("../../includes/dueño/dueñoHeader.php");
    ?>
    <h1>Promociones</h1>
    <h3>Este es el menu de mis promociones</h3>



    <div class="main-center">
        <div class="form__container-promociones">
            <form class="form-promociones" action="../../controllers/dueñoCtrl/promocionesDueñoController.php">
                <h2>Crear promocion</h2>

                <!-- Descripcion promo / BD = textPromo -->
                <label>Descripcion</label><br>
                <input type="text" name="textoPromo" required><br>

                <!-- Fecha Desde  -->
                <label>Fecha Desde :</label>
                <input type="date" name="fechaDesde" required>

                <!-- Fecha Hasta  -->
                <label>Fecha Hasta :</label>
                <input type="date" name="fechaHasta" required><br>

                <!-- Dias de semana que estara disponible  -->
                <label>Disponibilidad semanal:</label><br>

                <!-- Permitir seleccionar todos los dias -->
                Seleccionar todo <input type="checkbox" id="seleccionarTodos" value="semCompleta"><br>

                <!-- Dias semana individual -->
                Lunes  <input type="checkbox" name="diasSemana[]" value="lun"><br>
                Martes<input type="checkbox" name="diasSemana[]" value="mar"><br>
                Miercoles<input type="checkbox" name="diasSemana[]" value="mie"><br>
                Jueves<input type="checkbox" name="diasSemana[]" value="jue"><br>
                Viernes<input type="checkbox" name="diasSemana[]" value="vie"><br>
                Sabado<input type="checkbox" name="diasSemana[]" value="sab"><br>
                Domingos<input type="checkbox" name="diasSemana[]" value="dom"><br>

                <!-- Seleccionar categoria cliente -->
                <label>Categoria cliente</label><br>
                <select name="categoriaCliente" id="">
                    <option value="inicial">Inicial</option>
                    <option value="medium">Medium</option>
                    <option value="premium">Premium</option>
                </select><br>

                <input class="button-form" type="submit" name="confirm" value="Crear promocion">
            </form>
        </div>
    </div>

    <script>
    // Selecciona el checkbox de "seleccionar todos"
    const seleccionarTodos = document.getElementById('seleccionarTodos');
    // Selecciona todos los checkbox de los días
    const dias = document.querySelectorAll('input[name="diasSemana[]"]');

    seleccionarTodos.addEventListener('change', function() {
        dias.forEach(dia => dia.checked = this.checked);
    });
</script>



</body>
</html>

<?php

mysqli_close($conexion);

?>