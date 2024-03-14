<?php
session_start();

// Verificar si el usuario está autenticado y tiene rol de administrador
if (!isset($_SESSION["ID_usuario"]) || !isset($_SESSION["Nombre"]) || $_SESSION["Rol"] !== 'admin') {
    header("Location: IniciarSesion.php"); // Redirigir si no es un administrador autenticado
    exit();
}

// Verificar si se recibió el ID del producto
if (!isset($_POST['id_producto'])) {
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

// Eliminar el producto con el ID proporcionado
$id_producto = $_POST['id_producto'];
$stmt = $conn->prepare("DELETE FROM Productos WHERE ID_producto = ?");
$stmt->bind_param("i", $id_producto);
$stmt->execute();

 
$stmt->close();
$conn->close();

 
echo "<script>alert('Producto eliminado correctamente.'); window.location.href = 'productos.php';</script>";
?>


