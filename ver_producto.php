<?php
session_start();

// Verificar si el usuario está autenticado y tiene rol de administrador
if (!isset($_SESSION["ID_usuario"]) || !isset($_SESSION["Nombre"]) || $_SESSION["Rol"] !== 'admin') {
    header("Location: IniciarSesion.php"); // Redirigir si no es un administrador autenticado
    exit();
}

// Verificar si se recibió el ID del producto
if (!isset($_GET['id_producto'])) {
    header("Location: CentroControl.php"); // Redirigir si no se proporcionó el ID del producto
    exit();
}

$servername = "localhost";
$username = "root";
$password = "Conexion";
$dbname = "tutienda";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("La conexión falló: " . $conn->connect_error);
}

// Obtener el producto con el ID proporcionado
$id_producto = $_GET['id_producto'];
$stmt = $conn->prepare("SELECT * FROM Productos WHERE ID_producto = ?");
$stmt->bind_param("i", $id_producto);
$stmt->execute();
$result = $stmt->get_result();

// Verificar si se encontró el producto
if ($result->num_rows === 0) {
    echo "No se encontró el producto.";
    exit();
}

// Mostrar los detalles del producto
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver Producto - Tu Calzado</title>
 </head>

<body>
    <!-- Botón para retroceder al menú -->
    <a href="CentroControl.php">Volver al Menú</a>

    <!-- Detalles del producto -->
    <h2>Detalles del Producto</h2>
    <p><strong>Nombre:</strong> <?php echo $row['Nombre']; ?></p>
    <p><strong>Descripción:</strong> <?php echo $row['Descripcion']; ?></p>
    <p><strong>Precio (₡):</strong> <?php echo $row['Precio']; ?></p>
    <p><strong>Stock:</strong> <?php echo $row['Stock']; ?></p>
    <p><strong>Imagen:</strong> <img src="<?php echo $row['Imagen']; ?>" alt="Imagen de Producto" style="width: 200px;"></p>
</body>

</html>

<?php
$stmt->close();
$conn->close();
?>
