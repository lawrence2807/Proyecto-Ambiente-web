<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

// Configuración del servidor SMTP
$mail = new PHPMailer(true);

try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host       = 'smtp.office365.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'skylm12@outlook.com';
    $mail->Password   = 'Elnegrocatu12.';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port       = 587;

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST['correo'])) {
            $correo = $_POST['correo'];

            // Generar y almacenar el código en la base de datos
            $codigo = bin2hex(random_bytes(6));
            $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));

            $_SESSION['correo_recuperacion'] = $correo;
            $_SESSION['codigo_recuperacion'] = $codigo;
            
            // Guardar el correo y el código en la base de datos
            $stmt = $conn->prepare("INSERT INTO RecuperacionContrasena (Correo, Token, Expiracion, Codigo) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $correo, $codigo, $expiracion, $codigo);
            $stmt->execute();

            // Imprimir el código generado (puedes quitar esto en producción)
            echo "Código de recuperación: $codigo";

            // Resto del código para enviar el correo
            $mail->setFrom('skylm12@outlook.com', 'Tu Calzado');
            $mail->addAddress($correo);

            $mail->isHTML(true);
            $mail->Subject = 'Código de recuperación de contraseña';
            $mail->Body    = "Tu código de recuperación es: $codigo";

            $mail->send();

            // Redirigir a CambiarContraseña.php
            header("Location: CambiarContraseña.php");
            exit();
        } else {
            echo "Error: Debes proporcionar una dirección de correo electrónico.";
        }
    }

} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Contraseña - Tucalzado.com</title>
</head>

<body>
    <h2>Recuperar Contraseña</h2>

    <form action="" method="post">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" required>

        <button type="submit" name="enviarCorreo">Enviar Correo de Recuperación</button>
    </form>
</body>

</html>
