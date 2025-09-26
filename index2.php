

<?php
$claveIngresada = 'admin123';
$hashBD = '$2y$10$VO1FHGVFGLvpQWjP9XVYKeBt3snTyq2LZXhG7vEN2GsX/DTY3ixHe';

if (password_verify($claveIngresada, $hashBD)) {
    echo "¡Coincide!";
} else {
    echo "No coincide.";
}



echo password_hash("admin123", PASSWORD_DEFAULT);
?>
