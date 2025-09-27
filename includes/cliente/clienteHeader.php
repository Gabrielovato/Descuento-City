



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/Descuento-City/assets/css/estilos.css">
</head>
<body>
    <header class="header">
        <div class="header_log-container">
            <a href="/Descuento-City/includes/cliente/clienteHeader.php"><img src="/Descuento-City/assets/img/logo_descuento_city_100px_white.png" alt="logo"></a>
        </div>
        </nav>        
        <form action="/Descuento-City/busqueda.php" method="GET" class="header__search-form">
            <input type="text" name="search" placeholder="Codigo Local" class="input-form">
            <button type="sumbit" class="button-form-search">Buscar</button>
        </form>
        <nav class="header__nav">
            <ul class="header__nav-list">
                <li class="header__nav-item"><a href="#inicio">Inicio</a></li>
                <li class="header__nav-item"><a href="#promociones">Promociones</a></li>
                <li class="header__nav-item"><a href="#contacto"></a></li>
                <li class="header__nav-item"><a href="#contacto">Uso de promociones</a></li>
                <li class="header__nav-item"><a href="/Descuento-City/views/auth/logout.php">Cerrar sesion</a></li>
            </ul>  

    </header>
</body>
</html>