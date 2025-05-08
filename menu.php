<?php
// Inicia la sesión o reanuda la sesión actual
session_start();

// Comprueba si la variable de sesión 'usuario' está establecida
if (isset($_SESSION['user'])) {
    $servidor = "localhost";
    $usuarioDB = "root";
    $contrasenaDB = "";
    $nombreDB = "demos";


    // Crear conexión
    $conn = new mysqli($servidor, $usuarioDB, $contrasenaDB, $nombreDB);

    // Comprobar conexión
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }
} else {

    //Evita que se pueda realizar el login sin un método de envío de datos
    echo "Acceso no autorizado";

    //Termina
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Menú</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
        }

        p {
            text-align: center;
            color: #666;
        }

        a {
            display: inline-block;
            text-align: center;
            margin: 20px auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        a:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<body>
    <h1>Logged in</h1>
    <p>Bienvenido, <?php echo htmlspecialchars($_SESSION['user']); ?>!</p>
    <a href="logout.php">Desconectar</a>
</body>

</html>