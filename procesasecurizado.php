<?php
// Inicia la sesión o reanuda la sesión actual
session_start();
// Guardamos el contenido introducido por el usuario en el campo del captcha
$captcha = $_POST['captcha'];

// Comprueba si la variable de sesión 'usuario' está establecida
if (isset($_SESSION['user'])) {
    // Si está activa, redirige al usuario a la página 'menu.php'
    header("location: menu.php");
    // Termina
    exit();
}
	//Si el captcha que introdujo el usuario no concuerda con el que se asigno al valor de la sesión
	//devuelve al index.php con un mensaje de error sobre el captcha indicando que no era correcto
	if ($captcha != $_SESSION['captcha']['code']){
	    // Redirigir a index.php con un mensaje de error
		header("Location: index.php?error=captcha");
		exit();
	}
	elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Obtener datos del formulario
    $user = $_POST['user']; // Sin validación
    $pass = $_POST['pass']; // Sin validación 

    // Conectar a la base de datos
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

    // si existe la conexion
    if ($conn) {
        // Validar datos, preparar la consulta con un statement(declaración) donde ? es un marcador de posición
        $stmt = $conn->prepare("SELECT * FROM usuarios WHERE user = ? AND pass = ?");

        // Enlaza las variables de entrada con los parámetros de la consulta donde ? marca
        $stmt->bind_param("ss", $user, $pass); // 'ss' indica que ambos parámetros son strings

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener resultados
        $resultado = $stmt->get_result();

        // Comprobar si hay un usuario válido
        if ($resultado) {
            if ($resultado->num_rows > 0) {
                $_SESSION['user'] = $user;
                header("location: menu.php");
                exit();
            } else {
				//redirige al index.php y asigna el valor de error "Login"
                header("Location: index.php?error=login");
				exit();
            }
        } else {
            // Mostrar mensaje de error si la consulta falla
            echo "Error en la consulta SQL: " . $conn->error;
        }
		
        // Cerrar la declaración y la conexión
        $stmt->close();
        $conn->close();
    } else {
        echo "Acceso no autorizado";
    }
}
