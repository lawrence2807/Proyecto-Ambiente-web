<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

session_start();

// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "Conexion";
$dbname = "tutienda";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica que se haya proporcionado la dirección de correo electrónico
    if (isset($_POST['correo'])) {
        $correo = $conn->real_escape_string($_POST["correo"]);

        // Genera y almacena el código en la base de datos
        $codigo = bin2hex(random_bytes(6));
        $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));

        $stmt = $conn->prepare("INSERT INTO RecuperacionContrasena (Correo, Codigo, Expiracion) VALUES (?, ?, ?)");

        if (!$stmt) {
            die("Error en la preparación de la consulta: " . $conn->error);
        }

        $stmt->bind_param("sss", $correo, $codigo, $expiracion);
        $result = $stmt->execute();

        if (!$result) {
            die("Error al ejecutar la consulta: " . $stmt->error);
        }

        // Configuración de PHPMailer
        $mail = new PHPMailer(true);
        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.office365.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'padive2384@comsb.com';
            $mail->Password   = '';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->Port       = 587;

            // Recipients
            $mail->setFrom('padive2384@comsb.com', 'TuCalzado');
            $mail->addAddress($correo);

            // Content
            $mail->isHTML(true);
            $mail->Subject = '  Tiendas de zapatos grande';
            $mail->Body    = 'Tu códigodddde recuperación es holaaa como estas este es e lco ccodosigos afasf
            afaffaf
            afwfwfwghasf
            avcwfaf: ' . $codigo;

            $mail->send();

            // Redirigir o mostrar mensaje de éxito
            header("Location: CambiarContraseña.php?correo=" . urlencode($correo));
            exit();
        } catch (Exception $e) {
            echo "Error al enviar el correo: {$mail->ErrorInfo}";
        }
    } else {
        echo "Error: Debes proporcionar una dirección de correo electrónico.";
    }
}

// Cerrar la conexión a la base de datos al final del script
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olvidar Contraseña - Tucalzado.com</title>
</head>

<body>
    <h2>Recuperación de Contraseña</h2>

    <!-- Formulario de olvidar contraseña -->
    <form action="" method="post">
        <label for="correo">Correo Electrónico:</label>
        <input type="email" name="correo" required>

        <button type="submit" name="enviarCorreo">Enviar Correo de Recuperación</button>
    </form>

</body>

</html>
