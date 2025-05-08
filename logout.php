<?php
session_start();

// Elimina todas las variables de sesión
session_unset();

// Destruye la sesión actual
session_destroy();

// Redirige a la página de inicio de sesión (index.php)
header("location: index.php");
exit();
?>

