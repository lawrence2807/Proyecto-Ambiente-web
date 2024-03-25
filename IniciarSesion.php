<?php
session_start();

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $servername = "localhost";
    $username = "root";
    $password = "Conexion";
    $dbname = "tutienda";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    $correo = $_POST["correo"];
    $contrasena = $_POST["contrasena"];

    $stmt = $conn->prepare("SELECT ID_usuario, Nombre, Contraseña, Rol FROM Usuarios WHERE CorreoElectronico = ?");
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($id_usuario, $nombre, $hashed_password, $rol);
        $stmt->fetch();

        if (password_verify($contrasena, $hashed_password)) {
            $_SESSION["ID_usuario"] = $id_usuario;
            $_SESSION["Nombre"] = $nombre;
            $_SESSION["Rol"] = $rol; // Agregar el rol a la sesión

            // Verificar el rol y redirigir
            if ($rol == 'admin') {
                header("Location: CentroControl.php");
                exit();
            } else {
                header("Location: index.php");
                exit();
            }
        } else {
            $error = "Contraseña incorrecta.";
        }
    } else {
        $error = "Usuario no encontrado.";
    }

    $stmt->close();
    $conn->close();
}

?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Tucalzado.com</title>
</head>

<body>
    <h2>Iniciar Sesión</h2>

    <?php
    // Mostrar mensaje de error solo si se ha enviado el formulario
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form action="" method="post">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>

        <button type="submit">Iniciar Sesión</button>

        <div>
            <a href="OlvidarContrasena.php">¿No recuerdas tu contraseña?</a>
            <span> | </span>
            <a href="Registro.php">Registrarse</a>
        </div>
    </form>
</body>

</html>
