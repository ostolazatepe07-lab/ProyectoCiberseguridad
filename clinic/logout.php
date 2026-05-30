<?php
session_start();
session_destroy(); // Elimina todos los datos de la sesión
header("Location: index.php"); // Te manda de vuelta al login
exit();
?>
