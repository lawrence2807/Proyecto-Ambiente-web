<?php

require 'vendor/autoload.php';

session_start();

// Inicializar la conexión a la base de datos si es necesario
$servername = "localhost";
$username = "root";
$password = "Conexion";
$dbname = "tutienda";
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['codigo'], $_POST['password'], $_POST['confirm_password'])) {
        $codigo = trim($_POST["codigo"]);
        $password = $_POST["password"];
        $confirmPassword = $_POST["confirm_password"];

        // Verifica que las contraseñas coincidan
        if ($password !== $confirmPassword) {
            echo "Error: Las contraseñas no coinciden.";
            exit();
        }

        // Verifica si 'codigo_recuperacion' está definida en $_SESSION
        if (isset($_SESSION['codigo_recuperacion'])) {
            // Imprime el código recuperado de la sesión (para depurar)
            echo "<p>Código recuperado de la sesión: " . htmlspecialchars($_SESSION['codigo_recuperacion']) . "</p>";

            // Verifica el código en la sesión
            if ($_SESSION['codigo_recuperacion'] === $codigo) {
                // El código es válido, permite cambiar la contraseña
                $correo = $_SESSION['correo_recuperacion'];

                // Actualiza la contraseña en la base de datos
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                $updateStmt = $conn->prepare("UPDATE Usuarios SET Contraseña = ? WHERE CorreoElectronico = ?");
                $updateStmt->bind_param("ss", $hashedPassword, $correo);
                $updateStmt->execute();

                // Elimina la información de recuperación de la sesión
                unset($_SESSION['correo_recuperacion']);
                unset($_SESSION['codigo_recuperacion']);

                // Redirige o muestra un mensaje de éxito
                header("Location: ContraseñaCambiada.php");
                exit();
            } else {
                echo "Error: Código no válido. Código ingresado: " . $codigo . " Código esperado: " . $_SESSION['codigo_recuperacion'];
            }
        } else {
            echo "Error: 'codigo_recuperacion' no está definida en la sesión.";
        }
    } else {
        echo "Error: Debes proporcionar el código y la nueva contraseña.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cambiar Contraseña - Tucalzado.com</title>
</head>

<body>
    <h2>Cambiar Contraseña</h2>

    <?php
    // Verifica si 'codigo_recuperacion' está definida en $_SESSION antes de imprimir
    if (isset($_SESSION['codigo_recuperacion'])) {
        echo "<p>Código de verificación: " . htmlspecialchars($_SESSION['codigo_recuperacion']) . "</p>";
    }

    // Verifica si 'correo_recuperacion' está definida en $_SESSION antes de imprimir
    if (isset($_SESSION['correo_recuperacion'])) {
        echo "<p>Correo electrónico: " . htmlspecialchars($_SESSION['correo_recuperacion']) . "</p>";
    }
    ?>

    <!-- Formulario para cambiar la contraseña -->
    <form action="" method="post">
        <label for="codigo">Código de Verificación:</label>
        <input type="text" name="codigo" required>

        <label for="password">Nueva Contraseña:</label>
        <input type="password" name="password" required>

        <label for="confirm_password">Confirmar Nueva Contraseña:</label>
        <input type="password" name="confirm_password" required>

        <button type="submit" name="cambiarContraseña">Cambiar Contraseña</button>
    </form>
</body>

</html>
