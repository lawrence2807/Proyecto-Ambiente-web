<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $servername = "localhost";
    $username = "root";
    $password = "Conexion";   
    $dbname = "tutienda";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    $nombre = $conn->real_escape_string($_POST["nombre"]);
    $correo = $conn->real_escape_string($_POST["correo"]);
    $contrasena = $_POST["contrasena"];
    $confirmarContrasena = $_POST["confirmarContrasena"];

    $stmt = null;
    $error = '';

    if ($contrasena !== $confirmarContrasena) {
        $error = "Las contraseñas no coinciden.";
    } else {
        $stmt = $conn->prepare("SELECT ID_usuario FROM Usuarios WHERE CorreoElectronico = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Este correo ya está registrado.";
        } else {
            $contrasenaHash = password_hash($contrasena, PASSWORD_BCRYPT);
            $stmt = $conn->prepare("INSERT INTO Usuarios (Nombre, CorreoElectronico, Contraseña) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $correo, $contrasenaHash);
            $stmt->execute();

            $registroExitoso = true;
        }
    }

    if ($stmt !== null) {
        $stmt->close();
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Tucalzado.com</title>
</head>

<body>
    <h2>Registro de Usuario</h2>

    <?php
    if (!empty($error)) {
        echo "<p style='color: red;'>$error</p>";
    }

    if (isset($registroExitoso)) {
        echo "<p style='color: green;'>¡Registro exitoso! Puedes iniciar sesión ahora.</p>";
    }
    ?>

    <form action="" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" required>

        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" required>

        <label for="contrasena">Contraseña:</label>
        <input type="password" name="contrasena" required>
        <small>La contraseña debe tener al menos 8 caracteres e incluir al menos una letra mayúscula, una letra minúscula y un número.</small>

        <label for="confirmarContrasena">Confirmar Contraseña:</label>
        <input type="password" name="confirmarContrasena" required>

        <button type="submit">Registrarse</button>
    </form>

    <p>¿Ya tienes una cuenta? <a href="IniciarSesion.php">Iniciar Sesión</a></p>
</body>

</html>
