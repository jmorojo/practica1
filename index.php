<?php
// Inicia la sesión o reanuda la sesión actual
session_start();
$_SESSION = array();

//Añadimos el fichero de generación de captchas y lo iniciamos guardando el valor del captcha en una sesion
include("simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();

// Comprueba si la variable de sesión 'usuario' está establecida
if (isset($_SESSION['user'])) {
    // Si está activa, redirige al usuario a la página 'menu.php'
    header("location: menu.php");
    // Termina
    exit();
}
?>


<!DOCTYPE html>
    <html lang="es">

    <head>
        <meta charset="UTF-8">
        <title>Inicio de Sesión</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
            }

            h2 {
                text-align: center;
                color: #333;
            }

            form {
                max-width: 400px;
                margin: 0 auto;
                padding: 20px;
                background: white;
                border-radius: 5px;
                box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            }

            label {
                display: block;
                margin: 10px 0 5px;
                color: #666;
            }

            input[type="text"],
            input[type="password"] {
                width: 95%;
                padding: 10px;
                margin: 5px 0 15px;
                border: 1px solid #ccc;
                border-radius: 5px;
            }

            input[type="submit"] {
                background-color: #5cb85c;
                color: white;
                border: none;
                padding: 10px;
                cursor: pointer;
                border-radius: 5px;
                width: 100%;
            }

            input[type="submit"]:hover {
                background-color: #4cae4c;
            }
			 
			.error-message {
            color: red;
            font-weight: bold;
			}

        </style>

    <body>
        <h2>Formulario de Inicio de Sesión</h2>
        <form action="procesasecurizado.php" method="POST">
			<?php
			//Muestra el mensaje de dentro del DOM si el parámetro pasado al login es igual a login
			if (isset($_GET['error']) && $_GET['error'] == 'login') {
			echo '<p style="color: red; font-weight: bold;">Usuario o contraseña incorrectos.</p>';
			}
			?>
            <label for="user">Usuario:</label>
            <input type="text" id="user" name="user" required>
            <br>
            <label for="pass">Contraseña:</label>
            <input type="password" id="pass" name="pass" required>
            <br>
            <input type="submit" value="Iniciar Sesión">
			<?php
			//Muestra el mensaje de dentro del DOM si el parámetro pasado al login es igual a captcha
			if (isset($_GET['error']) && $_GET['error'] == 'captcha') {
			echo '<p style="color: red; font-weight: bold;">Captcha incorrecto. Por favor, inténtalo de nuevo.</p>';
			}
			?>
			<p>
				<?php
					//Muestra el valor del captcha en forma de imagen para evitar que un script o bot pueda extraerlo facilmente del DOM
					echo '<img src="' . $_SESSION['captcha']['image_src'] . '" alt="CAPTCHA code">';

				?>
			</p>
			<p>
				<input type="text" name="captcha"/>
			</p>
        </form>

    </body>

    </html>