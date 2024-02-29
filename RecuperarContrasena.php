<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $mail->Host       = 'smtp.gmail.com';
$mail->SMTPAuth   = true;
$mail->Username   = 'tucalzadoclientes@gmail.com';
$mail->Password   = 'TucalzadoClientes12.';
$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
$mail->Port       = 587;


    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("La conexión falló: " . $conn->connect_error);
    }

    $correo = $conn->real_escape_string($_POST["correo"]);
    $token = $conn->real_escape_string($_POST["token"]);
    $nuevaContrasena = password_hash($_POST["nuevaContrasena"], PASSWORD_DEFAULT);

    // Verificar si el token es válido
    $stmt = $conn->prepare("SELECT * FROM RecuperacionContrasena WHERE Correo = ? AND Token = ? AND Expiracion > NOW()");
    $stmt->bind_param("ss", $correo, $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Actualizar la contraseña del usuario
        $stmt = $conn->prepare("UPDATE Usuarios SET Contraseña = ? WHERE CorreoElectronico = ?");
        $stmt->bind_param("ss", $nuevaContrasena, $correo);
        $stmt->execute();

        // Eliminar el registro de recuperación de contraseña
        $stmt = $conn->prepare("DELETE FROM RecuperacionContrasena WHERE Correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();

        // Redirigir o mostrar mensaje de éxito
        header("Location: ContraseñaRestablecida.php");
        exit();
    } else {
        $error = "Token inválido o expirado.";
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
    <title>Restablecer Contraseña - Tucalzado.com</title>
</head>

<body>
    <h2>Restablecer Contraseña</h2>

    <?php
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <!-- Formulario de restablecimiento de contraseña -->
    <form action="" method="post">
        <input type="hidden" name="correo" value="<?php echo $_GET['correo']; ?>">
        <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">

        <label for="nuevaContrasena">Nueva Contraseña:</label>
        <input type="password" name="nuevaContrasena" required>

        <button type="submit">Restablecer Contraseña</button>
    </form>

</body>

</html>
