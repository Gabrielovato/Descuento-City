<?php

session_start();


if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["confirm"])){
    unset($_SESSION);
    $_SESSION = null;
    $_SESSION = "";

    session_destroy();
    header("location:../index.php");
    exit();

}




?>

